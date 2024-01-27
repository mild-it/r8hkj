<?php 
    session_start();
    include('server.php'); 
    include('connectDB.php'); 
?>

<?php
session_start();
require_once("LineLoginLib.php");
// กรณีต้องการตรวจสอบการแจ้ง error ให้เปิด 3 บรรทัดล่างนี้ให้ทำงาน กรณีไม่ ให้ comment ปิดไป
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
// กรณีมีการเชื่อมต่อกับฐานข้อมูล
//require_once("dbconnect.php");
 

define('LINE_LOGIN_CHANNEL_ID','');
define('LINE_LOGIN_CHANNEL_SECRET','');
define('LINE_LOGIN_CALLBACK_URL','https://.moph.go.th/r8nds/login_uselib_callback.php'); //ใส่ url ของ web server
 
$LineLogin = new LineLoginLib(
    LINE_LOGIN_CHANNEL_ID, LINE_LOGIN_CHANNEL_SECRET, LINE_LOGIN_CALLBACK_URL);
     
if(!isset($_SESSION['ses_login_accToken_val'])){    
    $LineLogin->authorize(); 
    exit;
}
 
$accToken = $_SESSION['ses_login_accToken_val'];
// Status Token Check
if($LineLogin->verifyToken($accToken)){
    $accToken."<br><hr>";
    "Token Status OK <br>";  
}

//exit;
// echo "<hr>";
 
if(isset($_SESSION['ses_login_userData_val']) && $_SESSION['ses_login_userData_val']!=""){
    // GET USER DATA FROM ID TOKEN
    $lineUserData = json_decode($_SESSION['ses_login_userData_val'],true);
    ($lineUserData); 
    "<hr>";
    "Line UserID: ".$lineUserData['sub']."<br>";
    "Line Display Name: ".$lineUserData['name']."<br>";
    '<img style="width:100px;" src="'.$lineUserData['picture'].'" /><br>';
}
 
 
// echo "<hr>";
if(isset($_SESSION['ses_login_refreshToken_val']) && $_SESSION['ses_login_refreshToken_val']!=""){
    '
    <form method="post">
    <button type="submit" name="refreshToken">Refresh Access Token</button>
    </form>   
    ';  
}
if(isset($_SESSION['ses_login_refreshToken_val']) && $_SESSION['ses_login_refreshToken_val']!=""){
    if(isset($_POST['refreshToken'])){
        $refreshToken = $_SESSION['ses_login_refreshToken_val'];
        $new_accToken = $LineLogin->refreshToken($refreshToken); 
        if(isset($new_accToken) && is_string($new_accToken)){
            $_SESSION['ses_login_accToken_val'] = $new_accToken;
        }       
        $LineLogin->redirect("line_register.php");
    }
}
// Revoke Token
//if($LineLogin->revokeToken($accToken)){
//  echo "Logout Line Success<br>";   
//}
//
// Revoke Token with Result
//$statusRevoke = $LineLogin->revokeToken($accToken, true);
//print_r($statusRevoke);
?>
<!-- <?php
"<hr>";
if($LineLogin->verifyToken($accToken)){
?>
<form method="post">
<button type="submit" name="lineLogout">LINE Logout</button>
</form>
<?php }else{ ?>
<form method="post">
<button type="submit" name="lineLogin">LINE Login</button>
</form>   
<?php } ?> -->
<?php
if(isset($_POST['lineLogin'])){
    $LineLogin->authorize(); 
    exit;   
}
if(isset($_POST['lineLogout'])){
    unset(
        $_SESSION['ses_login_accToken_val'],
        $_SESSION['ses_login_refreshToken_val'],
        $_SESSION['ses_login_userData_val']
    );  
    "<hr>";
    if($LineLogin->revokeToken($accToken)){
        "Logout Line Success<br>";   
    }
    '
    <form method="post">
    <button type="submit" name="lineLogin">LINE Login</button>
    </form>   
    ';
    $LineLogin->redirect("line_register.php");
}

?>
<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">

    <script type="text/javascript">
    function ShowHideDiv() {
        var level = document.getElementById("level");
        var hospcode = document.getElementById("hospcode");
        hospcode.style.display = level.value == "pcu" ? "block" : "none";

        var opt = document.getElementById("opt");
        opt.style.display = level.value == "opt" ? "block" : "none";
    }
    </script>
    
</head>

<body class="h-100">
    
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
    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                    <a class="text-center " > <h2 class="card login-form mb-4">ลงทะเบียน</h2></a>
                                    <div class="form-validation">
                                    <form class="form-valide" action="line_register_db.php" method="post">

                                    <?php if (isset($_SESSION['error'])) : ?>
                                        <div class="error">
                                            <h4>
                                                <?php 
                                                    echo $_SESSION['error'];
                                                    unset($_SESSION['error']);
                                                ?>
                                            </h4>
                                        </div>
                                    <?php endif ?>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="username">ID Line 
                                            </label>
                                            <div class="col-lg-6">
                                                    <label class=" col-form-label" for="username" id="id_line">
                                                    <?php
                                                        echo "".$lineUserData['sub']."<br>";  
                                                    ?>
                                                    </label>
                                                <!-- <input type="text" class="form-control" id="username1" name="name" placeholder="" disabled> -->
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="username">Display  Name 
                                            </label>
                                            <div class="col-lg-6">
                                                <label class=" col-form-label" for="username" id="display_name">
                                                    <?php
                                                    
                                                        echo "".$lineUserData['name']."<br>";
                                                   
                                                    ?>
                                                </label>
                                                <!-- <input type="text" class="form-control" id="username1" name="username" placeholder="name"> -->
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="username">ชื่อ</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="username1" name="username" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="lastname">สกุล</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="lastname1" name="lastname" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="cid">เลขบัตรประชาชน</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="cid" name="cid" placeholder="" onfocusout="checkForm()">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="email">อีเมล์ </label>
                                            <div class="col-lg-6">
                                                <input type="email" class="form-control" id="email1" name="email" placeholder="">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="password_1">Password</label>
                                            <div class="col-lg-6">
                                                <input type="password" class="form-control" id="password1" name="password_1" placeholder="">
                                            </div>
                                        </div>

                                        <div class="form-group row">
		                                    <label class="col-lg-4 col-form-label" for="level" class="col-md-4 control-label">ระดับผู้ใช้งาน</label>
		                                    <div class="col-md-6">
			                                    <select class="form-control" name="level" id="level"   onchange = "ShowHideDiv()" >
				                                    <option disabled selected required>-เลือกหน่วยงาน-</option>
				                                    <option value="pcu">รพ.</option>
				                                    <option value="pmj">พมจ.</option>
				                                    <option value="opt">อบต./เทศบาล</option>
			                                    </select>
		                                    </div>
	                                    </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="hospcode">หน่วยงานสาธาณสุข</label>
                                            <div class="col-lg-6">
                                                <select class="custom-select" id="hospcode" name="hospcode"  style="display: none" >
                                                    <option value="">-เลือกหน่วยงาน-</option>
			                                            <?php
                                                            $i=1;
                                                            $q="SELECT * FROM office where off_id_new IN ('10991','10704','10992','10993','10994','23367') ORDER BY distid,Off_type";
                                                            $result = $mysqli->query($q); // ทำการ query คำสั่ง sql 
                                                            while($rs=$result->fetch_object()){ // วนลูปแสดงข้อมูล
                                                            $off_name=$rs->off_name;
                                                            $off_id_new=$rs->off_id_new;
                                                        ?>
                                                        <option value="<?=$off_id_new?>"><?=$off_name?></option>
                                                    <?php }?>
		                                        </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="opt">หน่วยงานเทศบาล/อบต.
                                            </label>
                                            <div class="col-lg-6">
                                                <select class="custom-select" id="opt" name="opt" style="display: none" >
                                                    <option value="">-เลือกหน่วยงาน-</option>
                                                    <?php
                                                        include('connect.php');
                                                        $sql0 = "SELECT * FROM tesaban group by tcode";
                                                        $query0 = mysqli_query($conn, $sql0);
                                                        while($result0 = mysqli_fetch_assoc($query0)): ?>
                                                            <option value="<?=$result0['tcode']?>"><?=$result0['hospname']?></option>
                                                        <?php endwhile; ?>
		                                        </select>
                                            </div>
                                        </div>
                                        
                                        <!-- <div class="form-group row">
                                            <label class="col-lg-4 col-form-label"><a href="#">Terms &amp; Conditions</a>  <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-8">
                                                <label class="css-control css-control-primary css-checkbox" for="val-terms">
                                                    <input type="checkbox" class="css-control-input" id="val-terms" name="val-terms" value="1"> <span class="css-control-indicator"></span> I agree to the terms</label>
                                            </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary" name="reg_user">ลงทะเบียน</button>
                                                <!-- <button type="submit" class="btn btn-primary">ยกเลิก</button> -->
                                            </div>
                                        </div>
                                    </form>
                                    
                                    
                                    <?php
                                        if($LineLogin->verifyToken($accToken)){
                                        ?>
                                        <form method="post">
                                        <div class="form-group row" >
                                            <div class="col-lg-8 ml-auto" >
                                                <button type="submit" class="btn btn-primary" name="lineLogout">ยกเลิก</button>
                                            </div>
                                        </div>
                                        </form>
                                        <!-- <form method="post">
                                        <button type="submit" name="lineLogout">LINE Logout</button>
                                        </form> -->
                                        <?php }else{ ?>
                                        <!-- <form method="post">
                                        <button type="submit" name="lineLogin">LINE Login</button>
                                        </form>    -->
                                        <?php } ?>
                                        <?php
                                        
                                        if(isset($_POST['lineLogout'])){
                                            unset(
                                                $_SESSION['ses_login_accToken_val'],
                                                $_SESSION['ses_login_refreshToken_val'],
                                                $_SESSION['ses_login_userData_val']
                                            );  
                                            
                                            if($LineLogin->revokeToken($accToken)){
                                                echo "Logout Line Success<br>";   
                                            }
                                            
                                            $LineLogin->redirect("line_register.php");
                                        }
                                    ?>
                                    
                                    <!-- <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                            <p>เป็นสมาชิกอยู่แล้ว <a href="page-login.php">Click ที่นี่</a></p>
                                            </div>
                                            
                                    </div>   -->
                                </div>
                                    <!-- <p class="mt-5 login-form__footer">เป็นสมาชิกอยู่แล้ว <a href="page-login.php" class="text-primary">Click ที่นี้</a></p> -->
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
if(isset($_POST['lineLogin'])){
    $LineLogin->authorize(); 
    exit;   
}
if(isset($_POST['lineLogout'])){
    unset(
        $_SESSION['ses_login_accToken_val'],
        $_SESSION['ses_login_refreshToken_val'],
        $_SESSION['ses_login_userData_val']
    );  
    echo "<hr>";
    if($LineLogin->revokeToken($accToken)){
        echo "Logout Line Success<br>";   
    }
    echo '
    <form method="post">
    <button type="submit" name="lineLogin">LINE Login</button>
    </form>   
    ';
    $LineLogin->redirect("line_register.php");
}
?>
    

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>
</html>





