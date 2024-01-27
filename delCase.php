<?php session_start(); if($_SESSION["levelx"]==""){header("Location: page-login.php");} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>R8:NDS</title>
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<script  language="javascript">  
function reload_view(t) {
	window.opener.location.reload();
	setTimeout("self.close()",(t * 10000));
}
</script>

<link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
		body {
		  font-family: 'Kanit', sans-serif;
		}
		h1,h2,h3,h4,h5,h6 {
		  font-family: 'Kanit', sans-serif;
		}
    </style>
<body>



<?php
if($_REQUEST["act"]==1)
{
  include ("connectDB.php");
  $cid=$_REQUEST["cid"];       
           $sql = "DELETE FROM caseDis WHERE cid='$cid' ";
          //  $sql = "DELETE FROM caseDis WHERE cid=".$_GET['id'];
           $mysqli->query($sql);
           
          echo "<center><h3>ลบข้อมูลเรียบร้อยแล้ว</h3>";
          // echo "<hr><input type='button' class='btn btn-outline-primary' onclick='reload_view(0)' value='&nbsp;&nbsp;ปิด&nbsp;&nbsp;'><br>";
  ?>
<META HTTP-EQUIV="Refresh" CONTENT="0;URL=./page1.php">

<?php
}//ปิด add
else{
?>      

<div class="container">    
<button onclick="history.back()" class="btn btn-warning"> <i class="fa fa-arrow-left"></i>ยกเลิก</button>   
<FORM name="form1" class="form-inline" ACTION ='delCase.php?act=1&cid=<?=$cid?>' METHOD='post'  enctype='multipart/form-data'>
          <div class="input-group mb-3 input-group-sm">
          <?php
            include ("connectDB.php");
            $cid=$_REQUEST["cid"];
            $cid=base64_decode($cid);
            // $cid=1399900532681;
            $q1="SELECT * FROM caseDis where cid='$cid'";          
            $result1 = $mysqli->query($q1);                                                                   
            $rs1=$result1->fetch_object();
            $cid=$rs1->cid;
            $fname=$rs1->fname;
            $lname=$rs1->lname;
            
          ?>
          <div class="container my-5">
          
      <div class="card">
      <div class="card-header">
      <!-- <div class="card-body"> -->
            <h5>ลบข้อมูลคนพิการ</h5>
            <div class="input-group mb-3 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">เลขประชาชน : </span>
                      </div>
                    <input type="text" class="form-control"  name="cid" value="<?=$cid?>" readonly>
                    <!-- <p><?=$cid?></p> -->
                    </div> 
            <div class="input-group mb-3 input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">ชื่อ :</span>
            </div>
          <input type="text" class="form-control"  name="fname" value="<?=$fname?>" readonly>
          </div>
          <div class="input-group mb-3 input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">สกุล :</span>
            </div>
          <input type="text" class="form-control"  name="lname" value="<?=$lname?>" readonly>
          </div>  
          <button type="submit" class="btn btn-danger"> <i class="fa fa-trash"></i> ยืนยันลบข้อมูล</button>
          
</FORM>

  <?php
}
 ?>
        </div>    
        </div>           

</body>

</html>