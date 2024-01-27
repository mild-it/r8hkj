<?php
session_start();
if($_SESSION["levelx"] == "") {
header("Location: alert_pcu.php");
}
include ("connectDB.php");
include ("connect.php");
$cid_case=$_REQUEST["cid_case"];
$q="SELECT * FROM caseDis WHERE cid = '$cid_case'";
$result0 = mysqli_query($conn,$q);
$row = mysqli_fetch_array($result0);
$fn=$row['fname'];
$ln=$row['lname'];
$lat1=$row['lat'];
$long1=$row['lon'];
?>
<!DOCTYPE HTML>
<html>
  <head>
      <meta charset="UTF-8">
      <title>Map Routing Location R8NDS</title>
      <style type="text/css">
        html{
          height:100%; 
        }
        body{ 
          margin:0px;
          height:100%; 
        }
        #map {
          height: 100%;
        }
        #result {
          position: absolute;
          top: 0;
          bottom: 0;
          right: 0;
          width: 1px;
          height: 80%;
          margin: auto;
          border: 4px solid #dddddd;
          background: #ffffff;
          overflow: auto;
          z-index: 2;
      }
      </style>
      <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

      <script type="text/javascript" src="https://api.longdo.com/map/?key="></script>
      <script>
      var long = '<?=$long1?>';
          var lat = '<?=$lat1?>';
          var map;
          var Marker = new longdo.Marker({
            lon: long,
            lat: lat
          },{
            title: 'ตำแหน่งของคุณ',
            datail: 'อยู่ที่นี่'
          });
          function init() {
          var map = new longdo.Map({
                placeholder: document.getElementById('map'),
                zoom: 20,
                lasview: false,
                language: 'th'
            });
            map.location(longdo.LocationMode.Geolocation);
            var result = map.location();

            var lon_position = result.lon;
            var lat_position = result.lat;

            console.log("lat: "+ lat_position + "lon: "+ lon_position);

            var markGeolocation = new longdo.Marker({
              lon: long,
              lat: lat
            });

            var popup1 = new longdo.Popup({ lon: long, lat: lat },
            {
              title: 'พิกัดบ้านคนพิการ'
              // detail: ''
            });
            map.Event.bind('location', function () {
                var location = map.location(); // Cross hair location

                //console.log(location.lat);

                document.getElementById("acc_lat").value = location.lat;
                document.getElementById("acc_long").value = location.lon;
            });
            map.location(longdo.LocationMode.Geolocation);
            map.Overlays.add(markGeolocation);
            map.Overlays.add(popup1);
            // map.Overlays.bounce(markGeolocation) // Show bounce animation

            map.Route.placeholder(document.getElementById('result'));
            map.Route.add(new longdo.Marker({ lon: lon_position, lat: lat_position },
            ));
            map.Route.add({ lon: long, lat: lat });
            map.Route.search();
          }
          
        </script>
      
  </head>
  <body onload="init();">
      <div id="map"></div>
      <div id="result"></div>
  </body>
</html>
