<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "transport";  // transport.sql DB name

$con = mysqli_connect($servername, $username, $password, $dbname);

if (!$con) {
    die(json_encode(["status" => "error", "message" => "Database connection failed."]));
}
?>