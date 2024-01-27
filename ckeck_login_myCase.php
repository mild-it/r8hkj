<?php
error_reporting( error_reporting() & ~E_NOTICE );
session_start();
require_once("LibmyCase.php");
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
define('LINE_LOGIN_CALLBACK_URL', 'https://.moph.go.th/r8nds/login_callback_myCase.php'); //ใส่ url ของ web server

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
$userInfo = $LineLogin->userProfile($accToken,true);
if (!is_null($userInfo) && is_array($userInfo) && array_key_exists('userId',$userInfo)) {
    //print_r($userInfo);
}
//exit;

if (isset($_SESSION['ses_login_userData_val']) && $_SESSION['ses_login_userData_val']!=""){
    // GET USER DATA FROM ID TOKEN
    $lineUserData = json_decode($_SESSION['ses_login_userData_val'],true);
    "Line UserID: ".$lineUserData['sub']."<br>";
    "Line Display Name: ".$lineUserData['name']."<br>";
    '<img style="width:100px;" src="'.$lineUserData['picture'].'" /><br>';
    $lineid = $lineUserData['sub'];
    $displayname = $lineUserData['name'];

    include('server.php');
    $errors = array();
        if (count($errors) == 0) {
            
            $query = "SELECT * FROM member WHERE id_line = '$lineid'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 1) {

                $row = mysqli_fetch_array($result);
                $lineid = $row['id_line'];
                $level = $row['level'];
                $statusUser = $row['statusUser'];
                $provinces = $row['provinces_pcu2'];
                // echo $level;
                switch($level) {
                    case "pcu1":
                        $_SESSION['level_pcu1'] = $level;
//                      $_SESSION['pcu'] = $row['hospcode'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['id_line'] = $row['id_line'];
                        $_SESSION['statusUser'] = $statusUser == "a";
                        $_SESSION['levelx'] = $level;
//                      $_SESSION['pcu'] = $row['hospcode'];
                        $_SESSION['level'] = $row['pcu1'];
                        header("Location: pcu1.php");
                        break;
                    case "pcu2":
                        $_SESSION['level_pcu2'] = $level;
                        $_SESSION['pcu'] = $row['hospcode'];
                        // $_SESSION['email'] = $row['email'];
                        $_SESSION['id_line'] = $row['id_line'];
                        $_SESSION['statusUser'] = $statusUser == "a";
                        $_SESSION['levelx'] = $level;
                        $_SESSION['level'] = $row['pcu2'];
                        $_SESSION['provinces'] = $row['provinces_pcu2'];
                        header("Location: pcu2.php");
                        break;
                    case "obj":
                        $_SESSION['level_obj'] = $level;
                        $_SESSION['pcu'] = $row['hospcode'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['id_line'] = $row['id_line'];
                        $_SESSION['statusUser'] = $statusUser == "a";
                        $_SESSION['levelx'] = $level;
                        $_SESSION['pcu'] = $row['hospcode'];
                        $_SESSION['level'] = $row['obj'];
                        header("Location: obj.php");
                        break;
                    // case "pmj";
                    //     $_SESSION['level_pmj'] = $level;
                    //     $_SESSION['levelx'] = $level;
                    //     $_SESSION['statusUser'] = $statusUser == "a";
                    //     $_SESSION['email'] = $row['email'];
                    //     $_SESSION['id_line'] = $row['id_line'];
                    //     Header("Location: page2.php");
                    //     break;
                    // case "opt";
                    //     $_SESSION['level_opt'] = $level;
                    //     $_SESSION['levelx'] = $level;
                    //     $_SESSION['level'] = $row['opt'];
                    //     $_SESSION['statusUser'] = $statusUser == "a";
                    //     $_SESSION['email'] = $row['email'];
                    //     $_SESSION['id_line'] = $row['id_line'];
                    //     Header("Location: page3.php");
                    //     break;
                    case "etc":
                        $_SESSION['level_etc'] = $level;
                        $_SESSION['levelx'] = $level;
                        $_SESSION['level'] = $row['etc'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['id_line'] = $row['id_line'];
                        $_SESSION['provinces']=$row['provinces'];
                        header("Location: myCase.php");
                        break;
                    default:
                        echo "<script>alert('สถานะของคุณไม่ถูกต้อง');</script>";
                    //  header ("Location: page-login.php");
                        break;
                }

                // if($_SESSION["statusUser"]==""){
                //     array_push($errors, "ยังไม่ได้รับอนุมัติเข้าใช้งาน");
                //     $_SESSION['error'] = "ยังไม่ได้รับอนุมัติเข้าใช้งาน";
                //     header("location: page-login.php");
                // }

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
