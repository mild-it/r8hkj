<?php
session_start();
if ($_SESSION["levelx"] != "admin") {
    header("Location: ../page-login.php");
}
include('../connectDB.php');
$id = $mysqli->real_escape_string($_GET['id']);
$sql = "select * from member where id = '$id' and (provinces = '$_SESSION[provinces]' or provinces_pmj = '$_SESSION[provinces]' or provinces_opt = '$_SESSION[provinces]' or provinces_pcu2 = '$_SESSION[provinces]')";
$result = $mysqli->query($sql);
$r = mysqli_fetch_array($result);
?>
<form method="POST" action="users_edit.php">
    <input type="hidden" class="bcId" name="id" value="<?php echo $id; ?>">
    <div class="mb-3">
        <label for="username" class="col-form-label">ชื่อ</label>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo $r["username"]; ?>">
    </div>
    <div class="mb-3">
        <label for="lastname" class="col-form-label">สกุล</label>
        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $r["lastname"]; ?>">
    </div>
    <div class="mb-3">
        <label for="level" class="col-form-label">ระดับผู้ใช้งาน</label>
        <select name="level" id="level" class="form-control" required onchange="LoadDepartment(this.value)">
            <option value="pcu" <?php if ($r["level"] == "pcu") { echo "selected"; } ?>>รพ.</option>
            <option value="pmj" <?php if ($r["level"] == "pmj") { echo "selected"; } ?>>พมจ.</option>
            <option value="opt" <?php if ($r["level"] == "opt") { echo "selected"; } ?>>อบต./เทศบาล</option>
            <!-- <option value="etc" <?php if ($r["level"] == "etc") { echo "selected"; } ?>>ประชาชน</option> -->
            <option value="pcu1" <?php if ($r["level"] == "pcu1") { echo "selected"; } ?>>อสม.</option>
            <option value="pcu2" <?php if ($r["level"] == "pcu2") { echo "selected"; } ?>>รพ.สต.</option>
<!--             <option value="obj" <?php if ($r["level"] == "obj") { echo "selected"; } ?>>อบจ.</option> -->
            <option value="admin" <?php if ($r["level"] == "admin") { echo "selected"; } ?>>Admin</option>
        </select>
    </div>
    <div class="mb-3" id="tDepartment">
        <?php
        if ($r["level"] == "pcu") {
            $sql_hos = "select off_id, off_name from office where provid = '$_SESSION[provinces]' and off_type in('04', '06', '07')";
            $result_hos = $mysqli->query($sql_hos);
        ?>
            <label for="hosp" class="col-form-label">เลือก รพ.</label>
            <select name="hosp_id" id="hosp" class="form-control" required>
                <option value="">-เลือก รพ.-</option>
                <?php
                while ($r_hos = mysqli_fetch_array($result_hos)) {
                    if ($r["hospcode"] == $r_hos["off_id"]) {
                        echo "<option value='$r_hos[off_id]' selected>$r_hos[off_name]</option>";
                    } else {
                        echo "<option value='$r_hos[off_id]'>$r_hos[off_name]</option>";
                    }
                }
                ?>
            </select>
        <?php
        }
        if ($r["level"] == "opt") {
            $sql_opt = "select tcode, hospname, ampname from tesaban where province = '$_SESSION[provinces]'";
            $result_opt = $mysqli->query($sql_opt);
        ?>
            <label for="opt" class="col-form-label">เลือก อบต./เทศบาล</label>
            <select name="opt" id="opt" class="form-control" required>
                <option value="">-เลือก-</option>
                <?php
                while ($r_opt = mysqli_fetch_array($result_opt)) {
                    if ($r["opt"] == $r_opt["tcode"]) {
                        echo "<option value='$r_opt[tcode]' selected>[$r_opt[ampname]] $r_opt[hospname]</option>";
                    } else {
                        echo "<option value='$r_opt[tcode]'>[$r_opt[ampname]] $r_opt[hospname]</option>";
                    }
                }
                ?>
            </select>
        <?php
        }
        ?>
    </div>
    <div class="mb-3">
        <label for="statusUser" class="col-form-label">การอนุญาต</label>
            <select name="statusUser" id="statusUser" class="form-control" required>
                <option value="a" <?php if ($r["statusUser"] == "a")  { echo "selected"; } ?>>อนุญาต</option>
                <option value="" <?php if ($r["statusUser"] == "")  { echo "selected"; } ?>>ไม่อนุญาต</option>
            </select>
    </div>
            
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="bc-edit" value="boychawin.com" class="btn btn-primary">Update</button>
    </div>
</form>
