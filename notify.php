<?php
// echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
include ("connectDB.php");
include ("connect.php");

$province='39';

$mysqli->query("DROP TABLE notify");

$mysqli->query("CREATE TABLE notify SELECT 0 as xtype,tcode,hospname,villcode as n FROM tesaban WHERE province='$province' group by tcode");
$mysqli->query("INSERT IGNORE notify SELECT 1,off_id,off_name,0 FROM office WHERE provid='$province' and off_type IN('05','06','07') group by off_id");
$mysqli->query("INSERT INTO notify value(2,0,'พมจ.',0)");

$mysqli->query("UPDATE notify SET n=0");

$mysqli->query("UPDATE notify a SET a.n=(SELECT count(*) FROM caseDis b WHERE b.hospcode=a.tcode and b.statusCase IN('HOS','DOC') and left(tambol,2)='$province') WHERE a.xtype=1");
$mysqli->query("UPDATE notify a SET a.n=(SELECT count(*) FROM caseDis b WHERE b.obt=a.tcode and b.statusCase IN('OBT') and left(tambol,2)='$province') WHERE a.xtype=0");
$mysqli->query("UPDATE notify a SET a.n=(SELECT count(*) FROM caseDis b WHERE b.statusCase IN('PMJ') and left(tambol,2)='$province') WHERE a.xtype=2");
$mysqli->query("DELETE FROM notify WHERE n=0");

@$notify.= "==ระบบแจ้งเตือนอัตโนมัติ== \n หน่วยงานที่ยังมีเคสติดตาม ดังนี้";
@$rpt=0;
$sql = "SELECT * from notify";
			$result = mysqli_query($conn,$sql);																							
    		while($row = mysqli_fetch_array($result)) 
    		{
					$hospname=$row['hospname'];
          $n=$row['n'];
          $notify.= "\n $hospname จำนวน $n  เคส";
				  $rpt=1;
        }

if($rpt==0){$notify="==ระบบแจ้งเตือนอัตโนมัติ== \n ==วันนี้ไม่มีเคสให้ติดตาม (WOW!!)==";}
//line notify------------------
//$token = "pQ65v4EHGjaJtUkZe48xMimpczXar5eqxihCKm6RX2N"; 
function send_line_notify($message, $token)
{
  $ch = curl_init();
  curl_setopt( $ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
  curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt( $ch, CURLOPT_POST, 1);
  curl_setopt( $ch, CURLOPT_POSTFIELDS, "message=$message");
  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
  $headers = array( "Content-type: application/x-www-form-urlencoded", "Authorization: Bearer $token", );
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
  $result = curl_exec( $ch );
  curl_close( $ch );

  return $result;
}
// echo $notify;
$message = $notify;
$token = ''; //ระบุ TOKEN line Notify

echo send_line_notify($message, $token);

//-end line notify---------------------------


?>
