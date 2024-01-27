<?php
	include 'includes/session.php';

	if(isset($_POST['bc-delete'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("DELETE FROM member WHERE id=$id");
			$stmt->execute(['id'=>$id]);

			$_SESSION['success'] = 'ลบข้อมูลผู้ใช้งานเรียบร้อย';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Check the information completely.';
	}

	header('location: user.php');
	
?>