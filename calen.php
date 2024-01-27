<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>datepicker thai</title>
</head>
  <body>
<script type="text/javascript" src="jquery.js"></script>
 <link href="dist/css/bootstrap-datepicker.css" rel="stylesheet" />
  <script src="dist/js/bootstrap-datepicker-custom.js"></script>
  <script src="dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
 <script>
      $(document).ready(function () {
          $('.datepickerx').datepicker({
              format: 'dd-mm-yyyy',
              todayBtn: true,
              language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
              thaiyear: true              //Set เป็นปี พ.ศ.
          }).datepicker("setDate", "0");  //กำหนดเป็นวันปัจุบัน
      });
  </script>
            <input name="endDate" id="inputdatepicker" class="datepickerx" data-date-format="dd-mm-yyyy">

<?php

$jquery_ui_v="1.8.5";  
$theme=array(  
    "0"=>"base",  
    "1"=>"black-tie",  
    "2"=>"blitzer",  
    "3"=>"cupertino",  
    "4"=>"dark-hive",  
    "5"=>"dot-luv",  
    "6"=>"eggplant",  
    "7"=>"excite-bike",  
    "8"=>"flick",  
    "9"=>"hot-sneaks",  
    "10"=>"humanity",  
    "11"=>"le-frog",  
    "12"=>"mint-choc",  
    "13"=>"overcast",  
    "14"=>"pepper-grinder",  
    "15"=>"redmond",  
    "16"=>"smoothness",  
    "17"=>"south-street",  
    "18"=>"start",  
    "19"=>"sunny",  
    "20"=>"swanky-purse",  
    "21"=>"trontastic",  
    "22"=>"ui-darkness",  
    "23"=>"ui-lightness",  
    "24"=>"vader" 
);  
$jquery_ui_theme=$theme[22];  
?>  
<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/<?=$jquery_ui_v?>/themes/<?=$jquery_ui_theme?>/jquery-ui.css" />  
<style type="text/css">  
/* ปรับขนาดตัวอักษรของข้อความใน tabs  
สามารถปรับเปลี่ยน รายละเอียดอื่นๆ เพิ่มเติมเกี่ยวกับ tabs 
*/ 
.ui-tabs{
    font-family:tahoma;
    font-size:11px;
}
</style>  
<style type="text/css">
/* Overide css code กำหนดความกว้างของปฏิทินและอื่นๆ */
.ui-datepicker{
    width:220px;
    font-family:tahoma;
    font-size:11px;
    text-align:center;
}
</style>
 
<body>
 
 
<div style="margin:auto;width:95%;">
 
<input name="dateInput" type="text" id="dateInput" value="" />
 
</div>
 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function(){
    var dateBefore=null;
    $("#dateInput").datepicker({
        dateFormat: 'dd/mm/yy',
        showOn: 'button',
//      buttonImage: 'http://jqueryui.com/demos/datepicker/images/calendar.gif',
        buttonImageOnly: false,
        dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'], 
        monthNamesShort: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
        changeMonth: true,
        changeYear: true,
        beforeShow:function(){  
            if($(this).val()!=""){
                var arrayDate=$(this).val().split("/");     
                arrayDate[2]=parseInt(arrayDate[2])-543;
                $(this).val(arrayDate[0]+"/"+arrayDate[1]+"/"+arrayDate[2]);
            }
            setTimeout(function(){
                $.each($(".ui-datepicker-year option"),function(j,k){
                    var textYear=parseInt($(".ui-datepicker-year option").eq(j).val())+543;
                    $(".ui-datepicker-year option").eq(j).text(textYear);
                });             
            },50);
        },
        onChangeMonthYear: function(){
            setTimeout(function(){
                $.each($(".ui-datepicker-year option"),function(j,k){
                    var textYear=parseInt($(".ui-datepicker-year option").eq(j).val())+543;
                    $(".ui-datepicker-year option").eq(j).text(textYear);
                });             
            },50);      
        },
        onClose:function(){
            if($(this).val()!="" && $(this).val()==dateBefore){         
                var arrayDate=dateBefore.split("/");
                arrayDate[2]=parseInt(arrayDate[2])+543;
                $(this).val(arrayDate[0]+"/"+arrayDate[1]+"/"+arrayDate[2]);    
            }       
        },
        onSelect: function(dateText, inst){ 
            dateBefore=$(this).val();
            var arrayDate=dateText.split("/");
            arrayDate[2]=parseInt(arrayDate[2])+543;
            $(this).val(arrayDate[0]+"/"+arrayDate[1]+"/"+arrayDate[2]);
        }   
 
    });    
});
</script>
  </body>
</html>