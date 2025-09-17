<?php
session_start();

$host = "localhost";
$user = "root"; 
$pass = "";     
$dbname = "cook_islands_certificates";

// $host = "localhost";
// $user = "upviseco"; 
// $pass = "EqlMa585x9";     
// $dbname = "upviseco_cook_islands_certificates";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>