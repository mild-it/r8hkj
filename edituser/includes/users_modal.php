<!-- Add Users-->

<div class="modal fade" id="addnew" tabindex="-1" aria-labelledby="addnewLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addnewLabel">Add New</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="users_add.php">
                    <div class="mb-3">
                        <label for="email" class="col-form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="bc-add" value="boychawin.com" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Edit Users-->

<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLabel">แก้ไขสิทธิ์การเข้าใช้งานเว็บไซต์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="users_edit.php">
                    <input type="hidden" class="bcId" name="id">
                    <div class="mb-3">
                        <label for="edit_email" class="col-form-label">ชื่อ</label>
                        <input type="text" class="form-control" id="username" name="username" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="col-form-label">สกุล</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="level" class="col-form-label">ระดับผู้ใช้งาน</label>
                        <select name="level" id="level" class="form-control" required>
                            <option value="pcu">รพ.</option>
                            <option value="pmj">พมจ.</option>
                            <option value="opt">อบต./เทศบาล</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="statusUser" class="col-form-label">การอนุญาต</label>
                            <select name="statusUser" id="statusUser" class="form-control" required>
                                <option value="a">อนุญาต</option>
                                <option value="">ไม่อนุญาต</option>
                           </select>
                    </div>
                           
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="bc-edit" value="boychawin.com" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Delete Users-->

<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteLabel">ลบผู้ใช้งาน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="users_delete.php">
                    <input type="hidden" class="bcId" name="id">
                    <div class="text-center">
                        <b class="del_username"></b>
                        <b class="del_lastname"></b>
                        <b class="del_email"></b>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="bc-delete" value="boychawin.com" class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
