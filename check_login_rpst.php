<?php
error_reporting( error_reporting() & ~E_NOTICE );
session_start();
require_once("LoginLib.php");
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
define('LINE_LOGIN_CALLBACK_URL', 'https://.moph.go.th/r8nds/login_callback.php'); //ใส่ url ของ web server

$LineLogin = new LineLoginLib(
    LINE_LOGIN_CHANNEL_ID, LINE_LOGIN_CHANNEL_SECRET, LINE_LOGIN_CALLBACK_URL);

if (!isset($_SESSION['ses_login_accToken_val'])) {
    $LineLogin->authorize();
    exit;
}

$accToken = $_SESSION['ses_login_accToken_val'];
// Status Token Check
if ($LineLogin->verifyToken($accToken)) {
}

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

    // include('server.php');
    $errors = array();
    if (count($errors) == 0) {
        
        $query = "SELECT * FROM member WHERE id_line = '$lineid'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {

            $row = mysqli_fetch_array($result);
            $lineid = $row['id_line'];
            $level = $row['level'];
            $statusUser = $row['statusUser'];
            $provinces = $row['provinces'];
            
            switch($level) {
                 case "pcu1":
                    $_SESSION['level_pcu1'] = $level;
                    $_SESSION['levelx'] = $level;
                    $_SESSION['level'] = $row['pcu1'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['id_line'] = $row['id_line'];
                    $_SESSION['provinces']=$row['provinces'];
                    header("Location: alert_edit.php");
                    break;
                case "pcu2":
                    $_SESSION['level_pcu2'] = $level;
                    $_SESSION['levelx'] = $level;
                    $_SESSION['level'] = $row['pcu2'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['id_line'] = $row['id_line'];
                    $_SESSION['provinces']=$row['provinces'];
                    header("Location: alert_edit.php");
                    break;
                case "etc":
                    $_SESSION['level_etc'] = $level;
                    $_SESSION['levelx'] = $level;
                    $_SESSION['level'] = $row['etc'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['id_line'] = $row['id_line'];
                    $_SESSION['provinces']=$row['provinces'];
                    header("Location: accept.php");
                    break;
                case "obj":
                    $_SESSION['level_obj'] = $level;
                    $_SESSION['levelx'] = $level;
                    $_SESSION['level'] = $row['obj'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['id_line'] = $row['id_line'];
                    $_SESSION['provinces']=$row['provinces'];
                    header("Location: alert_edit.php");
                    break;
                default:
                    echo "<script>alert('สถานะของคุณไม่ถูกต้อง');</script>";
//                     header ("Location: page-login.php");
                    break;
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
            array_push($errors, "ยังไม่ได้ลงทะเบียน");
            $_SESSION['error'] = "ยังไม่ได้ลงทะเบียน";
            header("location: alert_not_register.php"); //ไปหน้าแจ้งเตือนไม่ได้ลงทะเบียน กรุณากลับไปหน้าลงทะเบียน
        }
    }
}
?>
