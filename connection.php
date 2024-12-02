<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "library_db"; // Replace with your actual database name

$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
