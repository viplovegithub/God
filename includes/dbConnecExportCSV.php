<?php
$host = 'localhost'; // MYSQL database host adress
$db = 'eam'; // MYSQL database name
$user = 'eam'; // Mysql Datbase user
$pass = 'YourDBPassword'; // Mysql Datbase password
 
// Connect to the database
$link = mysql_connect($host, $user, $pass); mysql_select_db($db);
?>