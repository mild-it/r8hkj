<?php
session_start();
require_once("LoginLib.php");
 
// กรณีต้องการตรวจสอบการแจ้ง error ให้เปิด 3 บรรทัดล่างนี้ให้ทำงาน กรณีไม่ ให้ comment ปิดไป
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
// กรณีมีการเชื่อมต่อกับฐานข้อมูล
//require_once("dbconnect.php");
 
/// ส่วนการกำหนดค่านี้สามารถทำเป็นไฟล์ include แทนได้
define('LINE_LOGIN_CHANNEL_ID','');
define('LINE_LOGIN_CHANNEL_SECRET','');
define('LINE_LOGIN_CALLBACK_URL','https://.moph.go.th/r8nds/login_callback.php'); //ใส่ url ของ web server
 
$LineLogin = new LineLoginLib(
    LINE_LOGIN_CHANNEL_ID, LINE_LOGIN_CHANNEL_SECRET, LINE_LOGIN_CALLBACK_URL);
     
// กรณีต้องการดึงค่าเฉพาะ access token ไปใช้งาน
/*$accToken = $LineLogin->requestAccessToken($_GET);
if(isset($accToken) && is_string($accToken)){
    $_SESSION['ses_login_accToken_val'] = $accToken;
}*/
 
// กรณีต้องการดึงค่าเฉพาะ access token และค่าอื่นๆ รวมถึงข้อมูลผู้ใช้ เช่น userId ในไลน์ ไปใช้งาน
$dataToken = $LineLogin->requestAccessToken($_GET, true);
if(!is_null($dataToken) && is_array($dataToken)){
    if(array_key_exists('access_token',$dataToken)){
        $_SESSION['ses_login_accToken_val'] = $dataToken['access_token'];
    }
    if(array_key_exists('refresh_token',$dataToken)){
        $_SESSION['ses_login_refreshToken_val'] = $dataToken['refresh_token'];
    }   
    if(array_key_exists('id_token',$dataToken)){
        $_SESSION['ses_login_userData_val'] = $dataToken['user'];
    }      
}
$LineLogin->redirect('check_login_rpst.php'); 

?>




