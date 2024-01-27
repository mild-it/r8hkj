<?php
session_start();
if ($_SESSION["level"]=="etc") {
	header("location: accept.php");
}
?>
<?php
$id_line = $_SESSION['id_line'];
// echo "line=$id_line";

include ("connectDB.php");
include ("connect.php");
include ("function.php");
?>

<!DOCTYPE html>
<html lang="en">

<title>R8NDS</title>
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
 <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <style>
		body {  font-family: 'Kanit', sans-serif;	}	h1,h2,h3,h4,h5,h6 {  font-family: 'Kanit', sans-serif;	}
    </style>
<style type="text/css">.bgimg {  background-image: url('../images/disLogo.png'); }  </style>
</head>
<body>
<div class="container">
<h3>ติดตามตรวจสอบสถานะ</h3>
    	<?php 
			$sql = "SELECT * FROM caseDis WHERE idSend='$id_line' order by dateVDOCall DESC";
			$result = mysqli_query($conn,$sql);
			$nrow = mysqli_num_rows($result);
			if($nrow<=0){echo "ไม่พบข้อมูล";}
    		$i = 1;																								
    		while($row = mysqli_fetch_array($result)) 
    		{
					$fname=$row['fname'];					
					$lname=$row['lname'];
					$statusCase=$row['statusCase'];
						if($statusCase=='HOS'){$statusCase='โรงพยาบาลกำลังตรวจสอบ';}
						if($statusCase=='PMJ'){$statusCase='พมจ.กำลังตรวจสอบ';}
						if($statusCase=='OBT'){$statusCase='เทศบาล/อบต.กำลังตรวจสอบ';}
						if($statusCase=='DOC'){$statusCase='อยู่ระหว่างขอเอกสารเพิ่มเติม';}
						if($statusCase=='OK'){$statusCase='เรียบร้อยแล้ว';}
					$tel=$row['tel'];
					$dateVDOCall=$row['dateVDOCall'];
					$idSend=$row['idSend'];
						$q1="SELECT * FROM member where id_line='$id_line'";          
							$result1 = mysqli_query($conn,$q1);	                                                                 
							$rs1=$result1->fetch_object();
							$idMeet=$rs1->idMeet;
	?>
			<div class="card  bg-light" style="width:100%">
				<div class="card-body">
					<h4 class="card-title "><?=$i.'# '.$fname.' '.$lname?></h4>
					<p class="card-text">สถานะ : <?=$statusCase?></p>
					<p class="card-text">โทรศัพท์ : <?=$tel?> <a href="tel:<?=$tel?>" target="_blank" class="btn btn-info btn-lg" role="button"><i class="fa fa-volume-control-phone"></i></a>	</p>
					<p class="card-text">วันนัด VDO Call :</p>
					<?php
					if($dateVDOCall==null){echo "ไม่มีนัดหมาย";}
					else{
						?>
					<?php echo dateTimex($dateVDOCall);?> //กรุณากดปุ่มนี้>><a href="<?=$idMeet?>" target="_blank" class="btn btn-primary btn-lg" role="button"><i class="fa fa-video-camera"></i></a>	    	
					<?php } ?>
				</div>
			</div>
		<br>
    	<?php  $i++;	}  	?>
   
</div>
</body>

</html>
