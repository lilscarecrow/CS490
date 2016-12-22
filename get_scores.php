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

$checkAvailable = @$db->query("SELECT * FROM tests WHERE num='$testNum'");

$scoreList = array();

$query = "SELECT questions FROM tests WHERE num='$testNum'";
$result = @$db->query($query);
$testStr = $result->fetch_row()[0];
$qNums = explode(',', $testStr);

$query = "SELECT weights FROM tests WHERE num='$testNum'";
$result = @$db->query($query);
$wghtStr = $result->fetch_row()[0];
$weightList = explode(",", $wghtStr);

$scoreList['weights'] = $weightList; // subarray 1

$qList = array();

for ($i = 0; $i < count($qNums); $i++)
{
    $query = "SELECT question FROM qbank WHERE q_num = '$qNums[$i]'";
    $result = @$db->query($query);
    array_push($qList, $result->fetch_row()[0]);
}

$scoreList['questions'] = $qList; // subarray 2

$caseList = array();
$remarks = array();
$compiles = array();
$submission = array();
$comments = array();
$weights = array();
$qScores = array();

for ($i = 0; $i < count($qNums); $i++)
{
    $qCases = array();
    $result = @$db->query("SELECT testcase1, testcase2, testcase3, testcase4, testcase5 FROM qbank WHERE q_num = '$qNums[$i]'");
    $qRow = $result->fetch_row();

    $query = "SELECT compiles, case1, case2, case3, case4, case5, submission, remarks, comments, q_score FROM scores WHERE test_num='$testNum' AND question_num='$qNums[$i]' AND user='$user'";
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

    array_push($qScores, $row[9]);

    if ($row[8] == null) // Puts an empty string instead of null for empty feedback fields.
    {
        array_push($comments, '');
        continue;
    }

    array_push($comments, $row[8]);
}

$scoreList['testCases'] = $caseList; // subarray 3
$scoreList['remarks'] = $remarks; // subarray 4
$scoreList['compile'] = $compiles; // subarray 5
$scoreList['code'] = $submission; // subarray 6
$scoreList['feedback'] = $comments; // subarray 7
$scoreList['subScores'] = $qScores; // subarray 8

echo json_encode($scoreList);

?>