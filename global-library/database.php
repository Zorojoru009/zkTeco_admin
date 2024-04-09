<?php
date_default_timezone_set("Asia/Manila");
$today_date1 = date("Y-m-d H:i:s");
$today_date2 = date("Y-m-d");

// database connection config
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'db_tridentbio';

try {
    $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
}
catch(PDOException $e)
    { echo "Connection failed: " . $e->getMessage(); }

/*
// database connection config
$dbHost_live = '35.213.175.236';
$dbUser_live = 'uuseag7n60cgz';
$dbPass_live = '9lasdl8ouxgc';
$dbName_live = 'dbymgvbcdzfqgv';

try {
    $conn_live = new PDO("mysql:host=$dbHost_live;dbname=$dbName_live", $dbUser_live, $dbPass_live);
    // set the PDO error mode to exception
    $conn_live->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
}
catch(PDOException $e)
    { echo "Connection failed: " . $e->getMessage(); }
*/

$link  = mysqli_connect("$dbHost","$dbUser","$dbPass","$dbName");


?>
