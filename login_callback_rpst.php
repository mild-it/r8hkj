<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<link rel="stylesheet" href="assets/sweetalert/sweetalert2.min.css">
<script src="assets/sweetalert/sweetalert2.min.js"></script>
<script src="assets/sweetalert/sweetalert.script.min.js"></script>
<style>
    *:focus {
        outline: none;
    }
</style>
<?php
require_once("LoginLib_new.php");
$line = new LineLogin();
$get = $_GET;

$code = $get['code'];
$state = $get['state'];
$token = $line->token($code, $state);

if (property_exists($token, 'error')) {
    header('location: index.php');
}

if ($token->id_token) {
    $profile = $line->profileFormIdToken($token);
    $_SESSION['profile'] = $profile;
    $result_profile_line = $line->profile($profile->access_token);
    $email = $profile->email;
    $line_id = $result_profile_line->userId;
    include "connectDB.php";
    $sql = "select * from member where email='$email' or id_line='$line_id'";
    $result = $mysqli->query($sql);
    $row = mysqli_fetch_array($result);
    if ($row['email'] != "") {
        $level = $row['level'];
        switch($level) {
            case "pcu":
                $_SESSION['level_pcu'] = $level;
                $_SESSION['pcu'] = $row['hospcode'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['id_line'] = $row['id_line'];
                $_SESSION['statusUser'] = $statusUser=="a";
                $_SESSION['levelx'] = $level;
                $_SESSION['pcu'] = $row['hospcode'];
                header("Location: alert.php");
                break;
            case "pmj":
                $_SESSION['level_pmj'] = $level;
                $_SESSION['levelx'] = $level;
                $_SESSION['statusUser'] = $statusUser=="a";
                $_SESSION['email'] = $row['email'];
                $_SESSION['id_line'] = $row['id_line'];
                Header("Location: alert.php");
                break;
            case "opt":
                $_SESSION['level_opt'] = $level;
                $_SESSION['levelx'] = $level;
                $_SESSION['level'] = $row['opt'];
                $_SESSION['statusUser'] = $statusUser=="a";
                $_SESSION['email'] = $row['email'];
                $_SESSION['id_line'] = $row['id_line'];
                Header("Location: alert.php");
                break;
            case "etc":
                $_SESSION['level_etc'] = $level;
                $_SESSION['levelx'] = $level;
                $_SESSION['level'] = $row['etc'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['id_line'] = $row['id_line'];
                $_SESSION['provinces']=$row['provinces'];
                Header("Location: alert.php");
                break;
            // default:
            //     echo "<script>alert('สถานะของคุณไม่ถูกต้อง');</script>";
            //     Header ("Location: page-login.php");
            //     break;
        }
        echo '<script>
            setTimeout(function() {
                swal({
                    title: "User ID ของท่านได้ลงทะเบียนแล้ว",
                    text: "",
                    type: "success"
                }, function() {
                    window.close();
                });
            }, 1000);
        </script>';
    } else {
        header('location: register_rpst_form.php');
    }
}
?>