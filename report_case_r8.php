<?php
session_start();
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
    $sql_province = "select p.name_th as label, count(c.cid) as y
    from provinces as p
    left outer join caseDis as c on p.`code` = mid(c.tambol, 1, 2)
    where p.`code` in('38', '39', '41', '42', '43', '47', '48')
    group by p.`code`
    order by p.sort_data";
    $result_province = $mysqli->query($sql_province);
    $array_data = array();
    while ($row_province = mysqli_fetch_array($result_province)) {
        array_push($array_data, $row_province);
    }

    // SQL ChartDistType
    $sql_chartdisttype = "select c.disType as indexLabel, count(c.cid) as y
    from caseDis as c
    group by c.disType";
    $result_chartdisttype = $mysqli->query($sql_chartdisttype);
    $array_chartdisttype = array();
    while ($row_chartdisttype = mysqli_fetch_array($result_chartdisttype)) {
        array_push($array_chartdisttype, $row_chartdisttype);
    }

    // SQL ข้อมูลจำนวนเคสแยกตามจังหวัด
    $sql_table = "select p.`code` as chwpart, p.name_th
        , sum(case when c.statusCase='HOS' then 1 else 0 end) as hos_case
        , sum(case when c.statusCase='PMJ' then 1 else 0 end) as pmj_case
        , sum(case when c.statusCase='OBT' then 1 else 0 end) as obt_case
        , sum(case when c.statusCase='DOC' then 1 else 0 end) as doc_case
        , sum(case when c.statusCase='OK' then 1 else 0 end) as ok_case
        , sum(case when c.statusCase='DEAD' then 1 else 0 end) as dead_case
        , sum(case when c.statusCase='DENY' then 1 else 0 end) as deny_case
        from provinces as p
        left outer join caseDis as c on p.`code` = mid(c.tambol, 1, 2)
        where p.`code` in('38', '39', '41', '42', '43', '47', '48')
        group by p.`code`
        order by p.sort_data";
    $result_table = $mysqli->query($sql_table);

    // SQL จำนวนเคสแยกตามจังหวัด
    $sql_disttype = "select p.`code`, p.name_th
    , sum(case when c.disType = 'ทางการเห็น' then 1 else 0 end) as disttype1
    , sum(case when c.disType = 'ทางการได้ยินหรือการสื่อความหมาย' then 1 else 0 end) as disttype2
    , sum(case when c.disType = 'ทางการเคลื่อนไหวหรือทางร่างกาย' then 1 else 0 end) as disttype3
    , sum(case when c.disType = 'ทางจิตใจหรือพฤติกรรม' then 1 else 0 end) as disttype4
    , sum(case when c.disType = 'ทางสติปัญญา' then 1 else 0 end) as disttype5
    , sum(case when c.disType = 'ทางการเรียนรู้' then 1 else 0 end) as disttype6
    , sum(case when c.disType = 'ทางออทิสติก' then 1 else 0 end) as disttype7
    , sum(case when c.disType = '' or c.disType is null then 1 else 0 end) as disttype8
    from provinces as p
    left outer join caseDis as c on p.`code` = mid(c.tambol, 1, 2)
    where p.`code` in('38', '39', '41', '42', '43', '47', '48') and  c.statusCase != ''
    group by p.`code`
    order by p.sort_data";
    $result_disttype = $mysqli->query($sql_disttype);

    // SQL จำนวนผู้ใช้งาน
    $sql_member = "select m2.*, sum(case when m.`level`='opt' then 1 else 0 end) as obt
    from
    (select m1.*, sum(case when m.`level`='pmj' then 1 else 0 end) as pmj
        from
        (select p.`code` as chwpart, p.name_th, p.sort_data
            , sum(case when m.`level`='etc' then 1 else 0 end) as etc
            , sum(case when m.`level`='admin' then 1 else 0 end) as admin
            , sum(case when m.`level`='pcu' then 1 else 0 end) as pcu
            from provinces as p
            left outer join member as m on p.`code` = m.provinces
            where p.`code` in('38', '39', '41', '42', '43', '47', '48')
            group by p.`code`
            order by p.sort_data) as m1
        left outer join member as m on m1.chwpart = m.provinces_pmj
        group by m1.chwpart order by m1.sort_data) as m2
    left outer join member as m on m2.chwpart = m.provinces_opt
    group by m2.chwpart order by m2.sort_data";
    $result_member = $mysqli->query($sql_member);

    // SQL history case
    $sql_history_case = "select date_sub(date(now()), interval 14 day) as date1, sum(case when c.dateREG = date_sub(date(now()), interval 14 day) then 1 else 0 end) as sum_date1
    , date_sub(date(now()), interval 13 day) as date2, sum(case when c.dateREG = date_sub(date(now()), interval 13 day) then 1 else 0 end) as sum_date2
    , date_sub(date(now()), interval 12 day) as date3, sum(case when c.dateREG = date_sub(date(now()), interval 12 day) then 1 else 0 end) as sum_date3
    , date_sub(date(now()), interval 11 day) as date4, sum(case when c.dateREG = date_sub(date(now()), interval 11 day) then 1 else 0 end) as sum_date4
    , date_sub(date(now()), interval 10 day) as date5, sum(case when c.dateREG = date_sub(date(now()), interval 10 day) then 1 else 0 end) as sum_date5
    , date_sub(date(now()), interval 9 day) as date6, sum(case when c.dateREG = date_sub(date(now()), interval 9 day) then 1 else 0 end) as sum_date6
    , date_sub(date(now()), interval 8 day) as date7, sum(case when c.dateREG = date_sub(date(now()), interval 8 day) then 1 else 0 end) as sum_date7
    , date_sub(date(now()), interval 7 day) as date8, sum(case when c.dateREG = date_sub(date(now()), interval 7 day) then 1 else 0 end) as sum_date8
    , date_sub(date(now()), interval 6 day) as date9, sum(case when c.dateREG = date_sub(date(now()), interval 6 day) then 1 else 0 end) as sum_date9
    , date_sub(date(now()), interval 5 day) as date10, sum(case when c.dateREG = date_sub(date(now()), interval 5 day) then 1 else 0 end) as sum_date10
    , date_sub(date(now()), interval 4 day) as date11, sum(case when c.dateREG = date_sub(date(now()), interval 4 day) then 1 else 0 end) as sum_date11
    , date_sub(date(now()), interval 3 day) as date12, sum(case when c.dateREG = date_sub(date(now()), interval 3 day) then 1 else 0 end) as sum_date12
    , date_sub(date(now()), interval 2 day) as date13, sum(case when c.dateREG = date_sub(date(now()), interval 2 day) then 1 else 0 end) as sum_date13
    , date_sub(date(now()), interval 1 day) as date14, sum(case when c.dateREG = date_sub(date(now()), interval 1 day) then 1 else 0 end) as sum_date14
    , date(now()) as date15, sum(case when c.dateREG = date(now()) then 1 else 0 end) as sum_date15
    from caseDis as c
    where c.dateREG between date_sub(date(now()), interval 15 day) and date(now())";
    $result_history_case = $mysqli->query($sql_history_case);
    $r_history_case = mysqli_fetch_array($result_history_case);
    $history_case_data = array( 
        array("label"=>$r_history_case["date1"], "y"=>$r_history_case["sum_date1"]),
        array("label"=>$r_history_case["date2"], "y"=>$r_history_case["sum_date2"]),
        array("label"=>$r_history_case["date3"], "y"=>$r_history_case["sum_date3"]),
        array("label"=>$r_history_case["date4"], "y"=>$r_history_case["sum_date4"]),
        array("label"=>$r_history_case["date5"], "y"=>$r_history_case["sum_date5"]),
        array("label"=>$r_history_case["date6"], "y"=>$r_history_case["sum_date6"]),
        array("label"=>$r_history_case["date7"], "y"=>$r_history_case["sum_date7"]),
        array("label"=>$r_history_case["date8"], "y"=>$r_history_case["sum_date8"]),
        array("label"=>$r_history_case["date9"], "y"=>$r_history_case["sum_date9"]),
        array("label"=>$r_history_case["date10"], "y"=>$r_history_case["sum_date10"]),
        array("label"=>$r_history_case["date11"], "y"=>$r_history_case["sum_date11"]),
        array("label"=>$r_history_case["date12"], "y"=>$r_history_case["sum_date12"]),
        array("label"=>$r_history_case["date13"], "y"=>$r_history_case["sum_date13"]),
        array("label"=>$r_history_case["date14"], "y"=>$r_history_case["sum_date14"]),
        array("label"=>$r_history_case["date15"], "y"=>$r_history_case["sum_date15"])
    )
    ?>
    <div class="content">
        <div>
            <h4>ระบบรายงาน</h4>
        </div>
        <div>
            <div class="row">
                <div class="col-md-5">
                    <h5>จำนวนคนพิการที่ลงทะเบียน</h5>
                    <div id="chartContainer" style="height: 410px; width: 100%;"></div>
                </div>
                <div class="col-md-7">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 14%;">จังหวัด</th>
                                <th class="text-center" style="width: 11%;">ยื่นคำขอใหม่</th>
                                <th class="text-center" style="width: 11%;">พมจ.ตรวจสอบ</th>
                                <th class="text-center" style="width: 12%;">เทศบาลตรวจสอบ</th>
                                <th class="text-center" style="width: 12%;">ขอเอกสารเพิ่มเติม</th>
                                <th class="text-center" style="width: 12%;">เรียบร้อยแล้ว</th>
                                <th class="text-center" style="width: 8%;">เสียชีวิต</th>
                                <th class="text-center" style="width: 9%;">ปฏิเสธออกบัตร</th>
                                <th class="text-center" style="width: 11%;">รวมทั้งสิ้น</th>
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
                                <td><?php echo "<a href='report_case_province.php?chwpart=$r_table[chwpart]'>$r_table[name_th]</a>"; ?></td>
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
                                <th>เขตสุขภาพที่ 8</th>
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
                <div class="col-md-12">
                    <h5>ข้อมูลแยกตามประเภทความพิการ</h5>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 11%;">จังหวัด</th>
                                <th class="text-center" style="width: 8%;">ทางการเห็น</th>
                                <th class="text-center" style="width: 14%;">ทางการได้ยินหรือการสื่อความหมาย</th>
                                <th class="text-center" style="width: 14%;">ทางการเคลื่อนไหวหรือทางร่างกาย</th>
                                <th class="text-center" style="width: 14%;">ทางจิตใจหรือพฤติกรรม</th>
                                <th class="text-center" style="width: 8%;">ทางสติปัญญา</th>
                                <th class="text-center" style="width: 8%;">ทางการเรียนรู้</th>
                                <th class="text-center" style="width: 8%;">ทางออทิสติก</th>
                                <th class="text-center" style="width: 7%;">ไม่ระบุ</th>
                                <th class="text-center" style="width: 8%;">รวมทั้งสิ้น</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_disttype1 = 0;
                            $total_disttype2 = 0;
                            $total_disttype3 = 0;
                            $total_disttype4 = 0;
                            $total_disttype5 = 0;
                            $total_disttype6 = 0;
                            $total_disttype7 = 0;
                            $total_disttype8 = 0;
                            $total_case = 0;
                            while($r_disttype = mysqli_fetch_array($result_disttype)) {
                                $sum_case = $r_disttype["disttype1"] + $r_disttype["disttype2"] + $r_disttype["disttype3"] + $r_disttype["disttype4"] + $r_disttype["disttype5"] + $r_disttype["disttype6"] + $r_disttype["disttype7"] + $r_disttype["disttype8"];
                                $total_disttype1 += $r_disttype["disttype1"];
                                $total_disttype2 += $r_disttype["disttype2"];
                                $total_disttype3 += $r_disttype["disttype3"];
                                $total_disttype4 += $r_disttype["disttype4"];
                                $total_disttype5 += $r_disttype["disttype5"];
                                $total_disttype6 += $r_disttype["disttype6"];
                                $total_disttype7 += $r_disttype["disttype7"];
                                $total_disttype8 += $r_disttype["disttype8"];
                                $total_case += $sum_case;
                            ?>
                            <tr>
                                <td><?php echo $r_disttype["name_th"]; ?></td>
                                <td class="text-center"><?php echo number_format($r_disttype["disttype1"]); ?></td>
                                <td class="text-center"><?php echo number_format($r_disttype["disttype2"]); ?></td>
                                <td class="text-center"><?php echo number_format($r_disttype["disttype3"]); ?></td>
                                <td class="text-center"><?php echo number_format($r_disttype["disttype4"]); ?></td>
                                <td class="text-center"><?php echo number_format($r_disttype["disttype5"]); ?></td>
                                <td class="text-center"><?php echo number_format($r_disttype["disttype6"]); ?></td>
                                <td class="text-center"><?php echo number_format($r_disttype["disttype7"]); ?></td>
                                <td class="text-center"><?php echo number_format($r_disttype["disttype8"]); ?></td>
                                <td class="text-center"><?php echo number_format($sum_case); ?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <th>เขตสุขภาพที่ 8</th>
                                <th class="text-center"><?php echo number_format($total_disttype1); ?></th>
                                <th class="text-center"><?php echo number_format($total_disttype2); ?></th>
                                <th class="text-center"><?php echo number_format($total_disttype3); ?></th>
                                <th class="text-center"><?php echo number_format($total_disttype4); ?></th>
                                <th class="text-center"><?php echo number_format($total_disttype5); ?></th>
                                <th class="text-center"><?php echo number_format($total_disttype6); ?></th>
                                <th class="text-center"><?php echo number_format($total_disttype7); ?></th>
                                <th class="text-center"><?php echo number_format($total_disttype8); ?></th>
                                <th class="text-center"><?php echo number_format($total_case); ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <h5>จำนวนผู้พิการแยกตามประเภท</h5>
                    <div id="myChartDistType" style="height: 410px; width: 100%;"></div>
                </div>
                <div class="col-md-7">
                    <h5>ข้อมูลผู้ใช้งานระบบ</h5>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">จังหวัด</th>
                                <th class="text-center">ประชาชนทั่วไป</th>
                                <th class="text-center">โรงพยาบาล</th>
                                <th class="text-center">พมจ.</th>
                                <th class="text-center">เทศบาล/ท้องถิ่น</th>
                                <th class="text-center">แอดมิน</th>
                                <th class="text-center">รวมทั้งสิ้น</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_etc = 0;
                            $total_admin = 0;
                            $total_pcu = 0;
                            $total_pmj = 0;
                            $total_obt = 0;
                            $total_member = 0;
                            while($r_member = mysqli_fetch_array($result_member)) {
                                $sum_member = $r_member["etc"] + $r_member["admin"] + $r_member["pcu"] + $r_member["pmj"] + $r_member["obt"];
                                $total_etc += $r_member["etc"];
                                $total_admin += $r_member["admin"];
                                $total_pcu += $r_member["pcu"];
                                $total_pmj += $r_member["pmj"];
                                $total_obt += $r_member["obt"];
                                $total_member += $sum_member;
                            ?>
                            <tr>
                                <td><?php echo $r_member["name_th"]; ?></td>
                                <td class="text-center"><?php echo number_format($r_member["etc"]); ?></td>
                                <td class="text-center"><?php echo number_format($r_member["pcu"]); ?></td>
                                <td class="text-center"><?php echo number_format($r_member["pmj"]); ?></td>
                                <td class="text-center"><?php echo number_format($r_member["obt"]); ?></td>
                                <td class="text-center"><?php echo number_format($r_member["admin"]); ?></td>
                                <td class="text-center"><?php echo number_format($sum_member); ?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <th>เขตสุขภาพที่ 8</th>
                                <th class="text-center"><?php echo number_format($total_etc); ?></th>
                                <th class="text-center"><?php echo number_format($total_pcu); ?></th>
                                <th class="text-center"><?php echo number_format($total_pmj); ?></th>
                                <th class="text-center"><?php echo number_format($total_obt); ?></th>
                                <th class="text-center"><?php echo number_format($total_admin); ?></th>
                                <th class="text-center"><?php echo number_format($total_member); ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5>จำนวนคนพิการย้อนหลัง 15 วัน</h5>
                    <div id="chartHistoryCase" style="height: 410px; width: 100%;"></div>
                </div>
            </div>
            <div class="row">
                <?php include "counter_case_r8.php"; ?>
            </div>
        </div>
    </div>
</body>
<script>
    window.onload = function() {
        // Chart จำนวนคนพิการทั้งหมด
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title:{
                // text: "จำนวนคนพิการที่ลงทะเบียน"
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

        // Chart ประเภทความพิการ
        var chartDistType = new CanvasJS.Chart("myChartDistType", {
            title:{
                // text: "จำนวนผู้พิการแยกตามประเภท"
            },
            data: [{
                type: "pie",
                indexLabel: "{indexLabel}, {y}",
                showInLegend: true,
                legendText: "{indexLabel}, {y}",
                dataPoints: <?php echo json_encode($array_chartdisttype, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chartDistType.render();

        // Chart จำนวนคนพิการทั้งหมด
        var chart = new CanvasJS.Chart("chartHistoryCase", {
            animationEnabled: true,
            theme: "light2",
            title:{
                // text: "จำนวนคนพิการย้อนหลัง 15 วัน"
            },
            axisY: {
                title: "(จำนวนคนพิการย้อนหลัง 15 วัน)"
            },
            data: [{
                type: "splineArea",
                color: "rgba(54,158,173,.7)",
                yValueFormatString: "#,##0.## ",
                indexLabel: "{y}",
                dataPoints: <?php echo json_encode($history_case_data, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    }
</script>
</html>
