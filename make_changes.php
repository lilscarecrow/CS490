<?php
/**
 * Created by PhpStorm.
 * User: ron
 * Date: 12/8/16
 * Time: 4:18 AM
 */

// Here, the professor can make changes to the student grades and add comments.

require_once('db_connect.php');

$user = $_POST['user'];
$student = $_POST['student'];
$testNum = $_POST['testNum'];
$feedback = $_POST['feedback']; // array
$questionScores = $_POST['questionScores']; // array

$query = "SELECT questions FROM tests WHERE num='$testNum'";
$result = @$db->query($query);
$testStr = $result->fetch_row()[0];

$qNums = explode(",", $testStr);

$qScoreArr = (array)$questionScores;

for ($i = 0; $i < count($qScoreArr); $i++)
{
    $qScoreStr = $qScoreStr . $qScoreArr[$i] . ',';
}

$qScoreStr = substr($qScoreStr, 0, -1); // Gets rid of trailing comma.
$qScoreList = explode(',', $qScoreStr);

$feedbackArr = (array)$feedback;

for ($i = 0; $i < count($feedbackArr); $i++)
{
    $feedbackStr = $feedbackStr . $feedbackArr[$i] . ',';
}

$feedbackStr = substr($feedbackStr, 0, -1);
$feedbackList = explode(',', $feedbackStr);

for ($i = 0; $i < count($qNums); $i++)
{
    $query = "UPDATE scores SET q_score = '$qScoreList[$i]' WHERE user = '$student' AND test_num = '$testNum' AND question_num = '$qNums[$i]'";
    @$db->query($query);

    $query = "UPDATE scores SET comments = '$feedbackList[$i]' WHERE user = '$student' AND test_num = '$testNum' AND question_num = '$qNums[$i]'";
    @$db->query($query);
}