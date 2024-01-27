<?php session_start(); if($_SESSION["levelx"]==""){header("Location: page-login.php");} ?>

<?php
 //ini_set('display_errors', 1);
 //ini_set('display_startup_errors', 1);
 //error_reporting(E_ALL);
 @session_start();
$province = $_SESSION['province'];
$idMeet = $_SESSION['idMeet'];
include('server.php');
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
function checkID(id)
{
if(id.length != 13) return false;
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
		function confirmAdd()  
     {  
         return confirm('ต้องการเพิ่มรายการนี้? / โปรดยืนยัน!');  
     }  

function reload_view(t) {
	window.opener.location.reload();
	setTimeout("self.close()",(t * 10000));
}
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
if($_REQUEST["act"]==1)
{
  include ("connectDB.php");
  $cid=$_REQUEST["cid"]; 
  $fname=$_REQUEST["fname"]; 
  $lname=$_REQUEST["lname"]; 
  $sex=$_REQUEST["sex"]; 
  $birth=$_REQUEST["birth"];
  $disType=$_REQUEST["disType"];
  $homeNo=$_REQUEST["homeNo"]; 
  $mu=$_REQUEST["mu"]; 
  $tambol=$_REQUEST["district_id"]; 
  $amper=$_REQUEST["amphure_id"];
  $tel=$_REQUEST["tel"]; 
  $obt=$_REQUEST["obt"];

  
          $q1="SELECT * FROM caseDis WHERE cid = '$cid'";          
          $result1 = $mysqli->query($q1);                                                                   
          $rs1=$result1->fetch_object();
          $id_line=$rs1->idSend;	

      if($cid>0){
         //upload file
         if($_FILES['fileIdCard']['name']!="")
         {
          $fileIdCard=$rs1->fileIdCard;;	
          $DIR = 'temp/';
          $delfile1=$DIR.$fileIdCard;
          unlink($delfile1);
           $output_dir = "temp/";
           $sur = strrchr($_FILES['fileIdCard']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
           $fileIdCard = ('Idcard'.$cid.$sur); //ชื่อไฟล์ตาม id
           move_uploaded_file($_FILES["fileIdCard"]["tmp_name"],$output_dir.$fileIdCard);
           $sql = "UPDATE caseDis SET fileIdCard='$fileIdCard' WHERE cid='$cid' ";
           $mysqli->query($sql);
         }
         if($_FILES['fileHome']['name']!="")
         {
          $fileHome=$rs1->fileHome;	
          $DIR = 'temp/';
          $delfile2=$DIR.$fileHome;
          unlink($delfile2);
           $output_dir = "temp/";
           $sur = strrchr($_FILES['fileHome']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
           $fileHome = ('Home'.$cid.$sur); //ชื่อไฟล์ตาม id
           move_uploaded_file($_FILES["fileHome"]["tmp_name"],$output_dir.$fileHome);
           $sql = "UPDATE caseDis SET fileHome='$fileHome' WHERE cid='$cid' ";
           $mysqli->query($sql);
         }
         if($_FILES['fileIdCard2']['name']!="")
         {
          $fileIdCard2=$rs1->fileIdCard2;;	
          $DIR = 'temp/';
          $delfile7=$DIR.$fileIdCard2;
          unlink($delfile7);
           $output_dir = "temp/";
           $sur = strrchr($_FILES['fileIdCard2']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
           $fileIdCard2 = ('Idcard2'.$cid.$sur); //ชื่อไฟล์ตาม id
           move_uploaded_file($_FILES["fileIdCard2"]["tmp_name"],$output_dir.$fileIdCard2);
           $sql = "UPDATE caseDis SET fileIdCard2='$fileIdCard2' WHERE cid='$cid' ";
           $mysqli->query($sql);
         }
         if($_FILES['fileHome2']['name']!="")
         {
          $fileHome2=$rs1->fileHome2;	
          $DIR = 'temp/';
          $delfile8=$DIR.$fileHome2;
          unlink($delfile8);
           $output_dir = "temp/";
           $sur = strrchr($_FILES['fileHome2']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
           $fileHome2 = ('Home2'.$cid.$sur); //ชื่อไฟล์ตาม id
           move_uploaded_file($_FILES["fileHome2"]["tmp_name"],$output_dir.$fileHome2);
           $sql = "UPDATE caseDis SET fileHome2='$fileHome2' WHERE cid='$cid' ";
           $mysqli->query($sql);
         }
         if($_FILES['fileFace']['name']!="")
         {
          $fileface=$rs1->fileface;	
          $DIR = 'temp/';
          $delfile3=$DIR.$fileface;
          unlink($delfile3);
           $output_dir = "temp/";
           $sur = strrchr($_FILES['fileFace']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
           $fileFace = ('Face'.$cid.$sur); //ชื่อไฟล์ตาม id
           move_uploaded_file($_FILES["fileFace"]["tmp_name"],$output_dir.$fileFace);
           $sql = "UPDATE caseDis SET fileface='$fileFace' WHERE cid='$cid' ";
           $mysqli->query($sql);
         }
         if($_FILES['fileBook']['name']!="")
         {
          $fileBook=$rs1->fileBook;	
          $DIR = 'temp/';
          $delfile4=$DIR.$fileBook;
          unlink($delfile4);
           $output_dir = "temp/";
           $sur = strrchr($_FILES['fileBook']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
           $fileBook = ('Book'.$cid.$sur); //ชื่อไฟล์ตาม id
           move_uploaded_file($_FILES["fileBook"]["tmp_name"],$output_dir.$fileBook);
           $sql = "UPDATE caseDis SET fileBook='$fileBook' WHERE cid='$cid' ";
           $mysqli->query($sql);
         }
         if($_FILES['filePict']['name']!="")
         {
          $filePict=$rs1->filePict;	
          $DIR = 'temp/';
          $delfile5=$DIR.$filePict;
          unlink($delfile5);
           $output_dir = "temp/";
           $sur = strrchr($_FILES['filePict']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
           $filePict = ('Pict'.$cid.$sur); //ชื่อไฟล์ตาม id
           move_uploaded_file($_FILES["filePict"]["tmp_name"],$output_dir.$filePict);
           $sql = "UPDATE caseDis SET filePict='$filePict' WHERE cid='$cid' ";
           $mysqli->query($sql);
         }
         if($_FILES['fileBank']['name']!="")
         {
          $fileBank=$rs1->fileBank;	
          $DIR = 'temp/';
          $delfile6=$DIR.$fileBank;
          unlink($delfile6);
          $output_dir = "temp/";
          $sur = strrchr($_FILES['fileBank']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
          $fileBank = ('Bank'.$cid.$sur); //ชื่อไฟล์ตาม id
          move_uploaded_file($_FILES["fileBank"]["tmp_name"],$output_dir.$fileBank);
          $sql = "UPDATE caseDis SET fileBank='$fileBank' WHERE cid='$cid' ";
          $mysqli->query($sql);
        }
        if($_FILES['fileReg']['name']!="")
        {
         $fileReg=$rs1->fileReg;	
         $DIR = 'temp/';
         $delfile9=$DIR.$fileReg;
         unlink($delfile9);
         $output_dir = "temp/";
         $sur = strrchr($_FILES['fileReg']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
         $fileReg = ('Reg'.$cid.$sur); //ชื่อไฟล์ตาม id
         move_uploaded_file($_FILES["fileReg"]["tmp_name"],$output_dir.$fileReg);
         $sql = "UPDATE caseDis SET fileReg='$fileReg' WHERE cid='$cid' ";
         $mysqli->query($sql);
       }
       if($_FILES['fileConsent']['name']!="")
        {
         $fileConsent=$rs1->fileConsent;	
         $DIR = 'temp/';
         $delfile11=$DIR.$fileConsent;
         unlink($delfile11);
         $output_dir = "temp/";
         $sur = strrchr($_FILES['fileConsent']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
         $fileConsent = ('Consent'.$cid.$sur); //ชื่อไฟล์ตาม id
         move_uploaded_file($_FILES["fileConsent"]["tmp_name"],$output_dir.$fileConsent);
         $sql = "UPDATE caseDis SET fileConsent='$fileConsent' WHERE cid='$cid' ";
         $mysqli->query($sql);
       }
       if($_FILES['fileDelivery']['name']!="")
        {
         $fileDelivery=$rs1->fileDelivery;	
         $DIR = 'temp/';
         $delfile12=$DIR.$fileDelivery;
         unlink($delfile12);
         $output_dir = "temp/";
         $sur = strrchr($_FILES['fileDelivery']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
         $fileDelivery = ('Consent'.$cid.$sur); //ชื่อไฟล์ตาม id
         move_uploaded_file($_FILES["fileDelivery"]["tmp_name"],$output_dir.$fileDelivery);
         $sql = "UPDATE caseDis SET fileDelivery='$fileDelivery' WHERE cid='$cid' ";
         $mysqli->query($sql);
       }      
           $sql = "UPDATE caseDis SET fname='$fname',lname='$lname',sex='$sex',birth='$birth',disType='$disType',homeNo='$homeNo',mu='$mu',tambol='$tambol',amper='$amper',tel='$tel',obt='$obt',statusCase='PMJ' WHERE cid='$cid' ";
           $mysqli->query($sql);
           
            echo "<center><h3>แจ้งข้อมูลเรียบร้อยแล้ว</h3>";
            // echo "<hr><input type='button' class='btn btn-outline-primary' onclick='reload_view(0)' value='&nbsp;&nbsp;ปิด&nbsp;&nbsp;'><br>";
      //-----------แจ้ง Line
      $sql0 = "SELECT * FROM member WHERE `level`='pmj' and provinces='$province' and id_line is not null";
      $query0 = mysqli_query($conn, $sql0);
      while($result0 = mysqli_fetch_assoc($query0)){ 
        $id_line=$result0['id_line'];
        // echo "$id_line <br>";
              // Access Token
              $access_token = 'eNQ1Evl9snf9RLTTYTSYMoF1BkKVRFatm33B/ZdQmuPhjb913O+RT8l8t+2Ujxew3NtjmTbL8JYET5YGgGh0d5LY8eiq/JAAmbZVFmBuM7ZWekaas7LgtQ3Vl5KtuW0JSgFfq4h4XUGQ4Vuu+0s9sQdB04t89/1O/w1cDnyilFU=';
              // User ID
              // $userId = 'U80b248f7031744090346ea54c520a1b2';
              $userId = $id_line;
              // ข้อความที่ต้องการส่ง
              $messages = array(
              'type' => 'text',
              'text' => 'แจ้ง พมจ.-->มีการยื่นคำขอมีบัตรคนพิการรายใหม่ โปรดตรวจสอบในระบบ https://nblp.moph.go.th/r8nds/page2.php',
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
          }//ปิด while
     }

  ?>
<META HTTP-EQUIV="Refresh" CONTENT="0;URL=./page1.php">

<?php
}//ปิด act
else{
?>
<div class="container">
<button onclick="history.back(-1)" class="btn btn-success"> <i class="fa fa-arrow-left"></i> กลับ</button>
        <FORM name="form1" class="form-inline" ACTION ='editCase1.php?act=1&hospcode=<?=$hospcode?>' METHOD='post'  enctype='multipart/form-data'>
        <div class="container">       

          <div class="input-group mb-3 input-group-sm">
          <?php
            include ("connectDB.php");
            include ("function.php");
            $cid=$_REQUEST["cid"];
            $cid=base64_decode($cid);
            $q1="SELECT * FROM caseDis where cid='$cid'";          
            $result1 = $mysqli->query($q1);                                                                   
            $rs1=$result1->fetch_object();
            $cid=$rs1->cid;
            $fname=$rs1->fname;
            $lname=$rs1->lname;
            $sex=$rs1->sex;
            $birth=$rs1->birth;
            $disType=$rs1->disType;
            $homeNo=$rs1->homeNo;
            $disType=$rs1->disType;
            $mu=$rs1->mu;
            $tambol=$rs1->tambol;
                $q0="SELECT * FROM districts where id='$tambol'";          
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
            $fileIdCard=$rs1->fileIdCard;
            $fileHome=$rs1->fileHome;
            $fileFace=$rs1->fileface;
            $fileBook=$rs1->fileBook;
            $filePict=$rs1->filePict;
            $fileBank=$rs1->fileBank; 
            $fileIdCard2=$rs1->fileIdCard2;
            $fileHome2=$rs1->fileHome2; 
            $fileReg=$rs1->fileReg; 
            $fileConsent=$rs1->fileConsent;
            $fileDelivery=$rs1->fileDelivery;
            $info1=$rs1->info; 
            $infoFrom=$rs1->infoFrom; 
            $statusCase=$rs1->statusCase; 
            $dateREG=Thai_date($rs1->dateREG);
            $datePMJ=Thai_date($rs1->datePMJ);
            $dateOBT=Thai_date($rs1->dateOBT);
            $dateVDOCall=$rs1->dateVDOCall; 
            $id_line=$rs1->idSend;             

          include('connect.php');
          // $sql = "SELECT * FROM amphures where province_id=27";
          $sql = "SELECT * FROM amphures where code like '$province%' ";
          $query = mysqli_query($conn, $sql);
          ?>
          <div class="container my-5">
            
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
          <input type="text" class="form-control"  name="fname" value="<?=$fname?>" required>
          </div>
          <div class="input-group mb-3 input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">สกุล :</span>
            </div>
          <input type="text" class="form-control"  name="lname" value="<?=$lname?>" required>
          </div>  
          <div class="input-group mb-3 input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">เพศ :</span>
            </div>
            <select class="form-control" id="sex" name="sex" required>
              <?php
              if($sex=='ชาย'){$sex1='selected';}if($sex=='หญิง'){$sex2='selected';}
              ?>
            <option value="">-เลือก-</option>
            <option value="ชาย" <?=$sex1?>>ชาย</option>
            <option value="หญิง" <?=$sex2?>>หญิง</option>
            </select>
            </div>
            <div class="input-group mb-3 input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">วันเดือนปีเกิด :</span>
            </div>
          <input type="date" class="form-control"  name="birth" value="<?=$birth?>" required>
          </div>  
            <div class="input-group mb-3 input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">ประเภทความพิการ</span>
            </div>
            <select class="form-control" id="disType" name="disType" required>
            <option value="">-เลือกประเภทความพิการ-</option>
                <?php
                 include('connect.php');
                 $sql0 = "SELECT * FROM cdisatype";
                 $query0 = mysqli_query($conn, $sql0);
                while($result0 = mysqli_fetch_assoc($query0)): 
                  $disTypex=$result0['disatype'];
                  if($disType==$disTypex){$disType0='selected';}else{$disType0='';}
                ?>
                  <option value="<?=$result0['disatype']?>" <?=$disType0?> ><?=$result0['disatype']?></option>
                <?php endwhile; ?>
            </select>
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
          <input type="text" class="form-control"  name="homeNo" value="<?=$homeNo?>">
          </div>
          <div class="input-group mb-3 input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">หมู่ที่ :</span>
            </div>
            
            <?php
            if($mu=='01'){$mu1='selected';}if($mu=='02'){$mu2='selected';}if($mu=='03'){$mu3='selected';}
            if($mu=='04'){$mu4='selected';}if($mu=='05'){$mu5='selected';}if($mu=='06'){$mu6='selected';}
            if($mu=='07'){$mu7='selected';}if($mu=='08'){$mu8='selected';}if($mu=='09'){$mu9='selected';}
            if($mu=='10'){$mu10='selected';}if($mu=='11'){$mu11='selected';}if($mu=='12'){$mu12='selected';}
            if($mu=='13'){$mu13='selected';}if($mu=='14'){$mu14='selected';}if($mu=='15'){$mu15='selected';}
            if($mu=='16'){$mu16='selected';}if($mu=='17'){$mu17='selected';}if($mu=='18'){$mu18='selected';}
            if($mu=='19'){$mu19='selected';}if($mu=='20'){$mu20='selected';}if($mu=='21'){$mu21='selected';}
            if($mu=='22'){$mu22='selected';}if($mu=='23'){$mu23='selected';}if($mu=='24'){$mu24='selected';}
            if($mu=='25'){$mu25='selected';}if($mu=='26'){$mu26='selected';}if($mu=='27'){$mu27='selected';}
            if($mu=='28'){$mu28='selected';}if($mu=='29'){$mu29='selected';}if($mu=='30'){$mu30='selected';}
            ?>
          <select class="form-control" id="birth_month" name="mu" required>
            <option value="">-เลือก-</option>
            <option value="01" <?=$mu1?> >1</option>
            <option value="02" <?=$mu2?> >2</option>
            <option value="03" <?=$mu3?> >3</option>
            <option value="04" <?=$mu4?> >4</option>
            <option value="05" <?=$mu5?> >5</option>
            <option value="06" <?=$mu6?> >6</option>
            <option value="07" <?=$mu7?> >7</option>
            <option value="08" <?=$mu8?> >8</option>
            <option value="09" <?=$mu9?> >9</option>
            <option value="10" <?=$mu10?> >10</option>
            <option value="11" <?=$mu11?> >11</option>
            <option value="12" <?=$mu12?> >12</option>
            <option value="13" <?=$mu13?> >13</option>
            <option value="14" <?=$mu14?> >14</option>
            <option value="15" <?=$mu15?> >15</option>
            <option value="16" <?=$mu16?> >16</option>
            <option value="17" <?=$mu17?> >17</option>
            <option value="18" <?=$mu18?> >18</option>
            <option value="19" <?=$mu19?> >19</option>
            <option value="20" <?=$mu20?> >20</option>
            <option value="21" <?=$mu21?> >21</option>
            <option value="22" <?=$mu22?> >22</option>
            <option value="23" <?=$mu23?> >23</option>
            <option value="24" <?=$mu24?> >24</option>
            <option value="25" <?=$mu25?> >25</option>
            <option value="26" <?=$mu26?> >26</option>
            <option value="27" <?=$mu27?> >27</option>
            <option value="28" <?=$mu28?> >28</option>
            <option value="29" <?=$mu29?> >29</option>
            <option value="30" <?=$mu30?> >30</option>
            </select>
          </div>  

                <div class="input-group mb-3 input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">อำเภอ : </span>
                  </div>
                        <select name="amphure_id" id="amphure" class="form-control" required>
                            <option value="<?=$amper?>">-<?=$amperName?>-</option>
                            <?php while($result = mysqli_fetch_assoc($query)): 
                              ?>
                                <option value="<?=$result['id']?>" ><?=$result['name_th']?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                        <div class="input-group mb-3 input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">ตำบล :  </span>
                        </div>
                        <select name="district_id" id="district" class="form-control" required >
                            <option value="<?=$tambol?>">-<?=$tambolName?>-</option>
                        </select>
                       </div>
                    
                    <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">โทรศัพท์มือถือ : </span>
                      </div>
                    <input type="text" class="form-control"  name="tel" value="<?=$tel?>" required>
                    </div> 
                    <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">อยูในเขตเทศบาล/อบต.</span>
                      </div>
                      <select class="form-control" id="obt" name="obt" required>
                      <option value="">-เลือกหน่วยงาน-</option>
                          <?php
                          include('connect.php');
                          $sql0 = "SELECT * FROM tesaban group by tcode";
                          $query0 = mysqli_query($conn, $sql0);
                          while($result0 = mysqli_fetch_assoc($query0)): 
                            $obtx=$result0['tcode'];
                            if($obt==$obtx){$obt0='selected';}else{$obt0='';}
                           ?>
                            <option value="<?=$result0['tcode']?>" <?=$obt0?>><?=$result0['hospname']?></option>
                          <?php endwhile; ?>
                      </select>
                    </div> 
                    
          </div>
        </div>   
        <div class="card">
        <div class="card-header">
            <h5>ข้อมูลเอกสาร</h5>
                    <div class="input-group mb-3 input-group">    
                      <div class="input-group-prepend">
                        <span class="input-group-text">สำเนาบัตรประชาชนคนพิการ : </span>
                      </div>
                    <input type="file" class="form-control"  name="fileIdCard">
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalIdCard">ดูเอกสาร</button>  
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
                                    <?php if($fileIdCard==''||$fileIdCard== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                                      <embed SRC=./temp/<?=$fileIdCard?> style="width:100%; height:100%;">
                                      <?php }?>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                              </div>

                   </div>
                    <div class="input-group mb-3 input-group">    
                      <div class="input-group-prepend">
                        <span class="input-group-text">สำเนาทะเบียนบ้านคนพิการ : </span>
                      </div>
                    <input type="file" class="form-control"  name="fileHome">
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalHome">ดูเอกสาร</button>  
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
                                    <?php if($fileHome==''||$fileHome== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                                      <embed SRC=./temp/<?=$fileHome?> style="width:100%; height:100%;">
                                      <?php }?>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                              </div>
                    </div>
                    
                    <div class="input-group mb-3 input-group">    
                      <div class="input-group-prepend">
                        <span class="input-group-text">สำเนาบัตรประชาชนผู้ดูแล : </span>
                      </div>
                    <input type="file" class="form-control"  name="fileIdCard2">
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalIdCard2">ดูเอกสาร</button> 
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
                                    <?php if($fileIdCard2==''||$fileIdCard2== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                                      <embed SRC=./temp/<?=$fileIdCard2?> style="width:100%; height:100%;">
                                      <?php }?>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                              </div>
                    </div>
                    <div class="input-group mb-3 input-group">    
                      <div class="input-group-prepend">
                        <span class="input-group-text">สำเนาทะเบียนบ้านผู้ดูแล : </span>
                      </div>
                    <input type="file" class="form-control"  name="fileHome2">
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalHome2">ดูเอกสาร</button> 
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
                                    <?php if($fileHome2==''||$fileHome2== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                                      <embed SRC=./temp/<?=$fileHome2?> style="width:100%; height:100%;">
                                      <?php }?>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                              </div>
                    </div>
                    <div class="input-group mb-3 input-group">    
                      <div class="input-group-prepend">
                        <span class="input-group-text">รูปถ่ายหน้าตรง : </span>
                      </div>
                    <input type="file" class="form-control"  name="fileFace">
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalFace">ดูเอกสาร</button> 
                    </div> 
                              <div class="modal fade" id="ModalFace" role="dialog">    
                                <div class="modal-dialog modal-xl">
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">รูปถ่าย</h4>
                                    </div>
                                    <div class="modal-body">
                                    <?php if($fileFace==''||$fileFace== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                                      <IMG SRC=./temp/<?=$fileFace?> style="width:100%; height:100%;">
                                      <?php }?>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                              </div>
                    </div> 
                    <div class="input-group mb-3 input-group">    
                      <div class="input-group-prepend">
                        <span class="input-group-text">หนังสือรับรองความพิการ : </span>
                      </div>
                    <input type="file" class="form-control"  name="fileBook">
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalBook">ดูเอกสาร</button> 
                    </div> 
                              <div class="modal fade" id="ModalBook" role="dialog">    
                                <div class="modal-dialog modal-xl">
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">หนังสือรับรองความพิการ</h4>
                                    </div>
                                    <div class="modal-body">
                                    <?php if($fileBook==''||$fileBook== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                                      <embed SRC=./temp/<?=$fileBook?> style="width:100%; height:100%;">
                                      <?php }?>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                              </div>
                    </div> 
                    <div class="input-group mb-3 input-group">    
                      <div class="input-group-prepend">
                        <span class="input-group-text">รูปถ่ายความพิการ : </span>
                      </div>
                    <input type="file" class="form-control"  name="filePict">
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalPict">ดูเอกสาร</button> 
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
                                    <?php if($filePict==''||$filePict== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                                      <embed SRC=./temp/<?=$filePict?> style="width:100%; height:100%;">
                                      <?php }?>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                              </div>
                    </div> 
                    <div class="input-group mb-3 input-group">    
                      <div class="input-group-prepend">
                        <span class="input-group-text">รูปถ่ายหน้าบัญชีธนาคาร : </span>
                      </div>
                    <input type="file" class="form-control"  name="fileBank">
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalBank">ดูเอกสาร</button> 
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
                                    <?php if($fileBank==''||$fileBank== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                                      <embed SRC=./temp/<?=$fileBank?> style="width:100%; height:100%;">
                                      <?php }?>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                              </div>
                    </div> 
                    <div class="input-group mb-3 input-group">    
                      <div class="input-group-prepend">
                        <span class="input-group-text">หนังสือให้คำยินยอม : </span>
                      </div>
                    <input type="file" class="form-control"  name="fileConsent">
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalConsent">ดูเอกสาร</button> 
                    </div> 
                    <div class="modal fade" id="ModalConsent" role="dialog">    
                                <div class="modal-dialog modal-xl">
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">หนังสือให้คำยินยอม</h4>
                                    </div>
                                    <div class="modal-body">
                                    <?php if($fileConsent==''||$fileConsent== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                                      <embed SRC=./temp/<?=$fileConsent?> style="width:100%; height:100%;">
                                      <?php }?>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                              </div>
                    </div> 
				      <div class="input-group mb-3 input-group">    
                      <div class="input-group-prepend">
                        <span class="input-group-text">หนังสือนำส่ง : </span>
                      </div>
                    <input type="file" class="form-control"  name="fileDelivery">
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalDelivery">ดูเอกสาร</button> 
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
                                    <?php if($fileDelivery==''||$fileDelivery== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                                      <embed SRC=./temp/<?=$fileDelivery?> style="width:100%; height:100%;">
                                      <?php }?>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                              </div>
                    </div> 
                </div> 
                    <button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-save"></span>ส่ง พมจ.</button>
                    
                    </form>
 
            </div>
     
        </div>  
        <FORM name="form1" class="form-inline" ACTION ='editCase1.php?act=2' METHOD='post'  enctype='multipart/form-data'>
        <span class="input-group-text">ระบุวัน เวลา ในการตรวจร่างกายผ่านระบบVDO Call :</span>
          <input type="hidden" class="form-control"  name="cid" value="<?=$cid?>">
          <input type="hidden" class="form-control"  name="id_line" value="<?=$id_line?>">
          <input type="hidden" class="form-control"  name="namelname" value="<?=$fname.' '.$lname?>">
          <input type="datetime-local" class="form-control"  name="dateVDOCall" value="<?=$dateVDOCall?>" required>
          <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-save"></span>นัดตรวจร่างกาย</button>
        </form>   
        <?php
        if($_REQUEST["act"]==2)
        {
          $cid=$_REQUEST["cid"]; 
          $namelname=$_REQUEST["namelname"];
          $dateVDOCall=$_REQUEST["dateVDOCall"];
          $id_line=$_REQUEST["id_line"];
          $sql = "UPDATE caseDis SET dateVDOCall='$dateVDOCall' WHERE cid='$cid' ";
          $mysqli->query($sql);
          
           echo "<center><h3>แจ้งข้อมูลเรียบร้อยแล้ว</h3>";

           //-----------แจ้ง Line
              // Access Token
              $access_token = 'eNQ1Evl9snf9RLTTYTSYMoF1BkKVRFatm33B/ZdQmuPhjb913O+RT8l8t+2Ujxew3NtjmTbL8JYET5YGgGh0d5LY8eiq/JAAmbZVFmBuM7ZWekaas7LgtQ3Vl5KtuW0JSgFfq4h4XUGQ4Vuu+0s9sQdB04t89/1O/w1cDnyilFU=';
              // User ID
              $userId = $id_line;
              // ข้อความที่ต้องการส่ง
              $messages = array(
              'type' => 'text',
              'text' => 'วันที่'.$dateVDOCall.' ขอให้ท่านเข้าระบบวีดีโอคอล เพื่อการตรวจร่างกาย>>'.$namelname.'<<ตามลิงค์นี้'.$idMeet,               
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
              <META HTTP-EQUIV="Refresh" CONTENT="0;URL=./page1.php">
        <?php
        }
        ?>      
    </div>
   

</div>
<script src="assets/script.js"></script>
<script src="assets/script0.js"></script>



 </div>  

          
        </div>
     
      
<?php
}
?>
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
