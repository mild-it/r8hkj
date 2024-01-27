<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include ("connect.php");
session_start();
$d = $_SESSION['pcu'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
	<script type="text/javascript" src="js/show123.js"></script>
    <title>ลงทะเบียนเข้าใช้งาน</title>
<link rel="stylesheet" href="./style.css"> 
 <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
    <style>
		body {  font-family: 'Kanit', sans-serif;	}	h1,h2,h3,h4,h5,h6 {  font-family: 'Kanit', sans-serif;	}
    </style>
<style type="text/css">.bgimg {  background-image: url('../images/disLogo.png'); }  </style>
</head>
<body>
This filename is listPMJ.php

<table class="table table-bordered table-striped">
    <thead>
    	<tr class="btn-info">
	    	<th class='text-center'>No.</th>
	    	<th class='text-center'>ชื่อ</th>
	    	<th class='text-center'>สกุล</th>
	    	<th class='text-center'>ประเภทความพิการ</th>
	    	<th></th>
	    </tr>
    </thead>
    <tbody>
    	<?php 
    		$sql = "SELECT * FROM caseDis where statusCase='PMJ' and hospcode='$d'";    
    		$result = mysqli_query($conn,$sql);												
    		$i = 1;																								
    		while($row = mysqli_fetch_array($result)) 
    		{
    	?>
    	<tr>
	        <td><?php echo $i; ?></td>
	    	<td><?php echo $row['fname']; ?></td>
	    	<td><?php echo $row['lname']; ?></td>
	    	<td><?php echo $row['disType']; ?></td>
	    	<td>
				<button class="btn btn-info" data-toggle="modal" data-target="#myModal<?php echo $row['cid'] ?>"><i class="fa fa-search"></i></button>
				<button data-modal1="https://nblp.moph.go.th/r8nds/detailCase.php">xxx</button>
	    	</td>
    	</tr>
        <!-- //  here i am creating a modal popup code......... -->
    	<!-- <div id="myModal<?php echo $row['cid'] ?>" class="modal fade" role="dialog">
			<div class="modal-dialog">
			    <div class="modal-content">
					<div class="modal-header">
						 <button type="button" class="close" data-dismiss="modal">&times;</button>
						    <h4 class="modal-title">รายละเอียดส่วนบุคคล</h4>
				    </div>
				    <div class="modal-body">
						 <h3>ชื่อ : <?php echo $row['fname']; ?></h3>
						 <h3>สกุล: <?php echo $row['lname']; ?></h3>
						 <h3>ประเภทความพิการ : <?php echo $row['disType']; ?></h3>
						 
				    </div>
				</div>
			</div>
		</div>
 -->
        <!-- // end modal popup code........ -->

    	<?php  $i++;	}  	?>
    </tbody>
</table>



<svg style="display:none">
  <defs>
    <symbol viewBox="0 0 38 38" id="icon-cross">
      <path d="M19 17.6l5.3-5.4 1.4 1.4-5.3 5.4 5.3 5.3-1.4 1.4-5.3-5.3-5.3 5.3-1.4-1.4 5.2-5.3-5.2-5.3 1.4-1.4 5.3 5.3z"/>
    </symbol>
    <symbol viewBox='0 0 150 130' id="icon-loading">
      <title>Loading</title>
      <path d='M81.5 33l30.8-32.8c0.3-0.3 0.5-0.2 0.3 0.3 -1.8 5.2-1.7 15.3-1.7 15.3 -0.1 6.8-0.8 11.7-6.6 17.9L74.8 65.1c-0.2 0.2-0.4 0-0.3-0.2 1.5-5.1 1.2-15.1 1.2-15.1C75.4 45.6 76.4 38.4 81.5 33M105.9 54.8l43.8 10.3c0.4 0.1 0.4 0.4-0.2 0.4 -5.4 1-14.1 6.1-14.1 6.1 -6 3.3-10.5 5.2-18.8 3.2l-41.9-9.9c-0.3-0.1-0.2-0.3 0-0.4 5.2-1.3 13.7-6.5 13.7-6.5C92 55.9 98.7 53.1 105.9 54.8M99.4 86.3l13 43.2c0.1 0.4-0.1 0.5-0.4 0.1 -3.6-4.2-12.4-9.2-12.4-9.2 -5.8-3.5-9.7-6.5-12.2-14.6L75 64.5c-0.1-0.3 0.2-0.4 0.3-0.2 3.7 3.9 12.5 8.6 12.5 8.6C91.5 74.8 97.3 79.2 99.4 86.3M68.7 97l-30.8 32.8c-0.3 0.3-0.5 0.2-0.3-0.3 1.8-5.2 1.7-15.3 1.7-15.3 0.1-6.8 0.8-11.7 6.6-17.9l29.5-31.4c0.2-0.2 0.4 0 0.3 0.2 -1.5 5.1-1.2 15.1-1.2 15.1C74.8 84.4 73.8 91.6 68.7 97M44.1 75.8L0.3 65.4C-0.1 65.3-0.1 65 0.5 65c5.4-1 14.1-6.1 14.1-6.1 6-3.3 10.5-5.2 18.8-3.2l41.9 9.9c0.3 0.1 0.2 0.3 0 0.4 -5.2 1.3-13.7 6.5-13.7 6.5C58.1 74.7 51.3 77.5 44.1 75.8M50.2 43.8l-13-43.2c-0.1-0.4 0.1-0.5 0.4-0.1C41.2 4.7 50 9.7 50 9.7c5.8 3.5 9.7 6.5 12.2 14.6l12.4 41.3c0.1 0.3-0.2 0.4-0.3 0.2 -3.7-3.9-12.5-8.6-12.5-8.6C58.1 55.4 52.4 50.9 50.2 43.8'/>
    </symbol>
  </defs>
</svg>
 <a class="lnk_modal-open"    data-modalTitle="000"  data-modalDesc="111" href="https://nblp.moph.go.th/r8nds/detailCase.php"  data-modal="https://nblp.moph.go.th/r8nds/detailCase.php">
      test
    </a>

<script  src="./script.js"></script>
</body>

</html>