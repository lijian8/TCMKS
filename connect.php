<?php

if(!defined('INCLUDE_CHECK')) die('You are not allowed to execute this file directly');


/* Database config */

$db_host		= 'localhost';
$db_user		= 'tcmks';
$db_pass		= 'tcmks';
$db_database	= 'tcmks'; 

/* End config */



$link = mysql_connect($db_host, $db_user,$db_pass) or die('Unable to establish a DB connection');
//$dbc = mysqli_connect('localhost', 'tcmks', 'tcmks', 'tcmks') or die('Error connecting to MySQL server.');

mysql_select_db($db_database,$link);
mysql_query("SET names UTF8");

?>