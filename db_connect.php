<?php

define('DB_USER', 'rp387');
define('DB_PASSWORD', 'zptBa5ve');
define('DB_HOST', 'sql2.njit.edu'); //128.235.211.21 10.80.0.11 sql2.njit.edu
define('DB_NAME', 'rp387');

$db_connect = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Could not connect. ' . mysqli_connect_error() . "\n");

//$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); //I'm going to switch to the mysqli object soon.

?>
