<?php
session_start();
include('../connectDB.php');
$level = $_GET['level'];
if ($level == "pcu") {
    $sql_hos = "select off_id, off_name from office where provid = '$_SESSION[provinces]' and off_type in('04', '06', '07')";
    $result_hos = $mysqli->query($sql_hos);
    ?>
    <label for="hosp" class="col-form-label">เลือก รพ.</label>
    <select name="hosp_id" id="hosp" class="form-control" required>
        <option value="">-เลือก รพ.-</option>
        <?php
        while ($r_hos = mysqli_fetch_array($result_hos)) {
            echo "<option value='$r_hos[off_id]'>$r_hos[off_name]</option>";
        }
        ?>
    </select>
<?php
}
if ($level == "opt") {
    $sql_opt = "select tcode, hospname, ampname from tesaban where province = '$_SESSION[provinces]'";
    $result_opt = $mysqli->query($sql_opt);
    ?>
    <label for="opt" class="col-form-label">เลือก อบต./เทศบาล</label>
    <select name="opt" id="opt" class="form-control" required>
        <option value="">-เลือก-</option>
        <?php
        while ($r_opt = mysqli_fetch_array($result_opt)) {
            echo "<option value='$r_opt[tcode]'>[$r_opt[ampname]] $r_opt[hospname]</option>";
        }
        ?>
    </select>
<?php
}
?>