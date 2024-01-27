<?php
include('connect.php');
$sql = "SELECT * FROM amphures WHERE province_id={$_GET['province0_id']}";
$query = mysqli_query($conn, $sql);

$json = array();
while($result0 = mysqli_fetch_assoc($query)) {    
    array_push($json, $result0);
}
echo json_encode($json);