<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include ("connect.php");
include ("function.php");
include ("paginate.php");
session_start();
@$d = $_SESSION['pcu'];
@$d1 = $_SESSION['level'];
$level = $_SESSION['levelx'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
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

</head>


<body>
<div class="container">	
<form name="form1" method="get" action="">
<div class="form-group row">

<?php if($level=='pcu'){
?>
<!-- <a href="./page1.php" class="btn btn-success" role="button"><i class="fa fa-arrow-left"></i>กลับ</a> -->
<?php
}
?>
<?php if($level=='pmj'){
?>
<!-- <a href="./page2.php" class="btn btn-success" role="button"><i class="fa fa-arrow-left"></i>กลับ</a> -->
<?php
}
?><?php if($level=='opt'){
	?>
	<!-- <a href="./page3.php" class="btn btn-success" role="button"><i class="fa fa-arrow-left"></i>กลับ</a> -->
	<?php
	}
	?>

<label for="keyword" class="col-sm-4 col-form-label text-right">
    ค้นหา
    </label>
    <div class="col-sm-3">
      <input type="text" class="form-control" name="keyword" id="keyword" 
       value="<?=(isset($_GET['keyword']))?$_GET['keyword']:""?>">
    </div>
	<button type="submit" class="btn btn-primary btn-sm" name="btn_search" id="btn_search">ค้นหา</button>
	 
</div>    
</form>

<div class="table-responsive-sm">
<table class="table table-bordered table-striped">
    <thead>
		<tr>
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
		if($level=='pcu'){$sql = "SELECT * FROM caseDis where statusCase='OK' and hospcode='$d'";}  
			elseif($level=='opt'){$sql = "SELECT * FROM caseDis where statusCase='OK' and obt='$d1'";}
			else{$sql = "SELECT * FROM caseDis where statusCase='OK' ";} 
			// เงื่อนไขสำหรับ input text
			if(isset($_GET['keyword']) && $_GET['keyword']!=""){
				// ต่อคำสั่ง sql 
				$sql.=" AND fname LIKE '%".trim($_GET['keyword'])."%'";    
				}      
    		$result=mysqli_query($conn,$sql);
			@$total=$result->num_rows;											
    		$i = 1;		
				$e_page=10; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
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
				$sql.=" ORDER BY dateREG DESC,fname  LIMIT ".$s_page.",$e_page";
				$result = mysqli_query($conn,$sql);	
				
	if($result && $result->num_rows>0){  // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
    		while($row = mysqli_fetch_array($result)) 
    		{
				$num++;
				$cid=base64_encode($row['cid']);
				$id_obt=$row['obt'];
					$q1="SELECT hospname FROM tesaban where tcode='$id_obt'";          
					$result1 = mysqli_query($conn,$q1);	                                                                 
					$rs1=$result1->fetch_object();
					$name_obt=$rs1->hospname;
    	?>
    	<tr>
		<td class='text-center'> <?=($step_num*$e_page)+$num?></td>
	    	<td><?php echo $row['fname'].' '.$row['lname']; ?></td>
	    	<td><font size=2><?php echo $row['disType']; ?></td>
			<td><font size=2><?php echo $name_obt; ?></font></td>
			<td><font size=2><?php echo Thai_date($row['dateREG']); ?></td>
			<td><font size=2><?php echo Thai_date($row['datePMJ']); ?></td>
			<td><font size=2><?php echo Thai_date($row['dateOBT']); ?></td>
	    	<td class='text-center'>
				<!-- <button class="btn btn-info" data-toggle="modal" data-target="#myModal<?php echo $row['cid'] ?>"><i class="fa fa-search"></i></button> -->
					<a href="./detailCase.php?cid=<?=$cid?>" class="btn btn-info btn-sm" role="button"><i class="fa fa-search"></i></a> 

			</td>
    	</tr>

    	<?php  $i++;	
		}  
	}	?>

    </tbody>
</table>
<?php
page_navi($total,(isset($_GET['page']))?$_GET['page']:1,$e_page,$_GET);
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
</script>
</body>

</html>