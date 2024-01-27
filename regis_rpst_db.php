<?php
session_start();
?>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
    include('connectDB.php');
    include('server.php');
    
    $errors = array();

    if (isset($_SESSION,$_POST['reg_rpst'])) {
        $lineid = mysqli_real_escape_string($conn, $_POST['lineid']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
        $cid = mysqli_real_escape_string($conn, $_POST['cid']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        // $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
        $level = mysqli_real_escape_string($conn, $_POST['level']);
        $province_etc = $_POST['province_etc'];
        $province_pcu1 = $_POST['province_pcu1'];
        $province_pcu2 = $_POST['province_pcu2'];
        $province_obj = $_POST['province_obj'];
        $pcu1 = $_POST['pcu1'];
        $pcu2 = $_POST['pcu2'];
        
        if (empty($username)) {
            array_push($errors, "กรุณาใส่ชื่อ");
            $_SESSION['error'] = "กรุณาใส่ชื่อ";
        }
        if (empty($lastname)) {
            array_push($errors, "กรุณาใส่สกุล");
            $_SESSION['error'] = "กรุณาใส่สกุล";
        }
        if (empty($cid)) {
            array_push($errors, "กรุณาใส่เลขบัตรประชาชน");
            $_SESSION['error'] = "กรุณาใส่เลขบัตรประชาชน";
        }
        if (empty($email)) {
            array_push($errors, "กรุณาใส่ email");
            $_SESSION['error'] = "กรุณาใส่ email";
        }
        // if (empty($password_1)) {
        //     array_push($errors, "กรุณาใส่ Password");
        //     $_SESSION['error'] = "กรุณาใส่ Password";
        // }
        if (empty($level)) {
            array_push($errors, "เลือกสิทธิ์เข้าใช้งาน");
            $_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบ";
        }

        $user_check_query = "SELECT * FROM member WHERE email = '$email' OR id_line = '$lineid' ";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        if ($result) { // if user exists
            if ($result['email'] === $email) {
                array_push($errors, "email นี้ถูกลงทะเบียนแล้ว");
                $_SESSION['error'] = "email นี้ถูกลงทะเบียนแล้ว";
            }
            if ($result['id_line'] === $lineid) {
                array_push($errors, "User ID นี้ถูกลงทะเบียนแล้ว");
                $_SESSION['error'] = "User ID นี้ถูกลงทะเบียนแล้ว";
            }
            // echo json_encode("Success");
        }

        if (count($errors) == 0) {
            $password_1 = md5($password_1);
            $sql = "INSERT INTO member (username, lastname, cid, email,level,id_line,provinces,provinces_pcu1,provinces_pcu2,provinces_obj,pcu1,pcu2,date) VALUES ('$username','$lastname','$cid', '$email','$level','$lineid','$provinces_etc','$province_pcu1','$province_pcu2','$province_obj','$pcu1','$pcu2',NOW())";
            $query1 = mysqli_query($conn, $sql);

            // echo "<center><h3>ลงทะเบียนเรียบร้อยแล้ว</h3>";
            // $_SESSION['status'] = "ลงทะเบียนเรียบร้อยแล้ว";
            // $_SESSION['status_code'] = "Success";
            // header('location: register_rpst.php');
            echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "ลงทะเบียนสำเร็จ",
                            text: "",
                            type: "success"
                        }, function() {
                            window.close();
                        });
                      }, 1000);
                  </script>';
        } else {
            // $_SESSION['status'] = "ลงทะเบียนไม่สำเร็จ";
            // $_SESSION['status_code'] = "Error";
            // header("location: register_rpst.php");
            echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "ลงทะเบียนไม่สำเร็จ",
                            text: "กรุณาลงทะเบียนใหม่",
                            type: "error"
                        }, function() {
                            window.location = "register_rpst.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                      }, 1000);
                  </script>';
        }
    }
?>
