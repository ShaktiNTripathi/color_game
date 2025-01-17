<?php
/*
This file contains database config.phpuration assuming you are running mysql using user "root" and password ""
*/


define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'u448922470_pl7Sv');
define('DB_PASSWORD', 'Sugam@2024');
define('DB_NAME', 'u448922470_b6JXe');

// Try connecting to the Database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//Check the connection
if($conn == false){
    dir('Error: Cannot connect');
    Echo"Fail";
}

?>