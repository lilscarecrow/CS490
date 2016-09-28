<?php
/**
 * Created by PhpStorm.
 * User: ron
 * Date: 9/27/16
 */

require_once('db_connect.php');

$user = $_POST['user'];
$pass = $_POST['pass'];

$query = "SELECT user_id FROM login WHERE user_id = '$user'";

$user_found = @mysqli_query($db_connect, $query);

$query2 = "SELECT pw FROM login WHERE user_id = '$user' AND pw = '$pass'";

$pass_found = @mysqli_query($db_connect, $query2);

if (mysqli_num_rows($user_found) > 0)
{
    /*
    $actual_pass = $pass_found->fetch_assoc()['pw'];

    echo $actual_pass; // Used for testing purposes.
    echo $pass;
    echo mysqli_num_rows($pass_found);
    */

    if (mysqli_num_rows($pass_found) > 0)
        echo "OK";
    else
        echo "Invalid password.\n";
}
else
{
    echo "Invalid username\n";
    echo mysqli_error($db_connect);
}

mysqli_close($db_connect);

?>