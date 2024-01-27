<?php session_start(); if($_SESSION["levelx"]==""){header("Location: page-login.php");} ?>
<?php
    session_start();
    include('server.php');
    include('connectDB.php');

    $d = $_SESSION['level'];

    
    $q5="SELECT amphures.name_th hospname,count(caseDis.cid) p2 FROM caseDis
        INNER JOIN 	amphures ON	caseDis.amper = amphures.id
        GROUP BY caseDis.amper";
    $result5 = $mysqli->query($q5);                                                                  
    while($rs5=$result5->fetch_object()){
    $hospname=$rs5->hospname;
    $label2="'$hospname',$label2";
    $p2=$rs5->p2;
    $data2="'$p2',$data2";
    }

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
        <div class="nav-header">
            <div class="brand-logo">
                <a href="page3.php">
                    <b class="logo-abbr"><img src="images/disLogo.png" alt=""> </b>
                    <span class="logo-compact"><img src="./images/disLogoText.png" alt=""></span>
                    <span class="brand-title">
                        <img src="images/disLogoText.png" alt="">
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
                <br><h3 class="text-green"> &nbsp;&nbsp;&nbsp;    ระบบบริการข้อมูลคนพิการ  <font color="gray" size="2">&nbsp;&nbsp;&nbsp; Nongbualamphu Disability Data Center</font></h3><h5>&nbsp;&nbsp;&nbsp;หน่วยงาน: <?php echo $opt;?></h5>
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
        <div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                   
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
                            <i class="icon-chart menu-icon"></i><span class="nav-text">รายงาน</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./page3.php">รายงาน1</a></li>
                            <li><a href="./page3.php">รายงาน2</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-settings menu-icon"></i><span class="nav-text">ตั้งค่า</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./page3.php">ตั้งค่า1</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">
      <div class="container-fluid mt-3">
         <div class="col-lg-12 col-md-6 mt-4 mb-4">
          <div class="card z-index-2  ">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
              <div class="bg-gradient-info shadow-info border-radius-lg py-3 pe-1">
                <div class="chart">
                  <canvas id="chart-bars2" class="chart-canvas" height="170"></canvas>
                </div>
              </div>
            </div>
            <div class="card-body">
              <h6 class="mb-0 "> กราฟเปรียบเทียบจำนวนผู้พิการแยกรายอำเภอ </h6>
              <p class="text-sm "> ที่มา R8:NDS</p>
              <hr class="dark horizontal">
              <div class="d-flex ">
              </div>
            </div>
          </div>
        </div>
                
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

<script>
var ctx2 = document.getElementById("chart-bars2").getContext("2d");

new Chart(ctx2, {
  type: "bar",
  data: {
    labels: [เมือง,นากลาง,โนนสัง,ศรีบุญเรือง,สุวรรณคูหา,นาวัง],
    datasets: [{
      label: "ร้อยละ",
      tension: 0.4,
      borderWidth: 0,
      borderRadius: 4,
      borderSkipped: false,
      backgroundColor: "rgba(255, 255, 255, .8)",
      data: [1,3,2,4,6,5],
      maxBarThickness: 45
    }, ],
  },
  plugins: [ChartDataLabels],
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: false,
      }
    },
    interaction: {
      intersect: false,
      mode: 'index',
    },
    scales: {
      y: {
        grid: {
          drawBorder: false,
          display: true,
          drawOnChartArea: true,
          drawTicks: false,
          borderDash: [5, 5],
          color: 'rgba(255, 255, 255, .2)'
        },
        ticks: {
          suggestedMin: 0,
          suggestedMax: 500,
          beginAtZero: true,
          padding: 10,
          font: {
            size: 12,
            weight: 300,
            family: "Roboto",
            style: 'normal',
            lineHeight: 2
          },
          color: "#fff"
        },
      },
      x: {
        grid: {
          drawBorder: false,
          display: true,
          drawOnChartArea: true,
          drawTicks: false,
          borderDash: [5, 5],
          color: 'rgba(255, 255, 255, .2)'
        },
        ticks: {
          display: true,
          color: '#f8f9fa',
          padding: 10,
          font: {
            size: 12,
            weight: 300,
            family: "Roboto",
            style: 'normal',
            lineHeight: 2
          },
        }
      },
    },
  },
});
</script>
</body>

</html>