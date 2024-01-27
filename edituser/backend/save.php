<?php
include 'DB.php';

// if(count($_POST)>0){
// 	if($_POST['type']==1){
// 		$vname=$_POST['vname'];
// 		$tbname=$_POST['tbname'];
// 		$hname=$_POST['hospname'];
// 		$amper=$_POST['ampername'];
// 		$tcode=$_POST['tcode'];
// 		$sql = "INSERT INTO `tesaban`( `villname`, `tambolname`,`hospname`,`ampername`,`tcode`) 
// 		VALUES ('$vname','$tbname','$hname','$amper','$tcode')";
// 		if (mysqli_query($conn, $sql)) { echo json_encode(array("statusCode"=>200));	} 
// 		else { echo "Error: " . $sql . "<br>" . mysqli_error($conn);	}
// 		mysqli_close($conn);
// 	}
// }
if(count($_POST)>0){
	if($_POST['type']==2){
		$id=$_POST['id'];
		$statusUser=$_POST['statusUser'];
	
		$sql = "UPDATE member SET statusUser ='$statusUser' WHERE id=$id";
		if (mysqli_query($conn, $sql)) {	echo json_encode(array("statusCode"=>200));	} 
		else {	echo "Error: " . $sql . "<br>" . mysqli_error($conn);		}
		mysqli_close($conn);
	}
}
if(count($_POST)>0){
	if($_POST['type']==3){
		$id=$_POST['id'];
		$sql = "DELETE FROM member WHERE id=$id ";
		if (mysqli_query($conn, $sql)) {	echo $id; }  else {	echo "Error: " . $sql . "<br>" . mysqli_error($conn); 	}
		mysqli_close($conn);
	}
}
if(count($_POST)>0){
	if($_POST['type']==4){
		$id=$_POST['id'];
		$sql = "DELETE FROM member WHERE id in ($id)";
		if (mysqli_query($conn, $sql)) {	echo $id;		}  else {	echo "Error: " . $sql . "<br>" . mysqli_error($conn);		}
		mysqli_close($conn);
	}
}

?>