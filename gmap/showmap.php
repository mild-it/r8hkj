<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Google Map API 3 - 01</title>
<style type="text/css">
html { height: 100% }
body { 
    height:100%;
    margin:0;padding:0;
    font-family:tahoma, "Microsoft Sans Serif", sans-serif, Verdana;
    font-size:12px;
}
/* css กำหนดความกว้าง ความสูงของแผนที่ */
#map_canvas { 
    width:640px;
    height:400px;
    margin:auto;
/*  margin-top:100px;*/
}
</style>
 <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="jquery-1.11.2.min.js" ></script>

<script language="JavaScript">


function saveLatLng(){

var lat_value = $("#lat_value").val();
var lon_value = $("#lon_value").val();

$.ajax({
method : "POST",
url: "editlatlon.php",
data: { lat_value:lat_value, lon_value:lon_value}
}).done(function(text){

alert("แก้ไขพิกัดเรียบร้อยแล้ว");

});

}
</script>
 
</head>
<?php
function getaddress($lat,$lng)
{
$url = '//maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
$json = @file_get_contents($url);
$data=json_decode($json);
$status = $data->status;
if($status=="OK") return $data->results[0]->formatted_address;
else
return false;
}
$lat=$_POST[17.32613494329945];
$lng=$_POST[102.07574549121091];
$address= getaddress($lat,$lng);
if($address)
{
echo $address;
}
else
{
echo "Not found";
}
?>


<?
mysql_connect("209.15.96.46","ndsr8","R8411113##nds") or die(mysql_error());
mysql_select_db("r8nds") or die(mysql_error());

session_start(); 

$cid_case=$_REQUEST['cid_case'];

 $xy = mysql_fetch_array(mysql_query("SELECT * FROM caseDis WHERE cid= '$cid_case' "));
$lat1=$xy['lat'];
$long1=$xy['long'];
 if($lat1 <=0 | $long1<=0){$latlong='17.32613494329945,102.07574549121091';}else{$latlong=$lat1.','.$long1;}
 echo "<center>พิกัด=$latlong";
// echo "//$hid //$hospcode";
?>


 
<body>
  <div id="map_canvas"></div>
 <div id="showDD" style="margin:auto;padding-top:5px;width:550px;">  
  <form id="form_get_detailMap" name="form_get_detailMap" method="post" action="">  
    Latitude  
    <input name="lat_value" type="text" id="lat_value" value="0" size="15" />  
    Longitude  
    <input name="lon_value" type="text" id="lon_value" value="0" size="15" /> 
  <!-- Zoom   -->
  <!-- <input name="zoom_value" type="text" id="zoom_value" value="0" size="2" />   -->
  <input type="submit" name="button" id="button" value="บันทึกพิกัด" onclick="saveLatLng()" />  
  </form>  
</div> 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>  
<script type="text/javascript">
var map; // กำหนดตัวแปร map ไว้ด้านนอกฟังก์ชัน เพื่อให้สามารถเรียกใช้งาน จากส่วนอื่นได้
var GGM; // กำหนดตัวแปร GGM ไว้เก็บ google.maps Object จะได้เรียกใช้งานได้ง่ายขึ้น
function initialize() { // ฟังก์ชันแสดงแผนที่
    GGM=new Object(google.maps); // เก็บตัวแปร google.maps Object ไว้ในตัวแปร GGM
    // กำหนดจุดเริ่มต้นของแผนที่
    var my_Latlng  = new GGM.LatLng(<?=$latlong?>);
    var my_mapTypeId=GGM.MapTypeId.ROADMAP; // กำหนดรูปแบบแผนที่ที่แสดง
    // กำหนด DOM object ที่จะเอาแผนที่ไปแสดง ที่นี้คือ div id=map_canvas
    var my_DivObj=$("#map_canvas")[0]; 
    // กำหนด Option ของแผนที่
    var myOptions = {
        zoom: 14, // กำหนดขนาดการ zoom
        center: my_Latlng , // กำหนดจุดกึ่งกลาง
        mapTypeId:my_mapTypeId // กำหนดรูปแบบแผนที่
    };
    map = new GGM.Map(my_DivObj,myOptions);// สร้างแผนที่และเก็บตัวแปรไว้ในชื่อ map
     
    var my_Marker = new GGM.Marker({ // สร้างตัว marker
        position: my_Latlng,  // กำหนดไว้ที่เดียวกับจุดกึ่งกลาง
        map: map, // กำหนดว่า marker นี้ใช้กับแผนที่ชื่อ instance ว่า map
        draggable:true, // กำหนดให้สามารถลากตัว marker นี้ได้
        title:"คลิกลากเพื่อหาตำแหน่งจุดที่ต้องการ!" // แสดง title เมื่อเอาเมาส์มาอยู่เหนือ
    });
     
    // กำหนด event ให้กับตัว marker เมื่อสิ้นสุดการลากตัว marker ให้ทำงานอะไร
    GGM.event.addListener(my_Marker, 'dragend', function() {
        var my_Point = my_Marker.getPosition();  // หาตำแหน่งของตัว marker เมื่อกดลากแล้วปล่อย
        map.panTo(my_Point);  // ให้แผนที่แสดงไปที่ตัว marker       
        $("#lat_value").val(my_Point.lat());  // เอาค่า latitude ตัว marker แสดงใน textbox id=lat_value
        $("#lon_value").val(my_Point.lng()); // เอาค่า longitude ตัว marker แสดงใน textbox id=lon_value 
        $("#zoom_value").val(map.getZoom()); // เอาขนาด zoom ของแผนที่แสดงใน textbox id=zoom_value
    });     
 
    // กำหนด event ให้กับตัวแผนที่ เมื่อมีการเปลี่ยนแปลงการ zoom
    GGM.event.addListener(map, 'zoom_changed', function() {
        $("#zoom_value").val(map.getZoom()); // เอาขนาด zoom ของแผนที่แสดงใน textbox id=zoom_value  
    });
 
}
$(function(){
    // โหลด สคริป google map api เมื่อเว็บโหลดเรียบร้อยแล้ว
    // ค่าตัวแปร ที่ส่งไปในไฟล์ google map api
    // v=3.2&sensor=false&language=th&callback=initialize
    //  v เวอร์ชัน่ 3.2
    //  sensor กำหนดให้สามารถแสดงตำแหน่งทำเปิดแผนที่อยู่ได้ เหมาะสำหรับมือถือ ปกติใช้ false
    //  language ภาษา th ,en เป็นต้น
    //  callback ให้เรียกใช้ฟังก์ชันแสดง แผนที่ initialize
    $("<script/>", {
      "type": "text/javascript",
  //       src: "//maps.google.com/maps/api/js?v=3.1&sensor=false&language=th&callback=initialize"
           src: "https://maps.googleapis.com/maps/api/js?key=AIzaSyD3IXsCbKMUNOCd-m6Rl7S7QrJjUIgGfhs&callback=initialize"

	}).appendTo("body");    
});
</script>  


</body>
</html>
