<?php
	session_start();

	// Return to index page if already logged in
	if (isset($_SESSION['user_id']))
	{
		header('location:index.php');
	}

	require 'databaseConnectionOpening.php';

	if (!empty($_POST['email']) && !empty($_POST['wachtwoord']))
	{
		// Save form data in temporary variables
		$email = strip_tags($_POST['email']);
		$wachtwoord = strip_tags($_POST['wachtwoord']);
		$telnummer = strip_tags($_POST['telnummer']);
		$straat = strip_tags($_POST['straat']);
		$postcode = strip_tags($_POST['postcode']);
		$woonplaats = strip_tags($_POST['woonplaats']);

		// Insert form data into the database
		$query = "INSERT INTO gebruiker (email, wachtwoord, telefoonnummer, straat, postcode, woonplaats)
			  	  VALUES ('$email', '$wachtwoord', '$telnummer', '$straat', '$postcode', '$woonplaats')";

		$result = mysqli_query($connection, $query);

		// Successful registration
		if ($result)
		{
			echo "U staat geregistreerd bij boot.";
		}
		else // Failed registration
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
		<title>Register</title>
	</head>

	<body>
	<h1>Register</h1>

		<!-- Registration form -->
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

		<!-- Return to the index page -->
		<a href="index.php">Terug</a>

		<script src="js/jquery-2.1.4.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/script.js"></script>
	</body>
</html>