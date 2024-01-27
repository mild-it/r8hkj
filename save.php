<?php

session_start();


date_default_timezone_set("Asia/Bangkok");
$date = date("Y-m-d");
$time = date("H:i:s");


$serverName="127.0.0.1";
$userName="";
$userPassword="";
$dbName="";

$name = $_REQUEST['name'];
$samnak = $_REQUEST['samnak'];
$id = $_REQUEST['userid'];

$connect=mysqli_connect($serverName,$userName,$userPassword,$dbName)or die("connecterror".mysqli_error());
mysqli_set_charset($connect,"utf8");
$sql = "select user_id from register where user_id='$id' group by user_id";
$result = mysqli_query($connect,$sql) or die ("error".mysqli_error());
$count_row = mysqli_num_rows($result);
if($count_row < 1){

$query = "INSERT INTO register(user_id,name,samnak,date) VALUE ('$id', '$name','$samnak',NOW())";
$resource = mysqli_query($connect,$query) or die ("error".mysqli_error());
echo "<br/><br/>";
echo '<h1 align="center"><font color="red">*** ยินดีด้วยครับ คุณลงทะเบียนสำเร็จแล้ว ***</font></h1>';
echo '<h1 align="center"><font color="red"> กดที่เครื่องหมาย X มุมขวาบนเพื่อปิดหน้าต่างนี้</font></h1>';
}else{
echo '<h1 align="center"><font color="red">*** ขอโทษด้วยครับ คุณเคยลงทะเบียนแล้ว ***</font></h1>';
echo '<h1 align="center"><font color="red"> กดที่เครื่องหมาย X มุมขวาบนเพื่อปิดหน้าต่างนี้</font></h1>';
}
?>