<?php
	session_start();

	// Return to index page if already logged in
	if (isset($_SESSION['user_id']))
	{
		header('location:home.php');
	}

	require 'databaseConnectionOpening.php';

	$list_categories = array();

	$query_all_categories = "SELECT Categorie FROM categorie";
	$result_all_categories = mysqli_query($connection, $query_all_categories);

	while ($row_categories = $result_all_categories->fetch_assoc())
	{
		$list_categories[] = $row_categories['Categorie'];
	}

	$message = '';

	if (!empty($_POST) && !empty($_POST['email']) && !empty($_POST['wachtwoord']) &&
		!empty($_POST['telnummer']) && !empty($_POST['straat']) &&
		!empty($_POST['postcode']) && !empty($_POST['woonplaats']) &&
		!empty($_POST['naam']) && !empty($_POST['achternaam']) &&
		!empty($_POST['omschrijving']))
	{
		// Save form data in temporary variables
		$isGoedIn = ($_POST['isGoedIn']);
		$isSlechtIn = ($_POST['isSlechtIn']);

		// Insert new user into the database
		if (!($isGoedIn == $isSlechtIn))
		{
			// Save rest of form data in temporary variables
			$email = strip_tags($_POST['email']);
			$wachtwoord = strip_tags($_POST['wachtwoord']);
			$telnummer = strip_tags($_POST['telnummer']);
			$straat = strip_tags($_POST['straat']);
			$postcode = strip_tags($_POST['postcode']);
			$woonplaats = strip_tags($_POST['woonplaats']);
			$naam = strip_tags($_POST['naam']);
			$achternaam = strip_tags($_POST['achternaam']);
			$omschrijving = strip_tags($_POST['omschrijving']);

			if (!empty($_POST['tussenvoegsel'])) 
			{
				$tussenvoegsel = strip_tags($_POST['tussenvoegsel']);
			}
			else 
			{
				$tussenvoegsel = "";
			}

			// Insert user data into the database
			$query = "INSERT INTO gebruiker (email, wachtwoord, omschrijving, naam, tussenvoegsel, achternaam, telefoonnummer, straat, postcode, woonplaats)
				  	  VALUES ('$email', '$wachtwoord', '$omschrijving', '$naam', '$tussenvoegsel', '$achternaam' ,'$telnummer', '$straat', '$postcode', '$woonplaats')";

			$result = mysqli_query($connection, $query);

			$query_get_user_id = "SELECT Id FROM gebruiker WHERE email = '$email'";
			$result_get_user_id = mysqli_query($connection, $query_get_user_id);
			$get_user_id = mysqli_fetch_assoc($result_get_user_id);
			$id = $get_user_id['Id'];

			// Insert competency data into the database
			$query_insert_goed_in = "INSERT INTO gebruiker_is_goed_in_categorie
				  	 			  	 VALUES ($id, '$isGoedIn')";

			// Insert incompetency data into the database
			$query_insert_slecht_in = "INSERT INTO  gebruiker_is_slecht_in_categorie
				  	 			  	   VALUES ($id, '$isSlechtIn')";

			$result_inset_goed_in = mysqli_query($connection, $query_insert_goed_in);
			$result_inset_slecht_in = mysqli_query($connection, $query_insert_slecht_in);

			if ($result && $result_inset_goed_in && $result_inset_slecht_in)
			{
				$message .= '<b style="font-size: 20px;" class="green">U staat geregistreerd bij KoersWest!</b><br>
							 <b style="font-size: 20px;" class="grey">Klik <a href="login.php">hier</a> om naar de inlogpagina te gaan.</b><br>';
			}
			else
			{
				$message .= '<b style="font-size: 20px;" class="red">Een onbekende fout heeft zich voorgedaan tijdens het registreren.</b>';
			}
		}
		else
		{
			$message .= '<b style="font-size: 20px;" class="red">Er is iets mis gegaan tijdens het registreren.</b><br>
						 <b style="font-size: 20px;" class="grey">Heeft u voor uw bekwaamheden twee keer hetzelfde ingevoerd?</b>';
		}
	}
	else
	{
		if (!empty($_POST))
		{
			$message .= '<b style="font-size: 20px;" class="red">U bent een veld vergeten in te vullen.</b>';
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
		<title>Registreren</title>
	</head>

	<body>
		<?php 
		include("Navigation.php");
		?>

		<div class="container">
			<h1>Registreren</h1>

			<!-- Registration form -->
			<form action="register.php" method="POST">

					<input class="form-control" type="text" placeholder="email" name="email">

					<input class="form-control" type="password" placeholder="wachtwoord" name="wachtwoord">
					<input class="form-control" type="password" placeholder="wachtwoord" name="herhaal_wachtwoord">

					<input class="form-control" type="text" placeholder="Naam" name="naam">
					<input class="form-control" type="text" placeholder="Tussenvoegsel" name="tussenvoegsel">
					<input class="form-control" type="text" placeholder="Achternaam" name="achternaam">

					<input class="form-control" type="text" placeholder="tel. nummer" name="telnummer">
					<input class="form-control" type="text" placeholder="straat" name="straat">
					<input class="form-control" type="text" placeholder="postcode" name="postcode">
					<input class="form-control" type="text" placeholder="woonplaats" name="woonplaats"><br>

					<input class="form-control" type="text" placeholder="Geef een korte beschijving van jezelf" name="omschrijving">

					<label for="selectCategorieGoedIn"><b style="font-size: 20px;" class="green">Ik ben goed in</b></label>
					<select class="form-control" id="selectCategorieGoedIn" name="isGoedIn">
					<?php
						foreach ($list_categories as $row) 
						{
	        				echo"<option>";
	        				echo ($row);
	        				echo "</option>";
	        			}
	        		?>	
					</select><br>

					<label for="selectCategorieSlechtIn"><b style="font-size: 20px;" class="red">Ik heb hulp nodig bij</b></label>
					<select class="form-control" id="selectCategorieSlechtIn" name="isSlechtIn">
					<?php
						foreach ($list_categories as $row) 
						{
	        				echo"<option>";
	        				echo ($row);
	        				echo "</option>";
	        			}
	        		?>
					</select>

					<input style="margin: 10px;" type="submit" name="submit" value="Registreren">
			</form>

			<?php
			// Display message indicating a successful registration process or an error
			if(!empty($message)):
				echo $message;
			endif;
			?>

			<br><br>
			<!-- Return to the index page 
			<b><a href="index.php">Terug</a></b>-->
		</div>

		<script src="js/jquery-2.1.4.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/script.js"></script>
	</body>
</html>