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

//First, we check to see if the id exists in the first place.
$query = "SELECT user_id FROM login WHERE user_id = '$user'";

$user_found = @$db->query($query);

//Next, does the given password match the one paired with the id in my table?
$query = "SELECT pw FROM login WHERE user_id = '$user' AND pw = '$pass'";

$pass_found = @$db->query($query);

if ($user_found->num_rows > 0)
{
    if ($pass_found->num_rows > 0)
        echo true;
    else
        echo false;
}
else
{
    echo false;
    echo $db->mysqli_error;
}

$db->close;

?>
