<?php
session_start();

$site_url = "http://localhost/test/Maritimes_Certificate/";
$host = "localhost";
$user = "root"; 
$pass = "";     
$dbname = "cook_islands_certificates";

$site_url = "https://www.s2.upvise.com.co/";
// $host = "localhost";
// $user = "upviseco"; 
// $pass = "EqlMa585x9";     
// $dbname = "upviseco_cook_islands_certificates";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>