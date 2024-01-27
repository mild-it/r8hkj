<?php
@session_start();
if($_SESSION["levelx"] == "") {
  header("Location: page-login.php");
}
?>

<?php
/* ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
 $level='opt';*/
?>
<?php
$province = $_SESSION['province'];
$d = $_SESSION['pcu'];
$level = $_SESSION['levelx'];
if ($level == 'pmj') { $levelId = 'PMJ'; } if ($level == 'opt') {$levelId = 'OBT'; }
$cid = $_REQUEST["cid"];

include ("connect.php");
include ("function.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>R8:NDS</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/disLogo.png">
    <!-- Pignose Calender -->
    <link href="./plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="./plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="./plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <!-- Custom Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<script language="javascript">
function checkID(id) {
  if (id.length != 13) return false;
  for(i=0, sum=0; i < 12; i++)
  sum += parseFloat(id.charAt(i))*(13-i); if((11-sum%11)%10!=parseFloat(id.charAt(12)))
  return false; return true;}

function checkForm()
{ if(!checkID(document.form1.cid.value))
  document.form1.cid.value='';
// alert('รหัสประชาชนไม่ถูกต้อง');
}

function closeWin() {
  myWindow.close();   // Closes the new window
}
</script>
<script language="javascript">
function CheckNum(){
if (event.keyCode < 48 || event.keyCode > 57){
      event.returnValue = false;
     }
}
</script>

<script  language="javascript">  
		function confirmAdd()  {  return confirm('ต้องการเพิ่มรายการนี้? / โปรดยืนยัน!');    }  
		function reload_view(t) { 	window.opener.location.reload();	setTimeout("self.close()",(t * 10000)); }
</script>
<link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
		body {
		  font-family: 'Kanit', sans-serif;
		}
		h1,h2,h3,h4,h5,h6 {
		  font-family: 'Kanit', sans-serif;
		}

    .modal-body {
      /* 100% = dialog height, 120px = header + footer */
      max-height: calc(100% - 120px);
      overflow-y: scroll;
    }
    </style>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
<?php
if ($_REQUEST["act"] == 1) {
  include ("connectDB.php");

  //$cid=$_REQUEST["cid"]; 
  $info = $_REQUEST["info"];
  $obt = $_REQUEST["obt"];
  $obt_name = $_REQUEST["obt_name"];
  
  if ($_FILES['fileCard']['name'] != "") {
    $fileCard = $rs1->fileCard;	
    $DIR = 'temp/';
    $delfile10 = $DIR.$fileCard;
    unlink($delfile10);
    $output_dir = "temp/";
    $sur = strrchr($_FILES['fileCard']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
    $fileCard = ('Card'.$cid.$sur); //ชื่อไฟล์ตาม id
    move_uploaded_file($_FILES["fileCard"]["tmp_name"], $output_dir.$fileCard);
    $sql = "UPDATE caseDis SET fileCard='$fileCard' WHERE cid='$cid' ";
    $mysqli->query($sql);
  }

  $sql = "UPDATE caseDis SET statusCase = 'OBT', datePMJ = now() WHERE cid = '$cid'";
  $mysqli->query($sql);
  echo "<center><h3>บันทึกข้อมูลเรียบร้อยแล้ว</h3></center>";
  //-----------แจ้ง Line
  $sql0 = "SELECT * FROM member WHERE opt='$obt' and id_line is not null";
  $query0 = mysqli_query($conn, $sql0);
  while ($result0 = mysqli_fetch_assoc($query0)) {
    $id_line = $result0['id_line'];
    // echo "$id_line <br>";
    // Access Token
    // $access_token = 'eNQ1Evl9snf9RLTTYTSYMoF1BkKVRFatm33B/ZdQmuPhjb913O+RT8l8t+2Ujxew3NtjmTbL8JYET5YGgGh0d5LY8eiq/JAAmbZVFmBuM7ZWekaas7LgtQ3Vl5KtuW0JSgFfq4h4XUGQ4Vuu+0s9sQdB04t89/1O/w1cDnyilFU=';
    // User ID
    // $userId = 'U80b248f7031744090346ea54c520a1b2';
    $userId = $id_line;
    // ข้อความที่ต้องการส่ง
    $messages = array(
      'type' => 'text',
      'text' => $obt_name.'โปรดตรวจสอบผู้ขอขึ้นทะเบียนรายใหม่ คลิ๊ก>> https://datacenter-r8way.moph.go.th/r8nds/page3.php',
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
  } // ปิด while ค้นหา line _id

  ?>
<?php
  if($levelId=='PMJ'){
    ?>
<META HTTP-EQUIV="Refresh" CONTENT="0;URL=./page2.php">
<?php } ?>
<?php
  if($levelId=='OBT'){
    ?>
<META HTTP-EQUIV="Refresh" CONTENT="0;URL=./page3.php">
<?php } ?>

<?php
} // ปิด add
elseif($_REQUEST["act"]==5)
{
  include ("connectDB.php");

  $cid=$_REQUEST["cid"]; 
  $statusCasex=$_REQUEST["statusCasex"];  
     
           $sql = "UPDATE caseDis SET statusCase='$statusCasex' WHERE cid='$cid' ";
           $mysqli->query($sql);
           
            echo "<center><h3>บันทึกข้อมูลเรียบร้อยแล้ว</h3>";
  ?>
<?php
  if($levelId=='PMJ'){   ?><META HTTP-EQUIV="Refresh" CONTENT="0;URL=./page2.php"><?php } ?>
<?php
  if($levelId=='OBT'){   ?><META HTTP-EQUIV="Refresh" CONTENT="0;URL=./page3.php"><?php } ?>
<?php
}

elseif ($_REQUEST["act"] == 3) {
  include ("connectDB.php");
  $cid = $_REQUEST["cid"];
  $obt_name = $_REQUEST["obt_name"];
  $hospcode = $_REQUEST["hospcode"];

  $cool_extensions = Array('.pdf', '.jpg', '.png', '.jpeg');
  if ($_FILES['file_ds_money']['name'] != "") {
    $output_dir = "temp/obt/";
    $sur = strrchr($_FILES['file_ds_money']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
    if (!in_array($sur, $cool_extensions)) {
      echo "<script>alert('ระบบรองรับไฟล์ pdf, jpg, png เท่านั้น')</script>";
      // echo "ระบบรองรับไฟล์ pdf, jpg, png เท่านั้น";
      echo "<meta http-equiv='refresh' content='0;url=page3.php'>";
      exit();
    }
    $file_ds_money = ('dsm_'.$cid.$sur); //ชื่อไฟล์ตาม id
    move_uploaded_file($_FILES["file_ds_money"]["tmp_name"], $output_dir.$file_ds_money);
  }
  $sql = "UPDATE caseDis SET statusCase = 'OK', dateOBT = now() ,infoFrom='' ";
  if ($_FILES['file_ds_money']['name'] != "") {
    $sql .= ", fileOBT = '$file_ds_money'";
  }
  $sql .= " WHERE cid = '$cid'";
  $mysqli->query($sql);
  echo "<center><h3>บันทึกข้อมูลเรียบร้อยแล้ว</h3></center>";

  //-----------แจ้ง Line
  $sql_name = "select fname, lname from caseDis where cid='$cid'";
  $result_name = $mysqli->query($sql_name);
  $r_name = mysqli_fetch_array($result_name);

  $sql0 = "SELECT * FROM member WHERE hospcode='$hospcode' and id_line is not null";
  $query0 = mysqli_query($conn, $sql0);
  while ($result0 = mysqli_fetch_assoc($query0)) {
    $id_line = $result0['id_line'];
    // echo "$id_line <br>";
    // Access Token
    // $access_token = 'eNQ1Evl9snf9RLTTYTSYMoF1BkKVRFatm33B/ZdQmuPhjb913O+RT8l8t+2Ujxew3NtjmTbL8JYET5YGgGh0d5LY8eiq/JAAmbZVFmBuM7ZWekaas7LgtQ3Vl5KtuW0JSgFfq4h4XUGQ4Vuu+0s9sQdB04t89/1O/w1cDnyilFU=';
    // User ID
    // $userId = 'U80b248f7031744090346ea54c520a1b2';
    $userId = $id_line;
    // ข้อความที่ต้องการส่ง
    $messages = array(
      'type' => 'text',
      // 'text' => $off_name.'มีคนพิการได้รับการดูแลเรียบร้อยแล้ว โดย'.$obt_name,
      // 'text' => 'ผู้พิการชื่อ '.$r_name["fname"].' '.$r_name["lname"].' ได้รับการดูแลเรียบร้อยแล้ว โดย'.$obt_name,
      'text' => 'ผู้พิการ ได้รับการดูแลเรียบร้อยแล้ว โดย'.$obt_name,
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
  } // ปิด while ค้นหา line _id

  if ($levelId == 'PMJ') { ?><META HTTP-EQUIV="Refresh" CONTENT="0;URL=./page2.php"><?php } ?>
  <?php
  if ($levelId == 'OBT') { ?><META HTTP-EQUIV="Refresh" CONTENT="0;URL=./page3.php"><?php } ?>
  <?php
}
elseif($_REQUEST["act"]==2)
{
  include ("connectDB.php");

  $cid=$_REQUEST["cid"]; 
  $info=$_REQUEST["info"]; 
  $off_name=$_REQUEST["off_name"]; 
  $hospcode=$_REQUEST["hospcode"]; 
  
      
           $sql = "UPDATE caseDis SET info='$info',statusCase='DOC',infoFrom='$levelId' WHERE cid='$cid' ";
           $mysqli->query($sql);
           
            echo "<center><h3>บันทึกข้อมูลเรียบร้อยแล้ว</h3>";

//-----------แจ้ง Line
$sql0 = "SELECT * FROM member WHERE hospcode='$hospcode' and id_line is not null";
$query0 = mysqli_query($conn, $sql0);
while($result0 = mysqli_fetch_assoc($query0)) {
  $id_line = $result0['id_line'];
  
$userId = $id_line;
// ข้อความที่ต้องการส่ง
$messages = array(
'type' => 'text',
'text' => $off_name.'โปรดส่งเอกสารหรือให้ข้อมูลเพิ่มเติม คลิ๊ก>> https://datacenter-r8way.moph.go.th/r8nds/page1.php',
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
}//ปิด while ค้นหา line _id

  ?>
<?php
  if($levelId=='PMJ'){
    ?>
<META HTTP-EQUIV="Refresh" CONTENT="0;URL=./page2.php">
<?php } ?>
<?php
  if ($levelId == 'OBT') {
    ?>
<META HTTP-EQUIV="Refresh" CONTENT="0;URL=./page3.php">
<?php } ?>
<?php
} elseif ($_REQUEST["act"] == 4) {
          include ("connectDB.php");
          $cid=$_REQUEST["cid"];
          $dateOBT=$_REQUEST["dateOBT"];
          $sql = "UPDATE caseDis SET dateOBT='$dateOBT',statusCase='OK' ,infoFrom=''  WHERE cid='$cid' ";
          $mysqli->query($sql);

            $q1="SELECT * FROM caseDis where cid='$cid'";          
            $result1 = $mysqli->query($q1);                                                                   
            $rs1=$result1->fetch_object();
            $fname=$rs1->fname;
            $lname=$rs1->lname;
            $idSend=$rs1->idSend;
            $obt=$rs1->obt;
              $q2="SELECT * FROM tesaban where tcode='$obt'";          
              $result2 = $mysqli->query($q2);                                                                   
              $rs2=$result2->fetch_object();
              $obt_name=$rs2->hospname;
          
           echo "<center><h3>แจ้งข้อมูลเรียบร้อยแล้ว</h3>";
//-----------แจ้ง Line
        
        $userId = $idSend;
        // ข้อความที่ต้องการส่ง
        $messages = array(
        'type' => 'text',
        'text' => 'มีการแจ้งให้ไปติดต่อที่'.$obt_name.' ในวันที่ '.$dateOBT.'กรุณาตรวจสอบในระบบ',
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
     ?> 
          <META HTTP-EQUIV="Refresh" CONTENT="0;URL=./page3.php">
        <?php
        } else { // ไม่เข้า act อะไรซักอย่าง
  
  // $hospcode=23367;
?>
<div class="container">

        <div class="container">       

          <div class="input-group mb-3 input-group-sm">
          <?php
            include ("connectDB.php");
            $cid=$_REQUEST["cid"];
            $cid=base64_decode($cid);
            // $cid=1399900532681;
            $q1="SELECT * FROM caseDis where cid = '$cid'";          
            $result1 = $mysqli->query($q1);                                                                   
            $rs1 = $result1->fetch_object();
            $cid = $rs1->cid;
            $fname = $rs1->fname;
            $lname = $rs1->lname;
            $sex = $rs1->sex;
            $birth = $rs1->birth;
            $disType = $rs1->disType;
            $homeNo = $rs1->homeNo;
            $disType = $rs1->disType;
            $mu = $rs1->mu;
            $tambol = $rs1->tambol;
                $q0 = "SELECT * FROM districts where id='$tambol'";          
                $result0 = $mysqli->query($q0);                                                                   
                $rs0=$result0->fetch_object();
                $tambolName=$rs0->name_th;
            $amper=$rs1->amper;
                $q0="SELECT * FROM amphures where id='$amper'";          
                $result0 = $mysqli->query($q0);                                                                   
                $rs0=$result0->fetch_object();
                $amperName=$rs0->name_th;
            $tel=$rs1->tel;
            $obt=$rs1->obt;
                $q0="SELECT * FROM tesaban where tcode='$obt'";          
                $result0 = $mysqli->query($q0);                                                                   
                $rs0=$result0->fetch_object();
                $obt_name=$rs0->hospname;
            $hospcode=$rs1->hospcode;
                $q0="SELECT * FROM office where off_id='$hospcode'";          
                $result0 = $mysqli->query($q0);                                                                   
                $rs0=$result0->fetch_object();
                $off_name=$rs0->off_name;
            $fileIdCard=$rs1->fileIdCard;
            $fileHome=$rs1->fileHome;
            $fileFace=$rs1->fileface;
            $fileBook=$rs1->fileBook;
            $filePict=$rs1->filePict;
            $fileBank=$rs1->fileBank; 
            $fileReg=$rs1->fileReg;
            $fileIdCard2=$rs1->fileIdCard2;
            $fileHome2=$rs1->fileHome2;
            $fileCard=$rs1->fileCard;
            $fileConsent=$rs1->fileConsent;
            $fileCaregiver = $rs1->fileCaregiver;
            $fileCaregiverChange = $rs1->fileCaregiverChange;
            $fileAuthorize = $rs1->fileAuthorize;
            $fileDSCard = $rs1->fileDSCard;
            $fileOBT = $rs1->fileOBT;
	    $fileDelivery = $rs1->fileDelivery;
            $statusCase=$rs1->statusCase;
            $infox=$rs1->info;
            $idSend=$rs1->idSend;
            $dateREG=Thai_date($rs1->dateREG);
            $datePMJ=Thai_date($rs1->datePMJ);
            $dateOBT=Thai_date($rs1->dateOBT);  
            $birth_thai=Thai_date($rs1->birth);                     

          // include('connect.php');
          // $sql = "SELECT * FROM amphures where province_id=27";
          // $query = mysqli_query($conn, $sql);
          ?>
          <div class="container my-5">
          <button onclick="history.back(-1)" class="btn btn-success"> <i class="fa fa-arrow-left"></i> กลับ</button>
    <div class="card">
    <div class="card-header">
      <!-- <div class="card-body"> -->
            <h5>รายละเอียดข้อมูลคนพิการ</h5>
            <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">เลขประชาชน : </span>
                      </div>
                    <input type="text" class="form-control"  name="cid" value="<?=$cid?>" readonly>
                    <!-- <p><?=$cid?></p> -->
                    </div> 
            <div class="input-group mb-3 input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">ชื่อ :</span>
            </div>
          <input type="text" class="form-control"  name="fname" value="<?=$fname?>" readonly>
          </div>
          <div class="input-group mb-3 input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">สกุล :</span>
            </div>
          <input type="text" class="form-control"  name="lname" value="<?=$lname?>" readonly>
          </div>  
          <div class="input-group mb-3 input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">เพศ :</span>
            </div>
            <input type="text" class="form-control"  name="sex" value="<?=$sex?>" readonly>
            </div>
            <div class="input-group mb-3 input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">วันเดือนปีเกิด :</span>
            </div>
          <input type="text" class="form-control"  name="birth" value="<?=$birth_thai?>" readonly>
          </div>  
            <div class="input-group mb-3 input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">ประเภทความพิการ</span>
            </div>
            <input type="text" class="form-control"  name="disType" value="<?=$disType?>" readonly>
          </div>         
        </div>
        </div>   
        <div class="card bg-light">
    <div class="card-header">
            <h5>ข้อมูลที่อยู่</h5>
            <div class="input-group mb-3 input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">บ้านเลขที่ :</span>
            </div>
          <input type="text" class="form-control"  name="homeNo" value="<?=$homeNo?>" readonly>
          </div>
          <div class="input-group mb-3 input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">หมู่ที่ :</span>
            </div>
            <input type="text" class="form-control"  name="mu" value="<?=$mu?>" readonly>
          </div>  

                <div class="input-group mb-3 input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">อำเภอ : </span>
                  </div>
                  <input type="text" class="form-control" name="amphure_id" value="<?=$amperName?>" readonly>
                    </div>

                        <div class="input-group mb-3 input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">ตำบล :  </span>
                        </div>
                        <input type="text" class="form-control" name="district_id" value="<?=$tambolName?>" readonly>
                       </div>
                    
                    <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">โทรศัพท์มือถือ : </span>
                      </div>
                    <input type="text" class="form-control" name="tel" value="<?=$tel?>" readonly>
                    </div> 
                    <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">อยูในเขตเทศบาล/อบต.</span>
                      </div>
                      <input type="text" class="form-control" name="obt" value="<?=$obt_name?>" readonly>
                    </div>
                    
          </div>
        </div>
        <div class="card">
          <div class="card-header">ข้อมูลเอกสาร</div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" value="แบบคำขอมีบัตรประจำตัวคนพิการ" readonly>
                  <div class="input-group-append">
                    <button class="btn btn-info" type="button" data-toggle="modal" data-target="#ModalDSCard">ดูเอกสาร</button>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="ModalDSCard" role="dialog">
                <div class="modal-dialog modal-xl">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">แบบคำขอมีบัตรประจำตัวคนพิการ</h4>
                    </div>
                    <div class="modal-body">
                      <?php if ($fileConsent == '' || $fileConsent == null) { echo "ไม่สามารถเปิดแฟ้มข้อมูลได้ จะต้องมีหนังสือให้คำยินยอมเปิดเผยข้อมูลก่อน"; } elseif ($fileDSCard == '' || $fileDSCard == null) { echo "ไม่พบไฟล์เอกสาร"; } else { ?>
                      <embed SRC=./temp/<?=$fileDSCard?> style="width:100%; height:100%;">
                      <a href="dl_pic.php?pic=temp/<?=$fileDSCard?>">ดาวน์โหลด</a>
                      <?php } ?>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="input-group mb-3 input-group">
                  <input type="text" class="form-control" value="หนังสือให้คำยินยอมเปิดเผยข้อมูล" readonly>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalConsent">ดูเอกสาร</button>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="ModalConsent" role="dialog">    
                <div class="modal-dialog modal-xl">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">หนังสือให้คำยินยอมเปิดเผยข้อมูล</h4>
                    </div>
                    <div class="modal-body">
                    <?php if ($fileConsent == '' || $fileConsent == null) { echo "ไม่พบไฟล์เอกสาร"; } else { ?>
                      <embed SRC=./temp/<?=$fileConsent?> style="width:100%; height:100%;">
                      <a href="dl_pic.php?pic=temp/<?=$fileConsent?>">ดาวน์โหลด</a>
                      <?php } ?>
                    </div>
                    <div class="modal-footer">                                    
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="input-group mb-3 input-group">
                  <input type="text" class="form-control" value="เอกสารรับรองความพิการ" readonly>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalBook">ดูเอกสาร</button>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="ModalBook" role="dialog">
                <div class="modal-dialog modal-xl">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">เอกสารรับรองความพิการ</h4>
                    </div>
                    <div class="modal-body">
                    <?php if($fileConsent==''||$fileConsent== null){echo "ไม่สามารถเปิดแฟ้มข้อมูลได้ จะต้องมีหนังสือให้คำยินยอมเปิดเผยข้อมูลก่อน";}elseif($fileBook==''||$fileBook== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                      <embed SRC=./temp/<?=$fileBook?> style="width:100%; height:100%;">
                      <a href="dl_pic.php?pic=temp/<?=$fileBook?>">ดาวน์โหลด</a>
                      <?php }?>
                    </div>
                    <div class="modal-footer">                                    
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="input-group mb-3 input-group">
                  <input type="text" class="form-control" value="สำเนาบัตรประชาชนคนพิการ" readonly>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalIdCard">ดูเอกสาร</button>
                  </div>
                </div>
                <div class="modal fade" id="ModalIdCard" role="dialog">
                  <div class="modal-dialog modal-xl">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">สำเนาบัตรประชาชนคนพิการ</h4>
                      </div>
                      <div class="modal-body">
                      <?php if($fileConsent==''||$fileConsent== null){echo "ไม่สามารถเปิดแฟ้มข้อมูลได้ จะต้องมีหนังสือให้คำยินยอมเปิดเผยข้อมูลก่อน";}elseif($fileIdCard==''||$fileIdCard== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                        <embed SRC=./temp/<?=$fileIdCard?> style="width:100%; height:100%;"> 
                        <a href="dl_pic.php?pic=temp/<?=$fileIdCard?>">ดาวน์โหลด</a>                                    
                        <?php }?>
                      </div>
                      <div class="modal-footer">                                    
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="input-group mb-3 input-group">
                  <input type="text" class="form-control" value="สำเนาทะเบียนบ้านคนพิการ" readonly>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalHome">ดูเอกสาร</button>
                  </div>
                </div> 
                <div class="modal fade" id="ModalHome" role="dialog">    
                  <div class="modal-dialog modal-xl">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">สำเนาทะเบียนบ้านคนพิการ</h4>
                      </div>
                      <div class="modal-body">
                      <?php if($fileConsent==''||$fileConsent== null){echo "ไม่สามารถเปิดแฟ้มข้อมูลได้ จะต้องมีหนังสือให้คำยินยอมเปิดเผยข้อมูลก่อน";}elseif($fileHome==''||$fileHome== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                        <embed SRC=./temp/<?=$fileHome?> style="width:100%; height:100%;">
                        <a href="dl_pic.php?pic=temp/<?=$fileHome?>">ดาวน์โหลด</a>
                        <?php }?>
                      </div>
                      <div class="modal-footer">                                    
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="input-group mb-3 input-group">
                  <input type="text" class="form-control" value="สำเนาบัตรประชาชนผู้ดูแล" readonly>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalIdCard2">ดูเอกสาร</button>
                  </div>
                </div> 
                <div class="modal fade" id="ModalIdCard2" role="dialog">    
                  <div class="modal-dialog modal-xl">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">สำเนาบัตรประชาชนผู้ดูแล</h4>
                      </div>
                      <div class="modal-body">
                      <?php if($fileConsent==''||$fileConsent== null){echo "ไม่สามารถเปิดแฟ้มข้อมูลได้ จะต้องมีหนังสือให้คำยินยอมเปิดเผยข้อมูลก่อน";}elseif($fileIdCard2==''||$fileIdCard2== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                        <embed SRC=./temp/<?=$fileIdCard2?> style="width:100%; height:100%;">
                        <a href="dl_pic.php?pic=temp/<?=$fileIdCard2?>">ดาวน์โหลด</a>
                        <?php }?>
                      </div>
                      <div class="modal-footer">                                    
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div> 
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="input-group mb-3 input-group">
                  <input type="text" class="form-control" value="สำเนาทะเบียนบ้านผู้ดูแล" readonly>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalHome2">ดูเอกสาร</button>
                  </div>
                </div> 
                <div class="modal fade" id="ModalHome2" role="dialog">    
                  <div class="modal-dialog modal-xl">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">สำเนาทะเบียนบ้านผู้ดูแล</h4>
                      </div>
                      <div class="modal-body">
                      <?php if($fileConsent==''||$fileConsent== null){echo "ไม่สามารถเปิดแฟ้มข้อมูลได้ จะต้องมีหนังสือให้คำยินยอมเปิดเผยข้อมูลก่อน";}elseif($fileHome2==''||$fileHome2== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                        <embed SRC=./temp/<?=$fileHome2?> style="width:100%; height:100%;">
                        <a href="dl_pic.php?pic=temp/<?=$fileHome2?>">ดาวน์โหลด</a>
                        <?php }?>
                      </div>
                      <div class="modal-footer">                                    
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div> 
              </div>
              <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="input-group mb-3 input-group">
                  <input type="text" class="form-control" value="รูปถ่ายหน้าตรง" readonly>
                  <div class="input-group-append">
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalFace">ดูเอกสาร</button>
                </div>
                </div> 
                <div class="modal fade" id="ModalFace" role="dialog">    
                  <div class="modal-dialog modal-xl">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">รูปถ่ายหน้าตรง</h4>
                      </div>
                      <div class="modal-body">
                      <?php if($fileConsent==''||$fileConsent== null){echo "ไม่สามารถเปิดแฟ้มข้อมูลได้ จะต้องมีหนังสือให้คำยินยอมเปิดเผยข้อมูลก่อน";}elseif($fileFace==''||$fileFace== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                        <IMG SRC=./temp/<?=$fileFace?> style="width:100%; height:100%;">
                        <a href="dl_pic.php?pic=temp/<?=$fileFace?>">ดาวน์โหลด</a>
                        <?php }?>
                      </div>
                      <div class="modal-footer">                                    
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="input-group mb-3 input-group">
                  <input type="text" class="form-control" value="รูปถ่ายความพิการ" readonly>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalPict">ดูเอกสาร</button>
                  </div>
                </div> 
                <div class="modal fade" id="ModalPict" role="dialog">    
                  <div class="modal-dialog modal-xl">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">รูปถ่ายความพิการ</h4>
                      </div>
                      <div class="modal-body">
                      <?php if($fileConsent==''||$fileConsent== null){echo "ไม่สามารถเปิดแฟ้มข้อมูลได้ จะต้องมีหนังสือให้คำยินยอมเปิดเผยข้อมูลก่อน";}elseif($filePict==''||$filePict== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                        <embed SRC=./temp/<?=$filePict?> style="width:100%; height:100%;">
                        <a href="dl_pic.php?pic=temp/<?=$filePict?>">ดาวน์โหลด</a>
                        <?php }?>
                      </div>
                      <div class="modal-footer">                                    
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="input-group mb-3 input-group">
                  <input type="text" class="form-control" value="บัตรคนพิการ" readonly>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalCard">ดูเอกสาร</button>
                  </div>
                </div> 
                <div class="modal fade" id="ModalCard" role="dialog">    
                  <div class="modal-dialog modal-xl">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">บัตรคนพิการ</h4>
                      </div>
                      <div class="modal-body">
                      <?php if($fileConsent==''||$fileConsent== null){echo "ไม่สามารถเปิดแฟ้มข้อมูลได้ จะต้องมีหนังสือให้คำยินยอมเปิดเผยข้อมูลก่อน";}elseif($fileCard==''||$fileCard== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                        <embed SRC=./temp/<?=$fileCard?> style="width:100%; height:100%;">
                        <a href="dl_pic.php?pic=temp/<?=$fileCard?>">ดาวน์โหลด</a>
                        <?php }?>
                      </div>
                      <div class="modal-footer">                                    
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="input-group mb-3 input-group">
                  <input type="text" class="form-control" value="รูปถ่ายหน้าบัญชีธนาคาร" readonly>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalBank">ดูเอกสาร</button>
                  </div>
                </div>
                <div class="modal fade" id="ModalBank" role="dialog">    
                  <div class="modal-dialog modal-xl">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">รูปถ่ายหน้าบัญชีธนาคาร</h4>
                      </div>
                      <div class="modal-body">
                        <?php if($fileConsent==''||$fileConsent== null){echo "ไม่สามารถเปิดแฟ้มข้อมูลได้ จะต้องมีหนังสือให้คำยินยอมเปิดเผยข้อมูลก่อน";}elseif($fileBank==''||$fileBank== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                        <embed SRC=./temp/<?=$fileBank?> style="width:100%; height:100%;">
                        <a href="dl_pic.php?pic=temp/<?=$fileBank?>">ดาวน์โหลด</a>
                        <?php }?>
                      </div>
                      <div class="modal-footer">                                    
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="input-group mb-3 input-group">
                  <input type="text" class="form-control" value="หนังสือรับรองการเป็นผู้ดูแลคนพิการ" readonly>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalCaregiver">ดูเอกสาร</button>
                  </div>
                </div>
                <div class="modal fade" id="ModalCaregiver" role="dialog">    
                  <div class="modal-dialog modal-xl">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">หนังสือรับรองการเป็นผู้ดูแลคนพิการ</h4>
                      </div>
                      <div class="modal-body">
                        <?php if ($fileConsent == '' || $fileConsent == null) { echo "ไม่สามารถเปิดแฟ้มข้อมูลได้ จะต้องมีหนังสือให้คำยินยอมเปิดเผยข้อมูลก่อน"; } elseif ($fileCaregiver == '' || $fileCaregiver == null) { echo "ไม่พบไฟล์เอกสาร"; } else { ?>
                        <embed SRC=./temp/<?=$fileCaregiver?> style="width:100%; height:100%;">
                        <a href="dl_pic.php?pic=temp/<?=$fileCaregiver?>">ดาวน์โหลด</a>
                        <?php } ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="input-group mb-3 input-group">
                  <input type="text" class="form-control" value="หนังสือยินยอมให้เพิ่มหรือเปลี่ยนแปลงผู้ดูแลคนพิการ" readonly>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalCaregiverChange">ดูเอกสาร</button>
                  </div>
                </div>
                <div class="modal fade" id="ModalCaregiverChange" role="dialog">    
                  <div class="modal-dialog modal-xl">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">หนังสือยินยอมให้เพิ่มหรือเปลี่ยนแปลงผู้ดูแลคนพิการ</h4>
                      </div>
                      <div class="modal-body">
                        <?php if ($fileConsent == '' || $fileConsent == null) { echo "ไม่สามารถเปิดแฟ้มข้อมูลได้ จะต้องมีหนังสือให้คำยินยอมเปิดเผยข้อมูลก่อน";}elseif($fileCaregiverChange == '' || $fileCaregiverChange == null) { echo "ไม่พบไฟล์เอกสาร"; } else { ?>
                        <embed SRC=./temp/<?=$fileCaregiverChange?> style="width:100%; height:100%;">
                        <a href="dl_pic.php?pic=temp/<?=$fileCaregiverChange?>">ดาวน์โหลด</a>
                        <?php } ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="input-group mb-3 input-group">
                  <input type="text" class="form-control" value="หนังสือมอบอำนาจ" readonly>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalAuthorize">ดูเอกสาร</button>
                  </div>
                </div>
                <div class="modal fade" id="ModalAuthorize" role="dialog">    
                  <div class="modal-dialog modal-xl">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">หนังสือมอบอำนาจ</h4>
                      </div>
                      <div class="modal-body">
                        <?php if ($fileConsent == '' || $fileConsent == null) { echo "ไม่สามารถเปิดแฟ้มข้อมูลได้ จะต้องมีหนังสือให้คำยินยอมเปิดเผยข้อมูลก่อน";}elseif($fileAuthorize == '' || $fileAuthorize == null) { echo "ไม่พบไฟล์เอกสาร"; } else { ?>
                        <embed SRC=./temp/<?=$fileAuthorize?> style="width:100%; height:100%;">
                        <a href="dl_pic.php?pic=temp/<?=$fileAuthorize?>">ดาวน์โหลด</a>
                        <?php } ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
	      <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="input-group mb-3 input-group">
                  <input type="text" class="form-control" value="หนังสือนำส่ง" readonly>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalDelivery">ดูเอกสาร</button>
                  </div>
                </div>
                <div class="modal fade" id="ModalDelivery" role="dialog">    
                  <div class="modal-dialog modal-xl">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">หนังสือนำส่ง</h4>
                      </div>
                      <div class="modal-body">
                        <?php if ($fileDelivery == '' || $fileDelivery == null) { echo "ไม่สามารถเปิดแฟ้มข้อมูลได้ จะต้องมีหนังสือให้คำยินยอมเปิดเผยข้อมูลก่อน";}elseif($fileDelivery == '' || $fileDelivery == null) { echo "ไม่พบไฟล์เอกสาร"; } else { ?>
                        <embed SRC=./temp/<?=$fileDelivery?> style="width:100%; height:100%;">
                        <a href="dl_pic.php?pic=temp/<?=$fileDelivery?>">ดาวน์โหลด</a>
                        <?php } ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>    
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="input-group mb-3 input-group">
                  <input type="text" class="form-control" value="แบบคำขอลงทะเบียนรับเงินเบี้ยความพิการ" readonly>
                  <div class="input-group-append">
                    <button class="btn btn-info" type="button" data-toggle="modal" data-target="#ModalOBT">ดูเอกสาร</button>
                  </div>
                </div>
                <div class="modal fade" id="ModalOBT" role="dialog">    
                  <div class="modal-dialog modal-xl">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">แบบคำขอลงทะเบียนรับเงินเบี้ยความพิการ</h4>
                      </div>
                      <div class="modal-body">
                        <?php if ($fileConsent == '' || $fileConsent == null) { echo "ไม่สามารถเปิดแฟ้มข้อมูลได้ จะต้องมีหนังสือให้คำยินยอมเปิดเผยข้อมูลก่อน";}elseif($fileOBT == '' || $fileOBT == null) { echo "ไม่พบไฟล์เอกสาร"; } else { ?>
                        <embed src=./temp/<?=$fileOBT?> style="width:100%; height:100%;">
                        <a href="dl_pic.php?pic=temp/<?=$fileOBT?>">ดาวน์โหลด</a>
                        <?php } ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-save"></span>แก้ไข</button> -->
        </div>
        <div class="card">
          <div class="card-body">
            <font color="green">
              <p>วันที่ได้รับหนังสือรับรอง : <b><?=$dateREG?></b></p>
              <p>วันที่ได้รับการขึ้นทะเบียน : <b><?=$datePMJ?></b></p>
              <p>วันที่ได้รับการดูแล : <b><?=$dateOBT?></b></p>
            </font>
          </div>
        </div>
            <!-- <button onclick="window.close()" class="btn btn-danger btn-sm">ปิด</button>  -->
            
  <?php
 if ($statusCase != 'OK') {
  if ($level == 'pmj' || $level == 'opt') {

  ?>
        <div class="card">
          <div class="card-header">
              <h5>ผลการตรวจสอบ>>สำหรับจนท. พมจ./เทศบาล/อบต.</h5>
          </div>
             <form name="form1" action='detailCase.php?act=2' method='post' enctype='multipart/form-data'>
        <!-- <div class="input-group mb-12 input-group">
            <div class="input-group-prepend"> -->
              <span class="input-group-text">ระบุข้อมูลที่ต้องการตรวจสอบเพิ่มเติม :</span>
            <!-- </div> -->
          <input type="hidden" class="form-control" name="cid" value="<?=$cid?>">
          <input type="hidden" class="form-control" name="off_name" value="<?=$off_name?>">
          <input type="hidden" class="form-control" name="hospcode" value="<?=$hospcode?>">
          <input type="text" class="form-control" name="info" required>
          
          <button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-save"></span>ขอเพิ่ม</button>
          <p>ข้อมูลที่เคยขอ : <?=$infox?></p>
      
          </form>
        </div>
        <div>
          <?php
          }
          if ($level == 'pmj') {
            ?>
                <form name="form1" class="form-inline" action='detailCase.php?act=1' method='post' enctype='multipart/form-data'>
                  <input type="hidden" class="form-control" name="cid" value="<?=$cid?>">  
                  <input type="hidden" class="form-control" name="obt" value="<?=$obt?>"> 
                  <input type="hidden" class="form-control" name="obt_name" value="<?=$obt_name?>"> 
                  <div class="input-group-prepend">
                      <span class="input-group-text">รูปถ่ายบัตรประจำตัวคนพิการ : </span>
                  </div>
                  <input type="file" class="form-control" name="fileCard" required> 
                  <br><button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span>ผ่านการตรวจสอบ</button>
                </form>
            <?php }
            if ($level == 'opt') {
            ?>
            <div class="card">
              <div class="card-body">
                <form name="form2" class="form-inline" action='detailCase.php?act=4' method='post' enctype='multipart/form-data'>
                  <span class="input-group-text">ระบุวันที่ แจ้งผู้ดูแลมาติดต่อ :</span>
                    <input type="hidden" class="form-control" name="cid" value="<?=$cid?>">
                    <input type="date" class="form-control" name="dateOBT" required>
                    <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-save"></span>แจ้งผู้ดูแล</button>
                </form>
              </div>
            </div>
            <?php }
          }
          if ($level  == "opt" && $fileOBT == "") { ?>
            <div class="card">
              <div class="card-body">
                <form name="form1" action='detailCase.php?act=3' method='post' enctype='multipart/form-data' onsubmit="return confirm('ต้องการบันทึกยืนยันการดำเนินการใช่หรือไม่')">
                  <input type="hidden" class="form-control" name="cid" value="<?=$cid?>">
                  <input type="hidden" class="form-control" name="obt_name" value="<?=$obt_name?>">
                  <input type="hidden" class="form-control" name="off_name" value="<?=$off_name?>">
                  <input type="hidden" class="form-control" name="hospcode" value="<?=$hospcode?>">
                  <label for="file_ds_money">แบบคำขอลงทะเบียนรับเงินเบี้ยความพิการ</label>
                  <input type="file" accept=".jpg, .png, .jpeg, .pdf" class="form-control" name="file_ds_money" id="file_ds_money">
                  <br><button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span>เรียบร้อยแล้ว</button>
                </form>
              </div>
            </div>
          <?php
          }
        }
        ?>
    <hr>
    <FORM name="form1" class="form-inline" ACTION ='detailCase.php?act=5' METHOD='post'  enctype='multipart/form-data'>
        <input type="hidden" class="form-control"  name="cid" value="<?=$cid?>">  
        <div class="input-group-prepend">
              <span class="input-group-text">เปลี่ยนสถานะ :</span>
            </div>
            <select class="form-control" id="statusCasex" name="statusCasex" >
              <?php
              if($statusCase=='DEAD'){$sx1='selected';}if($statusCase=='DENY'){$sx2='selected';}
              ?>
            <option value="">-เลือก-</option>
            <option value="DEAD" <?=$sx1?>>เสียชีวิต</option>
            <option value="DENY" <?=$sx2?>>ปฎิเสธการออกบัตร</option>
            </select> 
          <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-save"></span>เปลี่ยน</button>
        </form>
        </div>    
      </div> 
    </div>
</div>
<script src="assets/script.js"></script>
<script src="assets/script0.js"></script>

 </div>         
        </div>
         
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        
        <!--**********************************
            Footer start
        ***********************************-->
        <!-- <div class="footer">
            <div class="copyright">
                <p>Copyright &copy; Designed & Developed by <a href="https://themeforest.net/user/quixlab">Quixlab</a> 2018</p>
            </div>
        </div> -->
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>

    <!-- Chartjs -->
    <script src="./plugins/chart.js/Chart.bundle.min.js"></script>
    <!-- Circle progress -->
    <script src="./plugins/circle-progress/circle-progress.min.js"></script>
    <!-- Datamap -->
    <script src="./plugins/d3v3/index.js"></script>
    <script src="./plugins/topojson/topojson.min.js"></script>
    <script src="./plugins/datamaps/datamaps.world.min.js"></script>
    <!-- Morrisjs -->
    <script src="./plugins/raphael/raphael.min.js"></script>
    <script src="./plugins/morris/morris.min.js"></script>
    <!-- Pignose Calender -->
    <script src="./plugins/moment/moment.min.js"></script>
    <script src="./plugins/pg-calendar/js/pignose.calendar.min.js"></script>
    <!-- ChartistJS -->
    <script src="./plugins/chartist/js/chartist.min.js"></script>
    <script src="./plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>

    <script src="./js/dashboard/dashboard-1.js"></script>

</body>

</html>
