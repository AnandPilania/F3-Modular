<?php

/**
* @author Mohamed Elbahja <Mohamed@elbahja.me>
* @copyright 2016 Application Layout PHP
* @version 1.0
* @package AppLayout PHP 
* @subpackage Social Loginer 
* @link http://www.elbahja.me
*/

session_start();

include('loginer_config.php');

if (!isset($_SESSION['sloginer'])) {

echo "<br><br>Login with Google: <a href='login.php?oauth=google'> Google </a><br><br>";

echo "Login with Facebook: <a href='login.php?oauth=facebook'> facebook</a><br><br>";

echo "Login with Twitter: <a href='login.php?oauth=twitter'> twitter</a><br><br>";

}else{

$dbconn = new mysqli($db_config['host'], $db_config['user'], $db_config['pass'], $db_config['db_name']);

if (!$dbconn){
	die(" Failed connect to MySQL ");
}

$userid = $dbconn->real_escape_string($_SESSION['sloginer']['uid']);
$oauth = $dbconn->real_escape_string($_SESSION['sloginer']['oauth']);

if($userinfo = $dbconn->query("SELECT * FROM $db_config[users_table] WHERE uid ='$userid' AND oauth ='$oauth'")) {

   $userdata = $userinfo->fetch_assoc();

   echo "<br>user Id : ". $userdata['id'];
   echo "<br>user social Id : ". $userdata['uid'];
   echo "<br>user name : ". $userdata['name'];
   echo "<br>user email : ". $userdata['email'];
   echo "<br>user gender : ". $userdata['gender'];
   echo "<br>user last name : ". $userdata['last_name'];
   echo "<br>user first name : ". $userdata['first_name'];
   echo "<br>user picture : ". $userdata['picture'];
   echo "<br>user date created : ". $userdata['date_created'];
   echo "<br>user date modified : ". $userdata['date_modified'];
}



echo "<h4>Session : </h4> ";
echo "Oauth Login : ". $_SESSION['sloginer']['oauth'];

echo "<br><br>Userid : ". $_SESSION['sloginer']['uid'];

echo "<br><br>User Name : ". $_SESSION['sloginer']['name'];

echo "<br><br>Logout : <a href='logout.php'> Logout</a><br>";

}

?>