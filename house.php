<?php
session_start();
if($_SESSION["levelx"] == "") {
    header("Location: alert_pcu.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<title>R8NDS</title>
	<head>
	  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
	<head>
	<script type="text/javascript" src="js/show123.js"></script>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Custom Stylesheet -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
 <link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<script>
	function isImage(fileHouse){
    var ext = getExtension(fileHouse);
    switch(ext.toLowerCase()){
        case 'jpg':
        case 'jpeg':
        case 'gif':
        case 'bmp':
        case 'png':
            return true;
    }
    return false;
}
</script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <style>
		body {  font-family: 'Kanit', sans-serif;	}	h1,h2,h3,h4,h5,h6 {  font-family: 'Kanit', sans-serif;	}
    </style>
    <style type="text/css">.bgimg {  background-image: url('../images/disLogo.png'); }  </style>
</head>
<body>
<div class="container">
<h4>รูปถ่ายที่อยู่อาศัย</h4>
<?php
            include ("connectDB.php");
            include ("function.php");
            $cid_case=$_REQUEST["cid_case"];
            $q1="SELECT * FROM caseDis where cid='$cid_case'";          
            $result1 = $mysqli->query($q1);                                                                   
            $rs1=$result1->fetch_object();
            $cid=$rs1->cid;
            $fileHouse=$rs1->fileHouse;
?>     
        <div class="container mt-3">      
                <?php if($fileHouse==''||$fileHouse== null){echo "ไม่พบไฟล์เอกสาร";}else{ ?>
                    <embed SRC=./temp/<?=$fileHouse?> style="width:100%;">
                <?php }?> 
        </div> 
        <form method='post' action='house.php?act=3&cid_case=<?=$cid_case?>' enctype="multipart/form-data">
          เลือกไฟล์ : <input type='file' name='fileHouse' id='file' class='form-control' ><br>
          <input type='submit' class='btn btn-info' onclick="isImage()" value='อัพโหลด' >
        </form>
</div>
</body>
<?php
if($_REQUEST["act"]==3)
{
  include ("connectDB.php");
  $cid_case=$_REQUEST["cid_case"]; 
          $q1="SELECT * FROM caseDis WHERE cid = '$cid_case'";          
          $result1 = $mysqli->query($q1);                                                                   
          $rs1=$result1->fetch_object();
         //upload file
         if($_FILES['fileHouse']['name']!="")
         {
          $fileHouse=$rs1->fileHouse;;	
          $DIR = 'temp/';
          $delfile1=$DIR.$fileHouse;
          unlink($delfile1);
           $output_dir = "temp/";
           $sur = strrchr($_FILES['fileHouse']['name'], "."); //ตัดนามสกุลไฟล์เก็บไว้
           $fileHouse = ('House'.$cid_case.$sur); //ชื่อไฟล์ตาม id
           move_uploaded_file($_FILES["fileHouse"]["tmp_name"],$output_dir.$fileHouse);
           $sql = "UPDATE caseDis SET fileHouse='$fileHouse' WHERE cid='$cid_case' ";
           $mysqli->query($sql);
		   
		   echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "อัพโหลดรูปภาพเรียบร้อย",
                            text: "",
                            type: "success"
                        }, function() {
                             window.close();
                        });
                      }, 1000);
                  </script>';
         }else {
            echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "กรุณาอัพโหลดรูปภาพใหม่",
                            text: "กรุณาอัพโหลดรูปภาพใหม่",
                            type: "error"
                        }, function() {
                            window.close();
                        });
                      }, 1000);
                  </script>';
        }		
}
?>
</html>
