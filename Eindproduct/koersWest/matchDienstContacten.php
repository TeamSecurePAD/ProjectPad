<?php
  session_start();

  // Make sure we're connected to the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, load a list of all available services, sorted by user
  if (isset($_SESSION['user_id']))
  {
    // User's session id, used to reference currently logged in user in database queries
    $id = $_SESSION['user_id'];
    $any_match = false;

    //Get the confirmd matches
    $query_match_dient_goedgekeurd = "SELECT gebruiker_Id
                                      FROM  match_diensten
                                      WHERE match_gebruiker_Id = $id 
                                      AND match_goedgekeurd = 1
                                      AND match_afgekeurd = 0";  

    $result_match_dienst_goedgekeurd =  mysqli_query($connection, $query_match_dient_goedgekeurd); 

    //gets all the service's you offer
    $query_bied_aan = "SELECT Dienst_dienst
                       FROM gebruiker_bied_dienst_aan
                       WHERE Gebruiker_Id = $id";

    $result_bied_aan = mysqli_query($connection, $query_bied_aan);

    //gets all the service's you offer
    $query_vraagt = "SELECT Dienst_dienst
                     FROM gebruiker_vraagt_dienst
                     WHERE Gebruiker_Id = $id";

    $result_vraagt = mysqli_query($connection, $query_vraagt);

    if (!empty($_POST['Afkeuren']))
    {
       $match_gebruiker_id = $_POST['Afkeuren'];

       if ($update = $connection->query("UPDATE match_diensten
                                         SET match_afgekeurd = 1
                                         WHERE gebruiker_Id = $match_gebruiker_id
                                         AND match_gebruiker_Id = $id "))
      {
          $message = "De match is verwijderd";
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
    <link rel="stylesheet" href="css/styles.css">
    <title>Dienst aanbieden</title>
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
          <div class = "block_dienst">
            <h1><c class = "white">Categorie matches</c></h1>
            <img class = "image" src = "images/contacts.png" width = "150" height = "150">
            <h2><c class = "white">Hier staan de goedgekeurde matches. Je kan nu zelf contact opnemen met je matches</c></h2>
          </div>
        </div>

        <!-- Subbody div indicates main area of user interaction and important content -->
        <div class = "subbody">

        <?php 
        // output the matches.

          while ($row_match_dienst_gevonden = $result_match_dienst_goedgekeurd->fetch_assoc()) 
          {

           $match_id = $row_match_dienst_gevonden['gebruiker_Id'];

           $query_match_goedgekeurd = "SELECT gebruiker_Id
                                       FROM  match_diensten
                                       WHERE gebruiker_Id = $id
                                       AND match_gebruiker_id = $match_id
                                       AND match_goedgekeurd = 1
                                       AND match_afgekeurd = 0";  

           $result_match_goedgekeurd =  mysqli_query($connection, $query_match_goedgekeurd);

            while ($row_match_goedgekeurd = $result_match_goedgekeurd->fetch_assoc()) 
            {


             $result_bied_aan -> data_seek(0);
             $result_vraagt -> data_seek(0);
             $any_match = true;
             $match_gebruiker_id = $row_match_dienst_gevonden['gebruiker_Id'];

             while ($row_bied_aan = $result_bied_aan->fetch_assoc()) 
              {
                 $dienst = $row_bied_aan['Dienst_dienst'];
                 
                 $query_match_aanbod = "SELECT Dienst_dienst
                                        FROM gebruiker_vraagt_dienst
                                        WHERE Dienst_dienst = '$dienst'
                                        And Gebruiker_Id = $match_gebruiker_id";

                 $result_match_aanbod = mysqli_query($connection, $query_match_aanbod);
                 $row_match_aanbod = mysqli_fetch_assoc($result_match_aanbod);

                 if (!empty($row_match_aanbod['Dienst_dienst'])) 
                 {
                  $gebruikerBiedAan = ($row_match_aanbod['Dienst_dienst']);
                 }

              }

              while ($row_vraagt = $result_vraagt->fetch_assoc()) 
              {
                 $dienst = $row_vraagt['Dienst_dienst'];
                 
                 $query_match_vraag = "SELECT Dienst_dienst
                                        FROM gebruiker_bied_dienst_aan
                                        WHERE Dienst_dienst = '$dienst'
                                        AND Gebruiker_Id = $match_gebruiker_id";

                 $result_match_vraag = mysqli_query($connection, $query_match_vraag);
                 $row_match_vraag = mysqli_fetch_assoc($result_match_vraag);

                 if (!empty($row_match_vraag['Dienst_dienst'])) 
                 {
                  $gebruikerVraagt = ($row_match_vraag['Dienst_dienst']);
                 }

              }

             $query_match_dienst_goedgekeurd = "SELECT naam, tussenvoegsel, achternaam, omschrijving, email, telefoonnummer
                                                FROM gebruiker
                                                WHERE Id = $match_gebruiker_id";

               $result_match_dienst_gegegevens =  mysqli_query($connection, $query_match_dienst_goedgekeurd);

               $row_match_dienst_gegevens = mysqli_fetch_assoc($result_match_dienst_gegegevens);

               $naam = $row_match_dienst_gegevens['naam'];
               $tussenvoegsel = $row_match_dienst_gegevens['tussenvoegsel'];
               $achternaam = $row_match_dienst_gegevens['achternaam'];
               $omschrijving = $row_match_dienst_gegevens['omschrijving'];
               $email = $row_match_dienst_gegevens['email'];
               $telefoonnummer = $row_match_dienst_gegevens['telefoonnummer'];

             $block_number = 1; 

             if (!empty($_POST['Afkeuren']))
              {
                if ($_POST['Afkeuren'] == $match_gebruiker_id)
                {
                  $block_number = 2;
                }
                else
                {
                  $block_number = 1;
                }
              }
             
             if ($block_number == 1) 
             {
          ?>
            <!-- Start of voorbeeld block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_dienst_extra_large">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Match</b></h3>
                  <p><b>Naam:</b> <?php echo ($naam);?>  <?php echo ($tussenvoegsel);?> <?php echo ($achternaam); ?> </p>
                  <p>Je bent gematcht op de diensten: <b><?php echo ($gebruikerBiedAan); ?> - <?php echo ($gebruikerVraagt)?></b></p>
                  <img class = "image" src = "<?php echo "images/".$gebruikerVraagt.".png"; ?>" width = "86" height = "86">
                  <br>
                  <p><b>Email: </b><?php echo ($email); ?></p>
                  <p><b>telefoonnummer: </b><?php echo ($telefoonnummer); ?></p>                
                </div>

                <!-- Submit button -->
                <div class = "service_button">
                  <form action="matchDienstContacten.php" method="POST">
                    <button type="submit" class="btn btn-danger">Verwijderen</button>
                    <input type="hidden" value= "<?php echo($match_gebruiker_id); ?>" name="Afkeuren"/>
                  </form>

                </div>
              </div>
            </div>
          <!-- End of block -->

        <?php
             }
             else if ($block_number == 2)
             {
        ?>
                <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
                  <div class = "block_confirmed_extra_large">

                    <!-- Block text -->
                    <div class = "media-body">
                      <h3 class = "media-heading"><b class = "white">Match</b></h3>
                        <p><b>Naam:</b> <?php echo ($naam);?>  <?php echo ($tussenvoegsel);?> <?php echo ($achternaam); ?> </p>
                        <p>Je bent gematcht op de diensten: <?php echo ($gebruikerBiedAan); ?> - <?php echo ($gebruikerVraagt)?></p>
                        <img class = "image" src = "<?php echo "images/".$gebruikerVraagt.".png"; ?>" width = "86" height = "86">

                      <h3 class = "media-heading" style = "position: absolute; bottom: 15px; left: 20%; right: 20%;"><b class = "white"><?php echo($naam)?> is uit de lijst verwijderd</b></h3>
                    </div>

                  </div>
                </div>        
        <?php
              }
            }
          }
          if (!$any_match) {
        ?>

          <!-- Start no match block-->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_dienst_extra_large">

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
                  <form action = "matchDienstIndex.php">
                    <button type = "submit" class = "btn btn-secondary" style = "color: black;">Klik om terug te gaan</button>
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