<?php
session_start();
if($_SESSION["levelx"] == "") {
    header("Location: alert_pcu.php");
}
$id_line = $_SESSION['id_line'];
// $id_line ="U12cb71df883f76f21e354bc28f85d701";
include ("connectDB.php");
include ("connect.php");
include ("function.php");
      $sql0 = "SELECT * FROM member WHERE id_line='$id_line' ";
      $result0 = mysqli_query($conn,$sql0);
      $row = mysqli_fetch_array($result0);
      $cid_osm=$row['cid'];
      $provinces=$row["provinces_pcu1"];
   

?>

<!DOCTYPE html>
<html lang="en">
<title>R8NDS</title>
	<head>
	  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
	<head>
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
<script>
	function isImage(fileHouse){
    var ext = getExtension(fileHouse);
    switch(ext.toLowerCase()){
        case 'jpg':
        case 'jpeg':
        case 'gif':
        case 'bmp':
        case 'png':
            return true;
    }
    return false;
}
</script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <style>
		body {  font-family: 'Kanit', sans-serif;	}	h1,h2,h3,h4,h5,h6 {  font-family: 'Kanit', sans-serif;	}
    </style>
    <style type="text/css">.bgimg {  background-image: url('../images/disLogo.png'); }  </style>
</head>
<body>
<div class="container">
<h3>ข้อมูลคนพิการในความรับผิดชอบ</h3>
    	<?php 
			$sql0 = "SELECT * FROM caseDis WHERE osm='$cid_osm' order by dateVDOCall DESC";
			$result0 = mysqli_query($conn,$sql0);
			$nrow0 = mysqli_num_rows($result);
			if($nrow0<=0){echo "ไม่พบข้อมูล";}
    		$i = 1;																								
    		while($row0 = mysqli_fetch_array($result)) 
    		{
                    $cid_case=$row0['cid'];
					$fname=$row0['fname'];					
					$lname=$row0['lname'];
		?>
			<table>
				<tr><td>$fname</td><td>$lanme</td><td><a href="pcu1.php?go2=1&cid_case=<?=$cid_case?>" class="btn btn-info"><i class="fa fa-search"></i></a></td></tr>
			</table>
		<?php
		} 
		if($_REQUEST["go2"]==1){
			$cid_case=$_REQUEST["cid_case"];
			$sql = "SELECT * FROM caseDis WHERE cid='$cid_case' ";
			$result = mysqli_query($conn,$sql);
			$row = mysqli_fetch_array($result);
					$fname=$row['fname'];					
					$lname=$row['lname'];
					$statusCase=$row['statusCase'];
						if($statusCase=='HOS'){$statusCase='โรงพยาบาลกำลังตรวจสอบ';}
						if($statusCase=='PMJ'){$statusCase='พมจ.กำลังตรวจสอบ';}
						if($statusCase=='OBT'){$statusCase='เทศบาล/อบต.กำลังตรวจสอบ';}
						if($statusCase=='DOC'){$statusCase='อยู่ระหว่างขอเอกสารเพิ่มเติม';}
						if($statusCase=='OK'){$statusCase='เรียบร้อยแล้ว';}
					$tel=$row['tel'];
			                $osm=$row['osm'];
			                $cm=$row['cm'];
			                $positionDis=$row['positionDis'];
			                $incomes=$row['incomes'];
			                $fileHouse=$row['fileHouse'];
			                $needs=$row['needs'];
					$needs_cm=$row['needs_cm']; if($needs_cm=='y'){$c='checked';}
			                $lat=$row['lat'];
			                $long=$row['long'];
			                $problems=$row['problems'];
					$dateVDOCall=$row['dateVDOCall'];
					$idSend=$row['idSend'];
			                $hospcode=$row['hospcode'];
						$q1="SELECT * FROM member where hospcode='$hospcode' and idMeet like 'https://%' ";          
							$result1 = mysqli_query($conn,$q1);	                                                                 
							$rs1=$result1->fetch_object();
							$idMeet=$rs1->idMeet;

							$homeNo=$row['homeNo'];
							$mu=$row['mu'];
							$tambol=$row['tambol'];
								$q2="SELECT * FROM districts where id='$tambol'";          
								$result2 = mysqli_query($conn,$q2);	                                                                 
								$rs2=$result2->fetch_object();
								$tambol=$rs2->name_th;
							$amper=$row['amper'];
								$q3="SELECT * FROM amphures where id='$amper'";          
								$result3 = mysqli_query($conn,$q3);	                                                                 
								$rs3=$result3->fetch_object();
								$amper=$rs3->name_th;
	?>
			<div class="card  bg-light" style="width:100%">
				<div class="card-body">
					<h4 class="card-title "><?=$i.'# '.$fname.' '.$lname?></h4>
					<p class="card-text">สถานะ : <?=$statusCase?></p>
					<p class="card-text">โทรศัพท์ : <?=$tel?> <a href="tel:<?=$tel?>" target="_blank" class="btn btn-info btn-lg" role="button"><i class="fa fa-volume-control-phone"></i></a>	</p>
					<p class="card-text">ที่อยู่ : เลขที่ <?=$homeNo?> หมู่<?=$mu?> ตำบล <?=$tambol?> อำเภอ <?=$amper?></p>
					<p class="card-text">วันนัด VDO Call :
					<?php
					if($dateVDOCall==null){echo "ไม่มีนัดหมาย";}
					else{
						?>
					<?php echo dateTimex($dateVDOCall);?> //กรุณากดปุ่มนี้>><a href="<?=$idMeet?>" target="_blank" class="btn btn-primary btn-lg" role="button"><i class="fa fa-video-camera"></i></a>	    	
					<?php } ?></p>
					
					<div class="card">
					<br>
					<FORM name="form2" class="form-inline" ACTION ='pcu1.php?act=2&cid_case=<?=$cid_case?>&provinces=<?=$provinces?>' METHOD='post'  enctype='multipart/form-data'>
					<p>&nbsp;&nbsp;ผู้ดูแล : <input type="text" name="cm" value="<?=$cm?>"></p>
					<p>&nbsp;&nbsp;พิการตำแหน่ง : <input type="text" name="positionDis" value="<?=$positionDis?>"></p>
					<p>&nbsp;&nbsp;รายได้ : <input type="text" name="incomes" value="<?=$incomes?>"></p>
					<p>&nbsp;&nbsp;ปัญหาอื่นๆ : <input type="text" name="problems" value="<?=$problems?>"></p>
					<p>&nbsp;&nbsp;ความต้องการสนับสนุน(อบจ.) : <input type="text" name="needs" value="<?=$needs?>"></p>
					<p> <input type="checkbox" class="form-check-input" id="check2" name="needs_cm" value="y" <?=$c?>>
                                             <label class="form-check-label" for="check2">ต้องการผู้ดูแล(พมจ.)</label></p>   
					<p>&nbsp;&nbsp;&nbsp;<input type="submit" value="ปรับปรุงข้อมูล" class="btn btn-secondary">	</p>
					</div>
				</form>
					<p>รูปถ่ายที่อยู่อาศัย : <a href="house.php?cid_case=<?=$cid_case?>" target="_blank" class="btn btn-success btn-lg" role="button" enctype='multipart/form-data'><i class="fa fa-home"></i></a> 
				
                    &nbsp;&nbsp;&nbsp;พิกัด : <a href="location.php?cid_case=<?=$cid_case?>" target="_blank" class="btn btn-success btn-lg" role="button" enctype='multipart/form-data'><i class="fa fa-map-marker"></i></a> </p>	
				</div>
			</div>
		<br>
    	<?php  $i++;	}  	?>
   
</div>
</body>	
<?php
if($_REQUEST["act"]==2)
{
  include ("connectDB.php");
  include ("connect.php");
  $cid_case=$_REQUEST["cid_case"];
  $cm=$_REQUEST["cm"]; 
  $positionDis=$_REQUEST["positionDis"];  
  $incomes=$_REQUEST["incomes"];
  $provinces=$_REQUEST["provinces"];
  $needs=$_REQUEST["needs"]; 
	
	if($needs=='ได้รับแล้ว'){$needsx=0;}if($needs==''){$needsx=0;}
	if($needsx!=0){
	//-----------แจ้ง Line อบจ.
            $sql0 = "SELECT * FROM member WHERE `level` = 'obj' and provinces_obj='$provinces'";
            $query0 = mysqli_query($conn, $sql0);
            while ($result0 = mysqli_fetch_assoc($query0)) {
                $id_line = $result0['id_line'];
                $userId = $id_line;
                // ข้อความที่ต้องการส่ง
                $messages = array(
                    'type' => 'text',
                    'text' => 'โปรดตรวจสอบคนพิการที่ขอรับการสนับสนุน คลิ๊ก>> https://datacenter-r8way.moph.go.th/r8nds/obj.php',
                );
                $post = json_encode(array(
                    'to' => array($userId),
                    'messages' => array($messages),
                ));
                // URL ของบริการ Replies สำหรับการตอบกลับด้วยข้อความอัตโนมัติ
                $url = 'https://api.line.me/v2/bot/message/multicast';
                $headers = array('Content-Type: application/json', 'Authorization: Bearer '.$access_token);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                $result = curl_exec($ch);
                echo $result;
            } //ปิด while ค้นหา line _id
	}
	
	$needs_cm=$_REQUEST["needs_cm"];
	if($needs_cm=='y'){
	//-----------แจ้ง Line พมจ.
            $sql0 = "SELECT * FROM member WHERE `level` = 'pmj' and provinces_pmj='$provinces'";
            $query0 = mysqli_query($conn, $sql0);
            while ($result0 = mysqli_fetch_assoc($query0)) {
                $id_line = $result0['id_line'];
                $userId = $id_line;
                // ข้อความที่ต้องการส่ง
                $messages = array(
                    'type' => 'text',
                    'text' => 'โปรดตรวจสอบคนพิการที่ขอผู้ดูแล คลิ๊ก>> https://datacenter-r8way.moph.go.th/r8nds/pmj.php',
                );
                $post = json_encode(array(
                    'to' => array($userId),
                    'messages' => array($messages),
                ));
                // URL ของบริการ Replies สำหรับการตอบกลับด้วยข้อความอัตโนมัติ
                $url = 'https://api.line.me/v2/bot/message/multicast';
                $headers = array('Content-Type: application/json', 'Authorization: Bearer '.$access_token);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                $result = curl_exec($ch);
                echo $result;
            } //ปิด while ค้นหา line _id
	}
  $problems=$_REQUEST["problems"]; 
  $sql = "UPDATE caseDis SET cm='$cm',positionDis='$positionDis',incomes='$incomes',needs='$needs',needs_cm='$needs_cm',problems='$problems' WHERE cid='$cid_case' ";
  $mysqli->query($sql);
?>
  <META HTTP-EQUIV="Refresh" CONTENT="0;URL=./pcu1.php">
<?php
}
  
?>

</html>
