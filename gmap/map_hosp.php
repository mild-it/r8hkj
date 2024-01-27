<?php
require('./../includes/connectDB.php');
require('./../functions/function.in.php');

$vars = array_merge($_GET,$_POST);array_walk_recursive($vars, function(&$item, $key) { $item = addslashes($item);});

CheckUser($_SESSION['admin_username'], $_SESSION['admin_password'],$text_encode);
if(! CheckLevel($_SESSION['admin_username'], 'input',$text_encode) ){
	die ("You can't access this file directly...");
}
$member_off_id = $_SESSION["member_officename"];

$sql="SELECT lat,lon  FROM geojson WHERE hcode='".$member_off_id."' ";
$query = $db->prepare($sql);
$query->execute();
$row = $query->fetchAll(PDO::FETCH_ASSOC); 
extract($row[0]);
?>
<!--connect to database -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-capable" content="yes" />
<!-- Apple devices fullscreen -->
<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<title>HDC - MAP</title>
<!--css-->
<?php require('./../themes/css/css.php');?>
<!--css-->
<!--jquery-->
<?php require ('./../themes/js/jquery.php');?>
<!--jquery-->
<!-- Favicon -->
<link rel="shortcut icon" href="./../themes/img/favicon.ico" />
<!-- Apple devices Homescreen icon -->
<link rel="apple-touch-icon-precomposed" href="./../themes/img/apple-touch-icon-precomposed.png" />

 <script async defer  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAaPq-TrV7M3snBr9GJRwP7ruQzLvoT4U&callback=myMaps"
  type="text/javascript"></script>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
 -->
<script type="text/javascript">

function myMaps() {
	var lat,lon;
	// var lat = 13.865312; 
	// var lon = 100.48187;
<?php
	if(is_null($lat) || is_null($lon) ){
?>		
		if (navigator.geolocation) {
		    navigator.geolocation.getCurrentPosition(
		    	function(position) {
            		lat =  position.coords.latitude;
              		lon =  position.coords.longitude ;
            		$('#mapsLat').val(position.coords.latitude);
					$('#mapsLng').val(position.coords.longitude);
					map(lat,lon);
          		 }
		    	, error
			);
		    lat = $('#mapsLat').val();
			lon = $('#mapsLng').val();
		} else {
		    alert('location not supported');
		}
<?php	
	} else{
?>		
		lat = <?php echo $lat;?> ; //13.865312;
		lon = <?php echo $lon;?> ; //100.48187;
		map(lat,lon);
<?php
	}
?>


}

function map(lat,lon) {
    var mapsGoo=google.maps;
	//set latitude ,longitude
	var Position=new mapsGoo.LatLng(lat,lon);
	var myOptions = {
	center:Position,
	zoom:18,
	mapTypeId: mapsGoo.MapTypeId.ROADMAP 
	};
	var map = new mapsGoo.Map(document.getElementById("map_canvas"),myOptions);
	var infowindow = new mapsGoo.InfoWindow();
	var marker = new mapsGoo.Marker({
		position: Position,
		draggable:true 
		//,title:"Hello World!"
		,icon:'../images/hospital-building.png'
	});

	//--
	var Posi=marker.getPosition();
	$('#mapsLat').val(Posi.lat());
	$('#mapsLng').val(Posi.lng());
	marker.setMap(map);
	//ตรวจจับเหตุการณ์ต่างๆ ที่เกิดใน google maps
	mapsGoo.event.addListener(marker, 'dragend', function(ev) {
		var location =ev.latLng;
		$('#mapsLat').val(location.lat());
		$('#mapsLng').val(location.lng());
	});
	
	mapsGoo.event.addListener(marker, 'click', function(ev) {
		var location =ev.latLng;
		$('#mapsLat').val(location.lat());
		$('#mapsLng').val(location.lng());
		infowindow.setContent('ละติจูด:'+location.lat()+'ลองติจูด:'+location.lng());
		infowindow.open(map, marker);
	});
	mapsGoo.event.addListener(map,'zoom_changed',function(ev){
		zoomLevel = map.getZoom();
		$('#mapsZoom').val(zoomLevel);
	});
	
}

function error(error) {
	var msg="";
	switch(error.code) {
        case error.PERMISSION_DENIED:
            msg = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            msg = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            msg = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            msg = "An unknown error occurred."
            break;
    }
    alert('error in geolocation >>>'+msg);
}

function success(position) {
    lat = position.coords.latitude;
    lon = position.coords.longitude;
    $('#mapsLat').val(position.coords.latitude);
	$('#mapsLng').val(position.coords.longitude);
    //alert(lat);
    //alert(lon);
};

$(document).ready(function(){
//	myMaps();
	$('#bt_savemaps').click(function(){ 
        url = 'map_hosp_save.php?'
                +'Hcode='+$('#hcode').val()
                +'&Lat='+$('#mapsLat').val()
                +'&Lng='+$('#mapsLng').val()
			    ;
//			alert(url);
				$.ajax({
                    url: url,
                    type: 'GET',
				
					success: function(data) {
                        $('#report').html(data);
					},
                    error: function(e) {
                          $('#report').html("มีข้อผิดพลาด กรุณาตรวจสอบ....<br/>"+e.message);
//						  alert(url);
                    }
                  });
	});
});

</script>
</head>
<body >
<?php require('./../includes/header.php');?>
<div class="container-fluid nav-hidden" id="content" >
<div class="col-sm-12">
<div class="box box-color">
 <div class="box-title" style=" background-color: #00a300;">
	   <h3 style="color: #00FFFFFF;">
		<i class="fa fa-th-list"></i>ตรวจสอบพิกัดของสถานพยาบาล
  </div>
</div>
<br/>

<div  class="col-sm-6" style="valign:middle;">
	<div  class="box-body table-responsive no-padding">
		<div id="map_canvas" style="width:650px; height:450px;"></div>
		<form action="" method="post">
			<div  class="col-sm-4">
			<input type="hidden"  id="hcode" value="<?php echo $member_off_id; ?>" />
			ละติจูด: <input type="text" size="20" id="mapsLat" />
			</div>
			<div  class="col-sm-4" >
			ลองติจูด <input type="text" size="20" id="mapsLng" />
			</div>
			<div  class="col-sm-4" >
			<br/>
			<input id="bt_savemaps" name="bt_savemaps" type="button" value="บันทึกข้อมูล" />
			</div>
		</form>
	</div>
</div>

<div  class="col-sm-6">
<h4><u>วิธีการใช้งาน</u></h4>
<ul>
<li>ใช้ Mouse จับที่หมุดรูปสถานพยาบาล <img src="./../images/hospital-building.png" height="25px" border="0" alt=""></li>
<li>เลื่อนตำแหน่งของหมุดให้ตรงกับตำแหน่งพิกัดของสถานพยาบาลของตนเอง </li>
<li>เลือกบันทึกเมื่อตรงพิกัดของสถานพยาบาลถูกต้อง</li>
<li>สามารถเปลี่ยนมุมมองในรูปแบบ Street View ได้เพื่อความแม่นยำ</li>
</ul>
<br/>
<div id="report" style=" margin: 6px 6px 6px 6px;"></div>
</div>
</div>
</div>

</body>
</html>