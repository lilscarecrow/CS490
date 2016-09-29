<?php
/**
 * get_login_info.php
 * Created by PhpStorm.
 * User: ron
 * Date: 9/27/16
 */

require_once('db_connect.php');

$user = $_POST['user'];
$pass = $_POST['pass'];

$query = "SELECT user_id FROM login WHERE user_id = '$user'";

$user_found = @mysqli_query($db_connect, $query);

$query = "SELECT pw FROM login WHERE user_id = '$user' AND pw = '$pass'";

$pass_found = @mysqli_query($db_connect, $query);

if (mysqli_num_rows($user_found) > 0)
{
    if (mysqli_num_rows($pass_found) > 0)
        echo true;
    else
        echo false;
}
else
{
    echo false;
    echo mysqli_error($db_connect);
}

mysqli_close($db_connect);

?>
