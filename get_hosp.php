<?php
include('connect.php');
$sql = "SELECT * FROM office WHERE provid={$_GET['provid']} AND off_type IN ('04', '05','06','07') ";
$query = mysqli_query($conn, $sql);

$json = array();
while($result1 = mysqli_fetch_assoc($query)) {    
    array_push($json, $result1);
}
echo json_encode($json);