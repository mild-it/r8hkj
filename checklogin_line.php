<?php
session_start();
?>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
require_once("LineLoginLib.php");
include('server.php'); 
include('connectDB.php');
 
// กรณีต้องการตรวจสอบการแจ้ง error ให้เปิด 3 บรรทัดล่างนี้ให้ทำงาน กรณีไม่ ให้ comment ปิดไป
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// กรณีมีการเชื่อมต่อกับฐานข้อมูล
//require_once("dbconnect.php");

define('LINE_LOGIN_CHANNEL_ID', '');
define('LINE_LOGIN_CHANNEL_SECRET', '');
define('LINE_LOGIN_CALLBACK_URL', 'https://.moph.go.th/r8nds/login_callback_line.php'); //ใส่ url ของ web server
 
$LineLogin = new LineLoginLib(LINE_LOGIN_CHANNEL_ID, LINE_LOGIN_CHANNEL_SECRET, LINE_LOGIN_CALLBACK_URL);
     
if(!isset($_SESSION['ses_login_accToken_val'])) {
    $LineLogin->authorize();
    exit;
}
 
$accToken = $_SESSION['ses_login_accToken_val'];
// Status Token Check
if($LineLogin->verifyToken($accToken)) {
     
}
 

// echo "<pre>";
// Status Token Check with Result 
//$statusToken = $LineLogin->verifyToken($accToken, true);
//print_r($statusToken);
 
 
//////////////////////////
// echo "<hr>";
// GET LINE USERID FROM USER PROFILE
//$userID = $LineLogin->userProfile($accToken);
//echo $userID;
 
//////////////////////////
// echo "<hr>";
// GET LINE USER PROFILE 
$userInfo = $LineLogin->userProfile($accToken, true);
if (!is_null($userInfo) && is_array($userInfo) && array_key_exists('userId', $userInfo)) {
    //print_r($userInfo);
}
//exit;

if (isset($_SESSION['ses_login_userData_val']) && $_SESSION['ses_login_userData_val'] != "") {
    // GET USER DATA FROM ID TOKEN
    $lineUserData = json_decode($_SESSION['ses_login_userData_val'], true);
    "Line UserID: ".$lineUserData['sub']."<br>";
    "Line Display Name: ".$lineUserData['name']."<br>";
    '<img style="width:100px;" src="'.$lineUserData['picture'].'" /><br>';
    $lineid = $lineUserData['sub'];
    $displayname = $lineUserData['name'];

    // session_start();
    // include('server.php');
    $errors = array();
    if (count($errors) == 0) {

        $query = "SELECT * FROM member WHERE id_line = '$lineid' OR email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            $lineid = $row['id_line'];
            $level = $row['level'];
            $statusUser = $row['statusUser'];
            
            switch($level) {
                case "pcu":
                    $_SESSION['level_pcu'] = $level;
                    $_SESSION['pcu'] = $row['hospcode'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['id_line'] = $row['id_line'];
                    $_SESSION['statusUser'] = $statusUser == "a";
                    $_SESSION['levelx'] = $level;
                    $_SESSION['pcu'] = $row['hospcode'];
                    $_SESSION['province'] = $row['provinces'];
                    header("location: page1.php");
                    break;
                case "pmj":
                    $_SESSION['level_pmj'] = $level;
                    $_SESSION['levelx'] = $level;
                    $_SESSION['statusUser'] = $statusUser == "a";
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['province_pmj'] = $row['provinces_pmj'];
                    $_SESSION['province'] = $row['provinces_pmj'];
                    $_SESSION['id_line'] = $row['id_line'];
                    header("location: page2.php");
                    break;
                case "opt":
                    $_SESSION['level_opt'] = $level;
                    $_SESSION['levelx'] = $level;
                    $_SESSION['level'] = $row['opt'];
                    $_SESSION['statusUser'] = $statusUser == "a";
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['province_opt'] = $row['provinces_opt'];
                    $_SESSION['province'] = $row['provinces_opt'];
                    $_SESSION['id_line'] = $row['id_line'];
                    header("location: page3.php");
                    break;
                case "admin":
                    $_SESSION['level_admin'] = $level;
                    $_SESSION['levelx'] = $level;
                    $_SESSION['email'] = $email;
                    $_SESSION['level'] = $row['admin'];
                    $_SESSION['provinces'] = $row['provinces'];
                    $_SESSION['statusUser'] = $statusUser == "a";
                    $_SESSION['id_line'] = $row['id_line'];
                    header("location: edituser/user.php");
                    break;
                default:
                    echo "<script>alert('สถานะของคุณไม่ถูกต้อง');</script>";
                    header("location: page-login.php");
                    break;
            }

            if ($_SESSION["statusUser"] == "") {
                array_push($errors, "ยังไม่ได้รับอนุมัติเข้าใช้งาน");
                $_SESSION['error'] = "ยังไม่ได้รับอนุมัติเข้าใช้งาน";
                header("location: page-login.php");

            //     echo '<script>
            //        setTimeout(function() {
            //         swal({
            //             title: "ยังไม่ได้รับอนุมัติเข้าใช้งาน",
            //             text: "",
            //             type: "error"
            //         }, function() {
            //             window.location = "page-login.php"; //หน้าที่ต้องการให้กระโดดไป
            //         });
            //       }, 1000);
            //   </script>';
            }

            // $_SESSION['email'] = $email;
            // $_SESSION['level'] = $
            // $_SESSION['success'] = "Your are now logged in";
            // header("location: page1.php");
        }
        // if (mysqli_num_rows($result) == 2){
        //     $_SESSION['level'] = 'pcu';
        //     header("location: page1.php");
        // }
        else {
            array_push($errors, "ชื่อผู้ใช้หรือรหัสผ่านผิด!");
            $_SESSION['error'] = "ชื่อผู้ใช้หรือรหัสผ่านผิด!";
            header("location: page-login.php");
        }
    } else {
        array_push($errors, "กรุณากรอกชื่อผู้ใช้และรหัสผ่าน");
        $_SESSION['error'] = "กรุณากรอกชื่อผู้ใช้และรหัสผ่าน";
        header("location: page-login.php");
    }
}
?>

