<?php
session_start();
require_once('LineLogin.php');
include "connectDB.php";
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
$line = new LineLogin();
$get = $_GET;

$code = $get['code'];
$state = $get['state'];
$token = $line->token($code, $state);

if (property_exists($token, 'error'))
    header('location: index.php');

if ($token->id_token) {
    $profile = $line->profileFormIdToken($token);
    $_SESSION['profile'] = $profile;
    $result_profile_line = $line->profile($profile->access_token);
    $email = $profile->email;
    $line_id = $result_profile_line->userId;
    // ค้นหาว่าลงทะเบียนหรือยัง
    $sql = "select * from member where email='$email' or id_line='$line_id'";
    $result = $mysqli->query($sql);
    $row = mysqli_fetch_array($result);
    if ($row['email']) {
        if ($row['statusUser'] == "a") {
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
        } else {
            echo '<script>
                setTimeout(function() {
                    swal({
                        title: "Warning!",
                        text: "ท่านเคยลงทะเบียนผ่านไลน์นี้แล้ว <br>อยู่ระหว่างรอผู้ดูแลระบบตรวจสอบข้อมูล",
                        type: "warning",
                        confirmButtonColor: "#d33",
                        confirmButtonText:"<span onclick=my2()>OK</span>"
                    });
                }, 0001);
            </script>';
        }
    } else {
        header('location: register_with_line.php');
    }
}
## get profile by token
// $profile = $line->profile($token->access_token);
// print_r($profile);
?>
<script>
    function my2() {
        window.location.href = "page-login.php";   
    } 
</script>