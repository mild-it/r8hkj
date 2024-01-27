<?php 
session_start();
include('server.php');
include ("connectDB.php");
?>
<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width,initial-scale=2"> -->
    <title>R8:NDS</title>
    <!-- Favicon icon -->
    <script src="https://kit.fontawesome.com/a46fd306c2.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/disLogo.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
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

    <script type="text/javascript">
    function ShowHideDiv() {
        var level = document.getElementById("level");
        var hospcode = document.getElementById("hospcode");
        hospcode.style.display = level.value == "pcu" ? "block" : "none";

        var opt = document.getElementById("opt");
        opt.style.display = level.value == "opt" ? "block" : "none";
    }
    </script>

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
</head>

<body class="h-100">
    
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                
                                    <a class="text-center " > <h2 class="card login-form mb-4">ลงทะเบียน</h2></a>
        
                                    <div class="form-validation">
                                    <form name="form1" class="form-valide" action="register_db.php" method="post">

                                    
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
                                    
                                    

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="username">ชื่อ</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="username1" name="username" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="lastname">สกุล</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="lastname1" name="lastname" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="cid">เลขบัตรประชาชน</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="cid" name="cid" placeholder="" onfocusout="checkForm()">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="email">อีเมล์ </label>
                                            <div class="col-lg-6">
                                                <input type="email" class="form-control" id="email1" name="email" placeholder="">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="password_1">Password</label>
                                            <div class="col-lg-6">
                                                <input type="password" class="form-control" id="password1" name="password_1" placeholder="">
                                            </div>
                                        </div>

                                        <div class="form-group row">
		                                    <label class="col-lg-4 col-form-label" for="level" class="col-md-4 control-label">ระดับผู้ใช้งาน</label>
		                                    <div class="col-md-6">
			                                    <select class="form-control" name="level" id="level"   onchange = "ShowHideDiv()" >
				                                    <option disabled selected required>-เลือกหน่วยงาน-</option>
				                                    <option value="pcu">รพ.</option>
				                                    <option value="pmj">พมจ.</option>
				                                    <option value="opt">อบต./เทศบาล</option>
			                                    </select>
		                                    </div>
	                                    </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="hospcode">หน่วยงานสาธาณสุข</label>
                                            <div class="col-lg-6">
                                                <select class="custom-select" id="hospcode" name="hospcode"  style="display: none" >
                                                    <option value="">-เลือกหน่วยงาน-</option>
			                                            <?php
                                                            $i=1;
                                                            $q="SELECT * FROM office where off_id_new IN ('10991','10704','10992','10993','10994','23367') ORDER BY distid,Off_type";
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
                                            <label class="col-lg-4 col-form-label" for="opt">หน่วยงานเทศบาล/อบต.
                                            </label>
                                            <div class="col-lg-6">
                                           
                                                <select class="custom-select" id="opt" name="opt" style="display: none" >
                                                    <option value="">-เลือกหน่วยงาน-</option>
                                                    <?php
                                                        include('connect.php');
                                                        $sql0 = "SELECT * FROM tesaban group by tcode";
                                                        $query0 = mysqli_query($conn, $sql0);
                                                        while($result0 = mysqli_fetch_assoc($query0)): ?>
                                                            <option value="<?=$result0['tcode']?>"><?php echo "[".$result0['ampname']."] ".$result0['hospname']; ?></option>
                                                        <?php endwhile; ?>
		                                        </select>
                                            </div>
                                        </div>

                                        <!-- <div class="form-group row">
                                            <label class="col-lg-4 col-form-label"><a href="#">Terms &amp; Conditions</a>  <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-8">
                                                <label class="css-control css-control-primary css-checkbox" for="val-terms">
                                                    <input type="checkbox" class="css-control-input" id="val-terms" name="val-terms" value="1"> <span class="css-control-indicator"></span> I agree to the terms</label>
                                            </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary" name="reguser">ลงทะเบียน</button>
                                                <!-- <button type="submit" class="btn btn-primary" ><a href="login_uselib.php"></a>ลงทะเบียนผ่านไลน์</button> -->
                                            </div>
                                        </div>
                                    </form>

                                    <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                
                                                <button type="submit" class="btn btn-primary" name="reg" style = "background-color: #4CAF50; color: white; text-align: center; text-size:20px;"><i class="fa-brands fa-line" style="font-size:20px"></i><a href="login_uselib.php" >&nbsp;<font color="white" >ลงทะเบียนผ่านไลน์</font></a></button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row" >
                                            <div class="col-lg-8 ml-auto">
                                            <h4><p>เป็นสมาชิกอยู่แล้ว <a href="page-login.php">Click ที่นี่</a></p></h4>
                                            </div>
                                            
                                    </div>
                                <!-- <form action="login_uselib.php" method="post">
                                        <div class="form-group row" >
                                            <div class="col-lg-8 ml-auto">
                                                
                                                <button type="submit" class="btn btn-primary"><a href="login_uselib.php"></a>ลงทะเบียนผ่านไลน์</button>
                                            </div>
                                        </div>

                                    </form> -->
                                    <!-- <p class="mt-5 login-form__footer">เป็นสมาชิกอยู่แล้ว <a href="page-login.php" class="text-primary">Click ที่นี้</a></p> -->
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>
</html>







