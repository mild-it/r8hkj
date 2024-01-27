<?php
session_start();
include ("connectDB.php");
$d = $_SESSION['pcu'];
$d1 = $_SESSION['level'];
$level = $_SESSION['levelx'];
$province = $_SESSION['province'];
$problems_status = $_SESSION['problems'];
include ("connect.php");
include ("function.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>ลงทะเบียนเข้าใช้งาน</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

</head>
<link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
<table class="table table-bordered table-striped">
    <thead>
    	<tr>
	    	<th class='text-center'>No.</th>
	    	<th class='text-center'>ชื่อ-สกุล</th>
	    	<th class='text-center'>ประเภทความพิการ</th>
			<th class='text-center'>หน่วยงานรับดูแล</th>
			<th class='text-center'><font size=2>วันที่รับรองความพิการ</th>
			<th class='text-center'><font size=2>วันที่ได้รับขึ้นทะเบียน</th>
			<th class='text-center'><font size=2>หน่วยงานนำเข้าข้อมูล</th>
	    	
	    </tr>
    </thead>
    <tbody>
    	<?php

    		if ($level == 'pcu') {
				$sql = "SELECT c.*, t.hospname as name_obt, t.ampname as obt_ampname FROM caseDis as c left outer join tesaban as t on c.obt = t.tcode where c.tambol like '$province%' and c.statusCase='DOC' and c.hospcode='$d' ORDER BY c.dateREG";
			} elseif ($level == 'opt') {
				$sql = "SELECT c.*, CASE WHEN problems= 'obt' THEN 'อปท.'
				else '' END as status_obt, t.hospname as name_obt, t.ampname as obt_ampname FROM caseDis as c left outer join tesaban as t on c.obt = t.tcode where c.tambol like '$province%' and c.statusCase='DOC' and c.infoFrom IN ('PMJ','OBT') and c.obt='$d1' ORDER BY c.dateREG";
			} else {
				$sql = "SELECT c.*, t.hospname as name_obt, t.ampname as obt_ampname FROM caseDis as c left outer join tesaban as t on c.obt = t.tcode where c.tambol like '$province%' and c.statusCase='DOC' and c.infoFrom='PMJ' ORDER BY c.dateREG";
			} 
			$result = mysqli_query($conn,$sql);
    		$i = 1;
    		while($row = mysqli_fetch_array($result)) 
    		{
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
			<td><?php echo Thai_date($row['dateREG']); ?></td>
			<td><?php echo Thai_date($row['datePMJ']); ?></td>
			<td><?php echo $row['status_obt'] ; ?></td>
	    	<td class='text-center'>
		<?php 
		if($level=='pcu'){
		?>
			 <a href="./editCase.php?cid=<?=$cid?>" class="btn btn-danger" role="button"><i class="fa fa-pencil"></i></a> 
		<?php }
		if($level=='opt'||$problems=='obt'){
			?>
				 <a href="./editCase.php?cid=<?=$cid?>" class="btn btn-danger" role="button"><i class="fa fa-pencil"></i></a> 
			<?php }
		else{
			?>
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
	    <?php } ?>
			</td>
    	</tr>
    	<?php  $i++;	}  	?>
    </tbody>
</table>

</body>

</html>
