<?php
if ($_SESSION['sess_counter_case_province'] == "") {
    $_SESSION['sess_counter_case_province'] = 0;
}
$fname = "counter_case_province.txt";
$f = fopen($fname, "r");
$data = fread($f, 5);
fclose($f);

if ($_SESSION['sess_counter_case_province'] == 0) {
    $data++;
    $f = fopen($fname, "w");
    fputs($f, $data);
    fclose($f);
}

// $data = sprintf("%06d", $data);
// echo "Visit : ";
// for($i = 0; $i < strlen($data); $i++) {
//     echo "<img src='images/counter/$data[$i].gif'>";
// }

echo "View : &nbsp;<span class='badge badge-pill badge-success'>&nbsp;".number_format($data)."&nbsp;</span>";

$_SESSION['sess_counter_case_province'] = 1;
?>