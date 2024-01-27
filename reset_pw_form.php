<?php
$st = $_POST["st"];
include "connectDB.php";
$email_encode = $mysqli->real_escape_string($_REQUEST["id"]);
$sql = "select username, lastname, email from member where md5(email) = '$email_encode' limit 1";
$result = $mysqli->query($sql);
$r = mysqli_fetch_array($result);
$st_reset = "0";
if ($st != "") {
    $st_pw = "0";
    $st_pw_cf = "0";
    $st_code_otp = "0";
    $new_pw = $mysqli->real_escape_string($_POST["new_pw"]);
    $new_pw_cf = $mysqli->real_escape_string($_POST["new_pw_cf"]);
    if (strlen($new_pw) >= 6) {
        $st_pw = "1";
    }
    if ($new_pw == $new_pw_cf) {
        $st_pw_cf = "1";
    }
    $code_otp = $mysqli->real_escape_string($_POST["code_otp"]);

    if ($st_pw == "1" && $st_pw_cf == "1") {
        $sql_code_otp = "select code_otp from reset_pw where md5(email) = '$email_encode'";
        $result_code_otp = $mysqli->query($sql_code_otp);
        $r_code_otp = mysqli_fetch_array($result_code_otp);
        if ($code_otp == $r_code_otp["code_otp"]) {
            $st_code_otp = "1";
        }
    }

    // บันทึกรหัสผ่านใหม่
    if ($st_code_otp == "1") {
        $pw_encode = md5($new_pw);
        $sql_update = "update member set password = '$pw_encode' where md5(email) = '$email_encode'";
        $result_update = $mysqli->query($sql_update);
        if ($result_update) {
            $st_reset = "1";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R8NDS Report R8way</title>
    <link rel="icon" type="image/png" sizes="16x16" href="images/disLogo.png">
    <link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Kanit', sans-serif;
        }
        .content {
            max-width: 98%;
            margin: auto;
            background: white;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <br>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8"><h4>R8 Disability Reset password</h4></div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                        <th scope="row">Email</th>
                        <td><?php echo $r["email"]; ?></td>
                        </tr>
                        <tr>
                        <th scope="row">ชื่อ</th>
                        <td><?php echo $r["username"]; ?></td>
                        </tr>
                        <tr>
                        <th scope="row">สกุล</th>
                        <td><?php echo $r["lastname"]; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-2"></div>
        </div>
        <?php if ($st_reset == "0") { ?>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="new_pw">รหัสผ่านใหม่</label>
                            <input type="password" class="form-control" id="new_pw" name="new_pw" aria-describedby="pwHelp" required>
                            <small id="pwHelp" class="form-text text-muted">ระบุรหัสผ่านใหม่เป็นภาษาอังกฤษหรือตัวเลข อย่างน้อย 6 ตัวอักษร</small>
                        </div>
                        <?php if ($st_pw == "0") { ?>
                            <div class="alert alert-warning" role="alert">ระบุรหัสผ่านไม่น้อยกว่า 6 ตัวอักษร</div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="new_pw_cf">ยืนยันรหัสผ่านใหม่</label>
                            <input type="password" class="form-control" id="new_pw_cf" name="new_pw_cf" aria-describedby="pwcfHelp" required>
                            <small id="pwcfHelp" class="form-text text-muted">ระบุยืนยันรหัสผ่านใหม่ ให้เหมือนกับช่องรหัสผ่านใหม่</small>
                        </div>
                        <?php if ($st_pw_cf == "0") { ?>
                            <div class="alert alert-warning" role="alert">ระบุรหัสผ่านให้เหมือนช่องด้านบน</div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="code_otp" class="text-danger">ระบุรหัสยันยัน 5 หลัก</label>
                            <input type="text" class="form-control" id="code_otp" name="code_otp" aria-describedby="otpHelp" required>
                            <small id="otpHelp" class="form-text text-muted">ระบุรหัสยืนยัน 5 หลักที่ได้รับในอีเมล์</small>
                        </div>
                        <?php if ($st_code_otp == "0") { ?>
                            <div class="alert alert-warning" role="alert">รหัสยืนยัน 5 หลัก ไม่ถูกต้อง กรุณาตรวจสอบว่าระบุถูกต้องตามที่ได้รับในอีเมล์หรือไม่</div>
                        <?php } ?>
                        <input type="hidden" name="st" value="1">
                        <input type="hidden" name="id" value="<?php echo $email_encode; ?>">
                        <button type="submit" class="btn btn-primary">ยืนยันเปลี่ยนรหัสผ่าน</button>
                    </form>
                </div>
                <div class="col-md-2"></div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Success!</h4>
                        <p>Reset password ใหม่เรียบร้อยแล้ว ท่านสามารถใช้รหัสผ่านใหม่เข้าใช้งานได้ทันที</p>
                        <hr>
                        <p class="mb-0">
                            <button type="button" class="btn btn-primary" onclick="location.href='page-login.php';">เข้าสู่ระบบ</button>
                        </p>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        <?php } ?>
    </div>
</body>
</html>
