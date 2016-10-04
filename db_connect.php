<?php
/**
 * db_connect.php
 * Created by PhpStorm.
 * User: ron
 * Date: 9/27/16
 */

define('DB_USER', 'rp387');
define('DB_PASSWORD', 'zptBa5ve');
define('DB_HOST', 'sql2.njit.edu');
define('DB_NAME', 'rp387');

$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
      or die('Could not connect. ' . $db->connect_error . "\n");

?>
