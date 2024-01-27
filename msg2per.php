<?php
// Access Token
$access_token = '';
// User ID
$userId = '';
// ข้อความที่ต้องการส่ง
$messages = array(
    'type' => 'text',
    'text' => 'ถึง  กรุณาเปิดระบบVDO CAll ตามลิงค์นี้ ',
);
$post = json_encode(array(
    'to' => array($userId),
    'messages' => array($messages),
));
// URL ของบริการ Replies สำหรับการตอบกลับด้วยข้อความอัตโนมัติ
$url = 'https://api.line.me/v2/bot/message/multicast';
$headers = array('Content-Type: application/json', 'Authorization: Bearer '.$access_token);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
echo $result;