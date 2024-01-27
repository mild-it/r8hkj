<?php
session_start();
?>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php 
    include('server.php');

    $errors = array();

    if (isset($_POST['login_user'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        if (empty($email)) {
            array_push($errors, "Username is required");
        }

        if (empty($password)) {
            array_push($errors, "Password is required");
        }

        if (count($errors) == 0) {
            $password = md5($password);
            $query = "SELECT * FROM member WHERE email = '$email' AND password = '$password' ";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 1) {

                $row = mysqli_fetch_array($result);

                $email = $row['email'];
                $level = $row['level'];
                $statusUser = $row['statusUser'];
                $id_line = $row['id_line'];
                $_SESSION['id_line'] = $id_line;
                // $province = $row['provinces'];
                // $_SESSION['province'] = $province;
                $idMeet = $row['idMeet'];
                $_SESSION['idMeet'] = $idMeet;

                switch($level){
                    case "pcu":
                        $_SESSION['level_pcu'] = $level;
                        $_SESSION['levelx'] = $level;
                        $_SESSION['email'] = $email;
                        $_SESSION['pcu'] = $row['hospcode'];
                        $_SESSION['province'] = $row['provinces'];
                        $_SESSION['statusUser'] = $statusUser=="a";
                        Header("Location: page1.php");
                        break;
                    case "pmj":
                        $_SESSION['level_pmj'] = $level;
			            $_SESSION['levelx'] = $level;
                        $_SESSION['email'] = $email;
                        $_SESSION['province_pmj'] = $row['provinces_pmj'];
                        $_SESSION['province'] = $row['provinces_pmj'];
                        $_SESSION['statusUser'] = $statusUser=="a";
                        Header("Location: page2.php");
                        break;
                    case "opt":
                        $_SESSION['level_opt'] = $level;
                        $_SESSION['levelx'] = $level;
                        $_SESSION['email'] = $email;
                        $_SESSION['level'] = $row['opt'];
                        $_SESSION['province_opt'] = $row['provinces_opt'];
                        $_SESSION['province'] = $row['provinces_opt'];
                        $_SESSION['statusUser'] = $statusUser=="a";
                        Header("Location: page3.php");
                        break;
                    case "admin":
                        $_SESSION['level_admin'] = $level;
                        $_SESSION['levelx'] = $level;
                        $_SESSION['email'] = $email;
                        $_SESSION['level'] = $row['admin'];
                        $_SESSION['provinces'] = $row['provinces'];
                        $_SESSION['statusUser'] = $statusUser=="a";
                        Header("Location: edituser/user.php");
                        break;
                    default:
                        echo "<script>alert('สถานะของคุณไม่ถูกต้อง');</script>";
                        Header ("Location: index.php");
                        break;
                }

                if($_SESSION["statusUser"]==""){
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
            array_push($errors, "กรุณากรอกอีเมล์และรหัสผ่าน");
            $_SESSION['error'] = "กรุณากรอกอีเมล์และรหัสผ่าน";
            header("location: page-login.php");
        }
    }

?>
