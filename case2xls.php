<?php session_start(); if($_SESSION["levelx"]==""){header("Location: page-login.php");} ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>R8:NDS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link href="assets/css/font-awesome.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>


</head>
<!-- เรียกใช้ javascript สำหรับ export ไฟล์ excel  -->
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"  ></script>
<script src="https://unpkg.com/file-saver@1.3.3/FileSaver.js"  ></script>

<script>
function ExcelReport()//function สำหรับสร้าง ไฟล์ excel จากตาราง
{
    var sheet_name="sheet1";/* กำหหนดชื่อ sheet ให้กับ excel โดยต้องไม่เกิน 31 ตัวอักษร */
    var elt = document.getElementById('myTable');/*กำหนดสร้างไฟล์ excel จาก table element ที่มี id ชื่อว่า myTable*/

    /*------สร้างไฟล์ excel------*/
    var wb = XLSX.utils.table_to_book(elt, {sheet: sheet_name});
    XLSX.writeFile(wb,'listCase.xlsx');//Download ไฟล์ excel จากตาราง html โดยใช้ชื่อว่า report.xlsx
}
</script>


<body>

<div class="container mt-3" style="width:80%;">
  <?php
   include ("connectDB.php");
   include ("function.php");
  @session_start();
  $d = $_SESSION['pcu'];

?>
<a href='#' class="btn btn-success btn-sm" id='download_link' onClick='javascript:ExcelReport();''><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>

 <table class="table table-bordered" id="myTable">
    <thead>
      <tr> <th><font size="2">ลำดับ</th>
          <th><font size="2">อำเภอ</th>
          <th><font size="2">ตำบล</th>
          <th><font size="2">หมู่ที่</th>
          <th><font size="2">บ้านเลขที่</th>
          <th><font size="2">cid</th>
          <th><font size="2">ชื่อ-สกุล</th>
          <th><font size="2">เพศ</th>
          <th><font size="2">วันเกิด</th>
          <th><font size="2">ประเภทความพิการ</th>
          <th><font size="2">เทศบาล/อบต.</th>
            <th><font size="2">รพ.สต.</th>
          <th><font size="2">โทรศัพท์</th>
      </tr>
     
    </thead>
    <tbody>
              <?php
                $q="SELECT caseDis.cid,caseDis.fname,caseDis.lname,caseDis.sex,caseDis.birth,caseDis.disType,caseDis.homeNo,caseDis.mu,caseDis.pcucode,
                districts.name_th as tambolName,amphures.name_th as amperName,caseDis.tel,tesaban.hospname FROM caseDis 
                INNER JOIN districts ON caseDis.tambol = districts.id INNER JOIN amphures ON caseDis.amper = amphures.id 
                INNER JOIN tesaban ON caseDis.obt = tesaban.tcode 
                WHERE caseDis.hospcode ='$d' ";
                $result = $mysqli->query($q);
                $i=1;    
          while($rs=$result->fetch_object()){ 
                $tambolName=$rs->tambolName;
                $amperName=$rs->amperName;
                $mu=$rs->mu;
                $homeNo=$rs->homeNo;
                $cid=$rs->cid;
                $fname=$rs->fname;
                $lname=$rs->lname;
                $sex=$rs->sex;
                $birth=$rs->birth;
                $birth=Thai_date($birth);
                $disType=$rs->disType;
                $hospname=$rs->hospname;
                $pcucode=$rs->pcucode;
                  $q1="SELECT off_name from office WHERE off_id='$pcucode' ";
                  $result1 = $mysqli->query($q1);                                                                   
                  $rs1=$result1->fetch_object();
                  $off_name=$rs1->off_name;
                $tel=$rs->tel;             
                   ?>    
                     <tr>            
                         <td><font size="2"><?=$i?></td>
                         <td><font size="2"><?=$amperName?></td>
                         <td><font size="2"><?=$tambolName?></td>
                         <td><font size="2"><?=$mu?></td>
                         <td><font size="2"><?=$homeNo?></td>
                         <td><font size="2"><?=$cid?></td>
                         <td><font size="2"><?=$fname.'  '.$lname?></td>
                         <td><font size="2"><?=$sex?></td>
                         <td><font size="2"><?=$birth?></td>
                         <td><font size="2"><?=$disType?></td>
                         <td><font size="2"><?=$hospname?></td>
                          <td><font size="2"><?=$off_name?></td>
                         <td><font size="2"><?=$tel?></td>
                     </tr>  
                   <?php
                  $i++;                   
               }  
            ?>
               </tbody>
               </table>              
  <?php
  
  ?>    
     
</div>
</body>
</html>
