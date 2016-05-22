<?php
  session_start();

  // Make sure we're connected to the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, load a list of all available services, sorted by user
  if (isset($_SESSION['user_id']))
  {
    // User's session id, used to reference currently logged in user in database queries
    $id = $_SESSION['user_id'];

    if (!empty($_POST['Afkeuren']))
    {
       $match_gebruiker_id = $_POST['Afkeuren'];

       if ($update = $connection->query("UPDATE match_categorie
                                         SET match_afgekeurd = 1
                                         WHERE gebruiker_Id = $match_gebruiker_id
                                         AND match_gebruiker_Id = $id "))
      {
          $message = "De match is verwijderd";
      }

    }

    //Get the confirmd matches
    $query_match_goedgekeurd = "SELECT gebruiker_Id, match_goedgekeurd, match_afgekeurd
                                FROM  match_categorie
                                WHERE match_gebruiker_id = $id
                                AND match_goedgekeurd = 1
                                AND match_afgekeurd = 0";  

    $result_match_goedgekeurd =  mysqli_query($connection, $query_match_goedgekeurd);      

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
    <title>Dienst aanbieden</title>
  </head>

  <body>

    <!-- Container that houses all the elements on the page -->
    <div class = "container">
      <!-- Body div that contains all elements of the page - lighter gray backdrop than page background for emphasis on interactible environment -->
      <div class = "body col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <!-- Title div that surrounds colored title band - white backdrop to further emphasize subsection -->
        <div class = "title">
          <!-- Green band to indicate content section with actual title elements -->
          <div class = "tile_info">
            <h1><c class = "white">Netwerk Talenten</c></h1>
            <h2><c class = "white">Hieronder staan contact gegevens van mensen met tegenovergestelde talenten. Je kan nu zelf contact opnemen. </c></h2>
          </div>
        </div>

        <!-- Subbody div indicates main area of user interaction and important content -->
        <div class = "subbody">

          <div class = "tile_info">
            <h3><b class = "white">Matches</b></h3>
          </div>

        <?php 
          
          $any_match = false;
        // output the matches.
          while ($row_match_goedgekeurd = $result_match_goedgekeurd->fetch_assoc()) 
          {
             $any_match = true;
             $match_gebruiker_id = $row_match_goedgekeurd['gebruiker_Id'];

             $query_match_goedgekeurd = "SELECT naam, tussenvoegsel, achternaam, omschrijving, email, telefoonnummer
                                         FROM gebruiker
                                         WHERE Id = $match_gebruiker_id";

              $result_match_goedgekeurd =  mysqli_query($connection, $query_match_goedgekeurd); 
              $row_match_goedgekeurd = mysqli_fetch_assoc($result_match_goedgekeurd);
            
             $query_talent = "SELECT Categorie_Categorie 
                              FROM gebruiker_is_goed_in_categorie
                              WHERE Gebruiker_id = $match_gebruiker_id";

             $result_talent =  mysqli_query($connection, $query_talent);
             $row_talent = mysqli_fetch_assoc($result_talent);

             $query_hulp_nodig = "SELECT Categorie_Categorie 
                                  FROM gebruiker_is_slecht_in_categorie
                                  WHERE Gebruiker_id = $match_gebruiker_id";

             $result_hulp_nodig =  mysqli_query($connection, $query_hulp_nodig);
             $row_hulp_nodig = mysqli_fetch_assoc($result_hulp_nodig);       



               $naam = $row_match_goedgekeurd['naam'];
               $tussenvoegsel = $row_match_goedgekeurd['tussenvoegsel'];
               $achternaam = $row_match_goedgekeurd['achternaam'];
               $omschrijving = $row_match_goedgekeurd['omschrijving'];
               $email = $row_match_goedgekeurd['email'];
               $telefoonnummer = $row_match_goedgekeurd['telefoonnummer'];
               $talent = $row_talent['Categorie_Categorie'];
               $hulpNodig = $row_hulp_nodig['Categorie_Categorie'];

          ?>

            <!-- Start of Contact block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_info_large">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Match</b></h3>
                  <p><b>Naam:</b> <?php echo ($naam);?>  <?php echo ($tussenvoegsel); echo ($achternaam); ?> </p>
                  <p><b>Omschrijving:</b> <?php echo ($omschrijving); ?> </p>
                  <br>
                  <p><?php echo ($naam);?> kan hulp gebruiken bij de categorie <b><?php echo ($hulpNodig); ?></b> en is 
                     goed in de categorie <b><?php echo ($talent);?></b> </p>
                  <p><b>Email: </b><?php echo ($email); ?></p>
                  <p><b>telefoonnummer: </b><?php echo ($telefoonnummer); ?></p>
                </div>

                <!-- Submit button -->
                <div class = "service_button">

                   <form action="ConfirmCategorieMenu.php" method="POST">
                    <button type="submit" class="btn btn-primary">Verwijderen</button>
                    <input type="hidden" value= "<?php echo($match_gebruiker_id); ?>" name="Afkeuren"/>
                  </form>

                </div>
              </div>
            </div>
            <!-- End of block -->

        <?php
          }
          if (!$any_match) {
        ?>

          <!-- Start no match block-->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_info_large">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Geen match</b></h3>
                  <img class = "image" src = "images/NoResult.png" width = "150" height = "150"><br><br>
                  Helaas nog geen match gevonden. Tijdens de spreekuren van Boot kunt u langs komen
                  met dringende problemen.
                </div>


              </div>
            </div>
            <!-- End of block -->


        <?php
          }
        ?>

            <!-- Back button in list of services - returns the user to the list of categories -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_grey">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Terug naar match menu</b></h3>
                  <img class = "image" src = "images/backarrow.png" width = "150" height = "150"><br><br>
                </div>

                <!-- Submit button -->
                <div class = "service_button">
                  <form action = "matchNavigationMenu.php">
                    <button type = "submit" class = "btn btn-primary">Klik om terug te gaan</button>
                  </form>
                </div>
              </div>
            </div>
            <!-- End of block -->

        </div>
      </div>
    </div>
    <br>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
</html>