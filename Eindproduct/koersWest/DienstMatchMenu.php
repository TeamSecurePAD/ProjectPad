<?php
  session_start();

  // Make sure we're connected to the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, load a list of all available services, sorted by user
  if (isset($_SESSION['user_id']))
  {
    // User's session id, used to reference currently logged in user in database queries
    $id = $_SESSION['user_id'];

    if (!empty($_POST['match_goedkeuren']))
    {
      $match_id = $_POST['match_goedkeuren'];

      if ($update = $connection->query("UPDATE match_diensten
                                        SET match_goedgekeurd = 1
                                        WHERE gebruiker_Id = $id
                                        AND match_gebruiker_Id = $match_id
                                        AND match_goedgekeurd = 0"))
      {
          $message = "de gegevens zijn naar verstuurd";
      }
    }

    if (!empty($_POST['match_negeren']))
    {
      $match_id = $_POST['match_negeren'];

      if ($update = $connection->query("UPDATE match_diensten
                                        SET match_afgekeurd = 1
                                        WHERE gebruiker_Id = $id
                                        AND match_gebruiker_Id = $match_id
                                        AND match_afgekeurd = 0"))
      {
          $message = "de gebruiker is verwijderd uit de lijst";
      }
    }

    //Gets the matches that are not confirmed.
    $query_match_dient_gevonden = "SELECT match_gebruiker_Id, match_goedgekeurd, match_afgekeurd
                                   FROM  match_diensten
                                   WHERE gebruiker_Id = $id 
                                   AND match_goedgekeurd = 0
                                   AND match_afgekeurd = 0";

    $result_match_dienst_gevonden = mysqli_query($connection, $query_match_dient_gevonden);


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
            <h1><c class = "white">matches Diensten</c></h1>
            <h2><c class = "white">In dit scherm kan je mensen gegevens sturen die tegenovergestelde 
              diensten aanbieden en vragen. De ander kan dan contact met je opnemen zodat jullie elkaar
              kunnen helpen.</c></h2>
          </div>
        </div>

        <!-- Subbody div indicates main area of user interaction and important content -->
        <div class = "subbody">

          <div class = "tile_info">
            <h3><b class = "white">matches</b></h3>
          </div>

          <?php 
       
        // output the matches.
          while ($row_match_dienst_gevonden = $result_match_dienst_gevonden->fetch_assoc()) 
          {
             $match_dienst_id = $row_match_dienst_gevonden['match_gebruiker_Id'];


              while ($row_bied_aan = $result_bied_aan->fetch_assoc()) 
              {
                 $dienst = $row_bied_aan['Dienst_dienst'];
                 
                 $query_match_aanbod = "SELECT Dienst_dienst
                                        FROM gebruiker_vraagt_dienst
                                        WHERE Dienst_dienst = '$dienst'
                                        And Gebruiker_Id = $match_dienst_id";

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
                                        AND Gebruiker_Id = $match_dienst_id";

                 $result_match_vraag = mysqli_query($connection, $query_match_vraag);
                 $row_match_vraag = mysqli_fetch_assoc($result_match_vraag);

                 $gebruikerVraagt = ($row_match_vraag['Dienst_dienst']);

                 if (!empty($row_match_vraagt['Dienst_dienst'])) 
                 {
                  $gebruikerVraagt = ($row_match_vraag['Dienst_dienst']);
                 }

              }

             $query_match_dienst = "SELECT naam, tussenvoegsel, achternaam, omschrijving
                                    FROM gebruiker
                                    WHERE Id = $match_dienst_id";

              $result_match_dienst =  mysqli_query($connection, $query_match_dienst);

               $row_match_dienst = mysqli_fetch_assoc($result_match_dienst);

               $naam = $row_match_dienst['naam'];
               $tussenvoegsel = $row_match_dienst['tussenvoegsel'];
               $achternaam = $row_match_dienst['achternaam'];
               $omschrijving = $row_match_dienst['omschrijving'];

          ?>

            <!-- Start of voorbeeld block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_info_large">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Match</b></h3>
                    <p><b>Naam:</b> <?php echo ($naam);?>  <?php echo ($tussenvoegsel); echo ($achternaam); ?> </p>
                    <p><b>Omschrijving:</b> <?php echo ($omschrijving); ?> </p>
                    <p>Je bent gematcht op de diensten: <?php echo ($gebruikerBiedAan); ?> - <?php echo ($gebruikerVraagt)?></p>
                </div>

                <!-- Submit button -->
                <div class = "service_button">

                  <form action = "matchingMenu.php" method="POST">
                    <button type="submit" class="btn btn-info">Gegevens sturen</button>
                    <input type="hidden" value= "<?php echo($match_dienst_id); ?>" name="match_goedkeuren"/>
                  </form>

                  <br>

                  <form action = "matchingMenu.php" method="POST">
                    <button type="submit" class="btn btn-info">Negeren</button>
                    <input type="hidden" value= "<?php echo($match_dienst_id); ?>" name="match_negeren"/>
                  </form>

                </div>
              </div>
            </div>
            <!-- End of block -->
          <?php
            }
          ?>

            <!-- Back button in list of services - returns the user to the list of categories -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_info">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Terug naar match menu</b></h3>
                  <img class = "image" src = "images/backarrow.png" width = "150" height = "150"><br><br>
                </div>

                <!-- Submit button -->
                <div class = "service_button">
                  <form action = "matchNavigationMenu.php">
                    <button type = "submit" class = "btn btn-info">Klik om terug te gaan</button>
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