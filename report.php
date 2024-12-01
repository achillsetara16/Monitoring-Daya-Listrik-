<!-- Nama File: report.php -->
<!-- Deskripsi: File ini menampilkan report pemakaian daya per gedung berdasarkan hari -->
<!-- Dibuat oleh: Elvan - NIM: 3312311004 -->
<!-- Tanggal: 13 November 2024 -->

<?php

require 'connect_mysql.php';

$building = $_POST["building"];
$date_start = $_POST["date_start"];
$date_end = $_POST["date_end"];
$total_building = 1;

if ($building == 0 || $date_start > $date_end) {
    echo "<script>
            alert('Invalid input. Please check your building selection or date range.');
            window.location.href = 'dashboard.php';
        </script>";
    exit();
} elseif ($building == "all") {
    $total_building = 2;
}

$datetime_start = $date_start . " 00:00:00";
$datetime_end = $date_end . " 23:59:59";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'metadata.php'; ?>
    <title>Report</title>
</head>
<body id="report">
    <header>
        <a class="back-button" href="dashboard.php">
            <img src="image/back.png" alt="Back Icon" />
            <p>BACK</p>
        </a>
        <p class="report-date"><span class="report-date-start"><?= $date_start ?></span> - <span class="report-date-end"><?= $date_end ?></span></p>
    </header>
    <div class="report-content">
        <h1>REPORT</h1>
        <div class="report-content-inside">

            <?php

            function updateReportData (&$report_datas, $date, $power_consumed) {
                $found = false;
                foreach ($report_datas as &$report_data) {
                    if ($report_data["date"] == $date) {
                        $report_data["total_consumed"] += $power_consumed;
                        $found = true;
                        break;
                    }
                }

                unset($report_data);

                if (!$found) {
                    $report_datas[] = [
                        "date" => $date,
                        "total_consumed" => $power_consumed
                    ];
                }
            }

            for ($count = 1; $count <= $total_building; $count++) {
                if ($total_building == 2) {
                    $building_number = $count;
                } else {
                    $building_number = $building;
                }

                $sql = "SELECT
                            start_time,
                            finish_time,
                            power_consumed
                        FROM
                            history
                        WHERE
                            building = 'Building $building_number'
                            AND
                            (
                                start_time BETWEEN '$datetime_start' AND '$datetime_end'
                                OR
                                (
                                    start_time < '$datetime_start'
                                    AND
                                    finish_time > '$datetime_start'
                                )
                            )";
                $result = mysqli_query($connect, $sql);

            ?>

            <div class="building">
                <hr />
                <h3 class="building-name">BUILDING <?= $building_number ?></h3>
                <table>
                    <colgroup>
                        <col width="40%" />
                        <col width="60%" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th align="left">Date</th>
                            <th align="right">Power Consumed</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        $report_datas = [];
                        $total_consumed = 0;

                        while ($data = mysqli_fetch_assoc($result)) {
                            $start_time = $data["start_time"];
                            $finish_time = $data["finish_time"];
                            $power_consumed = $data["power_consumed"];
                            
                            $start_date = date("Y-m-d", strtotime($start_time));
                            $finish_date = date("Y-m-d", strtotime($finish_time));
                            
                            if ($start_date == $finish_date) {
                                updateReportData($report_datas, $start_date, $power_consumed);
                                $total_consumed += $power_consumed;
                            } elseif ($start_date < $finish_date) {
                                $start_datetime = new DateTime($start_time);
                                $finish_datetime = new DateTime($finish_time);

                                $end_datetime = new DateTime($start_date);
                                $end_time = new DateInterval("P1D");
                                $end_datetime->add($end_time);

                                $start_timestamp = $start_datetime->getTimestamp();
                                $finish_timestamp = $finish_datetime->getTimestamp();
                                $end_timestamp = $end_datetime->getTimestamp();

                                $seconds_difference = $finish_timestamp - $start_timestamp;
                                $sameday_difference = $end_timestamp - $start_timestamp;
                                $day_difference_remaining = ceil(($seconds_difference - $sameday_difference) / 86400);
                                $remaining_difference = $seconds_difference;
                                
                                for ($day = 0; $day <= $day_difference_remaining; $day++) {
                                    $consumed = ($sameday_difference / $seconds_difference) * $power_consumed;

                                    if ($start_date >= $date_start && $start_date <= $date_end) {
                                        $total_consumed += $consumed;

                                        updateReportData($report_datas, $start_date, $consumed);
                                    }
                                    
                                    $tomorrow_date = new DateTime($start_date);
                                    $tomorrow_date->modify('+1 day');
                                    $start_date = $tomorrow_date->format('Y-m-d');

                                    $remaining_difference -= $sameday_difference;
                                    if ($remaining_difference > 86400) {
                                        $sameday_difference = 86400;
                                    } else {
                                        $sameday_difference = $remaining_difference;
                                    }
                                }
                            }
                        }

                        foreach ($report_datas as $report_data) {
                            echo "<tr>";
                            echo "<td>" . $report_data["date"] . "</td>";
                            echo "<td>" . number_format($report_data["total_consumed"], 2) . " Wh</td>";
                            echo "</tr>";
                        }

                        if ($report_datas == []) {
                            echo "<tr><td colspan='2'>No Data Found</td></tr>";
                        }

                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th align="left">Total Pemakaian</th>
                            <th align="right"><?= $total_consumed > 10000 ? number_format(($total_consumed / 1000), 2) . " kWh" : number_format($total_consumed, 2) . " Wh" ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <?php

            }

            ?>

        </div>
    </div>

    <script>
        document.querySelectorAll(".building").forEach(function (building) {
            const height = building.getBoundingClientRect().height;

            const hr = building.querySelector("hr");
            const hrHeight = hr.getBoundingClientRect().height;
            const hrStyle = window.getComputedStyle(hr);
            const hrMarginTop = parseFloat(hrStyle.marginTop);

            const table = building.querySelector("table");
            const tableStyle = window.getComputedStyle(table);
            const tableMarginTop = parseFloat(tableStyle.marginTop);

            const theadHeight = table.querySelector("thead").getBoundingClientRect().height;
            const tfootHeight = table.querySelector("tfoot").getBoundingClientRect().height;
            const tbodyHeight = height - hrHeight - hrMarginTop - tableMarginTop - theadHeight - tfootHeight;
            table.querySelector("tbody").style.maxHeight = `${tbodyHeight}px`;

            const tableWidth = table.getBoundingClientRect().width;
            table.querySelector("thead").style.width = `${tableWidth}px`;
            table.querySelector("tfoot").style.width = `${tableWidth}px`;
            table.querySelectorAll("tbody tr").forEach(function (tbodyTr) {
                tbodyTr.style.width = `${tableWidth}px`;
            });
        });
    </script>
</body>
</html>