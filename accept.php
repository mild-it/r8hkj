<?php
session_start();
// if ($_SESSION["level"] == "etc") {
//     header("location: accept.php");
// }
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

<script type="text/javascript" src="//code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
$(function(){
     $("#i_accept").click(function(){ // เมื่อคลิกที่ checkbox id=i_accept
         if($(this).prop("checked")==true){ // ถ้าเลือก
             $("#continue_bt").removeAttr("disabled"); // ให้ปุ่ม id=continue_bt ทำงาน สามารถคลิกได้
         }else{ // ยกเลิกไม่ทำการเลือก
             $("#continue_bt").attr("disabled","disabled");  // ให้ปุ่ม id=continue_bt ไม่ทำงาน
         }
     });
});
</script>
</head>
<body>
<main>
    <form action="regis_rpst_db.php" method="post">
        <h1>การให้คำยินยอมในการเปิดเผยเอกสาร ข้อมูลส่วนบุคคลในระบบอิเล็กทรอนิกส์</h1>
        <h4>วัตถุประสงค์ของระบบการบริการคนพิการแบบเบ็ดเสร็จ คือเพื่ออำนวยความสะดวกให้กับคนพิการ ตั้งแต่ขั้นตอนการตรวจสุขภาพเพื่อออกเอกสารรับรองความพิการ การขึ้นทะเบียนคนพิการ การออกบัตรคนพิการ และการเบิกจ่ายเงินค่าความพิการ ซึ่งระบบจะต้องมีการแลกเปลี่ยนข้อมูลระหว่างหน่วยงาน โรงพยาบาล สำนักงานพัฒนาสังคมและความมั่นคงของมนุษย์ และหน่วยงานองค์กรปกครองส่วนท้องถิ่น รวมถึงหน่วยงานราชการอื่นๆที่เกี่ยวข้อง เพื่อหน่วยงานจะได้พิจารณาข้อมูลระดับบุคคล รวมถึงเอกสารส่วนบุคคลอื่น ๆ ในการดำเนินงานตามขั้นตอนต่างๆที่เกี่ยวข้องต่อไป 
หากท่านประสงค์จะเข้าระบบการบริการคนพิการแบบเบ็ดเสร็จนี้ ท่านจะต้องยินยอมให้เปิดเผยเอกสาร ข้อมูลส่วนบุคคลต่างๆ ผ่านทางระบบอิเล็กทรอนิกส์ เพื่อให้หน่วยงานตรวจสอบ พิจารณา  แต่หากท่านไม่ประสงค์ที่จะเปิดเผยข้อมูลส่วนบุคคล ท่านจะต้องนำเอกสารส่วนบุคคลเหล่านั้น ณ หน่วยงานที่รับผิดชอบเองตามระบบเดิม
</h4><br>
        <div class="form-group row">
        <input type="checkbox" name="i_accept" id="i_accept" />
        ข้าพเจ้ายินยอมให้สถานพยาบาล หน่วยงานที่เกี่ยวข้องในระบบ เปิดเผยข้อมูล/ส่งข้อมูล ทางอิเล็กทรอนิกส์ (สำเนาข้อมูล)  เพื่อการดูแลสวัสดิภาพด้านสุขภาพของคนพิการ 
<br />
<br />
    <a href="sendCase.php"><input type="button" name="continue_bt" id="continue_bt" value="ยินยอม"
        disabled   onclick="alert('คุณได้ยินยอมเรียบร้อย')"  /></a>
        <input type="button" name="continue_bt" id="continue_bt" value="ไม่ยินยอม"
        onclick="alert('คุณไม่ได้ยินยอม')"  />   
        </div>   
    </form>
</main>
</body>
</html>