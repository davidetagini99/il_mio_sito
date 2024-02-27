<?php
$servername = "localhost";
$username = "root";
$password = "mySQLDavidePSWD99";
$dbname = "il_mio_sito";

// Create connection
$conn = new mysqli($servername, $username, $password , $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";