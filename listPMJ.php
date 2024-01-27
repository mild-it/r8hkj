<?php
session_start();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include ("connect.php");
include ("function.php");
include ("paginate.php");
@$d = $_SESSION['pcu'];
$level = $_SESSION['levelx'];
$province = $_SESSION['province'];
// echo "Level : ".$level." pro = ".$province;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
	
    <title>R8NDS</title>
	<head>
	<!-- <link rel='stylesheet' href='https://codepen.io/2kool2/pen/ZOmJqq.css'>
	<link rel="stylesheet" href="./style.css"> -->
	<script type="text/javascript" src="js/show123.js"></script>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
		body {  font-family: 'Kanit', sans-serif;	}	h1,h2,h3,h4,h5,h6 {  font-family: 'Kanit', sans-serif;	}
    </style>
<style type="text/css">.bgimg {  background-image: url('../images/disLogo.png'); }  </style>

</head>


<body>
<!-- <form name="form1" method="get" action="">
<div class="form-group row">
<a href="./page1.php" class="btn btn-success" role="button"><i class="fa fa-arrow-left"></i>กลับ</a>
    <label for="keyword" class="col-sm-4 col-form-label text-right">
    ค้นหา
    </label>
    <div class="col-sm-3">
      <input type="text" class="form-control" name="keyword" id="keyword" 
       value="<?=(isset($_GET['keyword']))?$_GET['keyword']:""?>">
    </div>
	<button type="submit" class="btn btn-primary btn-sm" name="btn_search" id="btn_search">ค้นหา</button>
	 
</div>    
</form> -->

<!-- <div class="table-responsive-sm"> -->
<table class="table table-bordered table-striped">
    <thead>
    	<tr>
	    	<th class='text-center'>No.</th>
	    	<th class='text-center'>ชื่อ-สกุล</th>
	    	<th class='text-center'>ประเภทความพิการ</th>
			<th class='text-center'>หน่วยงานรับดูแล</th>
			<th class='text-center'><font size=2>วันที่รับรองความพิการ</th>
	    	<th></th>
	    </tr>
    </thead>
    <tbody>
    	<?php 
		$num = 0;
		// if($level=='pmj'){$sql = "SELECT * FROM caseDis where tambol like '$province%' and statusCase='PMJ'"; }
		if ($level == 'pmj') { $sql = "SELECT c.*, t.hospname as name_obt, t.ampname as obt_ampname FROM caseDis as c left outer join tesaban as t on c.obt = t.tcode where c.tambol like '$province%' and c.statusCase='PMJ'"; }
		// else{$sql = "SELECT * FROM caseDis where tambol like '$province%' and statusCase='PMJ' and hospcode='$d'";  }
		else { $sql = "SELECT c.*, t.hospname as name_obt, t.ampname as obt_ampname FROM caseDis as c left outer join tesaban as t on c.obt = t.tcode where c.tambol like '$province%' and c.statusCase='PMJ' and c.hospcode='$d'"; }
			// เงื่อนไขสำหรับ input text
			if(isset($_GET['keyword']) && $_GET['keyword']!=""){
    		// ต่อคำสั่ง sql 
    		$sql.=" AND c.fname LIKE '%".trim($_GET['keyword'])."%' ";    
			}
			// $result=$mysqli->query($sql);
    		
			@$total=$result->num_rows;											
    		$i = 1;		
				$e_page=200; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
				$step_num=0;
				if(!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page']==1)){   
					$_GET['page']=1;   
					$step_num=0;
					$s_page = 0;    
				}else{   
					$s_page = $_GET['page']-1;
					$step_num=$_GET['page']-1;  
					$s_page = $s_page*$e_page;
				}   
				$sql.=" ORDER BY c.dateREG DESC, c.fname LIMIT ".$s_page.",$e_page";
				$result = mysqli_query($conn, $sql);
				
	if($result && $result->num_rows>0){  // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
    		while($row = mysqli_fetch_array($result)) 
    		{
				$num++;
				$cid=base64_encode($row['cid']);
				// $id_obt=$row['obt'];
				// $q1="SELECT hospname FROM tesaban where tcode='$id_obt'";          
				// $result1 = mysqli_query($conn, $q1);
				// $rs1=$result1->fetch_object();
				// $name_obt=$rs1->hospname;
    	?>
    	<tr>
	        <td class='text-center'> <?=($step_num*$e_page)+$num?></td>
	    	<td><?php echo $row['fname'].' '.$row['lname']; ?></td>
	    	<td><font size=2><?php echo $row['disType']; ?></td>
			<td><font size=2><?php echo $row['name_obt']." [อ.".$row['obt_ampname']."]"; ?></td>
			<td class='text-center'><?php echo Thai_date($row['dateREG']); ?></td>
	    	<td class='text-center'>
				<!-- <button class="btn btn-info" data-toggle="modal" data-target="#myModal<?php echo $row['cid'] ?>"><i class="fa fa-search"></i></button> -->
				<?php 
					if($level=='pcu'){
					?>
					<a href="./editCase.php?cid=<?=$cid?>" class="btn btn-success" role="button"><i class="fa fa-pencil"></i></a> 
					<a href="./delCase.php?cid=<?=$cid?>" class="btn btn-danger" role="button"><i class="fa fa-trash"></i></a> 
					<!-- <a href="#" target="_blank" class="btn btn-success" role="button" onClick="whenClicked();"><i class="fa fa-pencil"></i></a> -->
					<?php   }
		else{ ?>
					<a href="./detailCase.php?cid=<?=$cid?>" class="btn btn-info" role="button"><i class="fa fa-search"></i></a> 
					<?php 
				} ?>
			</td>
    	</tr>

    	<?php  $i++;	
		}  
	}	?>

    </tbody>
</table>
<?php
// page_navi($total,(isset($_GET['page']))?$_GET['page']:1,$e_page,$_GET);
?>
</div>
 
<br>
 
<br>
</div>
 
<script src="https://unpkg.com/jquery@3.3.1/dist/jquery.min.js"></script>
<script src="https://unpkg.com/bootstrap@4.1.0/dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(function(){
     
});

function whenClicked() 
{
    window.close();
    opener.open(http://www.example.com, '_blank');
}
</script>
</body>

</html>
