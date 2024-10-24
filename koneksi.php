<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "telkozy";

$conn = mysqli_connect($host, $user, $pass, $db); 
if (!$conn){
    die("Database error!");
}
?>