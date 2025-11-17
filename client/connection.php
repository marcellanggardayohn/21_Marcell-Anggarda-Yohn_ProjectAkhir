<?php
$host = "localhost";
$user = "root";      // ganti jika berbeda
$pass = "mysql";          // password MySQL
$db   = "project";  // nama database

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
