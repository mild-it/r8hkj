<?php
session_start();
if ($_SESSION["levelx"] != "admin") {
    header("Location: ../page-login.php");
}
include('../connectDB.php');
$id = $mysqli->real_escape_string($_POST['id']);
$username = $mysqli->real_escape_string($_POST['username']);
$lastname = $mysqli->real_escape_string($_POST['lastname']);
$level = $mysqli->real_escape_string($_POST['level']);
$hosp_id = $mysqli->real_escape_string($_POST['hosp_id']);
$opt = $mysqli->real_escape_string($_POST['opt']);
$statusUser = $mysqli->real_escape_string($_POST['statusUser']);

$sql = "update member set username = '$username', lastname = '$lastname', level = '$level', statusUser = '$statusUser'";
if ($level == "pcu") {
	$sql .= ", hospcode = '$hosp_id', provinces = '$_SESSION[provinces]', provinces_pmj = '', provinces_opt = ''";
}
if ($level == "pmj") {
	$sql .= ", hospcode = '', provinces = '', provinces_pmj = '$_SESSION[provinces]', provinces_opt = ''";
}
if ($level == "opt") {
	$sql .= ", hospcode = '', provinces = '', opt = '$opt', provinces_pmj = '', provinces_opt = '$_SESSION[provinces]'";
}
if ($level == "etc") {
	$sql .= ", hospcode = '', provinces = '$_SESSION[provinces]', opt = '', provinces_pmj = '', provinces_opt = ''";
}
if ($level == "pcu1") {
	$sql .= ", hospcode = '',pcu1 = '',pcu2 = '', provinces = '$_SESSION[provinces]', opt = '', provinces_pmj = '', provinces_opt = '',provinces_pcu1 = '',provinces_pcu2 = '',provinces_obj = ''";
}
if ($level == "pcu2") {
	$sql .= ", hospcode = '',pcu1 = '',pcu2 = '', provinces = '$_SESSION[provinces]', opt = '', provinces_pmj = '', provinces_opt = '',provinces_pcu1 = '',provinces_pcu2 = '',provinces_obj = ''";
}
if ($level == "admin") {
	$sql .= ", hospcode = '', provinces = '$_SESSION[provinces]', opt = '', provinces_pmj = '', provinces_opt = ''";
}
$sql .= " where id = '$id'";
$result = $mysqli->query($sql);
if ($result) {
	$_SESSION['success'] = 'แก้ไขเรียบร้อย';
} else {
	$_SESSION['error'] = 'ไม่สามารถแก้ไขข้อมูลได้';
}

header('location: user.php');
// include 'includes/session.php';

// if (isset($_POST['bc-edit'])) {
// 	$id = $_POST['id'];
// 	$username = $_POST['username'];
// 	$lastname = $_POST['lastname'];
// 	$statusUser = $_POST['statusUser'];

// 	$conn = $pdo->open();
	
// 	try {
// 		$stmt = $conn->prepare("UPDATE member SET username = '$username', lastname = '$lastname', statusUser = '$statusUser' WHERE id = $id");
// 		$stmt->execute(['username'=>$username, 'lastname'=>$lastname, 'statusUser'=>$statusUser, 'id'=>$id]);
// 		$_SESSION['success'] = 'แก้ไขเรียบร้อย';
// 	}
// 	catch(PDOException $e) {
// 		$_SESSION['error'] = $e->getMessage();
// 	}
	
// 	$pdo->close();
// }
// else{
// 	$_SESSION['error'] = 'Check the information completely.';
// }

// header('location: user.php');

?>
