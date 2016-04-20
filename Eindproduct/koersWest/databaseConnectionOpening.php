<?php
$dbhost = "localhost";
$dbuser = "pad_user";
$dbpass = "YES";
$database = "koerswest";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $database);

if (mysqli_connect_error()){
	die("Database connection failed: " .
		mysqli_connect_error(). "(". mysqli_connect_errno(). ")"
		);
}

?>