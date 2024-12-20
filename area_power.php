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

$result = mysqli_query($connect, $sql);
$data = mysqli_fetch_assoc($result);

$total = $data["total"];

header("Content-Type: application/json");
echo json_encode(["total" => number_format($total, 4)]);

?>