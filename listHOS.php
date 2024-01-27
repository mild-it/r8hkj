<?php
include ("connectDB.php");
session_start();
$d = $_SESSION['pcu'];
$d1 = $_SESSION['level'];
include ("connect.php");
include ("function.php");
$level = $_SESSION['levelx'];
$idMeet = $_SESSION['idMeet'];
//  echo $d.$level;
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
    <style>
		body {  font-family: 'Kanit', sans-serif;	}	h1,h2,h3,h4,h5,h6 {  font-family: 'Kanit', sans-serif;	}
    </style>
<style type="text/css">.bgimg {  background-image: url('../images/disLogo.png'); }  </style>

</head>
<script type="text/javascript">
function popup(url,name,windowWidth,windowHeight){    
    myleft=(screen.width)?(screen.width-windowWidth)/2:100; 
    mytop=(screen.height)?(screen.height-windowHeight)/2:100;   
    properties = "width="+windowWidth+",height="+windowHeight;
    properties +=",scrollbars=yes, top="+mytop+",left="+myleft;   
    window.open(url,name,properties);
}
</script>
<body>
<table class="table table-bordered table-striped">
    <thead>

		<tr>
	    	<th class='text-center'>No.</th>
	    	<th class='text-center'>ชื่อ-สกุล</th>
	    	<th class='text-center'>ที่อยู่</th>
			<th class='text-center'>โทรศัพท์</th>
			<th class='text-center'><font size=2>วันที่ยื่นคำขอ</th>
			<th class='text-center'><font size=2>วันที่นัดVDOCall</th>
	    	<th></th>
	    </tr>
    </thead>
    <tbody>
    	<?php 
			$sql = "SELECT * FROM caseDis where statusCase='HOS' and hospcode='$d' order by dateSend DESC";
			$result = mysqli_query($conn,$sql);	
    		$i = 1;																								
    		while($row = mysqli_fetch_array($result)) 
    		{
				$cid=base64_encode($row['cid']);

					$homeNo=$row['homeNo'];
					$mu=$row['mu'];
					$tambol=$row['tambol'];
						$q1="SELECT name_th FROM districts where id='$tambol'";          
						$result1 = mysqli_query($conn,$q1);	                                                                 
						$rs1=$result1->fetch_object();
						$tambol_name=$rs1->name_th;
					$amper=$row['amper'];
						$q1="SELECT name_th FROM amphures where id='$amper'";          
						$result1 = mysqli_query($conn,$q1);	                                                                 
						$rs1=$result1->fetch_object();
						$amper_name=$rs1->name_th;
					$address="$homeNo หมู่ $mu ตำบล $tambol_name อำเภอ $amper_name";
					$dateVDOCall=$row['dateVDOCall'];
					if($dateVDOCall==null){$showVDO="ไม่มีนัดหมาย";}
					else{$showVDO="dateTimex($dateVDOCall);?><a href='<?=$idMeet?>'' target='_blank' class='btn btn-info' role='button'><i class='fa fa-video-camera'></i></a>";}
	?>
    	<tr>
	        <td><?php echo $i; ?></td>
	    	<td><?php echo $row['fname'].' '.$row['lname']; ?></td>
			<td><font size=2><?php echo $address;?></td>
			<td><?php echo $row['tel']; ?></td>
			<td><?php echo Thai_date($row['dateSend']);?></td>
			<?php
			if($dateVDOCall==null){echo "<td>ไม่มีนัดหมาย</td>";}
			else{
				?>
			<td><?php echo dateTimex($dateVDOCall);?><a href="<?=$idMeet?>" target="_blank" class="btn btn-info" role="button"><i class="fa fa-video-camera"></i></a> </td>	    	
			<?php } ?>
			<td class='text-center'>
	   
			<a href="./editCase1.php?cid=<?=$cid?>" class="btn btn-danger" role="button"><i class="fa fa-pencil"></i></a> 
			<a href="./delCase.php?cid=<?=$cid?>" class="btn btn-danger" role="button"><i class="fa fa-trash"></i></a> 
			<!-- <a href="#" onclick="javascript:popup('./delCase.php?cid=<?=$cid?>','',800,480)" ><img src='edit.png' width='20' height='20' alt='แก้ไข'></a> -->
			
		
				<!-- <button type="button" data-toggle="modal" data-remote="" data-target="#detailCase<?=$i;?>"><div class="btn btn-success"><i class="fa fa-search"></i></div></button> -->
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

    	<?php  $i++;	}  	?>
    </tbody>
</table>




</body>

</html>