<?php
setcookie('');
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('server.php');
include('connectDB.php');

require_once("LoginLib_new.php");
$line = new LineLogin();
$result_profile_line = $line->profile($_SESSION["profile"]->access_token);
$lineid = $result_profile_line->userId;

$sql1 = "SELECT * FROM provinces where code in('38', '39', '41', '42', '43', '47', '48')";
$query1 = $mysqli->query($sql1);
// $query = mysqli_query($conn, $sql);

$sql2 = "SELECT * FROM provinces where code in('38', '39', '41', '42', '43', '47', '48')";
$query2 = $mysqli->query($sql2);
// $query2 = mysqli_query($conn, $sql2);

$sql3 = "SELECT * FROM provinces where code in('38', '39', '41', '42', '43', '47', '48')";
$query3 = $mysqli->query($sql3);
// $query3 = mysqli_query($conn, $sql3);

$sql4 = "SELECT * FROM provinces where code in('38', '39', '41', '42', '43', '47', '48')";
$query4 = $mysqli->query($sql4);
// $query3 = mysqli_query($conn, $sql3);
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
                // var etc = document.getElementById("province_etc");
                // etc.style.display = level.value == "etc" ? "block" : "none";

                var pcu_1 = document.getElementById("province_pcu1");
                pcu_1.style.display = level.value == "pcu1" ? "block" : "none";

                var pcu_2 = document.getElementById("province_pcu2");
                pcu_2.style.display = level.value == "pcu2" ? "block" : "none";

                var pao1 = document.getElementById("province_obj");
                pao1.style.display = level.value == "pao" ? "block" : "none";

                var hosp_p1 = document.getElementById("hosp_pcu1");
                hosp_p1.style.display = level.value == "pcu1" ? "block" : "none";

                var hosp_p2 = document.getElementById("hosp_pcu2");
                hosp_p2.style.display = level.value == "pcu2" ? "block" : "none";
            }
    </script>

        <script src="sc_pcu/jquery.min.js"></script>
        <script src="sc_pcu/script6.js"></script>

        <script src="sc_pcu2/jquery.min.js"></script>
        <script src="sc_pcu2/script7.js"></script>
</head>
<body>

<main>
    <form action="regis_rpst_db.php" method="post">
        <h1>ลงทะเบียน</h1>
        <?php
        if (isset($_SESSION['error'])) : ?>
            <div class="error">
                <h3>
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
        <?php
        if (isset($_SESSION['status'])) : ?>
            <div class="status">
                <h4>
                    <?php 
                        echo $_SESSION['status'];
                        unset($_SESSION['status']);
                    ?>
                </h4>
            </div>
        <?php endif ?>
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
            <label class="col-lg-4 col-form-label" for="lineid">User ID: </label>
            <div class="col-lg-6">
                <label class=" col-form-label" for="lineid" id="lineid"><?php echo $lineid; ?></label>
                <input type="hidden" name="lineid" value="<?php echo $lineid; ?>" size="32">
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
<!--         <div>
            <label for="password">รหัสผ่าน:</label>
            <input type="password" name="password_1" id="password">
        </div> -->
        
          
        <div class="form-group row">
		        <label class="col-lg-4 col-form-label" for="level">ประเภทผู้ใช้งาน:</label>
                <div class="col-md-6">
			<select class="form-control" name="level" id="level" onchange="ShowHideDiv()" required>
                        <option value="">-เลือกระดับผู้ใช้งาน-</option>
<!-- 			<option value="etc">ประชาชนทั่วไป</option> -->
                        <option value="pcu2">รพ.สต.</option>
                        <option value="pcu1">อสม.</option>
                        <option value="obj">อบจ.</option>
			</select>
		</div>
	    </div>
        
        <div class="form-group row">
		    <label class="col-lg-4 col-form-label" for="provinces1"></label>
            <div class="col-md-6">
                <select name="province_etc" id="province_etc" class="form-control" style="display: none">
                    <option value="">-เลือกจังหวัด-</option>
                        <?php while($result1 = mysqli_fetch_assoc($query1)):?>
                            <option value="<?=$result1['code']?>"><?=$result1['name_th']?></option>
                        <?php endwhile; ?>
                </select>  
            </div>
	    </div>
        <div class="form-group row">
		    <label class="col-lg-4 col-form-label" for="provinces2"></label>
            <div class="col-md-6">
                    <select name="province_pcu1" id="province_pcu1" class="form-control" style="display: none">
                        <option value="">-เลือกจังหวัด-</option>
                            <?php while($result2 = mysqli_fetch_assoc($query2)):?>
                                <option value="<?=$result2['code']?>"><?=$result2['name_th']?></option>
                            <?php endwhile; ?>
                    </select>
            </div>
	    </div>
        <div class="form-group row">
		    <label class="col-lg-4 col-form-label" for="provinces3"></label>
            <div class="col-md-6">
                    <select name="province_pcu2" id="province_pcu2" class="form-control" style="display: none">
                        <option value="">-เลือกจังหวัด-</option>
                            <?php while($result3 = mysqli_fetch_assoc($query3)):?>
                                <option value="<?=$result3['code']?>"><?=$result3['name_th']?></option>
                            <?php endwhile; ?>
                    </select>
            </div>
	    </div>
        <div class="form-group row">
		    <label class="col-lg-4 col-form-label" for="provinces4"></label>
            <div class="col-md-6">
                    <select name="province_obj" id="province_obj" class="form-control" style="display: none">
                        <option value="">-เลือกจังหวัด-</option>
                            <?php while($result4 = mysqli_fetch_assoc($query4)):?>
                                <option value="<?=$result4['code']?>"><?=$result4['name_th']?></option>
                            <?php endwhile; ?>
                    </select>
            </div>
	    </div>

        <div class="form-group row">
		        <label class="col-lg-4 col-form-label" for="hospcode1" ></label>
		            <div class="col-md-6">                        
                        <select name="pcu1" id="hosp_pcu1" class="form-control" style="display: none">
                            <option value="">-เลือกหน่วยงาน-</option>
                        </select>                    
		            </div>                        
	    </div>
        <div class="form-group row">
		        <label class="col-lg-4 col-form-label" for="hospcode2" ></label>
		            <div class="col-md-6">                        
                        <select name="pcu2" id="hosp_pcu2" class="form-control" style="display: none">
                            <option value="">-เลือกหน่วยงาน-</option>
                        </select>                  
		            </div>                        
	    </div>
        <button type="submit" name="reg_rpst">ลงทะเบียน</button>
        <!-- <footer>เป็นสมาชิกอยู่แล้ว <a href="login.php">คลิกที่นี่</a></footer> -->
    </form>
</main>
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>
</html>
