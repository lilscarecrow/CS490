<?php
/**
 * Created by PhpStorm.
 * User: ron
 * Date: 10/20/16
 * Time: 2:59 PM
 */

require_once("db_connect.php");

$user = $_POST['user'];
$testNum = $_POST['testNum'];

$db->query("UPDATE login SET scores_available = 1");

?>