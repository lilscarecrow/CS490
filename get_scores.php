<?php
/**
 * Created by PhpStorm.
 * User: ron
 * Date: 10/27/16
 * Time: 1:52 AM
 */

require_once("db_connect.php");

$user = $_POST['user'];

$checkAvailable = @$db->query("SELECT * FROM login WHERE user_id='$user'");
$available = $checkAvailable->fetch_row()[3];

if ($available)
{
    $scoreList = array();
    $scoreRows = @$db->query("SELECT * FROM scores WHERE user='$user'");

    while($row = $scoreRows->fetch_row())
    {
        $getQ = @$db->query("SELECT * FROM qbank WHERE q_num='$row[2]'");
        $question = $getQ->fetch_row()[1];
        $scoreStr = (string)$row[3] . ':' . (string)$row[4];
        $scoreList[$question] = $scoreStr;
    }

    echo json_encode($scoreList);
}
else
    ; // Do nothing
?>