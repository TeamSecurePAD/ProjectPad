<?php
$dbhost = "oege.ie.hva.nl";
$dbuser = "langevr004";
$dbpass = "ARnNzRhZ1BmDHs";
$database = "zlangevr004";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $database);

if (mysqli_connect_error()){
	die("Database connection failed: " .
		mysqli_connect_error(). "(". mysqli_connect_errno(). ")"
		);
}

?>