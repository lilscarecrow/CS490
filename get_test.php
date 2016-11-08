<?php
/**
 * Created by PhpStorm.
 * User: ron
 * Date: 10/24/16
 * Time: 3:32 PM
 */

//Brent Posts to me the user when he wants a test.
//I echo back to him an array of the test he wants.
//echo back question:test_case value

require_once('db_connect.php');

$user = $_POST['user'];
$qList = array();

$testRow = @$db->query("SELECT * FROM tests WHERE ready='0' LIMIT 1");

$row = $testRow->fetch_row();

$testStr = $row[1]; // Gets data from second column of the row.
$testNum = $row[0];

@$db->query("UPDATE tests SET ready='1' WHERE num='$testNum'");

$qNums = explode(',', $testStr); // Splits question numbers by comma

for ($i = 0; $i < count($qNums); $i++)
{
    $result = $db->query("SELECT * FROM qbank WHERE q_num = '$qNums[$i]'");

    $qRow = $result->fetch_row();

    $testCaseList = array();

    for ($i = 2; $i < 7; $i++)
    {
        if ($qRow[$i] == null)
            break;
        array_push($testCaseList, $qRow[$i]);
    }

    $qList[$qRow[1]] = $testCaseList;
}

echo json_encode($qList);

?>