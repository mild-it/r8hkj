<?php
session_start();
include ("connectDB.php");
$d = $_SESSION['pcu'];
$d1 = $_SESSION['level'];
$level = $_SESSION['levelx'];
include ("connect.php");
include ("function.php");
include ("paginate.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>R8NDS</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

</head>
<link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <style>
		body {  font-family: 'Kanit', sans-serif;	}
		h1,h2,h3,h4,h5,h6 {  font-family: 'Kanit', sans-serif;	}
    </style>
<style type="text/css">.bgimg {  background-image: url('../images/disLogo.png'); }  </style>
<?php 
$sql = "SELECT * FROM newCase where status='PMJ'";
$query = mysqli_query($conn, $sql);
?>
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
<div class="table-responsive-sm">
<table class="table table-bordered table-striped">
    <thead>
    	<tr class="gradient-5">
	    	<th class='text-center'>No.</th>
			<th class='text-center'>ชื่อ-สกุล</th>
	    	<th class='text-center'>ประเภทความพิการ</th>
			<th class='text-center'>หน่วยงานรับดูแล</th>
			<th class='text-center'><font size=2>วันที่รับรองความพิการ</th>
			<th class='text-center'><font size=2>วันที่ได้รับขึ้นทะเบียน</th>
			<th class='text-center'><font size=2>วันที่ได้รับการดูแล</th>
	    	<th></th>
	    </tr>
    </thead>
    <tbody>
    	<?php 
		$num = 0;
    		if ($level == 'pcu') {
				$sql = "SELECT c.*, t.hospname as name_obt, t.ampname as obt_ampname FROM caseDis as c left outer join tesaban as t on c.obt = t.tcode where c.statusCase='OK' and c.hospcode='$d'";
			} elseif ($level == 'opt') {
				$sql = "SELECT c.*, t.hospname as name_obt, t.ampname as obt_ampname FROM caseDis as c left outer join tesaban as t on c.obt = t.tcode where c.statusCase='OK' and c.obt='$d1'";
			} else {
				$sql = "SELECT c.*, t.hospname as name_obt, t.ampname as obt_ampname FROM caseDis as c left outer join tesaban as t on c.obt = t.tcode where c.statusCase='OK'";
			} 
			// เงื่อนไขสำหรับ input text
			if(isset($_GET['keyword']) && $_GET['keyword']!=""){
				// ต่อคำสั่ง sql 
				$sql.=" AND fname LIKE '%".trim($_GET['keyword'])."%' ";    
				}    
    		// $result = mysqli_query($conn,$sql);	

			@$total=$result->num_rows;												
    		$i = 1;		
			$e_page=5; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
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
				$result = mysqli_query($conn,$sql);	
				
			if($result && $result->num_rows>0){  // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
    		while($row = mysqli_fetch_array($result)) 
    		{
				$num++;
				$cid=base64_encode($row['cid']);
				// $id_obt=$row['obt'];
				// $q1="SELECT hospname FROM tesaban where tcode='$id_obt'";          
				// $result1 = mysqli_query($conn,$q1);
				// $rs1=$result1->fetch_object();
				// $name_obt=$rs1->hospname;
    	?>
    	<tr>
	        <td><?php echo $i; ?></td>
	    	<td><?php echo $row['fname'].' '.$row['lname']; ?></td>
	    	<td><font size=2><?php echo $row['disType']; ?></td>
			<td><font size=2><?php echo $row['name_obt']." [อ.".$row['obt_ampname']."]"; ?></font></td>
			<td><font size=2><?php echo Thai_date($row['dateREG']); ?></td>
			<td><font size=2><?php echo Thai_date($row['datePMJ']); ?></td>
			<td><font size=2><?php echo Thai_date($row['dateOBT']); ?></td>
	    	<td class='text-center'>
		<?php
		if($level=='pcu'){
		?>
			<a href="./editCase.php?cid=<?=$cid?>" class="btn btn-danger" role="button"><i class="fa fa-pencil"></i></a> 
		<?php }
			<!-- <a href="./detailCase.php?cid=<?=$cid?>" class="btn btn-info" role="button"><i class="fa fa-search"></i></a>  -->
					<button type="button" data-toggle="modal" data-remote="" data-target="#detailCase<?=$i;?>"><div class="btn btn-success"><i class="fa fa-search"></i></div></button>
						<!-- Model3 -->
						<div class="modal fade" id="detailCase<?=$i;?>" tabindex="-3"  role="dialog" aria-labelledby="z<?=$i;?>" aria-hidden="true">
							<div class="modal-dialog" style="margin-left: auto;">
								<div class="modal-content" style="width:1000px;height:1600px;">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"  aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
										<h5 class="modal-title" id="z<?=$i;?>" style="width:1400px">&nbsp;&nbsp;รายละเอียดข้อมูลผู้พิการ</h5>
									</div>
									<div class="modal-body" style="width:900px;height:1400:px;margin:auto" >
										<p>
											<iframe src="detailCase.php?cid=<?=$cid;?>" width="900" height="1400"></iframe>
										</p>
									</div>
								</div>
							</div>
						</div>
						<!-- end Modal -->
	    	</td>
    	</tr>
  

    	<?php  $i++;	
		}  
	}	?>

    </tbody>
</table>
<a href="./listOK1.php" class="btn btn-info btn-sm" role="button">ดูรายชื่อทั้งหมด</a>
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