<?php

$serverName = "localhost";
$username = "root";
$password = "";
$db = "pbl_sem3";

$connect = mysqli_connect($serverName, $username, $password, $db);

if (!$connect) {
    die("Failed to connect to Database: " . mysqli_connect_error());
}

?>