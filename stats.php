<?php
/**
 * Created by PhpStorm.
 * User: ron
 * Date: 11/15/16
 * Time: 2:32 PM
 */

require_once('db_connect.php');

$user = $_POST['user'];
$statList = array();

$getRole = @$db->query("SELECT role FROM login WHERE user_id='$user'");
$role = $getRole->fetch_row()[0];

$rows = @$db->query("SELECT * FROM tests");

for ($i = 0; $i < $rows->num_rows; $i++)
{
    $subList = array();
    $rowList = $rows->fetch_row();//If there's a problem with this file, it will probably be with fetch_row

    for ($j = 2; $j < sizeof($rowList); $j++)
    {
        if ($j == 2) // Checks if student has taken test already
        {
            $retakeCheck = @$db->query("SELECT * FROM scores WHERE test_num = '$rowList[0]' AND user = '$user'");
            if ($retakeCheck->num_rows == 0)
                array_push($subList, '1');
            else
                array_push($subList, '0');
            continue;
        }
        array_push($subList, $rowList[$j]);
    }

    $taken = @$db->query("SELECT user FROM scores WHERE test_num='$rowList[0]'");

    $uniqueList = array();
    for ($j = 0; $j < $taken->num_rows; $j++)
    {
        $id = $taken->fetch_row()[0];

        if(array_search($id, $uniqueList) === false)
            array_push($uniqueList, $id);
    }

    $query = @$db->query("SELECT user_id FROM login WHERE role='student'");
    $numOfStudents = $query->num_rows;

    if ($role === 'professor')
        array_push($subList, strval(sizeof($uniqueList)) . '/' . strval($numOfStudents));
    $statList[$rowList[0]] = $subList;
}

echo json_encode($statList);

/*
for ($i = 0; $i < $numRows; $i++) // Looking through each test
{
    $testNum = $testRows->fetch_row()[0];
    $query = "SELECT * FROM scores WHERE user = '$user' AND test_num = '$testNum'";
    $getTest = @$db->query($query);

    if($getTest->num_rows > 0) // Narrowing down by which tests the student actually took.
    {
        $qList = array();

        for ($j = 0; $j < $getTest->num_rows; $j++)
        {
            $qRow = $getTest->fetch_row();
            $subList = array();

            for ($k = 3; $k < sizeof($qRow); $k++)
                array_push($subList, $qRow[$k]);

            $qList[$qRow[2]] = $subList;
        }

        $statList[$testNum] = $qList;
    }
    else
        continue;

}
*/

?>