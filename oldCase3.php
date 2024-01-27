<?php
session_start();
if ($_SESSION["levelx"] == "") {
    header("Location: page-login.php");
}
?>

<?php
// @session_start();
include('server.php');
include('connectDB.php');
$id_line = $_SESSION['id_line'];
$province = $_SESSION['province'];
// echo "p=$province";
$d1 = $_SESSION['level'];
$d = $_SESSION['pcu'];
$query = "SELECT * FROM chkfile WHERE province = '$province'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$dscard = $row['dscard'];
if($dscard=='y'){
  $dscard = 'required';
}
$consent = $row['consent'];
if($consent=='y'){
  $consent = 'required';
}
$book = $row['book'];
if($book=='y'){
  $book = 'required';
}
$card = $row['card'];
if($card=='y'){
  $card = 'required';
}
$idcard = $row['idcard'];
if($idcard=='y'){
  $idcard = 'required';
}
$home = $row['home'];
if($home=='y'){
  $home = 'required';
}
$card2 = $row['card2'];
if($card2=='y'){
  $card2 = 'required';
}
$home2 = $row['home2'];
if($home2=='y'){
  $home2 = 'required';
}
$face = $row['face'];
if($face=='y'){
  $face = 'required';
}
$pict = $row['pict'];
if($pict=='y'){
  $pict = 'required';
}
$bank = $row['bank'];
if($bank=='y'){
  $bank = 'required';
}
$caregiver = $row['caregiver'];
if($caregiver=='y'){
  $caregiver = 'required';
}
$caregiverchange = $row['caregiverchange'];
if($caregiverchange=='y'){
  $caregiverchange = 'required';
}
$authorize = $row['authorize'];
if($authorize=='y'){
  $authorize = 'required';
}
$delivery = $row['delivery'];
if($delivery=='y'){
  $delivery = 'required';
}
$query = "SELECT * FROM tesaban WHERE tcode = $d1 LIMIT 1";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$opt = $row['hospname'];

$hospcode = $_REQUEST["hospcode"];
    // $hospcode=23367;
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
    <!-- <link rel="stylesheet" href="./plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="./plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css"> -->
    <!-- Custom Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="jquery.datetimepicker.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/bootstrap-select.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <!-- <script src="dist/js/bootstrap-select.js"></script> -->
</head>
<script language="javascript">
    function checkID(id) {
    if(id.length != 13) return false;
        for(i=0, sum=0; i < 12; i++)
            sum += parseFloat(id.charAt(i))*(13-i); if((11-sum%11)%10!=parseFloat(id.charAt(12)))
            return false;
        return true;
    }

    function checkForm() { if(!checkID(document.form1.cid.value))
        document.form1.cid.value='';
        // alert('รหัสประชาชนไม่ถูกต้อง');
    }

    function chktsb(a) {
        document.getElementById('ok').innerHTML = '';
        document.getElementById('ok').innerHTML = "<center>loading</center>";
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
        }
        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById('ok').innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open('GET', 'chktsb.php?pop='+a+'&moo='+document.getElementById('birth_month').value, true);
        xmlhttp.send();
    }

    function closeWin() {
        myWindow.close();
    }
</script>
<script language="javascript">
    function CheckNum() {
        if (event.keyCode < 48 || event.keyCode > 57) {
            event.returnValue = false;
        }
    }
</script>

<script  language="javascript">
    function confirmAdd() {
        return confirm('ต้องการเพิ่มรายการนี้? / โปรดยืนยัน!');
    }

    function reload_view(t) {
        window.opener.location.reload();
        setTimeout("self.close()", (t * 10000));
    }
</script>
<link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>	body { font-family: 'Kanit', sans-serif; } h1,h2,h3,h4,h5,h6 { font-family: 'Kanit', sans-serif; } </style>

<body>
    <!--*******************       Preloader start    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************     Preloader end   ********************-->  
    <!--**********************************     Main wrapper start   ***********************************-->
    <div id="main-wrapper">
    <!--**********************************     Nav header start    ***********************************-->
        <!-- <div class="nav-header">
            <div class="brand-logo">
                <a href="page1.php">
                    <b class="logo-abbr"><img src="images/disLogo.png" alt=""> </b>
                    <span class="logo-compact"><img src="./images/disLogoText.png" alt=""></span>
                    <span class="brand-title">
                        <img src="images/disLogoText.png" alt="">
                    </span>
                </a>
            </div>
        </div> -->

         <div class="nav-header">
            <div >
                <a href="page3.php">
                    <span >
                        <img src="images/rds3.png" alt="">
                    </span>
                </a>
            </div>
        </div>
        <!--**********************************     Nav header end     ***********************************-->
        <!--**********************************       Header start       ***********************************-->
        <div class="header">    
            <div class="header-content clearfix ">
                
                <div class="nav-control ">
                    <div class="hamburger ">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-left">
                <br><h3 class="text-green"> &nbsp;&nbsp;&nbsp;    ระบบบริการคนพิการแบบเบ็ดเสร็จ  <font color="gray" size="2">&nbsp;&nbsp;&nbsp; One-stop Service for Disabilities</font></h3><h5>&nbsp;&nbsp;&nbsp;หน่วยงาน: <?=$opt?></h5>
                </div>
                <div class="header-right">
                    <ul class="clearfix">
                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative"   data-toggle="dropdown">
                                <span class="activity active"></span>
                                <img src="images/user/1.png" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="app-profile.html"><i class="icon-user"></i> <span>Profile</span></a>
                                        </li>       
                                        
                                        <li><a href="page-login.php"><i class="icon-key"></i> <span>Logout</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************      Header end ti-comment-alt    ***********************************-->
        <!--**********************************      Sidebar start     ***********************************-->
        <div class="nk-sidebar bg-light text-white">
            <div class="nk-nav-scroll bg-light text-white">
                <ul class="metismenu bg-light text-white" id="menu">
                   
                    <!-- <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./page3.php">- หน้าหลัก</a></li>
                        </ul>
                    </li> -->
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-user menu-icon"></i><span class="nav-text">ทะเบียนคนพิการ</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./newCase3.php?hospcode=<?=$d?>">- เพิ่มรายใหม่</a></li>
                            <li><a href="./oldCase3.php?hospcode=<?=$d?>">- เพิ่มรายเก่า</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-chart menu-icon"></i><span class="nav-text">รายงาน</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./chart_distype.php">- ประเภทผู้พิการ</a></li>
                            <li><a href="./chart_distype_regis.php">- ผู้พิการที่ลงทะเบียน</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-settings menu-icon"></i><span class="nav-text">ตั้งค่า</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="#">- อยู่ระหว่างจัดทำ.</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
		<!--**********************************        Sidebar end     ***********************************-->
        <!--**********************************       Content body start      ***********************************-->
        <div class="content-body">
            

<?php
if ($_REQUEST["act"] == 1) {
    // include ("connectDB.php");
    $opt = $_REQUEST["hospcode"];

    $cid = $_REQUEST["cid"];
    $fname = $_REQUEST["fname"];
    $lname = $_REQUEST["lname"];
    $sex = $_REQUEST["sex"];
    $birth = $_REQUEST["birth"];
    $y_th1 = substr($birth,6,4);
    $y_en1 = $y_th1-543;
    $d_th1 = substr($birth,0,2);
    $m_th1 = substr($birth,3,2);
    $birth = $y_en1."-".$m_th1."-".$d_th1;
    $disType = $_REQUEST["disType"];
    $homeNo = $_REQUEST["homeNo"];
    $mu = $_REQUEST["mu"];
    $tambol = $_REQUEST["district_id"];
    $amper = $_REQUEST["amphure_id"];
    $tel = $_REQUEST["tel"];
    $obt = $_REQUEST["obt"];
    $pcu = $_REQUEST["pcu"];
  
   $q1 = "SELECT * FROM office where subdistid = '$tambol' and off_type IN('05','06','07') ";
    $result1 = $mysqli->query($q1);
    $rs1 = $result1->fetch_object();
    $off_name = $rs1->off_name;

    $q2 = "SELECT off_id,cup_code FROM office where off_id = '$pcu' and off_type IN('03','05','06','07') ";
    $result2 = $mysqli->query($q2);
    $rs2 = $result2->fetch_object();
    $hos = $rs2->cup_code;
    

    if ($cid != "") {
        //upload file
        if ($_FILES['fileDSCard']['name'] != "") {
            $output_dir = "temp/";
            $sur = strrchr($_FILES['fileDSCard']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
            $fileDSCard = ('DSCard'.$cid.$sur); //ชื่อไฟล์ตาม id
            move_uploaded_file($_FILES["fileDSCard"]["tmp_name"], $output_dir.$fileDSCard);
        }
        if ($_FILES['fileCard']['name'] != "") {
            $output_dir = "temp/";
            $sur = strrchr($_FILES['fileCard']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
            $fileCard = ('Card'.$cid.$sur); //ชื่อไฟล์ตาม id
            move_uploaded_file($_FILES["fileCard"]["tmp_name"], $output_dir.$fileCard);
        }
        if ($_FILES['fileIdCard']['name'] != "") {
            $output_dir = "temp/";
            $sur = strrchr($_FILES['fileIdCard']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
            $fileIdCard = ('Idcard'.$cid.$sur); //ชื่อไฟล์ตาม id
            move_uploaded_file($_FILES["fileIdCard"]["tmp_name"], $output_dir.$fileIdCard);
        }
        if ($_FILES['fileHome']['name'] != "") {
            $output_dir = "temp/";
            $sur = strrchr($_FILES['fileHome']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
            $fileHome = ('Home'.$cid.$sur); //ชื่อไฟล์ตาม id
            move_uploaded_file($_FILES["fileHome"]["tmp_name"], $output_dir.$fileHome);
        }
        if ($_FILES['fileFace']['name'] != "") {
            $output_dir = "temp/";
            $sur = strrchr($_FILES['fileFace']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
            $fileFace = ('Face'.$cid.$sur); //ชื่อไฟล์ตาม id
            move_uploaded_file($_FILES["fileFace"]["tmp_name"], $output_dir.$fileFace);
        }
        if ($_FILES['fileBook']['name'] != "") {
            $output_dir = "temp/";
            $sur = strrchr($_FILES['fileBook']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
            $fileBook = ('Book'.$cid.$sur); //ชื่อไฟล์ตาม id
            move_uploaded_file($_FILES["fileBook"]["tmp_name"], $output_dir.$fileBook);
        }
        if ($_FILES['filePict']['name'] != "") {
            $output_dir = "temp/";
            $sur = strrchr($_FILES['filePict']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
            $filePict = ('Pict'.$cid.$sur); //ชื่อไฟล์ตาม id
            move_uploaded_file($_FILES["filePict"]["tmp_name"], $output_dir.$filePict);
        }
        if ($_FILES['fileBank']['name'] != "") {
            $output_dir = "temp/";
            $sur = strrchr($_FILES['fileBank']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
            $fileBank = ('Bank'.$cid.$sur); //ชื่อไฟล์ตาม id
            move_uploaded_file($_FILES["fileBank"]["tmp_name"], $output_dir.$fileBank);
        }
        if ($_FILES['fileIdCard2']['name'] != "") {
            $output_dir = "temp/";
            $sur = strrchr($_FILES['fileIdCard2']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
            $fileIdCard2 = ('IdCard2'.$cid.$sur); //ชื่อไฟล์ตาม id
            move_uploaded_file($_FILES["fileIdcard2"]["tmp_name"], $output_dir.$fileIdCard2);
        }
        if ($_FILES['fileHome2']['name'] != "") {
            $output_dir = "temp/";
            $sur = strrchr($_FILES['fileHome2']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
            $fileHome2 = ('Home2'.$cid.$sur); //ชื่อไฟล์ตาม id
            move_uploaded_file($_FILES["fileHome2"]["tmp_name"], $output_dir.$fileHome2);
        }
        if ($_FILES['fileConsent']['name'] != "") {
            $output_dir = "temp/";
            $sur = strrchr($_FILES['fileConsent']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
            $fileConsent = ('Consent'.$cid.$sur); //ชื่อไฟล์ตาม id
            move_uploaded_file($_FILES["fileConsent"]["tmp_name"], $output_dir.$fileConsent);
        }
        if ($_FILES['fileCaregiver']['name'] != "") {
            $output_dir = "temp/";
            $sur = strrchr($_FILES['fileCaregiver']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
            $fileCaregiver = ('Caregiver'.$cid.$sur); //ชื่อไฟล์ตาม id
            move_uploaded_file($_FILES["fileCaregiver"]["tmp_name"], $output_dir.$fileCaregiver);
        }
        if ($_FILES['fileCaregiverChange']['name'] != "") {
            $output_dir = "temp/";
            $sur = strrchr($_FILES['fileCaregiverChange']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
            $fileCaregiverChange = ('CaregiverChange'.$cid.$sur); //ชื่อไฟล์ตาม id
            move_uploaded_file($_FILES["fileCaregiverChange"]["tmp_name"], $output_dir.$fileCaregiverChange);
        }
        if ($_FILES['fileAuthorize']['name'] != "") {
            $output_dir = "temp/";
            $sur = strrchr($_FILES['fileAuthorize']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
            $fileAuthorize = ('Authorize'.$cid.$sur); //ชื่อไฟล์ตาม id
            move_uploaded_file($_FILES["fileAuthorize"]["tmp_name"], $output_dir.$fileAuthorize);
        }
	if ($_FILES['fileDelivery']['name'] != "") {
            $output_dir = "temp/";
            $sur = strrchr($_FILES['fileDelivery']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
            $fileDelivery = ('Delivery'.$cid.$sur); //ชื่อไฟล์ตาม id
            move_uploaded_file($_FILES["fileDelivery"]["tmp_name"], $output_dir.$fileDelivery);
        }

        $sql = "INSERT INTO caseDis( hospcode,cid, fname, lname, sex, birth, disType, homeNo, mu, tambol, amper, tel, obt, pcucode, statusCase, fileIdCard, fileHome, fileFace, fileBook, filePict, fileBank, fileIdCard2, fileHome2, fileConsent, fileCaregiver, fileCaregiverChange, fileAuthorize, fileDSCard,fileCard,fileDelivery, dateREG, idSend, problems)
        VALUES ('$hos','$cid', '$fname', '$lname', '$sex', '$birth', '$disType', '$homeNo', '$mu', '$tambol', '$amper', '$tel', '$opt', '$pcu', 'OK', '$fileIdCard', '$fileHome', '$fileFace', '$fileBook', '$filePict', '$fileBank', '$fileIdCard2', '$fileHome2', '$fileConsent', '$fileCaregiver', '$fileCaregiverChange', '$fileAuthorize', '$fileDSCard', '$fileCard','$fileDelivery', now(), '$id_line','obt')";
        $result_newcase = $mysqli->query($sql);
        if ($result_newcase) {
            echo "<center><h3>ลงทะเบียนเรียบร้อยแล้ว</h3>";
            echo "<meta http-equiv='refresh' content='0;url=./page3.php'>";
        } else {
            echo "ไม่สามารถบันทึกข้อมูลได้!!!<br>";
            echo $sql;
        }
    } else {
        echo "ไม่พบ CID";
    }
?>
<!-- <META HTTP-EQUIV="Refresh" CONTENT="0;URL=./page3.php"> -->
<?php
// ปิด add
} else {
?>
<div class="container">
    <form name="form1" class="form-inline" action='oldCase3.php?act=1&hospcode=<?=$hospcode?>' method='post' enctype='multipart/form-data' autocomplete="off">
        <div class="container">
            <div class="input-group mb-3 input-group-sm">
                <?php
                include('connect.php');
                $sql = "SELECT * FROM amphures where code like '$province%' ";
                $query = mysqli_query($conn, $sql);
                ?>
                <div class="container my-5">
                    <div class="card">
                        <div class="card-header">
      <!-- <div class="card-body"> -->
            <h5>เพิ่มข้อมูลคนพิการรายเก่า</h5>
            <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">เลขประชาชน : </span>
                      </div>
                    <input type="text" class="form-control"  name="cid" onfocusout="checkForm()" placeholder="ระบุเลข13หลัก ไม่ต้องมีเครื่องหมายขีดคั่น" required>
                    </div> 
            <div class="input-group mb-3 input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">ชื่อ :</span>
            </div>
          <input type="text" class="form-control"  name="fname" required>
          </div>
          <div class="input-group mb-3 input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">สกุล :</span>
            </div>
          <input type="text" class="form-control"  name="lname" required>
          </div>  
          <div class="input-group mb-3 input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">เพศ :</span>
            </div>
            <select class="form-control" id="sex" name="sex" required>
            <option value="">-เลือก-</option>
            <option value="ชาย">ชาย</option>
            <option value="หญิง">หญิง</option>
            </select>
            </div>
            <div class="input-group mb-3 input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">วันเดือนปีเกิด :</span>
            </div>
          <!-- <input type="date" class="form-control"  data-date-format="yyyy-mm-dd" name="birth" required> -->
          <input type="text" class="form-control" name="birth" id="birth" value="" required>

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
                while($result0 = mysqli_fetch_assoc($query0)): ?>
                  <option value="<?=$result0['disatype']?>"><?=$result0['disatype']?></option>
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
          <input type="text" class="form-control" name="homeNo">
          </div>
          <div class="input-group mb-3 input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">หมู่ที่ :</span>
            </div>
            <input type="text" class="form-control" size="10" name="mu" required>
          <!-- <select class="form-control" id="birth_month" name="mu" required>
            <option value="">-เลือก-</option>
            <option value="00">0</option>
            <option value="01">1</option>
            <option value="02">2</option>
            <option value="03">3</option>
            <option value="04">4</option>
            <option value="05">5</option>
            <option value="06">6</option>
            <option value="07">7</option>
            <option value="08">8</option>
            <option value="09">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            </select> -->
          </div>
                <div class="input-group mb-3 input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">อำเภอ : </span>
                  </div>
                        <select name="amphure_id" id="amphure" class="form-control" required>
                            <option value="">-เลือกอำเภอ-</option>
                            <?php while($result = mysqli_fetch_assoc($query)): ?>
                                <option value="<?=$result['id']?>" ><?=$result['name_th']?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                        <div class="input-group mb-3 input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">ตำบล : </span>
                        </div>
                        <select name="district_id" id="district" class="form-control"  required >
                            <option value="">-เลือกตำบล-</option>
                        </select>
                       </div>

                       <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">โทรศัพท์มือถือ : </span>
                      </div>
                    <input type="text" class="form-control" name="tel" required>
                    </div> 
                    <!-- <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">อยูในเขตเทศบาล/อบต.</span>
                      </div>
                      <select id="select-testing" class="selectpicker" data-live-search="true" title="กรุณาเลือก" name="obt" required>
                      <select class="form-control" id="obt" name="obt" required>
                      <option value="">-เลือกหน่วยงาน-</option>
                          <?php
						  
                         // include('connect.php');
                          $sql0 = "SELECT * FROM tesaban WHERE province='$province' group by tcode";
                          $query0 = mysqli_query($conn, $sql0);
                          while ($result0 = mysqli_fetch_assoc($query0)):
                            $obtx = $result0['tcode'];
                            if ($tcode == $obtx) { $obt0 = 'selected'; } else { $obt0 = ''; }
                           ?>
                            <option value="<?=$result0['tcode']?>" <?=$obt0?>><?php echo "[".$result0['ampname']."] ".$result0['hospname']; ?></option>
                          <?php endwhile; ?>
                      </select>
            </div> -->
	    <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">อยูในเขตรพ.สต.</span>
                      </div>
                      <select id="select-testing" class="selectpicker" data-live-search="true" title="กรุณาเลือก" name="pcu">
                      <option value="">-เลือกหน่วยงาน-</option>
                          <?php		  
                         // include('connect.php');
                          $sql0 = "SELECT * FROM office WHERE provid='$province' and off_type IN('03', '04', '06', '07','08', '09')";
                          $query0 = mysqli_query($conn, $sql0);
                          while ($result0 = mysqli_fetch_assoc($query0)):
                            $pcux = $result0['off_id'];
                            if ($off_id == $pcux) { $pcu0 = 'selected'; } else { $pcu0 = ''; }
                           ?>
                            <option value="<?=$result0['off_id']?>" <?=$pcu0?>><?php echo "[".$result0['distid']."] ".$result0['off_name']; ?></option>
                          <?php endwhile; ?>
                      </select>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>ข้อมูลเอกสาร</h5>
                <div>
                    <div class="input-group mb-3 input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">แบบคำขอมีบัตรประจำตัวคนพิการ : </span>
                        </div>
                        <input type="file" class="form-control" name="fileDSCard" >
                    </div>
                  <div class="input-group mb-3 input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">บัตรประจำตัวคนพิการ : </span>
                        </div>
                        <input type="file" class="form-control" name="fileCard">
                    </div>
                </div>
                <div class="input-group mb-3 input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">หนังสือให้คำยินยอม : </span>
                    </div>
                    <input type="file" class="form-control bg-info" name="fileConsent" >
                </div>  
                <div class="input-group mb-3 input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">เอกสารรับรองความพิการ : </span>
                    </div>
                    <input type="file" class="form-control bg-info" name="fileBook" >
                </div> 
                <div class="input-group mb-3 input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">สำเนาบัตรประชาชนคนพิการ : </span>
                    </div>
                    <input type="file" class="form-control" name="fileIdCard" >
                </div>
                    <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">สำเนาทะเบียนบ้านคนพิการ : </span>
                      </div>
                    <input type="file" class="form-control" name="fileHome" >
                    </div> 
                    <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">สำเนาบัตรประชาชนผู้ดูแล : </span>
                      </div>
                    <input type="file" class="form-control" name="fileIdCard2" >
                    </div> 
                    <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">สำเนาทะเบียนบ้านผู้ดูแล : </span>
                      </div>
                    <input type="file" class="form-control" name="fileHome2" >
                    </div> 
                    <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">รูปถ่ายหน้าตรง สำหรับติดบัตรคนพิการ : </span>
                      </div>
                    <input type="file" class="form-control" name="fileFace" >
                    </div> 
                    
                    <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">รูปถ่ายเต็มตัว คนพิการ : </span>
                      </div>
                    <input type="file" class="form-control" name="filePict" >
                    </div> 
                    <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">รูปถ่ายหน้าบัญชีธนาคาร : </span>
                      </div>
                      <input type="file" class="form-control" name="fileBank">
                    </div>

                    <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">หนังสือรับรองการเป็นผู้ดูแลคนพิการ : </span>
                      </div>
                      <input type="file" class="form-control" name="fileCaregiver" >
                    </div>
                    <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">หนังสือยินยอมให้เพิ่มหรือเปลี่ยนแปลงผู้ดูแลคนพิการ : </span>
                      </div>
                      <input type="file" class="form-control" name="fileCaregiverChange">
                    </div>
                    <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">หนังสือมอบอำนาจ : </span>
                      </div>
                      <input type="file" class="form-control" name="fileAuthorize">
                    </div>
		    <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">หนังสือนำส่ง : </span>
                      </div>
                      <input type="file" class="form-control" name="fileDelivery" >
                    </div>
                    
                </div> 
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span>เพิ่มข้อมูล</button>
                   
            </div>
            <!-- <button onclick="window.close()" class="btn btn-danger btn-sm">ปิด</button>  -->
        </div>  
                   
    </div>
   
</div>
<script src="assets/script.js"></script>
<script src="assets/script0.js"></script>
 </div>
        </div>
        
        </form>
         
<?php
}
?>
        </div>
        <!--**********************************      Content body end     ***********************************-->    
        <!--**********************************         Footer start      ***********************************-->
        <!-- <div class="footer">
            <div class="copyright">
                <p>Copyright &copy; Designed & Developed by <a href="https://themeforest.net/user/quixlab">Quixlab</a> 2018</p>
            </div>
        </div> -->
        <!--**********************************     Footer end    ***********************************-->
    </div>
    <!--**********************************     Main wrapper end   ***********************************-->
    <!--**********************************        Scripts    ***********************************-->
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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>   
<script src="jquery.datetimepicker.full.js"></script>
<script type="text/javascript">   
$(function(){
    $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
    // กรณีใช้แบบ input
    $("#birth").datetimepicker({
        timepicker:false,
		//defaultDate: '01/07/1922',
		//yearStart: 1922,  ดูค่าในเจเอสไฟล์เป็นหลัก
		//yearEnd: 2022,
        format:'d-m-Y',  // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000      
		//defaultDate: '31/12/2022',
		maxDate: new Date('31/12/2565'),
		//minDate: new Date('2017-12-5'),
		//yearRange: '-200:+0', // last hundred years or
		yearRange: '1950:2025', // specifying a hard coded year range
        lang:'th',  // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
        onSelectDate:function(dp,$input){
            var yearT=new Date(dp).getFullYear()-0;  
            var yearTH=yearT+543;
            var fulldate=$input.val();
            //var fulldateTH=fulldate.replace(yearT,yearTH);
			var fulldateTH=fulldate.replace(yearT,yearTH);
            $input.val(fulldateTH);
        },
    });       
    // กรณีใช้กับ input ต้องกำหนดส่วนนี้ด้วยเสมอ เพื่อปรับปีให้เป็น ค.ศ. ก่อนแสดงปฏิทิน
    $("#birth").on("mouseenter mouseleave",function(e){
        var dateValue=$(this).val();
        if(dateValue!=""){
                var arr_date=dateValue.split("-"); // ถ้าใช้ตัวแบ่งรูปแบบอื่น ให้เปลี่ยนเป็นตามรูปแบบนั้น
                // ในที่นี้อยู่ในรูปแบบ 00-00-0000 เป็น d-m-Y  แบ่งด่วย - ดังนั้น ตัวแปรที่เป็นปี จะอยู่ใน array
                //  ตัวที่สอง arr_date[2] โดยเริ่มนับจาก 0 
                if(e.type=="mouseenter"){
                    var yearT=arr_date[2]-543;
                }       
                if(e.type=="mouseleave"){
                    var yearT=parseInt(arr_date[2])+543;
                }   
                dateValue=dateValue.replace(arr_date[2],yearT);
                $(this).val(dateValue);
        }       
    });
     
});
</script>
</body>

</html>
