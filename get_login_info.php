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
$user_info = array();

//First, we check to see if the id exists in the first place.
$query = "SELECT user_id FROM login WHERE user_id = '$user'";

$user_found = @$db->query($query);

//Next, does the given password match the one paired with the id in my table?
$query = "SELECT pw FROM login WHERE user_id = '$user' AND pw = '$pass'";

$pass_found = @$db->query($query);

if ($user_found->num_rows > 0)
{
    if ($pass_found->num_rows > 0)
    {
        $query = "SELECT role FROM login WHERE user_id = '$user' AND role = 'student'";
        $is_student = @$db->query($query);

        $query = "SELECT role FROM login WHERE user_id = '$user' AND role = 'professor'";
        $is_prof = @$db->query($query);

        if ($is_student->num_rows > 0)
            $user_info['role'] = 'student';
        else if ($is_prof->num_rows > 0)
            $user_info['role'] = 'professor';
        else
            $user_info['role'] = 'null';

        $user_info['user'] = $user;

        echo json_encode($user_info);
    }
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
