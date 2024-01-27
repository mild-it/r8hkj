<?php 
    session_start();
    include('server.php'); 
    include('connectDB.php'); 
?>

<?php
session_start();
require_once("LoginLib.php");

// กรณีต้องการตรวจสอบการแจ้ง error ให้เปิด 3 บรรทัดล่างนี้ให้ทำงาน กรณีไม่ ให้ comment ปิดไป
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
// กรณีมีการเชื่อมต่อกับฐานข้อมูล
//require_once("dbconnect.php");
 
/// ส่วนการกำหนดค่านี้สามารถทำเป็นไฟล์ include แทนได้
define('LINE_LOGIN_CHANNEL_ID','1657294629');
define('LINE_LOGIN_CHANNEL_SECRET','b461fecab258c85715cb9433b391d507');
define('LINE_LOGIN_CALLBACK_URL','https://nblp.moph.go.th/r8nds/login_callback.php');
 
$LineLogin = new LineLoginLib(
    LINE_LOGIN_CHANNEL_ID, LINE_LOGIN_CHANNEL_SECRET, LINE_LOGIN_CALLBACK_URL);
     
if(!isset($_SESSION['ses_login_accToken_val'])){    
    $LineLogin->authorize(); 
    exit;
}
 
$accToken = $_SESSION['ses_login_accToken_val'];
// Status Token Check
if($LineLogin->verifyToken($accToken)){
    $accToken."<br><hr>";
    "Token Status OK <br>";  
}

//exit;
// echo "<hr>";
 
if(isset($_SESSION['ses_login_userData_val']) && $_SESSION['ses_login_userData_val']!=""){
    // GET USER DATA FROM ID TOKEN
    $lineUserData = json_decode($_SESSION['ses_login_userData_val'],true);
    ($lineUserData); 
    "<hr>";
    "Line UserID: ".$lineUserData['sub']."<br>";
    "Line Display Name: ".$lineUserData['name']."<br>";
    '<img style="width:100px;" src="'.$lineUserData['picture'].'" /><br>';
    $lineid = $lineUserData['sub'];
    $displayname = $lineUserData['name'];
}
 
 
// echo "<hr>";
if(isset($_SESSION['ses_login_refreshToken_val']) && $_SESSION['ses_login_refreshToken_val']!=""){
    '
    <form method="post">
    <button type="submit" name="refreshToken">Refresh Access Token</button>
    </form>   
    ';  
}
if(isset($_SESSION['ses_login_refreshToken_val']) && $_SESSION['ses_login_refreshToken_val']!=""){
    if(isset($_POST['refreshToken'])){
        $refreshToken = $_SESSION['ses_login_refreshToken_val'];
        $new_accToken = $LineLogin->refreshToken($refreshToken); 
        if(isset($new_accToken) && is_string($new_accToken)){
            $_SESSION['ses_login_accToken_val'] = $new_accToken;
        }       
        $LineLogin->redirect("register_rpst.php");
    }
}
// Revoke Token
//if($LineLogin->revokeToken($accToken)){
//  echo "Logout Line Success<br>";   
//}
//
// Revoke Token with Result
//$statusRevoke = $LineLogin->revokeToken($accToken, true);
//print_r($statusRevoke);
?>
<!-- <?php
"<hr>";
if($LineLogin->verifyToken($accToken)){
?>
<form method="post">
<button type="submit" name="lineLogout">LINE Logout</button>
</form>
<?php }else{ ?>
<form method="post">
<button type="submit" name="lineLogin">LINE Login</button>
</form>   
<?php } ?> -->
<?php
if(isset($_POST['lineLogin'])){
    $LineLogin->authorize(); 
    exit;   
}
if(isset($_POST['lineLogout'])){
    unset(
        $_SESSION['ses_login_accToken_val'],
        $_SESSION['ses_login_refreshToken_val'],
        $_SESSION['ses_login_userData_val']
    );  
    "<hr>";
    if($LineLogin->revokeToken($accToken)){
        "Logout Line Success<br>";   
    }
    '
    <form method="post">
    <button type="submit" name="lineLogin">LINE Login</button>
    </form>   
    ';
    $LineLogin->redirect("register_rpst.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
    <title>R8:NDS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <style>
          body {  font-family: 'Kanit', sans-serif;	}
          h1,h2,h3,h4,h5,h6 {  font-family: 'Kanit', sans-serif;	}
          </style>
          <style type="text/css">.bgimg {  background-image: url('../images/disLogo.png'); }  </style>

          <style>
            body {
              background-image: url("images/user-login.png");
              no-repeat fix; background-size: 100%;
            } 
      </style>

    <script language="javascript">
        function checkID(id)
        {
        if(id.length != 13) return false;
        for(i=0, sum=0; i < 12; i++)
        sum += parseFloat(id.charAt(i))*(13-i); if((11-sum%11)%10!=parseFloat(id.charAt(12)))
        return false; return true;}

        function checkForm()
        { if(!checkID(document.form1.cid.value))
            document.form1.cid.value='';
        }
    </script>

    <script type="text/javascript">
    function ShowHideDiv() {
        var level = document.getElementById("level");
        var hospcode = document.getElementById("hospcode");
        hospcode.style.display = level.value == "pcu" ? "block" : "none";

        var opt = document.getElementById("opt");
        opt.style.display = level.value == "opt" ? "block" : "none";
    }
    </script>
</head>
<body>
<main>
    <form action="regis_rpst_db.php" method="post">
        <h1>ลงทะเบียน รพ.สต.</h1>

        <?php include('errors.php'); ?>
                                    <?php if (isset($_SESSION['error'])) : ?>
                                        <div class="error">
                                            <h4>
                                                <?php 
                                                    echo $_SESSION['error'];
                                                    unset($_SESSION['error']);
                                                ?>
                                            </h4>
                                        </div>
                                    <?php endif ?>
                                    <?php if (isset($_SESSION['err'])) : ?>
                                        <div class="error">
                                            <h4>
                                                <?php 
                                                    echo $_SESSION['err'];
                                                    unset($_SESSION['err']);
                                                ?>
                                            </h4>
                                        </div>
                                    <?php endif ?>
        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="lineid">User ID:
                                            </label>
                                            <div class="col-lg-6">
                                                    <label class=" col-form-label" for="lineid" id="lineid">
                                                    <?php
                                                        echo $lineid;  
                                                    ?>
                                                    </label>
                                                    <input type="hidden" name="lineid" value="<?php echo $lineid ; ?>" size="32">
                                            </div>
                                        </div>


        <div class="form-group row">
            <label class="col-lg-4 col-form-label" for="displayname">Display Name: 
                </label>
                    <div class="col-lg-6">
                        <label class=" col-form-label" for="displayname" id="display_name">
                            <?php echo $displayname;?>
                </label>
                            <input type="hidden" name="displayname" value="<?php echo $displayname ; ?>" size="32">
                    </div>
        </div>   

        <div>
            <label for="username">ชื่อ:</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="lastname">สกุล:</label>
            <input type="text" name="lastname" id="lastname1">
        </div>
        <div>
            <label for="cid">เลขบัตรประชาชน:</label>
            <input type="text" class="form-control" id="cid" name="cid" placeholder="" onfocusout="checkForm()">
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="password">รหัสผ่าน:</label>
            <input type="password" name="password_1" id="password">
        </div>
        <div class="form-group row">
		        <label class="col-lg-4 col-form-label" for="provinces" >จังหวัด:</label>
		            <div class="col-md-6">                        
			            <select class="form-control" name="provinces" id="provinces">                        
				            <option disabled selected required>-เลือกจังหวัด-</option>
                            <?php
                                $i=1;
                                $q2="SELECT * FROM provinces where code = '39'";
                                $result2 = $mysqli->query($q2); // ทำการ query คำสั่ง sql 
                                while($rs2=$result2->fetch_object()){ // วนลูปแสดงข้อมูล
                                $name_th=$rs2->name_th;
                                $code=$rs2->code;
                            ?>
                            <option value="<?=$code?>"><?=$name_th?></option>
                            <?php }?>                         
			            </select>                        
		            </div>                        
	      </div> 
          
        <div class="form-group row">
		        <label class="col-lg-4 col-form-label" for="level" >ระดับผู้ใช้งาน:</label>
                <div class="col-md-6">
			        <select class="form-control" name="level" id="level"   onchange = "ShowHideDiv()" >
				        <option disabled selected required>-เลือกหน่วยงาน-</option>
				        <option value="pcu">หน่วยงานสาธารณสุข</option>
				        <option value="pmj">พมจ.</option>
				        <option value="opt">อบต./เทศบาล</option>
			        </select>
		        </div>                    
	      </div>
        <div class="form-group row">
		        <label class="col-lg-4 col-form-label" for="hospcode" >หน่วยงานสาธารณสุข:</label>
		            <div class="col-md-6">                        
			            <select class="custom-select" id="hospcode" name="hospcode"  style="display: none"  >                        
				            <option disabled selected required>-เลือกหน่วยงาน-</option> 
                            <?php
                                $i=1;
                                $q="SELECT * FROM office WHERE provid LIKE '39%' OR off_type IN ('05,06,07')";
                                $result = $mysqli->query($q); // ทำการ query คำสั่ง sql 
                                while($rs=$result->fetch_object()){ // วนลูปแสดงข้อมูล
                                $off_name=$rs->off_name;
                                $off_id_new=$rs->off_id_new;
                            ?>
                            <option value="<?=$off_id_new?>"><?=$off_name?></option>
                            <?php }?>                                           
			            </select>                        
		            </div>                        
	    </div>
        
        <div class="form-group row">
            <label class="col-lg-4 col-form-label" for="opt" >หน่วยงาน อปท:</label>
                <div class="col-md-6">
                <select class="custom-select" id="opt" name="opt" style="display: none" >
                    <option value="">-เลือกหน่วยงาน-</option>
                        <?php
                            include('connect.php');
                            $sql0 = "SELECT * FROM tesaban where villcode LIKE '39%'";
                            $query0 = mysqli_query($conn, $sql0);
                                while($result0 = mysqli_fetch_assoc($query0)): ?>
                                    <option value="<?=$result0['tcode']?>"><?=$result0['hospname']?></option>
                                <?php endwhile; ?>
		        </select>
                </div>
        </div>
        <!-- <div>
            <label for="password2">ยืนยันรหัสผ่าน:</label>
            <input type="password" name="password2" id="password2">
        </div> -->
        <!-- <div>
            <label for="agree">
                <input type="checkbox" name="agree" id="agree" value="yes"/> I agree
                with the
                <a href="#" title="term of services">term of services</a>
            </label>
        </div> -->
        <button type="submit" name="reg_rpst">ลงทะเบียน</button>
        <!-- <footer>เป็นสมาชิกอยู่แล้ว <a href="login.php">คลิกที่นี่</a></footer> -->
    </form>
</main>
</body>
</html>