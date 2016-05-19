<?php
$dbhost = "localhost";
$dbuser = "pad_user";
$dbpass = "project";
$database = "koerswest";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $database);

if (mysqli_connect_error()){
	die("Database connection failed: " .
		mysqli_connect_error(). "(". mysqli_connect_errno(). ")"
		);
}

?>