<?php
session_start();
if($_SESSION["levelx"]==""){header("Location: page-login.php");} ?>

<?php
    @session_start();
    include('server.php');
    include('connectDB.php');
    include ("connect.php");
    include ("function.php");
    include ("paginate.php");
    //echo $_SESSION['pcu'];
    $d = $_SESSION['pcu'];
	$dd = $_SESSION['level'];
    @$d1 = $_SESSION['level'];
    $level = $_SESSION['levelx'];
    $province = $_SESSION['province'];
    $query = "SELECT * FROM office WHERE off_id_new = $d LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $pcu = $row['off_name'];

    $province = $_SESSION['province'];
    $query = "SELECT * FROM provinces WHERE code = $province";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $province_name = $row['name_th'];


    $resultx = $mysqli->query("SELECT * from caseDis WHERE tambol like '$province%' and statusCase='PMJ' ");
    $countPMJ=mysqli_num_rows($resultx);
    $resultx = $mysqli->query("SELECT * from caseDis WHERE tambol like '$province%' and (statusCase='OBT' or infoFrom='OBT') ");
    $countOBT=mysqli_num_rows($resultx);
    $resultx = $mysqli->query("SELECT * from caseDis WHERE tambol like '$province%' and statusCase='DOC' and infoFrom='PMJ' ");
    $countDOC=mysqli_num_rows($resultx);
    $resultx = $mysqli->query("SELECT * from caseDis WHERE tambol like '$province%' and statusCase='OK' ");
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
    <style>
		body {  font-family: 'Kanit', sans-serif;	}
		h1,h2,h3,h4,h5,h6 {  font-family: 'Kanit', sans-serif;	}
    </style>
<style type="text/css">.bgimg {  background-image: url('../images/disLogo.png'); }  </style>
</head>
<body>

    <!--*******************    Preloader start    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************        Preloader end    ********************-->
    <!--**********************************      Main wrapper start   ***********************************-->
    <div id="main-wrapper">
    <!--**********************************        Nav header start       ***********************************-->
        <!-- <div class="nav-header">
            <div class="brand-logo">
                <a href="pageOK2.php">
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
                <a href="pageOK2.php">
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
                <p><h3 class="text-green"> &nbsp;&nbsp;&nbsp;    ระบบบริการคนพิการแบบเบ็ดเสร็จ  <font color="gray" size="2">&nbsp;&nbsp;&nbsp; One-stop Service for Disabilities</font></h3><h5>&nbsp;&nbsp;&nbsp;หน่วยงาน:สำนักงานพัฒนาสังคมและความมั่นคงของมนุษย์<?=$province_name?></h5>
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
                                        
                                        <li><a href="pageOK2.php?act=1"><i class="icon-key"></i> <span>ออกจากระบบ</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************          Header end ti-comment-alt       ***********************************-->
        <!--**********************************         Sidebar start      ***********************************-->
        <div class="nk-sidebar bg-light text-white">           
            <div class="nk-nav-scroll bg-light text-white">
                <ul class="metismenu bg-light text-white" id="menu">
                   
                    <!-- <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./page2.php">Home</a></li>
                        </ul>
                    </li> -->
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-chart menu-icon"></i><span class="nav-text">รายงาน</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./chart_distype_pmj.php">- ประเภทคนพิการ</a></li>
                            <li><a href="./chart_distype_regis_pmj.php">- จำนวนคนพิการ</a></li>
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
        <!--**********************************       Sidebar end      ***********************************-->
        <!--**********************************     Content body start      ***********************************-->
        <div class="content-body">
    <br>
     <div class="container-fluid mt-3">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-2">
							<!-- <a href="#" onclick="showdisPMJ(0);"> -->
                            <a href="./page2.php">
                            <div class="card-body">
                                <h3 class="card-title text-white">ขอขึ้นทะเบียนรายใหม่</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?=$countPMJ?></h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-wheelchair"></i></span>
                            </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-3">
							<!-- <a href="#" onclick="showdisOBT(1);"> -->
                            <a href="./page2.php">
                            <div class="card-body">
                                <h3 class="card-title text-white">เทศบาล/อบต.ตรวจสอบ</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?=$countOBT?></h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-pencil-square-o"></i></span>
                            </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-1">
                            <a href="./page2.php">
							<!-- <a href="#" onclick="showdisPaper(2);"> -->
                            <div class="card-body">
                                <h3 class="card-title text-white">ขอเอกสารเพิ่มเติม</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?=$countDOC?></h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-newspaper-o"></i></span>
                            </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-5">
                            <a href="#">
							<!-- <a href="#" onclick="showdisOK(3)"> -->
                            <div class="card-body">
                                <h3 class="card-title text-white">เรียบร้อยแล้ว</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?=$countOK?></h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-check-square-o"></i></span>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
<form name="form1" method="get" action="">
<div class="form-group row">
<label for="keyword" class="col-sm-4 col-form-label text-right">
    ค้นหา
    </label>
    <div class="col-sm-3">
      <input type="text" class="form-control" name="keyword" id="keyword" 
       value="<?=(isset($_GET['keyword']))?$_GET['keyword']:""?>">
    </div>
	<button type="submit" class="btn btn-primary btn-sm" name="btn_search" id="btn_search">ค้นหา</button>
</div>    
</form>
<div class="table-responsive-sm">
<table class="table table-bordered table-striped">
    <thead>
		<tr class="gradient-5">
	    	<th class='text-center'>No.</th>
			<th class='text-center'>ชื่อ-สกุล</th>
	    	<th class='text-center'>ประเภทความพิการ</th>
			<th class='text-center'>หน่วยงานรับดูแล</th>
			<th class='text-center'><font size=2>วันที่รับรองความพิการ</th>
			<th class='text-center'><font size=2>วันที่ได้รับขึ้นทะเบียน</th>
			<th class='text-center'><font size=2>วันที่ได้รับการดูแล</th>
	    	<th></th>
	    </tr>
    </thead>
    <tbody>
    <?php 
		$num = 0;
		if ($level == 'pcu') {
            $sql = "SELECT c.*, t.hospname as name_obt, t.ampname as obt_ampname FROM caseDis as c left outer join tesaban as t on c.obt = t.tcode where c.tambol like '$province%' and c.statusCase='OK' and c.hospcode='$d'";
        } elseif ($level == 'opt') {
            $sql = "SELECT *, t.hospname as name_obt, t.ampname as obt_ampname FROM caseDis as c left outer join tesaban as t on c.obt = t.tcode where c.tambol like '$province%' and c.statusCase='OK' and c.obt='$d1'";
        } else {
            $sql = "SELECT *, t.hospname as name_obt, t.ampname as obt_ampname FROM caseDis as c left outer join tesaban as t on c.obt = t.tcode where c.tambol like '$province%' and c.statusCase='OK' ";
        }
			// เงื่อนไขสำหรับ input text
			if(isset($_GET['keyword']) && $_GET['keyword']!=""){
				// ต่อคำสั่ง sql 
				$sql.=" AND c.fname LIKE '%".trim($_GET['keyword'])."%'";    
				}
    		$result=mysqli_query($conn,$sql);
			@$total=$result->num_rows;											
    		$i = 1;		
				$e_page=10; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
				$step_num=0;
				if(!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page']==1)){   
					$_GET['page']=1;   
					$step_num=0;
					$s_page = 0;    
				}else{   
					$s_page = $_GET['page']-1;
					$step_num=$_GET['page']-1;  
					$s_page = $s_page*$e_page;
				}   
				$sql.=" ORDER BY c.dateREG DESC, c.fname LIMIT ".$s_page.",$e_page";
				$result = mysqli_query($conn,$sql);	
				
	if($result && $result->num_rows>0){  // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
    		while($row = mysqli_fetch_array($result)) 
    		{
				$num++;
				$cid=base64_encode($row['cid']);
				// $id_obt=$row['obt'];
                // $q1="SELECT hospname FROM tesaban where tcode='$id_obt'";          
                // $result1 = mysqli_query($conn,$q1);
                // $rs1=$result1->fetch_object();
                // $name_obt=$rs1->hospname;
    	?>
    	<tr>
		<td class='text-center'> <?=($step_num*$e_page)+$num?></td>
	    	<td><?php echo $row['fname'].' '.$row['lname']; ?></td>
	    	<td><font size=2><?php echo $row['disType']; ?></td>
			<td><font size=2><?php echo $row['name_obt']." [อ.".$row['obt_ampname']."]"; ?></font></td>
			<td><font size=2><?php echo Thai_date($row['dateREG']); ?></td>
			<td><font size=2><?php echo Thai_date($row['datePMJ']); ?></td>
			<td><font size=2><?php echo Thai_date($row['dateOBT']); ?></td>
	    	<td class='text-center'>
				<!-- <button class="btn btn-info" data-toggle="modal" data-target="#myModal<?php echo $row['cid'] ?>"><i class="fa fa-search"></i></button> -->
					<a href="./detailCase.php?cid=<?=$cid?>" class="btn btn-info btn-sm" role="button"><i class="fa fa-search"></i></a> 

			</td>
    	</tr>

    	<?php  $i++;	
		}  
	}	?>

    </tbody>
</table>
<?php
page_navi($total,(isset($_GET['page']))?$_GET['page']:1,$e_page,$_GET);
?>
</div>
 
<br>
 
<br>
</div>
 
<script src="https://unpkg.com/jquery@3.3.1/dist/jquery.min.js"></script>
<script src="https://unpkg.com/bootstrap@4.1.0/dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(function(){
     
});
</script>
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************            Content body end        ***********************************-->
        <!--**********************************           Footer start        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <!-- <p>Copyright &copy; Designed & Developed by <a href="https://themeforest.net/user/quixlab">Quixlab</a> 2018</p> -->
            </div>
        </div>
        <!--**********************************          Footer end       ***********************************-->
    </div>
	<!--**********************************        Main wrapper end    ***********************************-->
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
	<!-- <script  src="./script.js"></script> -->

</body>

</html>
