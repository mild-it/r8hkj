<?php
session_start();
if($_SESSION["levelx"] == "") {
header("Location: page-login.php");
}

include('server.php');
include('connectDB.php');
$provinces = $_SESSION['province'];
// echo "p=$provinces";

$query = "SELECT * FROM provinces WHERE code = $provinces";

$sqlp = "SELECT * FROM amphures where code like '$provinces%' ";
$query10 = mysqli_query($conn, $sqlp);

$q1 = "SELECT COUNT(disType) as disType1 FROM caseDis
where disType = 'ทางการเห็น' AND tambol like '$provinces%'";
$result1 = $mysqli->query($q1); $rs1=$result1->fetch_object();
$disType1=$rs1->disType1;

$q2 = "SELECT COUNT(disType) as disType2 FROM caseDis
where disType = 'ทางการได้ยินหรือการสื่อความหมาย' AND tambol like '$provinces%'";
$result2 = $mysqli->query($q2); $rs2=$result2->fetch_object();
$disType2=$rs2->disType2;

$q3 = "SELECT COUNT(disType) as disType3 FROM caseDis
where disType = 'ทางการเคลื่อนไหวหรือทางร่างกาย' AND tambol like '$provinces%'";
$result3 = $mysqli->query($q3); $rs3=$result3->fetch_object();
$disType3=$rs3->disType3;

$q4 = "SELECT COUNT(disType) as disType4 FROM caseDis
where disType = 'ทางจิตใจหรือพฤติกรรม' AND tambol like '$provinces%'";
$result4 = $mysqli->query($q4); $rs4=$result4->fetch_object();
$disType4=$rs4->disType4;

$q5 = "SELECT COUNT(disType) as disType5 FROM caseDis
where disType = 'ทางสติปัญญา' AND tambol like '$provinces%'";
$result5 = $mysqli->query($q5); $rs5=$result5->fetch_object();
$disType5=$rs5->disType5;

$q6 = "SELECT COUNT(disType) as disType6 FROM caseDis
where disType = 'ทางการเรียนรู้' AND tambol like '$provinces%'";
$result6 = $mysqli->query($q6); $rs6=$result6->fetch_object();
$disType6=$rs6->disType6;

$q7 = "SELECT COUNT(disType) as disType7 FROM caseDis
where disType = 'ทางออทิสติก' AND tambol like '$provinces%'";
$result7 = $mysqli->query($q7); $rs7=$result7->fetch_object();
$disType7=$rs7->disType7;

$dataPoints = array( 
    array("label"=>"ทางการเห็น", "y"=>$disType1),
	array("label"=>"ทางการได้ยินหรือการสื่อความหมาย", "y"=>$disType2),
	array("label"=>"ทางการเคลื่อนไหวหรือทางร่างกาย", "y"=>$disType3),
	array("label"=>"ทางจิตใจหรือพฤติกรรม", "y"=>$disType4),
	array("label"=>"ทางสติปัญญา", "y"=>$disType5),
	array("label"=>"ทางการเรียนรู้", "y"=>$disType6),
    array("label"=>"ทางออทิสติก", "y"=>$disType7)
)
?>

                    <?php
                        if($_REQUEST["act"]==1){
                            session_start();
                            include ("connectDB.php");
                            $amphures=$_REQUEST["amphure_id"]; 
                            $provinces = $_SESSION['province'];
                            // echo "pp=$amphures";
                            
                            $q1 = "SELECT COUNT(disType) as disType1 FROM caseDis
                            where disType = 'ทางการเห็น' AND amper = '$amphures'";
                            $result1 = $mysqli->query($q1); $rs1=$result1->fetch_object();
                            $disType1=$rs1->disType1;

                            $q2 = "SELECT COUNT(disType) as disType2 FROM caseDis
                            where disType = 'ทางการได้ยินหรือการสื่อความหมาย' AND amper = '$amphures'";
                            $result2 = $mysqli->query($q2); $rs2=$result2->fetch_object();
                            $disType2=$rs2->disType2;

                            $q3 = "SELECT COUNT(disType) as disType3 FROM caseDis
                            where disType = 'ทางการเคลื่อนไหวหรือทางร่างกาย' AND amper = '$amphures'";
                            $result3 = $mysqli->query($q3); $rs3=$result3->fetch_object();
                            $disType3=$rs3->disType3;

                            $q4 = "SELECT COUNT(disType) as disType4 FROM caseDis
                            where disType = 'ทางจิตใจหรือพฤติกรรม' AND amper = '$amphures'";
                            $result4 = $mysqli->query($q4); $rs4=$result4->fetch_object();
                            $disType4=$rs4->disType4;

                            $q5 = "SELECT COUNT(disType) as disType5 FROM caseDis
                            where disType = 'ทางสติปัญญา' AND amper = '$amphures'";
                            $result5 = $mysqli->query($q5); $rs5=$result5->fetch_object();
                            $disType5=$rs5->disType5;

                            $q6 = "SELECT COUNT(disType) as disType6 FROM caseDis
                            where disType = 'ทางการเรียนรู้' AND amper = '$amphures'";
                            $result6 = $mysqli->query($q6); $rs6=$result6->fetch_object();
                            $disType6=$rs6->disType6;

                            $q7 = "SELECT COUNT(disType) as disType7 FROM caseDis
                            where disType = 'ทางออทิสติก' AND amper = '$amphures'";
                            $result7 = $mysqli->query($q7); $rs7=$result7->fetch_object();
                            $disType7=$rs7->disType7;

                            

                        }
                    ?>

<?php
    session_start();
    include('server.php');
    include('connectDB.php');
    //echo $_SESSION['pcu'];
    $d = $_SESSION['pcu'];
	$dd = $_SESSION['level'];
    $query = "SELECT * FROM office WHERE off_id_new = $d LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $pcu = $row['off_name'];

    $resultx = $mysqli->query("SELECT * from caseDis WHERE hospcode='$d' and statusCase='PMJ' ");
    $countPMJ=mysqli_num_rows($resultx);
    $resultx = $mysqli->query("SELECT * from caseDis WHERE hospcode='$d' and statusCase='OBT' ");
    $countOBT=mysqli_num_rows($resultx);
    $resultx = $mysqli->query("SELECT * from caseDis WHERE hospcode='$d' and statusCase='DOC' ");
    $countDOC=mysqli_num_rows($resultx);
    $resultx = $mysqli->query("SELECT * from caseDis WHERE hospcode='$d' and statusCase='OK' ");
    $countOK=mysqli_num_rows($resultx);
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
    <style>
		body {  font-family: 'Kanit', sans-serif;	}
		h1,h2,h3,h4,h5,h6 {  font-family: 'Kanit', sans-serif;	}
    </style>

    <style>
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 320px;
            max-width: 660px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }
    </style>
<style type="text/css">.bgimg {  background-image: url('../images/disLogo.png'); }  </style>

                    <script>
                    window.onload = function() {
                    var chart = new CanvasJS.Chart("chartContainer", {
                        animationEnabled: true,
                        title: {
                            text: "ประเภทคนพิการที่ลงทะเบียน ภาพรวมจังหวัด"
                        },
                        subtitles: [{
                            text: ""
                        }],
                        data: [{
                            type: "pie",
                            yValueFormatString: "#,##0\"\"",
                            indexLabel: "{label} ({y})",
                            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                        }]
                    });
                    chart.render();
                    
                    }
                    </script>     
</head>
<body>
                        
<?php
  if($levelId=='PMJ'){
    ?>
<META HTTP-EQUIV="Refresh" CONTENT="0;URL=./pageOK2.php">
<?php } ?>
<?php
  if($levelId=='OBT'){
    ?>
<META HTTP-EQUIV="Refresh" CONTENT="0;URL=./pageOK3.php">
<?php } ?>


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
            <div>
                <a href="page1.php">
                    <span>
                        <img src="images/rds2.png" alt="">
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
                <br><h3 class="text-green"> &nbsp;&nbsp;&nbsp;    ระบบบริการข้อมูลคนพิการ  <font color="gray" size="2">&nbsp;&nbsp;&nbsp; Nongbualamphu Disability Data Center</font></h3><h5>&nbsp;&nbsp;&nbsp;หน่วยงาน: <?php echo $pcu;?></h5>
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
        <div class="nk-sidebar bg-light text-white">           
            <div class="nk-nav-scroll bg-light text-white">
                <ul class="metismenu bg-light text-white" id="menu">
                   
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
                            <li><a href="#">- อยู่ระหว่างจัดทำ.</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************       Sidebar end    ***********************************-->
        <!--**********************************      Content body start      ***********************************-->

       

    <div class="content-body">
    <br>
                
    <br>
        <div class="container-fluid mt-3">
                <div class="row">
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
				
            </div>       
            <!-- #/ container -->
                
        </div>

        <div align="center">
            <FORM name="form1" class="form-inline" ACTION ='?act=1&amphures=<?=$amphures?>' METHOD='post'  enctype='multipart/form-data'>
                <div class="container-fluid mt-3">
                    
                    <div >
                    <span>ดูรายงานแยกรายอำเภอ : </span>
                            <select name="amphure_id" id="amphure"  required>
                                <option value="">-เลือกอำเภอ-</option> 
                                <?php while($result = mysqli_fetch_assoc($query10)): ?>
                                    <option value="<?=$result['id']?>" ><?=$result['name_th']?></option>
                                <?php endwhile; ?>
                            </select> 
                            <button type="submit" class="btn btn-primary" name="report">ตกลง</button>
                    </div>
                </div>
            </FORM>
        </div>

        <!-- //กราฟ -->
        <div align="center">  
                <canvas id="myChart" style="width:100%;max-width:600px;"></canvas>
        </div>
       
        <!-- <figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        All color options in Highcharts can be defined as gradients or patterns.
        In this chart, a gradient fill is used for decorative effect in a pie
        chart.
    </p>
</figure> -->

        <div class="container-fluid mt-3">
            <DIV id="showdis">
					<img src="./images/bgImg.png" alt="Nature" style="width:100%;">
            </DIV>
        </div>
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
	<!-- <script  src="./script.js"></script> -->

    <script src="assets/script.js"></script>
    <script src="assets/script0.js"></script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>


                            <script>
                            var a = <?=$disType1;?>;
                            var b = <?=$disType2;?>;
                            var c = <?=$disType3;?>;
                            var d = <?=$disType4;?>;
                            var e = <?=$disType5;?>;
                            var f = <?=$disType6;?>;
                            var g = <?=$disType7;?>;
                            var am = <?=$amphures;?>;

                            var xValues = ["ทางการเห็น", "ทางการได้ยินหรือการสื่อความหมาย", "ทางการเคลื่อนไหวหรือทางร่างกาย", "ทางจิตใจหรือพฤติกรรม", "ทางสติปัญญา","ทางการเรียนรู้","ทางออทิสติก"];
                            var yValues = [a, b, c, d,e,f,g];
                            var barColors = [
                            "#b91d47",
                            "#00aba9",
                            "#2b5797",
                            "#e8c3b9",
                            "#1e7145",
                            "#CC33FF",
                            "#99FF99"
                            ];

                            new Chart("myChart", {
                            type: "pie",
                            data: {
                                labels: xValues,
                                datasets: [{
                                backgroundColor: barColors,
                                data: yValues
                                }]
                            },
                            options: {
                                title: {
                                display: true,
                                text:"ประเภทคนพิการที่ลงทะเบียนอำเภอ" 
                                }
                            }
                            });
                            </script>

                            <script>
                                    // Data retrieved from https://netmarketshare.com/
                                    // Radialize the colors
                                    Highcharts.setOptions({
                                        colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
                                            return {
                                                radialGradient: {
                                                    cx: 0.5,
                                                    cy: 0.3,
                                                    r: 0.7
                                                },
                                                stops: [
                                                    [0, color],
                                                    [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
                                                ]
                                            };
                                        })
                                    });

                                    // Build the chart
                                    Highcharts.chart('container', {
                                        chart: {
                                            plotBackgroundColor: null,
                                            plotBorderWidth: null,
                                            plotShadow: false,
                                            type: 'pie'
                                        },
                                        title: {
                                            text: 'Browser market shares in April, 2022'
                                        },
                                        tooltip: {
                                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                        },
                                        accessibility: {
                                            point: {
                                                valueSuffix: '%'
                                            }
                                        },
                                        plotOptions: {
                                            pie: {
                                                allowPointSelect: true,
                                                cursor: 'pointer',
                                                dataLabels: {
                                                    enabled: true,
                                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                                    connectorColor: 'silver'
                                                }
                                            }
                                        },
                                        series: [{
                                            name: 'Share',
                                            data: [
                                                { name: 'ทางการเห็น', y: 73.24 },
                                                { name: 'Edge', y: 12.93 },
                                                { name: 'Firefox', y: 4.73 },
                                                { name: 'Safari', y: 2.50 },
                                                { name: 'Internet Explorer', y: 1.65 },
                                                { name: 'Other', y: 4.93 }
                                            ]
                                        }]
                                    });

                            </script>
                    
</body>

</html>
