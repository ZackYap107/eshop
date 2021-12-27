<?php
// used to connect to the database
/*
$host = "sql302.epizy.com";
$db_name = "epiz_30656540_onlineEshop";
$username = "epiz_30656540";
$password = "xBDBNDP0K9Sf3";
*/
$host = "localhost";
$db_name = "online_store";
$username = "root";
$password = "";

try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    //echo "Connected successfully"; 
}
  
// show error
catch(PDOException $exception){
    echo "Connection error: ".$exception->getMessage();
}
?>