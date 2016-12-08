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
$testNum = $_POST['testNum'];
$testList = array();
$qList = array();
$testCaseList = array();
$funcNameList = array();

$testRow = @$db->query("SELECT * FROM tests WHERE num = '$testNum'");

$row = $testRow->fetch_row();

$testStr = $row[1]; // Gets data from second column of the row.
$testNum = $row[0];

//@$db->query("UPDATE tests SET ready='1' WHERE num='$testNum'"); Deprecated

$qNums = explode(',', $testStr); // Splits question numbers by comma

for ($i = 0; $i < count($qNums); $i++)
{
    $result = $db->query("SELECT * FROM qbank WHERE q_num = '$qNums[$i]'");

    $qRow = $result->fetch_row();

    $testCaseSubList = array();

    for ($j = 2; $j < 7; $j++)
    {
        if ($qRow[$j] == null)
            break;
        array_push($testCaseSubList, $qRow[$j]);
    }

    array_push($qList, $qRow[1]);
    array_push($testCaseList, $testCaseSubList);
    array_push($funcNameList, $qRow[8]);
    //$qList[$qRow[1]] = $testCaseList;
}

array_push($testList, $qList);
array_push($testList, $testCaseList);
array_push($testList, $funcNameList);

echo json_encode($testList);

?>