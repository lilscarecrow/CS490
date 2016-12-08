<?php
/**
 * get_login_info.php
 * Created by PhpStorm.
 * User: ron
 * Date: 9/27/16
 */

require_once("db_connect.php");

$user = $_POST['user'];
$reqArray = $_POST['list'];
$testName = $_POST['testName'];
$question_field = 1;
$difficulty_field = 7;

if ($reqArray == null) // In this case, they want to retrieve questions to make a test.
{
    $result = $db->query("SELECT * FROM qbank");
    $qList = array();

    for ($i = 1; $i <= $result->num_rows; $i++)
    {
        $qSubList = array();

        $get = $db->query("SELECT * FROM qbank WHERE q_num = '$i'");
        $row = $get->fetch_row();

        array_push($qSubList, $row[$question_field]);
        array_push($qSubList, $row[$difficulty_field]);

        $qList[$i] = $qSubList;
    }

    echo json_encode($qList);
}
elseif (!is_numeric($reqArray))// In this case, they want to store a test.
{
    $testStr = ''; // String Value that will be stored into my tests table.

    $var = (array)$reqArray; // Makes reqArray iterable.

    for ($i = 0; $i < count($var); $i++)
    {
        $testStr = $testStr . $var[$i] . ','; // concatenate
    }

    $testStr = substr($testStr, 0, -1); // Gets rid of trailing comma.
    $testStr = str_ireplace("\"", "", $testStr); // Cleaning up the brackets and quotes
    $testStr = str_ireplace("[", "", $testStr);
    $testStr = str_ireplace("]", "", $testStr);

    $query = "INSERT INTO tests VALUES(NULL, '$testStr', '1', '$testName', NOW(), '0')";
    $result = $db->query($query);
}

?>