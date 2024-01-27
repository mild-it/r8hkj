<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Create Connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn -> set_charset("utf8");

// Check connection
if (!$conn) {
    die("Connection failed" . mysqli_connect_error());
}
?>