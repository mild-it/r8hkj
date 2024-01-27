<?php
session_start();
if($_SESSION["levelx"] == "") {
    header("Location: page-login.php");
}
include('server.php');
include('connectDB.php');
$province = $_SESSION['province_opt'];
// $q1 = "SELECT COUNT(cid) as hosp1 FROM caseDis
// where hospcode = '10704' ";
// $result1 = $mysqli->query($q1); $rs1=$result1->fetch_object();
// $hosp1=$rs1->hosp1;

// $q2 = "SELECT COUNT(cid) as hosp2 FROM caseDis
// where hospcode = '10991' ";
// $result2 = $mysqli->query($q2); $rs2=$result2->fetch_object();
// $hosp2=$rs2->hosp2;

// $q3 = "SELECT COUNT(cid) as hosp3 FROM caseDis
// where hospcode = '10992' ";
// $result3 = $mysqli->query($q3); $rs3=$result3->fetch_object();
// $hosp3=$rs3->hosp3;

// $q4 = "SELECT COUNT(cid) as hosp4 FROM caseDis
// where hospcode = '10993' ";
// $result4 = $mysqli->query($q4); $rs4=$result4->fetch_object();
// $hosp4=$rs4->hosp4;

// $q5 = "SELECT COUNT(cid) as hosp5 FROM caseDis
// where hospcode = '10994' ";
// $result5 = $mysqli->query($q5); $rs5=$result5->fetch_object();
// $hosp5=$rs5->hosp5;

// $q6 = "SELECT COUNT(cid) as hosp6 FROM caseDis
// where hospcode = '23367' ";
// $result6 = $mysqli->query($q6); $rs6=$result6->fetch_object();
// $hosp6=$rs6->hosp6;

$sql_report = "SELECT o.off_name as label, COUNT(c.cid) as y
FROM office as o
LEFT OUTER JOIN caseDis as c on o.off_id = c.hospcode
WHERE o.provid = '$province' and o.off_type in('04', '06', '07')
GROUP BY o.off_id";
$result_report = $mysqli->query($sql_report);
$array_data = array();
$i = 0;
while($row_report = mysqli_fetch_array($result_report)) {
    array_push($array_data, $row_report);
}
// print_r($array_data);

 // $dataPoints = array( 
 //     array("y" => $hosp1, "label" => "รพ.หนองบัวลำภู" ),
 //     array("y" => $hosp2, "label" => "รพ.นากลาง" ),
 //     array("y" => $hosp3, "label" => "รพ.โนนสัง" ),
 //     array("y" => $hosp4, "label" => "รพ.ศรีบุญเรือง" ),
 //     array("y" => $hosp5, "label" => "รพ.สุวรรณคูหา" ),
 //     array("y" => $hosp6, "label" => "รพ.นาวัง" ),
 // );

?>

<?php
    @session_start();
    include('server.php');
    include('connectDB.php');
    //echo $_SESSION['pcu'];
    $d = $_SESSION['level'];
    // $query = "SELECT * FROM office WHERE off_id_new = $d LIMIT 1";
    // $result = mysqli_query($conn, $query);
    // $row = mysqli_fetch_array($result);
    // $pcu = $row['off_name'];
    // $obt='05390601';
    
    $query = "SELECT * FROM tesaban WHERE tcode = $d LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);

    $opt = $row['hospname'];
    // $obt = $row['tcode'];

    // $resultx = $mysqli->query("SELECT * from caseDis WHERE statusCase='PMJ' and obt='$obt'");
    // $countPMJ=mysqli_num_rows($resultx);
    $resultx = $mysqli->query("SELECT * from caseDis WHERE statusCase='OBT'  and obt='$d'");
    $countOBT=mysqli_num_rows($resultx);
    $resultx = $mysqli->query("SELECT * from caseDis WHERE statusCase='DOC' and infoFrom='OBT' and obt='$d'");
    $countDOC=mysqli_num_rows($resultx);
    $resultx = $mysqli->query("SELECT * from caseDis WHERE statusCase='OK'  and obt='$d'");
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

                <script>
                    window.onload = function() {
                    
                    var chart = new CanvasJS.Chart("chartContainer", {
                        animationEnabled: true,
                        theme: "light2",
                        title:{
                            text: "จำนวนคนพิการที่ลงทะเบียนภาพรวมจังหวัด"
                        },
                        axisY: {
                            title: "(จำนวนคนพิการที่ลงทะเบียน)"
                        },
                        data: [{
                            type: "column",
                            yValueFormatString: "#,##0.## ",
                            indexLabel: "{y}",
                            dataPoints: <?php echo json_encode($array_data, JSON_NUMERIC_CHECK); ?>
                        }]
                    });
                    chart.render();
                    
                    }
                </script>
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
            <div>
                <a href="page3.php">
                    <span>
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
                            <i class="icon-chart menu-icon"></i><span class="nav-text">รายงาน</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./chart_distype_obt.php">- ประเภทคนพิการ</a></li>
                            <li><a href="./chart_distype_regis_obt.php">- จำนวนคนพิการ</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-settings menu-icon"></i><span class="nav-text">ตั้งค่า</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="#">ตั้งค่า1</a></li>
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
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
				
            </div>       
            <!-- #/ container -->
                
        </div>
                
    
            <div class="container-fluid mt-3 table-responsive">
                <div class="table-wrapper">
                    <h4 class = "text-center">จำนวนคนพิการที่ลงทะเบียน (หน่วยงานองค์กรปกครองส่วนท้องถิ่น)</h4>
                    <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="gradient-3">
                            <th class='text-center'>No.</th>
                            <th class='text-center'>อปท.</th>
                            <th class='text-center'>รหัส อปท.</th>
                            <th class='text-center'>จำนวนผู้พิการ</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php
                            $sql_obt = "select t.tcode, t.hospname, count(distinct(c.cid)) as dis1
                            from caseDis as c
                            left outer join tesaban as t on c.obt = t.tcode
                            where t.province = '$province'
                            group by t.tcode";
                            // $result = mysqli_query($conn, "SELECT tesaban.hospname as hospname,tesaban.tcode as tcode,COUNT(distinct(caseDis.cid)) as dis1
                            // FROM caseDis left join tesaban ON tesaban.tcode = caseDis.obt  group by obt;");
                            $result = mysqli_query($conn, $sql_obt);

                            // $query1 = mysqli_query($conn,"SELECT obt ,COUNT(disType) as dis
                            // FROM caseDis  order by cid asc");
                            // $result2 = $mysqli->query($query1); $rs=$query1->fetch_object();
                            // $dis=$rs->dis;
                            
                            $i = 1;
                            $total_case = 0;
                            while($row = mysqli_fetch_array($result)) {
                                $total_case += $row['dis1'];
                            ?>
                            <tr id="<?php echo $row["id"]; ?>">
                                <td class='text-center'><?php echo $i; ?></td>
                                <td class='text-center'><?php echo $row["hospname"]; ?></td>
                                
                                <td class='text-center'><?php echo $row["tcode"]; ?></td>
                                <td class='text-center'><?php echo number_format($row["dis1"]); ?></td>
                                
                            </tr>
                            <?php
                            $i++;
                            }
                            ?>
                            <tr>
                            <!-- <td class='text-center' ></td> -->
                            
                            <td class='text-center' colspan="3">รวม</td>
                            <td class='text-center'><?php echo number_format($total_case); ?></td>
                            </tr>
				        </tbody>
                </table>
                </div>
            </div>


        <div class="container-fluid mt-3">
            <DIV id="showdis">
					<img src="./images/bgImg.png" alt="Nature" style="width:100%;">
            </DIV>
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

</body>

</html>
