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
$correct = $_POST['correct'];

$getTestNum = @$db->query("SELECT * FROM tests WHERE ready=1 LIMIT 1");
$testNum = $getTestNum->fetch_row()[2];

$getQuestionNum = @$db->query("SELECT * FROM qbank WHERE question='$questionWording'");
$qNum = @$getQuestionNum->fetch_row()[0];

@$db->query("INSERT INTO scores VALUES('$user', '$testNum', '$qNum', '$compile', '$correct')");

?>