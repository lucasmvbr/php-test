<?php
/* Database credentials */
define('DB_SERVER', 'mariadb');
define('DB_USERNAME', 'demouser');
define('DB_PASSWORD', 'VMware1!');
define('DB_NAME', 'demo');
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>


