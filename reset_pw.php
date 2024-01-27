<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/phpmailer/src/Exception.php';
require_once __DIR__ . '/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/phpmailer/src/SMTP.php';

include "connectDB.php";
$email = $mysqli->real_escape_string($_POST["email"]);
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
    <?php
    if ($email == "") {
    ?>
        <br>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8"><h4>R8 Disability Reset password</h4></div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted">ระบุอีเมล์ที่ท่านเคยลงทะเบียนสมัครสมาชิก</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Email</button>
                    <button type="button" class="btn btn-warning" onclick="location.href='page-login.php';">Cancle</button>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
    <?php
    } else {
        $sql = "select username, lastname, email from member where email = '$email'";
        $result = $mysqli->query($sql);
        $r = mysqli_fetch_array($result);
        if ($r["email"] != "") {
            $ymd_now = date("Y-m-d H:i:s");
            $code_otp = rand(10000, 99999);
            $sql_reset_data = "replace into reset_pw(email, code_otp, date_update) values('$email', '$code_otp', '$ymd_now')";
            $result_reset_data = $mysqli->query($sql_reset_data);
            $email_encrypt = md5($r["email"]);
            $body_email = "<b>รายละเอียดการ Reset password</b><br>
            ชื่อ - สกุล: ".$r["username"]." ".$r["lastname"]."<br>
            Email: ".$r["email"]."<br><br>
            Reset password <a href='https://.moph.go.th/r8nds/reset_pw_form.php?id=$email_encrypt' target='_blank'>คลิกที่นี่<a><br>
            โดยระบุรหัสยืนยัน 5 หลักดังนี้ <b><font color='#CC0000'>$code_otp</font></b><br><br><br><br>
            ---------------------------------<br>
            Mail นี้เป็นระบบอัตโนมัติ กรุณาอย่าตอบกลับ<br>
            R8 Disability Service";
            // Send Email
            $mail = new PHPMailer(true);
            try {
                // Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->Username = ''; // YOUR gmail email
                $mail->Password = ''; // YOUR gmail password

                // Sender and recipient settings
                $mail->setFrom('', 'R8 Disability');
                $mail->addAddress($r["email"], 'Receiver Name');
                $mail->addReplyTo('', 'R8 Disability'); // to set the reply to

                // Setting the email content
                $mail->IsHTML(true);
                $mail->Subject = "Reset password R8NDS";
                $mail->Body = $body_email;
                // $mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';

                $mail->send();
                ?>
                <br>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Success!</h4>
                            <p>ระบบส่งรายละเอียดในการ Reset password ให้ท่านทางอีเมล์นี้ <b><?php echo $email; ?></b> เรียบร้อยแล้ว<br>
                            กรุณาตรวจสอบอีเมล์ของท่าน หากไม่พบให้ตรวจสอบที่อีเมล์ขยะ (Junk mail)</p>
                            <hr>
                            <p class="mb-0">
                                <button type="button" class="btn btn-primary" onclick="location.href='page-login.php';">เข้าสู่ระบบ</button>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <?php
            } catch (Exception $e) {
                echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
        ?>
            <br>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Warning!</h4>
                        <p>ไม่พบอีเมล์ <b><?php echo $email; ?></b> ในระบบ กรุณาระบุอีเมล์ที่ท่านเคยลงทะเบียนสมัครเป็นสมาชิกให้ถูกต้อง</p>
                        <hr>
                        <p class="mb-0">
                            <button type="button" class="btn btn-primary" onclick="location.href='reset_pw.php';">ระบุอีเมล์อีกครั้ง</button>
                            <button type="button" class="btn btn-warning" onclick="location.href='page-login.php';">เข้าสู่ระบบ</button>
                        </p>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        <?php
        }
    }
    ?>
    </div>
</body>
</html>
