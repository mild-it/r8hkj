<?php
session_start();
include ("connectDB.php");
$d = $_SESSION['pcu'];
$d1 = $_SESSION['level'];
include ("connect.php");
include ("function.php");
$level = $_SESSION['levelx'];
$province = $_SESSION['province'];
  echo $d.$level;
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
<script type="text/javascript">
function popup(url,name,windowWidth,windowHeight){    
    myleft=(screen.width)?(screen.width-windowWidth)/2:100; 
    mytop=(screen.height)?(screen.height-windowHeight)/2:100;   
    properties = "width="+windowWidth+",height="+windowHeight;
    properties +=",scrollbars=yes, top="+mytop+",left="+myleft;   
    window.open(url,name,properties);
}
</script>
<link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
		body {  font-family: 'Kanit', sans-serif;	}
		h1,h2,h3,h4,h5,h6 {  font-family: 'Kanit', sans-serif;	}
    </style>
<style type="text/css">.bgimg {  background-image: url('../images/disLogo.png'); }  </style>

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
	    	<th></th>
	    </tr>
    </thead>
    <tbody>
    	<?php
			if ($level == 'pcu') { $sql = "SELECT c.*, t.hospname as name_obt, t.ampname as obt_ampname FROM caseDis as c left outer join tesaban as t on c.obt = t.tcode where c.statusCase='OBT' and c.hospcode='$d' order by c.dateREG DESC"; }
			elseif ($level == 'opt') { $sql = "SELECT c.*, t.hospname as name_obt, t.ampname as obt_ampname FROM caseDis as c left outer join tesaban as t on c.obt = t.tcode where c.statusCase='OBT' and c.obt='$d1' order by c.dateREG DESC"; }
			elseif ($level == 'pmj') { $sql = "SELECT c.*, t.hospname as name_obt, t.ampname as obt_ampname FROM caseDis as c left outer join tesaban as t on c.obt = t.tcode where c.tambol like '$province%' and (c.statusCase='OBT' or c.infoFrom='OBT') order by c.dateREG DESC"; }
    		$result = mysqli_query($conn,$sql);
    		$i = 1;
    		while($row = mysqli_fetch_array($result))
    		{
				$hospcode = $row['hospcode'];
				$q1="SELECT * FROM member where hospcode= $hospcode and idMeet like 'https://%' ";          
				$result1 = mysqli_query($conn,$q1);	                                                                 
				$rs1=$result1->fetch_object();
				$idMeet=$rs1->idMeet;

				$cid=base64_encode($row['cid']);
				// $id_obt=$row['obt'];
				// $q1="SELECT hospname FROM tesaban where tcode='$id_obt'";
				// $result1 = mysqli_query($conn, $q1);
				// $rs1=$result1->fetch_object();
				// $name_obt=$rs1->hospname;
    	?>
    	<tr>
	        <td><?php echo $i; ?></td>
	    	<td><a href="./detailCase.php?cid=<?=$cid?>" class="btn btn-info" role="button"><?php echo $row['fname'].' '.$row['lname']; ?></a></td>
	    	<td><font size=2><?php echo $row['disType']; ?></td>
			<td><font size=2><?php echo $row['name_obt']." [อ.".$row['obt_ampname']."]"; ?></td>
			<td><?php echo Thai_date($row['dateREG']); ?></td>
			<td><?php echo Thai_date($row['datePMJ']); ?></td>
	    	<td class='text-center'>
	    <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal<?php echo $row['cid'] ?>">View</button> -->
		<!-- <button class="btn btn-info" data-toggle="modal" data-target="#myModal<?php echo $row['cid'] ?>"><i class="fa fa-search"></i></button> -->
		<?php 
		if($level=='pcu'){
		?>
			<a href="./editCase.php?cid=<?=$cid?>" class="btn btn-danger" role="button"><i class="fa fa-pencil"></i></a> 
			<!-- <a href="#" onclick="javascript:popup('./editCase.php?cid=<?=$cid?>','',800,480)" >.</a> -->
			<!-- <a href="editCase.php?cid=<?=$cid?>" target="_blank" >.</a> -->
			
			
		<?php }
		else{
			?>
			<a href="./detailCase.php?cid=<?=$cid?>" class="btn btn-info" role="button"><i class="fa fa-search"></i></a> 
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
	    <?php } ?>
	    	</td>
    	</tr>
        <!-- //  here i am creating a modal popup code......... -->
    	<div id="myModal<?php echo $row['cid'] ?>" class="modal fade" role="dialog">
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
        <!-- // end modal popup code........ -->
    	<?php  $i++;	}  	?>
    </tbody>
</table>
</body>
</html>
