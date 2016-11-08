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
$question_field = 1;


if ($reqArray == null) // In this case, they want to retrieve questions to make a test.
{
    $result = $db->query("SELECT * FROM qbank");
    $qList = array();

    for ($i = 1; $i <= $result->num_rows; $i++)
    {]
        $get = $db->query("SELECT * FROM qbank WHERE q_num = '$i'");
        $row = $get->fetch_row();
        $qList[$i] = $row[1]; // I'm using index 1, because the question is the second field in the qbank table.
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

    $query = "INSERT INTO tests VALUES(NULL, '$testStr', '0')";
    $result = $db->query($query);
}

?>