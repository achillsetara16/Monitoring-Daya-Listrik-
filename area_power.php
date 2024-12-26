<?php

require 'connect_mysql.php';

$postData = file_get_contents("php://input");
$request = json_decode($postData, true);
$area = $request["area"];
$start_time = date("Y-m-d 00:00:00");

$sql = "SELECT
            SUM(power_consumed) AS total
        FROM
            history
        WHERE
            area = '$area' AND start_time >= '$start_time'
";

$sql_2 = "SELECT
            power_consumed
        FROM
            history
        WHERE
            area = '$area' AND control_off IS NULL
        ORDER BY
            id DESC
        LIMIT
            1
";

$result = mysqli_query($connect, $sql);
$data = mysqli_fetch_assoc($result);

$result_2 = mysqli_query($connect, $sql_2);

$total = $data["total"];

if (mysqli_num_rows($result_2) > 0) {
    $data_2 = mysqli_fetch_assoc($result_2);
    $power_consumed = $data_2["power_consumed"];
} else {
    $power_consumed = 0;
}

header("Content-Type: application/json");
echo json_encode([
    "total" => number_format($total, 4),
    "power_consumed" => number_format($power_consumed, 4)
]);

?>