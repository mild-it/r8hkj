<?php 
session_start();
    include('connectDB.php');
    include('server.php');
    
    $errors = array();

    if (isset($_POST['reguser'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
        $cid = mysqli_real_escape_string($conn, $_POST['cid']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
        $level = mysqli_real_escape_string($conn, $_POST['level']);
        $hospcode = $_POST['hospcode'];
        $opt = $_POST['opt'];
        

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
        if (empty($password_1)) {
            array_push($errors, "กรุณาใส่ Password");
            $_SESSION['error'] = "กรุณาใส่ Password";
        }
        if (empty($level)) {
            array_push($errors, "เลือกสิทธิ์เข้าใช้งาน");
            $_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบ";
        }

        $user_check_query = "SELECT * FROM member WHERE  email = '$email' ";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        if ($result) { // if user exists
           
            if ($result['email'] == $email) {
                array_push($errors, "email นี้ถูกลงทะเบียนแล้ว");
                $_SESSION['error'] = "email นี้ถูกลงทะเบียนแล้ว";
            }
            // echo json_encode("Success");
        }

        if (count($errors) == 0) {
            $password = md5($password_1);

            $sql = "INSERT INTO member (username, lastname, cid, email,  password,level,hospcode,opt,date) VALUES ('$username','$lastname','$cid', '$email','$password','$level','$hospcode','$opt',NOW())";
            $query1=mysqli_query($conn, $sql);
            
            echo "<center><h3>ลงทะเบียนเรียบร้อยแล้ว</h3>";
            $_SESSION['status'] = "ลงทะเบียนเรียบร้อยแล้ว";
            $_SESSION['status_code'] = "Success";
            header('location: page-login.php');
        }else {
            $_SESSION['status'] = "ลงทะเบียนไม่สำเร็จ";
            $_SESSION['status_code'] = "Error";
            header("location: page-register.php");
        }
    }

?>
