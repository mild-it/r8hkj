<?php
include 'includes/session.php';
if ($_SESSION["levelx"] != "admin") {
    header("Location: ../page-login.php");
}
?>

<?php
if ($_REQUEST['act'] == 1) { 
	session_destroy();
	$_SESSION["levelx"] = '';
	header("Location: ../page-login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>กำหนดสิทธิ์เข้าใช้งาน</title>
	<!-- Fontawesome -->
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
	<link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
	<!-- Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<!-- Toastr -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />

	<link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
</head>

<body>
	<!-- container -->
	<div class="container mt-5">
		<div class="row">
			<div class="col-12">
				<div class="jumbotron">
					<p class="lead">กำหนดสิทธิ์เข้าใช้งาน</p>
					<!-- <hr class="my-4"> -->
				</div>
			</div>
		</div>
	</div>
	<div class="container-sm">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<!-- <div class="card-header bg-transparent">
						<a type=" button" href="#addnew" class="btn btn-primary btn-sm btn-flat" data-bs-toggle="modal" data-bs-target="#addnew"><i class="fas fa-plus-square"></i></a>
					</div> -->
					<div align ="right" >
						<a href="user.php?act=1" class="btn btn-success"><span>ออกจากระบบ</span></a>						
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="tableData" class="table table-striped">
								<thead>
									<th>ชื่อ</th>
									<th>สกุล</th>
									<th>Email</th>
									<th>รพ.</th>
									<th>รพ.สต</th>
									<th>อปท.</th>
									<th>ระดับผู้ใช้งาน</th>
									<th>สถานะ</th>
									<th>Action</th>
								</thead>
								<tbody>
									<?php
									$conn = $pdo->open();
									try {
										$sql_stmp = "SELECT *,
										case when `level` = 'pcu' then 'รพ.'
											when `level` = 'pmj' then 'พมจ.'
											when `level` = 'opt' then 'อบต./เทศบาล'
											when `level` = 'pcu2' then 'รพ.สต'
											when `level` = 'admin' then 'Admin'
											end as level_name,
											case when statusUser = 'a' then 'Active' else '' end as status_name
										FROM member where provinces = '$provinces' or provinces_pmj = '$provinces' or provinces_opt = '$provinces' or provinces_pcu2 = '$provinces' order by statusUser, username";
										$stmt = $conn->prepare($sql_stmp);
										// $stmt = $conn->prepare("SELECT * FROM member where provinces = '$provinces' or provinces_pmj = '$provinces' or provinces_opt = '$provinces' order by statusUser, username");
										$stmt->execute();
										foreach ($stmt as $row) {
											echo "<tr>
												<td>".$row['username']."</td>
												<td>".$row['lastname']."</td>
												<td>".$row['email']."</td>
												<td>".$row['hospcode']."</td>
												<td>".$row['pcu2']."</td>
												<td>".$row['opt']."</td>
												<td>".$row['level_name']."</td>
												<td>".$row['status_name']."</td>
												<td>
													<button class='btn btn-success btn-sm edit_member btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i></button>
													<button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['id']."'><i class='fa fa-trash'></i></button>
												</td>
											</tr>";
											// echo "<button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i></button>";
										}
									} catch (PDOException $e) {
										echo $e->getMessage();
									}
									$pdo->close();
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="edit_member" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editLabel">แก้ไขสิทธิ์การเข้าใช้งานเว็บไซต์</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" id="body_edit_member">
						
					</div>
				</div>
			</div>
		</div>

		<?php include 'includes/users_modal.php'; ?>
	</div>

	<?php include 'includes/scripts.php'; ?>
	<script src="../dist/js/jquery-3.5.1.js"></script>
	<script src="../dist/js/jquery.dataTables.min.js"></script>
	<script src="../dist/js/dataTables.bootstrap5.min.js"></script>
	<script>
		$(function() {
			$(document).on('click', '.edit_member', function(e) {
				e.preventDefault();
				var id = $(this).data('id');
				$("#body_edit_member").load("users_edit_modal.php?id=" + id);
				// console.log(id);
				$('#edit_member').modal('show');
			});

			$(document).on('click', '.edit', function(e) {
				e.preventDefault();
				$('#edit').modal('show');
				var id = $(this).data('id');
				getData(id);
				console.log(id);
			});

			$(document).on('click', '.delete', function(e) {
				e.preventDefault();
				$('#delete').modal('show');
				var id = $(this).data('id');
				console.log(id);
				getData(id);
			});

		});

		function getData(id) {
			$.ajax({
				type: 'POST',
				url: 'users_data.php',
				data: {
					id: id
				},
				dataType: 'json',
				success: function(response) {
					$('.bcId').val(response.id);
					$('#username').val(response.username);
					$('.del_username').html(response.username);
					$('#lastname').val(response.lastname);
					$('.del_lastname').html(response.lastname);
					$('#email').val(response.email);
					$('.del_email').html(response.email);
				}
			});
		}

		function LoadDepartment(v) {
			$("#tDepartment").load("load_department.php?level=" + v);
		}

		$(document).ready(function () {
			$('#tableData').DataTable();
		});
	</script>
</body>

</html>
