<?php
session_start();


if ( isset($_SESSION['user_id'])){
  header('location:index.php');
}

require 'databaseConnectionOpening.php';

if (!empty($_POST['email']) && !empty($_POST['wachtwoord'])) {

	//hier zet ik de form data in varriable
	$email = $_POST['email'];
	$wachtwoord = $_POST['wachtwoord'];
	$telnummer = $_POST['telnummer'];
	$straat = $_POST['straat'];
	$postcode = $_POST['postcode'];
	$woonplaats = $_POST['woonplaats'];

// zet de data uit het register form in een database.
$query = "INSERT INTO gebruiker (email, wachtwoord, telefoonnummer, straat, postcode, woonplaats)
		  VALUES ('$email', '$wachtwoord', '$telnummer', '$straat', '$postcode', '$woonplaats' )";

		  $result = mysqli_query($connection, $query);

if ($result) {
	echo "U staat geregistreerd bij boot.";
		}
else
{
 	die ("Database query failed". mysql_error($connection));
}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <title>register</title>
</head>
<body>

<form action="register.php" method="POST">

		<input type="text" placeholder="email" name="email">

		<input type"password" placeholder="wachtwoord" name="wachtwoord">
		<input type"password" placeholder="wachtwoord" name="herhaal_wachtwoord">

		<input type="text" placeholder="tel. nummer" name="telnummer">
		<input type="text" placeholder="straat" name="straat">
		<input type="text" placeholder="postcode" name="postcode">
		<input type="text" placeholder="woonplaats" name="woonplaats">

		<input type="submit">

	</form>

<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script> or
<script src="js/script.js"></script>
</body>
</html>