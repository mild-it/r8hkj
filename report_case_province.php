<?php
session_start();
$chwpart = $_GET['chwpart'];
$chwname = array(
    "38" => "บึงกาฬ",
    "39" => "หนองบัวลำภู",
    "41" => "อุดรธานี",
    "42" => "เลย",
    "43" => "หนองคาย",
    "47" => "สกลนคร",
    "48" => "นครพนม"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R8NDS Report R8way</title>
    <link rel="icon" type="image/png" sizes="16x16" href="images/disLogo.png">
    <link href="css/style.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
		body {
            font-family: 'Kanit', sans-serif;
        }
		h1, h2, h3, h4, h5, h6 {
            font-family: 'Kanit', sans-serif;
        }
        .content {
            max-width: 90%;
            margin: auto;
            background: white;
            padding: 10px;
        }
    </style>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</head>
<body>
    <?php
    include('connectDB.php');
    $sql_province = "select a.name_th as label, count(c.cid) as y
    from amphures as a
    left outer join caseDis as c on a.`code` = mid(c.tambol, 1, 4)
    where mid(a.`code`, 1, 2) = '$chwpart'
    group by a.`code`";
    $result_province = $mysqli->query($sql_province);
    $array_data = array();
    while($row_province = mysqli_fetch_array($result_province)) {
        array_push($array_data, $row_province);
    }

    $sql_table = "select a.`code` as amppart, a.name_th
    , sum(case when c.statusCase='HOS' then 1 else 0 end) as hos_case
    , sum(case when c.statusCase='PMJ' then 1 else 0 end) as pmj_case
    , sum(case when c.statusCase='OBT' then 1 else 0 end) as obt_case
    , sum(case when c.statusCase='DOC' then 1 else 0 end) as doc_case
    , sum(case when c.statusCase='OK' then 1 else 0 end) as ok_case
    , sum(case when c.statusCase='DEAD' then 1 else 0 end) as dead_case
    , sum(case when c.statusCase='DENY' then 1 else 0 end) as deny_case
    from amphures as a
    left outer join caseDis as c on a.`code` = mid(c.tambol, 1, 4)
    where mid(a.`code`, 1, 2) = '$chwpart'
    group by a.`code`";
    $result_table = $mysqli->query($sql_table);
    ?>
    <div class="content">
        <div>
            <h5>สรุปข้อมูลผู้พิการจังหวัด<?php echo $chwname[$chwpart]; ?></h5>
        </div>
        <div>
            <div class="row">
                <div class="col-md-12">
                    <div id="chartContainer" style="height: 410px; width: 100%;"></div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">อำเภอ</th>
                                <th class="text-center">ยื่นคำขอใหม่</th>
                                <th class="text-center">พมจ.ตรวจสอบ</th>
                                <th class="text-center">เทศบาลตรวจสอบ</th>
                                <th class="text-center">ขอเอกสารเพิ่มเติม</th>
                                <th class="text-center">เรียบร้อยแล้ว</th>
                                <th class="text-center">เสียชีวิต</th>
                                <th class="text-center">ปฏิเสธออกบัตร</th>
                                <th class="text-center">รวมทั้งสิ้น</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_hos = 0;
                            $total_pmj = 0;
                            $total_obt = 0;
                            $total_doc = 0;
                            $total_ok = 0;
                            $total_dead = 0;
                            $total_deny = 0;
                            $total_case = 0;
                            while($r_table = mysqli_fetch_array($result_table)) {
                                $sum_case = $r_table["hos_case"] + $r_table["pmj_case"] + $r_table["obt_case"] + $r_table["doc_case"] + $r_table["ok_case"] + $r_table["dead_case"] + $r_table["deny_case"];
                                $total_hos += $r_table["hos_case"];
                                $total_pmj += $r_table["pmj_case"];
                                $total_obt += $r_table["obt_case"];
                                $total_doc += $r_table["doc_case"];
                                $total_ok += $r_table["ok_case"];
                                $total_dead += $r_table["dead_case"];
                                $total_deny += $r_table["deny_case"];
                                $total_case += $sum_case;
                            ?>
                            <tr>
                                <td><?php echo $r_table["name_th"]; ?></td>
                                <td class="text-center"><?php echo number_format($r_table["hos_case"]); ?></td>
                                <td class="text-center"><?php echo number_format($r_table["pmj_case"]); ?></td>
                                <td class="text-center"><?php echo number_format($r_table["obt_case"]); ?></td>
                                <td class="text-center"><?php echo number_format($r_table["doc_case"]); ?></td>
                                <td class="text-center"><?php echo number_format($r_table["ok_case"]); ?></td>
                                <td class="text-center"><?php echo number_format($r_table["dead_case"]); ?></td>
                                <td class="text-center"><?php echo number_format($r_table["deny_case"]); ?></td>
                                <td class="text-center"><?php echo number_format($sum_case); ?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <th>จังหวัด<?php echo $chwname[$chwpart]; ?></th>
                                <th class="text-center"><?php echo number_format($total_hos); ?></th>
                                <th class="text-center"><?php echo number_format($total_pmj); ?></th>
                                <th class="text-center"><?php echo number_format($total_obt); ?></th>
                                <th class="text-center"><?php echo number_format($total_doc); ?></th>
                                <th class="text-center"><?php echo number_format($total_ok); ?></th>
                                <th class="text-center"><?php echo number_format($total_dead); ?></th>
                                <th class="text-center"><?php echo number_format($total_deny); ?></th>
                                <th class="text-center"><?php echo number_format($total_case); ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <?php include "counter_case_province.php"; ?>
            </div>
        </div>
    </div>
</body>
<script>
    window.onload = function() {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title:{
                text: "จำนวนคนพิการที่ลงทะเบียน"
            },
            axisY: {
                title: "(จำนวนคนพิการที่ลงทะเบียน)"
            },
            data: [{
                type: "column",
                yValueFormatString: "#,##0.## ",
                indexLabel: "{y}",
                dataPoints: <?php echo json_encode($array_data, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    }
</script>
</html>
