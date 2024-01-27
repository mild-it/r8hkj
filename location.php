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
        <title>Map Location R8NDS</title>
        
        <style type="text/css">
          html{
            height:100%; 
          }
          body{ 
            margin:0px;
            height:100%; 
          }
          #map {
            width:900px;
            height:700px;
            margin:auto;  
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
          }
          
        </script>
    </head>
    <body onload="init();">
        </br>
        <div id="map"></div>
        <div style="margin:auto;padding-top:5px;width:550px;">  
        <h4><span class="badge bg-secondary"><?php echo $fn ?>&nbsp;&nbsp;<?php echo $ln ?></span></h4>
              <form method="post" action="location.php?act=3&cid_case=<?=$cid_case?>" enctype='multipart/form-data'>
                Latitude  
                <input name="lat_value" type="text" id="acc_lat" style="margin-top: 0.5rem; font-size: 2rem; font-size:25px;" />  <br />
                Longitude  
                <input name="lon_value" type="text" id="acc_long" style="margin-top: 0.5rem; font-size: 2rem; font-size:25px;" />  <br />
              <br />
              <button type="submit"  style="width:200px; height:100; font-size:30px;">บันทึก</button> 
              </form>  
        </div>
        <div class="form-group row" style="margin:auto;padding-top:5px;width:550px;">
              <div class="col-lg-12 ml-auto">
                  <button type="submit" class="btn btn-primary" style="width:200px; height:100; font-size:30px;"><a href="https://maps.google.com?saddr=Current+Location&daddr=<?=$lat1?>,<?=$long1?>" enctype='multipart/form-data'>เส้นทาง</a></button>
              </div>
        </div>
    </body>
    <?php
if($_REQUEST["act"]==3)
{
    include ("connectDB.php");
    include ("connect.php");
    $cid_case=$_REQUEST["cid_case"];
    $q1="SELECT * FROM caseDis WHERE cid = '$cid_case'";          
    $result1 = $mysqli->query($q1);                                                                   
    $rs1=$result1->fetch_object();
 //ถ้ามีค่าส่งมาจากฟอร์ม
    if(isset($_POST['lat_value']) && isset($_POST['lon_value'])){
    //ประกาศตัวแปรรับค่าจากฟอร์ม
    $lat_value = $_POST['lat_value'];
    $lon_value = $_POST['lon_value'];
    //sql insert
    $sql = "UPDATE caseDis SET lat = '$lat_value' , lon='$lon_value' where cid = '$cid_case'";
    $mysqli->query($sql);
     // sweet alert 
    
     echo '<script>
     setTimeout(function() {
      swal({
          title: "บันทึกพิกัดเรียบร้อย",
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
          title: "กรุณาอัพโหลดใหม่",
          text: "กรุณาอัพโหลดใหม่",
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
