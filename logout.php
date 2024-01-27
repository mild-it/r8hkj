<?php
session_start();
session_destroy();
$_SESSION["levelx"] = '';
header("Location: page-login.php");
?>