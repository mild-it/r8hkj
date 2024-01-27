<?
session_start(); 
$cid_case=$_SESSION['cid_case'];
$lat=$_REQUEST['lat_value'];
$lon=$_REQUEST['lon_value'];

mysql_connect("209.15.96.46","ndsr8","R8411113##nds") or die(mysql_error());
mysql_select_db("r8nds") or die(mysql_error());
$cs1 = "SET character_set_results=utf8"; 
$cs2 = "SET character_set_client = utf8"; 
$cs3 = "SET character_set_connection = utf8"; 
@mysql_query($cs1) or die('Error query: ' . mysql_error()); 
@mysql_query($cs2) or die('Error query: ' . mysql_error()); 
@mysql_query($cs3) or die('Error query: ' . mysql_error()); 


mysql_query("UPDATE caseDis SET lat='$lat',long='$lon' where cid='$cid_case' ");



?>