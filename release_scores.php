<?php
/**
 * Created by PhpStorm.
 * User: ron
 * Date: 10/20/16
 * Time: 2:59 PM
 */

require_once("db_connect.php");

$user = $_POST['user'];
$testNum = $_POST['testNum'];

/*
$result = @$db->query("SELECT user_id FROM login WHERE role = 'student'");
$numStudents = $result->num_rows;

// Go find any untaken tests (available=1, but nothing in scores table) and mark them as zero.
for ($i = 0; $i < $numStudents; $i++)
{
    $check = @$db->query("SELECT * FROM scores WHERE user = '$user' AND test_num = '$testNum'");
    $testTaken = $check->num_rows;

    if ($testTaken == 0)
    {
        $testStr = (@$db->query("SELECT questions FROM tests WHERE num = '$testNum'"))->fetch_row()[0];
        $qNums = explode(',', $testStr);

        for ($i = 0; $i < sizeof($qNums); $i++)
        {
            @$db->query("INSERT INTO scores VALUES('$user', '$testNum', '$qNums[$i]', 0, 0, 0, 0, 0,'', 'No submission.')");
        }
    }
}
*/

@$db->query("UPDATE tests SET available = 0 WHERE num = '$testNum'");
@$db->query("UPDATE tests SET released = 1 WHERE num = '$testNum'");

?>