<?php
session_start();

require 'databaseConnectionOpening.php';

  if (isset($_SESSION['user_id']))
  {
    $id = $_SESSION['user_id'];

    $query = "SELECT id, email, omschrijving, naam, tussenvoegsel, achternaam, telefoonnummer, straat, postcode, woonplaats
              FROM gebruiker
              WHERE id = $id";

    $result = mysqli_query($connection, $query);

    if ($result)
    {
      $row = mysqli_fetch_assoc($result);
      $gebruikerID = $row['id'];
      $dbemail = $row['email'];
      $dbstraat = $row['straat'];
      $dbtelnummer = $row['telefoonnummer'];
      $dbpostcode = $row['postcode'];
      $dbwoonplaats = $row['woonplaats'];
      $dbomschrijving = $row['omschrijving'];
      $dbnaam = $row['naam'];
      $dbtussenvoegsel = $row['tussenvoegsel'];
      $dbachternaam = $row['achternaam'];
    }

    if (!empty($_POST['email'])  && !empty($_POST['telnummer']) && !empty($_POST['straat']) 
    	&& !empty($_POST['postcode']) && !empty($_POST['woonplaats']) 
    	&& !empty($_POST['naam']) && !empty($_POST['achternaam']) &&
		!empty($_POST['omschrijving']))
	{

		// Save rest of form data in temporary variables
     	$dbemail = $_POST['email'];
    	$dbstraat = $_POST['straat'];
      	$dbtelnummer = $_POST['telnummer'];
     	$dbpostcode = $_POST['postcode'];
     	$dbwoonplaats = $_POST['woonplaats'];
      	$dbomschrijving = $_POST['omschrijving'];
      	$dbnaam = $_POST['naam'];
        $dbachternaam = $_POST['achternaam'];


		// Insert user data into the database
		$query_update = "UPDATE gebruiker
				  		 SET email = $dbemail, straat = $dbstraat, telnummer=$dbtelnummer, postcode = $dbpostcode, woonplaats = $dbwoonplaats
					  	 omschrijving = $dbomschrijving, naam = $dbnaam, tussenvoegsel = $dbtussenvoegsel, achternaam = $dbachternaam
			      		 WHERE id = $id";

			$result_update = mysqli_query($connection, $query);
		
		if ($result_update) 
		{
			echo "de gegevens zijn aangepast";
		}
		else 
		{
			echo "Er is een fout opgetreden tijdens het aanpassen";
		}

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
		<link rel="stylesheet" href="css/styles.min.css">
		<title>Gegevens</title>
	</head>

	<body>
		<?php 
		include("Navigation.php");
		?>

		<div class="container">

			<h1>Je kunt hier je gegevens aanpassen</h1>
			<p>Vergeet niet om op opslaan te klikken als je klaar ben!</p>

			<!-- Registration form -->
			<form action="userData.php" method="POST">

					<input class="form-control" type="text" placeholder="email" value = <?php echo ($dbemail); ?> name="email">

					<input class="form-control" type="text" placeholder="Naam" value = <?php echo ($dbnaam); ?> name="naam">
					<input class="form-control" type="text" placeholder="Tussenvoegsel" value = <?php echo ($dbtussenvoegsel); ?> name="tussenvoegsel">
					<input class="form-control" type="text" placeholder="Achternaam" value = <?php echo ($dbachternaam); ?> name="achternaam">

					<input class="form-control" type="text" placeholder="tel. nummer" value = <?php echo ($dbtelnummer); ?> name="telnummer">
					<input class="form-control" type="text" placeholder="straat" value = <?php echo ($dbstraat); ?> name="straat">
					<input class="form-control" type="text" placeholder="postcode" value = <?php echo ($dbpostcode); ?> name="postcode">
					<input class="form-control" type="text" placeholder="woonplaats" value = <?php echo ($dbwoonplaats); ?> name="woonplaats"><br>

					<input class="form-control" type="text" placeholder="Geef een korte beschijving van jezelf" value = <?php echo ($dbomschrijving); ?> name="omschrijving">

					<input style="margin: 10px;" type="submit" name="submit" value="Opslaan">

			</form>
		</div>

		<script src="js/jquery-2.1.4.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/script.js"></script>
	</body>
</html>