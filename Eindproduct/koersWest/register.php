<?php
	session_start();

	// Return to index page if already logged in
	if (isset($_SESSION['user_id']))
	{
		header('location:index.php');
	}
	require 'databaseConnectionOpening.php';

	/*Code to determene at with step of the register procces the user is*/

	$message = "";
	$stepNumber = 1;
	$id = 0;

	if (!empty($_POST['id']))
	{
		$id = $_POST['id'];
	}

	if (!empty($_POST['stepNumber'])) 
	{
		
	if 	(!empty($_POST) && !empty($_POST['email']) && !empty($_POST['wachtwoord']) &&
		!empty($_POST['telnummer']) && !empty($_POST['straat']) &&
		!empty($_POST['postcode']) && !empty($_POST['woonplaats']) &&
		!empty($_POST['naam']) && !empty($_POST['achternaam']))
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

			if (!empty($_POST['tussenvoegsel'])) 
			{
				$tussenvoegsel = strip_tags($_POST['tussenvoegsel']);
			}
			else 
			{
				$tussenvoegsel = "";
			}

				$query = "INSERT INTO gebruiker (email, wachtwoord, omschrijving, 
									  naam, tussenvoegsel, achternaam, telefoonnummer,
									  straat, postcode, woonplaats)

				  	  	  VALUES ('$email', '$wachtwoord', 'hoi', '$naam',
				  	  	  		  '$tussenvoegsel', '$achternaam' ,'$telnummer',
				  	  	  		  '$straat', '$postcode', '$woonplaats')";

			$result = mysqli_query($connection, $query);

			$query_get_user_id = "SELECT Id FROM gebruiker WHERE email = '$email'";
			$result_get_user_id = mysqli_query($connection, $query_get_user_id);
			$get_user_id = mysqli_fetch_assoc($result_get_user_id);

			$id = $get_user_id['Id'];
			$stepNumber = 2;

		} 
		else
		{
			$message = "Je bent een veld vergeten in te vullen";
		}

	}
	
	if (!empty($_POST['gekozen_categorie']))
	{
		$stepNumber = 2;	
	}

	if (!empty($_POST['bevestig_categorie']))
	{	
		$bevestigCatergorie = $_POST['bevestig_categorie'];
		// Insert competency data into the database
		$query_insert_goed_in = "INSERT INTO gebruiker_is_goed_in_categorie
				  	 			 VALUES ($id, '$bevestigCatergorie')";

		$result_inset_goed_in = mysqli_query($connection, $query_insert_goed_in);

		$stepNumber = 3;

	}

	if (!empty($_POST['gekozen_slecht_in_categorie']))
	{
		$stepNumber = 3;	
	}

	if (!empty($_POST['bevestig_slecht_in_categorie']))
	{	
		$bevestigCatergorie = $_POST['bevestig_slecht_in_categorie'];
		// Insert competency data into the database
		$query_insert_goed_in = "INSERT INTO gebruiker_is_slecht_in_categorie
				  	 			 VALUES ($id, '$bevestigCatergorie')";

		$result_inset_goed_in = mysqli_query($connection, $query_insert_goed_in);

		$stepNumber = 4;

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
    <title>Registratie</title>
  </head>

  <body>
  	<?php
    include("title.php");
    ?>

    <!-- Container that houses all the elements on the page -->
    <div class = "container">
      <!-- Body div that contains all elements of the page - lighter gray backdrop than page background for emphasis on interactible environment -->
      <div class = "body col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <!-- Title div that surrounds colored title band - white backdrop to further emphasize subsection -->
        <div class = "title">
          <!-- Green band to indicate content section with actual title elements -->
          <div class = "tile_info">
            <h1><c class = "white">Registreren</c></h1>
            <h2><c class = "white">Vul uw gegevens hieronder in</c></h2>
          </div>
        </div>

        <!-- Subbody div indicates main area of user interaction and important content -->
        <div class = "subbody">

        <?php if ($stepNumber == 1) 
    			 {
    			 ?>

          <div class = "tile_info">
            <h3><b class = "white">Gegevens</b></h3>
            <?php 
            if (!empty($message)) {
            	?>

            <!-- Error message block - informs the user of any errors in the login process -->
            <div class = "block col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class = "block_error_small_orange">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Let op</b></h3>
                  <img class = "image" src = "images/warning.png" width = "86" height = "86"><br>
                  <b class = "white"> <?php echo ($message); ?></b>
                </div>

              </div>
            </div>
            <!-- End of block -->            	

            	<?php
            }
            ?>
            <!-- Start of register block -->
            <div class = "block  col-xs-12 col-sm-12 col-md-6 col-lg-6">
              <div class = "block_info">

                <!-- Block text -->
                <div class = "media-body">
                  			<!-- Registration form --> 
					<form action="register.php" method="POST"> 

					<h4>Inloggegevens</h4>
					<input class="form-control" type="text" placeholder="email" name="email">
					<input class="form-control" type="password" placeholder="wachtwoord" name="wachtwoord">
					<input class="form-control" type="password" placeholder="wachtwoord" name="herhaal_wachtwoord">
					
					<br>
					<h4>Persoonsgegevens</h4>
					<input class="form-control" type="text" placeholder="Naam" name="naam">
					<input class="form-control" type="text" placeholder="Tussenvoegsel   (Optioneel)" name="tussenvoegsel">
					<input class="form-control" type="text" placeholder="Achternaam" name="achternaam">
					<br>
					<input class="form-control" type="text" placeholder="tel. nummer" name="telnummer">
					<input class="form-control" type="text" placeholder="straat" name="straat">
					<input class="form-control" type="text" placeholder="postcode" name="postcode">
					<input class="form-control" type="text" placeholder="woonplaats" name="woonplaats"><br>

					<button type = "submit" class = "btn btn-primary" value= "StepOne" name="stepNumber">Verzenden</button>
					</form>
                </div>

              </div>
            </div>
            <!-- End of block -->

            <!-- Back button in list of services - returns the user to the list of categories -->
            <div class = "block  col-xs-12 col-sm-12 col-md-6 col-lg-6">
              <div class = "block_grey">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Terug naar categorieën</b></h3>
                  <img class = "image" src = "images/backarrow.png" width = "150" height = "150"><br><br>
                </div>

                <!-- Submit button -->
                <div class = "service_button">
                  <form action = "home.php">
                    <button type = "submit" class = "btn btn-secondary" style = "color: black;">Klik om terug te gaan</button>
                  </form>
                </div>
              </div>
            </div>
            <!-- End of block -->

           	<?php 
           	 }
           	 else if ($stepNumber == 2)
           	 {
           	 	// Provides a list of all categories in the database
    			$query_all_categories = "SELECT categorie FROM categorie";
    			$categories = mysqli_query($connection, $query_all_categories);

    		?>
    		<div class = "tile_info">
            <h3><b class = "white">Kies een categorie waar je goed in bent</b></h3>

    		<?php
       
           	   while($current_category = $categories->fetch_assoc())
	            {

	             $blockNumber = 1;

	             if (!empty($_POST['gekozen_categorie']))
	             {
	             	if ($_POST['gekozen_categorie'] == $current_category['categorie'])
	             	{
	             		$blockNumber = 2;
	             	}
	             	else 
	             	{
	             		$blockNumber = 1;
	             	}
	             }

	             if ($blockNumber == 1)
	             	{
	              ?>
	              <!-- Block that shows a service category -->
	              <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
	                <div class = "block_offer_service_small">

	                  <!-- Block text -->
	                  <div class = "media-body">
	                    <h3 class = "media-heading"><b class = "white"><?php echo $current_category['categorie'];?></b></h3>
	                    <img class = "image" src = "<?php echo "images/".$current_category['categorie'].".png"; ?>" width = "86" height = "86"><br><br>
	                  </div>

	                  <!-- Submit button -->
	                  <form action = "register.php" method = "POST">
	                    <button type = "submit" class = "btn btn-primary" value = "Diensten bekijken">Kiezen</button>
	                    <input type = "hidden" value = "<?php echo $current_category['categorie']; ?>" name = "gekozen_categorie"/>
	                    <input type = "hidden" value = "<?php echo $id; ?>" name = "id"/>
	                  </form>

	                </div>
	              </div>

           	<?php
           		  	 }
           		  	 else if ($blockNumber == 2)
           		  	 {
           	?>

	              <!-- Block that shows a service category -->
	              <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
	                <div class = "block_confirmed_small">

	                  <!-- Block text -->
	                  <div class = "media-body">
	                    <h3 class = "media-heading"><b class = "white"><?php echo $current_category['categorie'];?></b></h3>
	                    <img class = "image" src = "<?php echo "images/".$current_category['categorie'].".png"; ?>" width = "86" height = "86"><br><br>
	                  </div>

	                  <!-- Submit button -->
	                  <form action = "register.php" method = "POST">
	                    <button type = "submit" class = "btn btn-primary" value = "Diensten bekijken">Bevestigen</button>
	                    <input type = "hidden" value = "<?php echo $current_category['categorie']; ?>" name = "bevestig_categorie"/>
	                    <input type = "hidden" value = "<?php echo $id; ?>" name = "id"/>
	                  </form>

	                </div>
	              </div>
           	<?php

           		  	 }
           	 	 }
           	 	}
           	 	 else if ($stepNumber == 3) 
           	 	 {

	           	 	// Provides a list of all categories in the database
	    			$query_all_categories = "SELECT categorie FROM categorie";
	    			$categories = mysqli_query($connection, $query_all_categories);

	           	 	 $blockNumber = 1;

	           	 	  ?>
		    		<div class = "tile_info">
		            <h3><b class = "white">Kies een categorie waar je hulp bij kan gebruiken</b></h3>

		    		<?php


		        while($current_category = $categories->fetch_assoc())
	            {

	           		  if (!empty($_POST['gekozen_slecht_in_categorie']))
		             {
		             	if ($_POST['gekozen_slecht_in_categorie'] == $current_category['categorie'])
		             	{
		             		$blockNumber = 2;
		             	}
		             	else 
		             	{
		             		$blockNumber = 1;
		             	}
		             }

	             	if ($blockNumber == 1)
	             	{		             
			           	?>

	              <!-- Block that shows a service category -->
	              <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
	                <div class = "block_ask_for_service_small">

	                  <!-- Block text -->
	                  <div class = "media-body">
	                    <h3 class = "media-heading"><b class = "white"><?php echo $current_category['categorie'];?></b></h3>
	                    <img class = "image" src = "<?php echo "images/".$current_category['categorie'].".png"; ?>" width = "86" height = "86"><br><br>
	                  </div>

	                  <!-- Submit button -->
	                  <form action = "register.php" method = "POST">
	                    <button type = "submit" class = "btn btn-primary" value = "Diensten bekijken">Kiezen</button>
	                    <input type = "hidden" value = "<?php echo $current_category['categorie']; ?>" name = "gekozen_slecht_in_categorie"/>
	                    <input type = "hidden" value = "<?php echo $id; ?>" name = "id"/>
	                  </form>

	                </div>
	              </div>			           	


			           	<?php
           			}
           			else if ($blockNumber == 2) 
           			{
           				?>
			              <!-- Block that shows a service category -->
			              <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
			                <div class = "block_confirmed_small">

			                  <!-- Block text -->
			                  <div class = "media-body">
			                    <h3 class = "media-heading"><b class = "white"><?php echo $current_category['categorie'];?></b></h3>
			                    <img class = "image" src = "<?php echo "images/".$current_category['categorie'].".png"; ?>" width = "86" height = "86"><br><br>
			                  </div>

			                  <!-- Submit button -->
			                  <form action = "register.php" method = "POST">
			                    <button type = "submit" class = "btn btn-primary" value = "Diensten bekijken">Bevestigen</button>
			                    <input type = "hidden" value = "<?php echo $current_category['categorie']; ?>" name = "bevestig_slecht_in_categorie"/>
			                    <input type = "hidden" value = "<?php echo $id; ?>" name = "id"/>
			                  </form>

			                </div>
			              </div>
           				<?php
           				}	
           			}
           		}
           		else if ($stepNumber == 4)
           		{
           			?>
           				<!-- Block that shows a service category -->
			              <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
			                <div class = "block_confirmed_small">

			                  <!-- Block text -->
			                  <div class = "media-body">
			                    <h3 class = "media-heading"><b class = "white">Acount aangemaakt!</b></h3><br>
			                    <p>Je acount is succesvol aangemaakt. Je kan nu naar het inlogscherm gaan.</p>
			                    <img class = "image" src = "<?php echo "images/"."thumbsUp".".png"; ?>" width = "86" height = "86"><br><br>
			                  </div>

			                  <!-- Submit button -->
			                  <form action = "login.php" method = "POST">
			                    <button type = "submit" class = "btn btn-primary" value = "Diensten bekijken">Inloggen</button>
			                  </form>

			                </div>
			              </div>
           			<?php
           		}
           	?>

        </div>
      </div>
    </div>
    <br>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
</html>