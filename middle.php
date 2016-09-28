<?php
$username= $_POST['user'];
$password= $_POST['pass'];
$url="https://web.njit.edu/~rp387/get_login_info.php";

//init curl
$ch = curl_init();

//set the url
curl_setopt($ch, CURLOPT_URL, $url);

//post enable
curl_setopt($ch, CURLOPT_POST, 1);

//data fields
curl_setopt($ch, CURLOPT_POSTFIELDS, 'user='.$username.'&pass='.$password);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

//execute req
$output = curl_exec($ch);

curl_close($ch);

echo "Database: $output";

//echo json_encode($_POST);
//NJIT
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://cp4.njit.edu/cp/home/login");
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
			"user" => $username,
			"pass" => $password,
			"uuid" => "0xACA021"
			)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
curl_close($ch);
echo "NJIT: ";
if (strpos($result, 'Failed') == true) {
    echo "Login Unsuccessful";
}
else
{
  echo "Login Successful";
}
?>