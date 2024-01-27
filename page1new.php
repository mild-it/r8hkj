<?php session_start(); if($_SESSION["levelx"]==""){header("Location: page-login.php");} ?>

<?php
    session_start();
    include('server.php');
    include('connectDB.php');
    //echo $_SESSION['pcu'];
    $d = $_SESSION['pcu'];
	$dd = $_SESSION['level'];
    // $id_line = $_SESSION['id_line'];
    $query = "SELECT * FROM office WHERE off_id_new = $d LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $pcu = $row['off_name'];

    $resultx = $mysqli->query("SELECT * from caseDis WHERE hospcode='$d' and statusCase='HOS' ");
    $countHOS=mysqli_num_rows($resultx);
    $resultx = $mysqli->query("SELECT * from caseDis WHERE hospcode='$d' and statusCase='PMJ' ");
    $countPMJ=mysqli_num_rows($resultx);
    $resultx = $mysqli->query("SELECT * from caseDis WHERE hospcode='$d' and statusCase='OBT' ");
    $countOBT=mysqli_num_rows($resultx);
    $resultx = $mysqli->query("SELECT * from caseDis WHERE hospcode='$d' and statusCase='DOC' ");
    $countDOC=mysqli_num_rows($resultx);
    $resultx = $mysqli->query("SELECT * from caseDis WHERE hospcode='$d' and statusCase='OK' ");
    $countOK=mysqli_num_rows($resultx);
?>
<?php
  if($_REQUEST['act']==1){ 
  session_destroy(); 
  $_SESSION["levelx"]='';
  header("Location: page-login.php");
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>R8:NDS</title>
	<!-- <link rel='stylesheet' href='https://codepen.io/2kool2/pen/ZOmJqq.css'>
	<link rel="stylesheet" href="./style.css"> -->
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/disLogo.png">
    <!-- Pignose Calender -->
    <link href="./plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="./plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="./plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <!-- Custom Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script type="text/javascript" src="js/show123.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
		body {  font-family: 'Kanit', sans-serif;	}
		h1,h2,h3,h4,h5,h6 {  font-family: 'Kanit', sans-serif;	}
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
    <!--*******************     Preloader start   ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*************************************   Preloader end  ****************************************-->   
    <!--**********************************      Main wrapper start   ***********************************-->
    <div id="main-wrapper">
        <!--**********************************       Nav header start      ***********************************-->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="page1.php">
                    <b class="logo-abbr"><img src="images/disLogo.png" alt=""> </b>
                    <span class="logo-compact"><img src="./images/disLogoText.png" alt=""></span>
                    <span class="brand-title">
                        <img src="images/disLogoText.png" alt="">
                    </span>
                </a>
            </div>
        </div>
        <!--**********************************       Nav header end    ***********************************-->
        <!--**********************************       Header start      ***********************************-->
        <div class="header">    
            <div class="header-content clearfix ">
                
                <div class="nav-control ">
                    <div class="hamburger ">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-left">
                <br><h3 class="text-green"> &nbsp;&nbsp;&nbsp;    ระบบบริการคนพิการแบบเบ็ดเสร็จ  <font color="gray" size="2">&nbsp;&nbsp;&nbsp; One-stop Service Center for Disabilities</font></h3><h5>&nbsp;&nbsp;&nbsp;หน่วยงาน: <?php echo $pcu;?></h5>
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
                                            <a href="#"><i class="icon-user"></i> <span>Profile</span></a>
                                        </li>       
                                        
                                        <li><a href="page1.php?act=1"><i class="icon-key"></i> <span>ออกจากระบบ</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************     Header end ti-comment-alt      ***********************************-->
        <!--**********************************      Sidebar start      ***********************************-->
        <div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                   
                    <!-- <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./page1.php">- หน้าหลัก</a></li>
                        </ul>
                    </li> -->
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-user menu-icon"></i><span class="nav-text">ทะเบียนคนพิการ</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./newCase.php?hospcode=<?=$d?>">- เพิ่มรายใหม่</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-chart menu-icon"></i><span class="nav-text">รายงาน</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./chart_distype.php">- ประเภทคนพิการ</a></li>
                            <li><a href="./chart_distype_regis.php">- จำนวนคนพิการ</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-settings menu-icon"></i><span class="nav-text">ตั้งค่า</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="moobaan/tesabaan.php"  target="_Blank">- ตั้งค่าหมู่บ้าน.</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************       Sidebar end    ***********************************-->
        <!--**********************************      Content body start      ***********************************-->
    <div class="content-body">
<br>
            <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#home"><i class="fa fa-home"></i></a>
            </li>
            <li class="nav-item">
            <a class="nav-link  bg-info" data-bs-toggle="tab" href="#hos" ><font color="white">ยื่นคำขอใหม่ <h3><?=$countHOS?> <i class="fa fa-wheelchair"></i></h3></font></a>
            </li>
            <li class="nav-item">
            <a class="nav-link bg-secondary" data-bs-toggle="tab" href="#pmj"><font color="white">พมจ.ตรวจสอบ<h3><?=$countPMJ?> <i class="fa fa-id-card"></i></h3></font></a>
            </li>
            <li class="nav-item">
            <a class="nav-link bg-warning" data-bs-toggle="tab" href="#obt">ท้องถิ่นตรวจสอบ<h3><?=$countOBT?> <i class="fa fa-pencil-square-o"></i></h3></a>
            </li>
            <li class="nav-item">
            <a class="nav-link bg-danger" data-bs-toggle="tab" href="#doc"><font color="white">ขอข้อมูลเพิ่ม<h3><?=$countDOC?> <i class="fa fa-newspaper-o"></i></h3></font></a>
            </li>
            <li class="nav-item">
            <a class="nav-link bg-success" data-bs-toggle="tab" href="#ok"><font color="white">เรียบร้อยแล้ว<h3><?=$countOK?> <i class="fa fa-check-square-o"></i></h3></font></a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div id="home" class="container tab-pane active"><br>
            <img src="./images/bgImg.png" alt="Nature" style="width:100%;">
            </div>
            <div id="hos" class="container tab-pane fade"><br>
            <embed SRC=./listHOS.php style="width:100%; height:500px;">
            <!-- <iframe name="iFrame1" width="900" height="1050" src="listHOS.php" scrolling="yes" frameborder="0"></iframe> -->
            </div>
            <div id="pmj" class="container tab-pane fade"><br>
            <embed SRC=./listPMJ.php style="width:100%; height:500px;">
            </div>
            <div id="obt" class="container tab-pane fade"><br>
            <embed SRC=./listOBT.php style="width:100%; height:500px;">
            </div>
            <div id="doc" class="container tab-pane fade"><br>
            <embed SRC=./listPaper.php style="width:100%; height:500px;">
            </div>
            <div id="ok" class="container tab-pane fade"><br>
            <embed SRC=./listOK1.php style="width:100%; height:500px;">
            </div>
        </div>
                    
    </div>
    <script>
function focusFunction() {
  // Focus = Changes the background color of input to yellow
  document.getElementById("myInput").style.background = "yellow";
}

function blurFunction() {
  // No focus = Changes the background color of input to red
  document.getElementById("myInput").style.background = "red";
}

function fncAlert()
{
alert('Hello ThaiCreate.Com');
}
function reload_view() {
    location.reload();
}
</script>

    
        <!--**********************************     Content body end     ***********************************-->
        
        <!--**********************************    Footer start     ***********************************-->
        <div class="footer">
            <div class="copyright">
                <!-- <p>Copyright &copy; Designed & Developed by <a href="https://themeforest.net/user/quixlab">Quixlab</a> 2018</p> -->
            </div>
        </div>
        <!--**********************************     Footer end     ***********************************-->
    </div>
    <!--**********************************     Main wrapper end   ***********************************-->

    <!--**********************************   Scripts  ***********************************-->
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
	</main>
</body>

</html>