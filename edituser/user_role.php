<?php 
session_start();
include 'backend/DB.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>จัดการผู้ใช้งาน</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="ajax/ajax.js"></script>
</head>
<body>
    <div class="container">
	<p id="success"></p>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
						<h2>ผู้ใช้งาน</h2>
					</div>
					<!-- <div class="col-sm-6">
						<a href="#addModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>เพิ่มผู้ใช้งาน</span></a>
						<a href="JavaScript:void(0);" class="btn btn-danger" id="delete_multiple"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>						
					</div> -->
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
						<!-- <th>
							<span class="custom-checkbox">
								<input type="checkbox" id="selectAll">
								<label for="selectAll"></label>
							</span>
						</th> -->
						<th>NO</th>
                        <th>ชื่อ</th>
                        <th>สกุล</th>
						<th>email</th>
                        <th>รพ.</th>
						<th>อปท.</th>
						<th>ระดับผู้ใช้งาน</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
				
				<tbody>
				<?php
				session_start();
				include 'backend/DB.php';
				$result = mysqli_query($conn,"SELECT * FROM member Order by id asc");
					$i=1;
					while($row = mysqli_fetch_array($result)) {
				?>
				<tr id="<?php echo $row["id"]; ?>">

					<td><?php echo $i; ?></td>
					<td><?php echo $row["username"]; ?></td>
					<td><?php echo $row["lastname"]; ?></td>
					<td><?php echo $row["email"]; ?></td>
					<td><?php echo $row["hospcode"]; ?></td>
					<td><?php echo $row["opt"]; ?></td>
					<td><?php echo $row["level"]; ?></td>
					<td><?php echo $row["statusUser"]; ?></td>
					
					<td>
						<a href="#editModal" class="edit" data-toggle="modal">
							<i class="material-icons update" data-toggle="tooltip" 
							data-id="<?php echo $row["id"]; ?>"
							data-vname="<?php echo $row["username"]; ?>"
							data-tbname="<?php echo $row["lastname"]; ?>"
							data-hname="<?php echo $row["email"]; ?>"
							data-amper="<?php echo $row["hospcode"]; ?>"
							data-tcode="<?php echo $row["opt"]; ?>"
							title="Edit">&#xE254;</i>
						</a>
						<!-- <a href="#deleteModal" class="delete" data-id="<?php echo $row["id"]; ?>" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" 
						 title="Delete">&#xE872;</i></a> -->
                    </td>
				</tr>
				<?php
				$i++;
				}
				?>
				</tbody>
			</table>
        </div>
    </div>

	<!-- Add Modal HTML -->
	<div id="addModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="user_form" >
					<div class="modal-header">						
						<h4 class="modal-title">เพิ่มหมู่บ้านในเขตอปท.</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<div class="form-group">
							<label>ชื่อหมู่บ้าน</label>
							<input type="text" id="vname" name="vname" class="form-control" required>
						</div>
						<div class="form-group">
							<label>ตำบล</label>
							<input type="text" id="tbname" name="tbname" class="form-control" required>
						</div>
						<div class="form-group">
							<label>หน่วยงานอปท.(เทศบาล/อบต.)</label>
							<input type="text" id="hname" name="hname" class="form-control" required>
						</div>
						<div class="form-group">
							<label>อำเภอ</label>
							<input type="text" id="amper" name="amper" class="form-control" required>
						</div>					
					<div class="form-group">
							<label>รหัสอปท.</label>
							<input type="text" id="tcode" name="tcode" class="form-control" required>
						</div>					
					</div>
					<div class="modal-footer">
					    <input type="hidden" value="1" name="type">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<button type="button" class="btn btn-success" id="btn-add">Add</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Edit Modal HTML -->
	<div id="editModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="update_form">
					<div class="modal-header">						
						<h4 class="modal-title">แก้ไขสิทธิ์การเข้าใช้งานเว็บไซต์</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<input type="hidden" id="id_u" name="id" class="form-control" readonly>					
						<div class="form-group">
							<label>ชื่อ</label>
							<input type="text" id="vname_u" name="vname" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label>สกุล</label>
							<input type="text" id="tbname_u" name="tbname" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label>email</label>
							<input type="text" id="hname_u" name="hname" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label>รหัส รพ.</label>
							<input type="text" id="amper_u" name="amper" class="form-control" readonly>
						</div>		
						<div class="form-group">
							<label>รหัสอปท.</label>
							<input type="text" id="tcode_u" name="tcode" class="form-control" readonly>
						</div>	
						<div class="form-group">
						<label>สิทธิ์ในการเข้าใช้งาน</label>
                    		<select name="statusUser" id="statusUser" class="form-control" required>
                           <option value="a">อนุญาต</option>
                           <option value="">ไม่อนุญาต</option>
                           </select>

					</div>
					<div class="modal-footer">
					<input type="hidden" value="2" name="type">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<button type="button" class="btn btn-info" id="update">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Delete Modal HTML -->
	<div id="deleteModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
						
					<div class="modal-header">						
						<h4 class="modal-title">Delete Record</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<input type="hidden" id="id_d" name="id" class="form-control">					
						<p>Are you sure you want to delete these Records?</p>
						<p class="text-warning"><small>This action cannot be undone.</small></p>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<button type="button" class="btn btn-danger" id="delete">Delete</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</body>
</html>                                		                            