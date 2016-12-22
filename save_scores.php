<?php
/**
 * Created by PhpStorm.
 * User: ron
 * Date: 10/26/16
 * Time: 9:19 PM
 */

require_once("db_connect.php");

$user = $_POST['user'];
$questionWording = $_POST['question'];
$compile = $_POST['compile'];
$test_cases = json_decode($_POST['correct'], true);
$submission = $_POST['submission'];
$testNum = $_POST['testNum'];
$remarks = $_POST['remarks'];
$qScore = $_POST['qScore'];

// Add qScore field. It's the total score of the question with the weight factored into it.

$getQuestionNum = @$db->query("SELECT q_num FROM qbank WHERE question='$questionWording'");
$qNum = $getQuestionNum->fetch_row()[0];

if(sizeof($test_cases) == 2)
    $query = "INSERT INTO scores VALUES('$user', '$testNum', '$qNum', '$compile', '$test_cases[0]', '$test_cases[1]', NULL, NULL, NULL, '$submission', '$remarks', NULL, '$qScore')";
elseif(sizeof($test_cases) == 3)
    $query = "INSERT INTO scores VALUES('$user', '$testNum', '$qNum', '$compile', '$test_cases[0]', '$test_cases[1]', '$test_cases[2]', NULL, NULL, '$submission', '$remarks', NULL, '$qScore')";
elseif(sizeof($test_cases) == 4)
    $query = "INSERT INTO scores VALUES('$user', '$testNum', '$qNum', '$compile', '$test_cases[0]', '$test_cases[1]', '$test_cases[2]', '$test_cases[3]', NULL, '$submission', '$remarks', NULL, '$qScore')";
elseif(sizeof($test_cases) == 5)
    $query = "INSERT INTO scores VALUES('$user', '$testNum', '$qNum', '$compile', '$test_cases[0]', '$test_cases[1]', '$test_cases[2]', '$test_cases[3]', '$test_cases[4]', '$submission', '$remarks', NULL, '$qScore')";
else
    $query = "INSERT INTO scores VALUES('$user', '$testNum', '$qNum', '$compile', '$test_cases[0]', NULL, NULL, NULL, NULL, '$submission', '$remarks', NULL, '$qScore')";

@$db->query($query);

?>