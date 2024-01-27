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
    //echo $_SESSION['pcu'];
    $email = $_SESSION['email'];
    $d = $_SESSION['level'];
    // $query = "SELECT * FROM office WHERE off_id_new = $d LIMIT 1";
    // $result = mysqli_query($conn, $query);
    // $row = mysqli_fetch_array($result);
    // $pcu = $row['off_name'];
    // $obt='05390601';
    
    $query = "SELECT * FROM tesaban WHERE tcode = $d LIMIT 1";
    // echo "Debug: ".$query;
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);

    $opt = $row['hospname'];
    // $obt = $row['tcode'];

    // $resultx = $mysqli->query("SELECT * from caseDis WHERE statusCase='PMJ' and obt='$obt'");
    // $countPMJ=mysqli_num_rows($resultx);
    // $resultx = $mysqli->query("SELECT * from caseDis WHERE statusCase='OBT'  and obt='$d'");
    // $countOBT=mysqli_num_rows($resultx);
    // $resultx = $mysqli->query("SELECT * from caseDis WHERE statusCase='DOC' and infoFrom='OBT' and obt='$d'");
    // $countDOC=mysqli_num_rows($resultx);
    // $resultx = $mysqli->query("SELECT * from caseDis WHERE statusCase='OK'  and obt='$d'");
    // $countOK=mysqli_num_rows($resultx);

    $sql_case = "select sum(case when c.statusCase='OBT' then 1 else 0 end) as obt_case
    , sum(case when c.statusCase='DOC' and c.infoFrom = 'OBT' then 1 else 0 end) as doc_case
    , sum(case when c.statusCase='OK' then 1 else 0 end) as ok_case
    from caseDis as c
    where obt = '$d'";
    $result_case = $mysqli->query($sql_case);
    $row_case = mysqli_fetch_array($result_case);
?>
<?php
if ($_REQUEST['act'] == 1) { 
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
	<link rel='stylesheet' href='https://codepen.io/2kool2/pen/ZOmJqq.css'>
	<link rel="stylesheet" href="./style.css">
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
    <style>
		body {  font-family: 'Kanit', sans-serif;	}
		h1,h2,h3,h4,h5,h6 {  font-family: 'Kanit', sans-serif;	}
    </style>
<style type="text/css">.bgimg {  background-image: url('../images/disLogo.png'); }  </style>
</head>
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
    <!--*******************     Preloader end   ********************-->

    
    <!--**********************************      Main wrapper start  ***********************************-->
    <div id="main-wrapper">

        <!--**********************************          Nav header start      ***********************************-->
        <!-- <div class="nav-header">
            <div class="brand-logo">
                <a href="page3.php">
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
                        <img src="images/rds2.png" alt="">
                    </span>
                </a>
            </div>
        </div>
		<!--**********************************            Nav header end        ***********************************-->

        <!--**********************************            Header start        ***********************************-->

        <div class="header">    
            <div class="header-content clearfix ">

                <div class="nav-control ">
                    <div class="hamburger ">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-left">
                <br><h3 class="text-green"> &nbsp;&nbsp;&nbsp;    ระบบบริการคนพิการแบบเบ็ดเสร็จ  <font color="gray" size="2">&nbsp;&nbsp;&nbsp; One-stop Service for Disabilities</font></h3><h5>&nbsp;&nbsp;&nbsp;หน่วยงาน: <?php echo $opt;?></h5>
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
                                            <!-- <a href="app-profile.html"><i class="icon-user"></i> <span>Profile</span></a> -->
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myProfile">Profile</button>
                                        </li>
                                        
                                        <li><a href="page3.php?act=1"><i class="icon-key"></i> <span>ออกจากระบบ</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************            Header end ti-comment-alt        ***********************************-->

        <!--**********************************            Sidebar start        ***********************************-->
        <div class="nk-sidebar bg-light text-white">           
            <div class="nk-nav-scroll bg-light text-white">
                <ul class="metismenu bg-light text-white" id="menu">
                   
                    <!-- <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./page3.php">Home</a></li>
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
                            <li><a href="./chart_distype_obt.php">- ประเภทคนพิการ</a></li>
                            <li><a href="./chart_distype_regis_obt.php">- จำนวนคนพิการ</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-settings menu-icon"></i><span class="nav-text">อื่นๆ</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="listVDOOBT.php">Telemed</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************         Sidebar end      ***********************************-->
        <!--**********************************            Content body start        ***********************************-->
        <div class="content-body">
    <br>
    
              <div class="container-fluid mt-3">
                <div class="row">
                   
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-3">
                            <!-- <a href="./listOBT.php" target="_blank"> -->
							<a href="#" onclick="showdisOBT(1);">
                            <div class="card-body">
                                <h3 class="card-title text-white">ยื่นคำร้องฯ รายใหม่</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo number_format($row_case["obt_case"]); ?></h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-wheelchair"></i></span>
                            </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-1">
                            <!-- <a href="./listPaper.php" target="_blank"> -->
							<a href="#" onclick="showdisPaper(2);">
                            <div class="card-body">
                                <h3 class="card-title text-white">ขอเอกสารเพิ่มเติม</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo number_format($row_case["doc_case"]); ?></h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-newspaper-o"></i></span>
                            </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-5">
                            <a href="./pageOK3.php">
							<!-- <a href="#" onclick="showdisOK(3)"> -->
                            <div class="card-body">
                                <h3 class="card-title text-white">เรียบร้อยแล้ว</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?php echo number_format($row_case["ok_case"]); ?></h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-check-square-o"></i></span>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
                <DIV id="showdis">
					<img src="./images/bgImg.png" alt="Nature" style="width:100%;">
                </DIV>
                
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        
        
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <!-- <p>Copyright &copy; Designed & Developed by <a href="https://themeforest.net/user/quixlab">Quixlab</a> 2018</p> -->
            </div>
        </div>
			<!--**********************************     Footer end   ***********************************-->
    </div>
			<!--**********************************    Main wrapper end ***********************************-->
			<!--**********************************       Scripts    ***********************************-->
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


<!-- Modal -->
<div class="modal fade" id="myProfile" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-light">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ข้อมูลผู้ใช้งาน</h4>
        </div>
        <div class="modal-body">
            <?php
            $q1="SELECT * FROM member WHERE email='$email'";          
            $result1 = $mysqli->query($q1);                                                                   
            $rs1=$result1->fetch_object();
            $username=$rs1->username;
            $lastname=$rs1->lastname;
            $id_line=$rs1->id_line;
            ?>
          <FORM name="form1" class="form-inline" ACTION ='page3.php?act=4&email=<?=$email?>' METHOD='post'  enctype='multipart/form-data'>  
            <div class="container"> 
                <p>ชื่อ-สกุล : <?=$username.'  '.$lastname?></p>
                <p>ระบุ Line User ID : <input type="text" class="form-control" name="id_line" rows="2" cols="40" value="<?=$id_line?>" required></p>
                <p>รหัสเทศบาล : <?php echo $d; ?></p>
            </div>
            <button type="submit" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-save"></span>Update</button>
            </FORM>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
</div>
<?php
if ($_REQUEST['act'] == 4) {
    $email = $_REQUEST['email'];
    $id_line = $_REQUEST['id_line'];
    $sql = "UPDATE member SET id_line = '$id_line' WHERE email = '$email'";
    $mysqli->query($sql);
?>
<META HTTP-EQUIV="Refresh" CONTENT="0;URL=./page3.php">
<?php
}
?>
</body>

</html>
