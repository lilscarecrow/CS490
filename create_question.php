<?php
/**
 * Created by PhpStorm.
 * User: ron
 * Date: 10/13/16
 * Time: 3:09 PM
 */

require_once("db_connect.php");

$user = $_POST['user'];
$question = $_POST['question'];
$test_cases = json_decode($_POST['tests']);
$difficulty = $_POST['difficulty'];
$function_name = $_POST['funcName'];

if(sizeof($test_cases) == 2)
    $query = "INSERT INTO qbank VALUES(NULL, '$question', '$test_cases[0]', '$test_cases[1]', NULL, NULL, NULL, '$difficulty', '$function_name')";
elseif(sizeof($test_cases) == 3)
    $query = "INSERT INTO qbank VALUES(NULL, '$question', '$test_cases[0]', '$test_cases[1]', '$test_cases[2]', NULL, NULL, '$difficulty', '$function_name')";
elseif(sizeof($test_cases) == 4)
    $query = "INSERT INTO qbank VALUES(NULL, '$question', '$test_cases[0]', '$test_cases[1]', '$test_cases[2]', '$test_cases[3]', NULL, '$difficulty', '$function_name')";
elseif(sizeof($test_cases) == 5)
    $query = "INSERT INTO qbank VALUES(NULL, '$question', '$test_cases[0]', '$test_cases[1]', '$test_cases[2]', '$test_cases[3]', '$test_cases[4]', '$difficulty', '$function_name')";
else
    $query = "INSERT INTO qbank VALUES(NULL, '$question', '$test_cases[0]', NULL, NULL, NULL, NULL, '$difficulty', '$function_name')";

echo $query;

@$db->query($query);

?>