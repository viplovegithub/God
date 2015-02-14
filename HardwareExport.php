<?php
 
$host = 'localhost'; // MYSQL database host adress
$db = 'hmh_eam'; // MYSQL database name
$user = 'hmh_eam'; // Mysql Datbase user
$pass = 'be4sleep'; // Mysql Datbase password
 
// Connect to the database
$link = mysql_connect($host, $user, $pass);
mysql_select_db($db);
 
 
?>

