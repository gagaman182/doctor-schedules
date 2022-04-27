<?php
// 4.3
// $servername = "localhost";
// $username = "root";
// $password = "1234";
// $dbname = "epidem";
//  $port = "3306";
// localhost

// $servername = "localhost";
// $username = "root";
// $password = "123456789";
// $dbname = "epidem";
// $port = "3306";



// takis 2
$servername = "61.19.25.207";
//$servername = "172.16.99.207";
$username = "takis2";
$password = "skho5005";
$dbname = "doctor_schedule";
$port = "3306";



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");