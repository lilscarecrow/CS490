<?php
/**
 * Created by PhpStorm.
 * User: ron
 * Date: 10/27/16
 * Time: 1:52 AM
 */

require_once("db_connect.php");

$user = $_POST['user'];
$testNum = $_POST['testNum'];

// Redo w/ new availability check
$checkAvailable = @$db->query("SELECT * FROM tests WHERE num='$testNum'");

/*
if ($checkAvailable->fetch_row()[5] == '1' || $checkAvailable->fetch_row()[5] == 1)
    $available = true;
else
    $available = false;

if ($available) //if $available
{
*/
$scoreList = array();

$query = "SELECT questions FROM tests WHERE num='$testNum'";
$result = @$db->query($query);
$testStr = $result->fetch_row()[0];

$qNums = explode(',', $testStr);

$qList = array();

for ($i = 0; $i < count($qNums); $i++)
{
    $query = "SELECT question FROM qbank WHERE q_num = '$qNums[$i]'";
    $result = @$db->query($query);
    array_push($qList, $result->fetch_row()[0]);
}

$scoreList['questions'] = $qList; // subarray 1

// Not gonna lie; I don't even want to comment all of this...
$caseList = array();
$remarks = array();
$compiles = array();
$submission = array();
$comments = array();

for ($i = 0; $i < count($qNums); $i++)
{
    $qCases = array();
    $result = @$db->query("SELECT testcase1, testcase2, testcase3, testcase4, testcase5 FROM qbank WHERE q_num = '$qNums[$i]'");
    $qRow = $result->fetch_row();

    $query = "SELECT compiles, case1, case2, case3, case4, case5, submission, remarks, comments FROM scores WHERE test_num='$testNum' AND question_num='$qNums[$i]' AND user='$user'";
    $scores = @$db->query($query);
    $row = $scores->fetch_row();

    for ($j = 1; $j < 6; $j++)
    {
        if (empty($qRow[$j-1]))
            break;
        $qCases[$qRow[$j-1]] = $row[$j];
    }

    array_push($caseList, $qCases);

    array_push($remarks, $row[7]);

    array_push($compiles, $row[0]);

    array_push($submission, $row[6]);

    if ($row[8] == null) // Puts an empty string instead of null for empty feedback fields.
    {
        array_push($comments, '');
        continue;
    }

    array_push($comments, $row[8]);
}

$scoreList['testCases'] = $caseList; // subarray 2
$scoreList['remarks'] = $remarks; // subarray 3
$scoreList['compile'] = $compiles; // subarray 4

$scoreList['code'] = $submission; // submission - subarray 5
$scoreList['feedback'] = $comments; // feedback - subarray 6

echo json_encode($scoreList);

?>