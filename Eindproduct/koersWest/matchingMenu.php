<?php
session_start();
  // Make sure we're connected to the database
require 'databaseConnectionOpening.php';
  // If a user is logged in, load a list of all available services, sorted by user
if (isset($_SESSION['user_id']))
{
    // User's session id, used to reference currently logged in user in database queries
  $id = $_SESSION['user_id'];
  $message = "";

  //Gets the matches that are not confirmed.
  $query_match_gevonden = "SELECT match_gebruiker_Id, match_goedgekeurd, match_afgekeurd
                           FROM  match_categorie
                           WHERE gebruiker_Id = $id 
                           AND match_goedgekeurd = 0
                           AND match_afgekeurd = 0";

  $result_match_gevonden =  mysqli_query($connection, $query_match_gevonden);

    if (!empty($_POST['gekeurd']))
    {
      echo "test";
      $match_id = $_POST['match_id'];

      if ($_POST['gekeurd'] == "goedgekeurd") 
      {
        if ($update = $connection->query("UPDATE match_categorie
                                          SET match_goedgekeurd = 1
                                          WHERE gebruiker_Id = $id
                                          AND match_gebruiker_Id = $match_id
                                          AND match_goedgekeurd = 0"))
        {
            echo ("succes");
        }
      }
      else if ($_POST['gekeurd'] == "afgekeurd")
      {
          if ($update = $connection->query("UPDATE match_categorie
                                          SET match_afgekeurd = 1
                                          WHERE gebruiker_Id = $id
                                          AND match_gebruiker_Id = $match_id
                                          AND match_afgekeurd = 0"))
        {
        $message = "de gebruiker is verwijderd uit de lijst";
        }
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
          <div class = "tile_info">
            <h1><c class = "white">Talent matches</c></h1>
            <h2><c class = "white">In dit scherm kan je mensen gegevens sturen die tegenovergestelde 
              talenten hebben. De ander kan dan contact met je opnemen zodat jullie elkaar
             kunnen helpen.</c></h2>
          </div>
        </div>

        <!-- Subbody div indicates main area of user interaction and important content -->
        <div class = "subbody">

          <div class = "tile_info">
            <h3><b class = "white">Gevonden matches</b></h3>
          </div>

         <?php 
         $any_match = false;
        // output the matches.
      while ($row_match_gevonden = $result_match_gevonden->fetch_assoc()) 
      {
        $any_match = true;

       $match_gebruiker_id = $row_match_gevonden['match_gebruiker_Id'];
       $query_match_gegevens = "SELECT id, naam, tussenvoegsel, achternaam, omschrijving
                                FROM gebruiker
                                WHERE Id = $match_gebruiker_id";

       $result_match_gegevens =  mysqli_query($connection, $query_match_gegevens);
       
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

       if ( $result_match_gegevens) 
       {
         $row_match_gegevens = mysqli_fetch_assoc($result_match_gegevens);
         $id = $row_match_gegevens['id'];
         $naam = $row_match_gegevens['naam'];
         $tussenvoegsel = $row_match_gegevens['tussenvoegsel'];
         $achternaam = $row_match_gegevens['achternaam'];
         $omschrijving = $row_match_gegevens['omschrijving'];
         $talent = $row_talent['Categorie_Categorie'];
         $hulpNodig = $row_hulp_nodig['Categorie_Categorie'];

         $block_number = 1;

         if (!empty($_POST['gekeurd']))
         {

          if  ($_POST['gekeurd'] == "goedgekeurd" && $_POST['match_id'] == $match_gebruiker_id ) 
          {  
              $block_number = 2;
          }

          if  ($_POST['gekeurd'] == "afgekeurd" && $_POST['match_id'] == $match_gebruiker_id ) 
          {             
              $block_number = 3;
          }

         }

         if ($block_number == 1){
         ?>

          <!-- Start of voorbeeld block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_info_medium">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Match</b></h3>
                  <p><b>Naam:</b> <?php echo ($naam);?>  <?php echo ($tussenvoegsel);?> <?php echo ($achternaam); ?> </p>
                  <p><?php echo ($naam);?> kan hulp gebruiken bij de categorie <b><?php echo ($hulpNodig); ?></b> en is 
                     goed in de categorie <b><?php echo ($talent);?></b> </p>
                <img class = "image" src = "<?php echo "images/".$talent.".png"; ?>" width = "86" height = "86"><br><br>
                </div>

                <!-- Submit button -->
                <div class = "service_button">
                  <form action = "matchingMenu.php" method="POST">
                    <button type="submit" class="btn btn-success" value= "goedgekeurd" name="gekeurd">Gegevens sturen</button>
                    <button type="submit" class="btn btn-danger" value= "afgekeurd" name="gekeurd">Afwijzen</button>                    
                    <input type="hidden" value= "<?php echo($id); ?>" name="id"/>
                    <input type="hidden" value= "<?php echo($match_gebruiker_id); ?>" name="match_id"/>
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
                        <div class = "block_confirmed_medium">

                          <!-- Block text -->
                          <div class = "media-body">
                            <h3 class = "media-heading"><b class = "white">Match</b></h3>
                            <p><b>Naam:</b> <?php echo ($naam);?>  <?php echo ($tussenvoegsel);?> <?php echo ($achternaam); ?> </p>
                            <p><?php echo ($naam);?> kan hulp gebruiken bij de categorie <b><?php echo ($hulpNodig); ?></b> en is 
                            goed in de categorie <b><?php echo ($talent);?></b> </p>
                            <img class = "image" src = "<?php echo "images/".$talent.".png"; ?>" width = "86" height = "86"><br>
                            

                            <h3 class = "media-heading" style = "position: absolute; bottom: 15px; left: 20%; right: 20%;"><b class = "white">Je gegevens zijn naar <?php echo($naam)?> verstuurd. </b></h3>
                          </div>

                        </div>
                      </div>
                    <?php

                }
              
              else if ($block_number == 3)
              {
                ?>
                <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
                  <div class = "block_confirmed_medium">

                    <!-- Block text -->
                    <div class = "media-body">
                      <h3 class = "media-heading"><b class = "white">Match</b></h3>
                       <p><b>Naam:</b> <?php echo ($naam);?>  <?php echo ($tussenvoegsel);?> <?php echo ($achternaam); ?> </p>
                       <p><?php echo ($naam);?> kan hulp gebruiken bij de categorie <b><?php echo ($hulpNodig); ?></b> en is 
                        goed in de categorie <b><?php echo ($talent);?></b> </p>
                      <img class = "image" src = "<?php echo "images/".$talent.".png"; ?>" width = "86" height = "86"><br>

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
              <div class = "block_info_medium">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Geen match</b></h3>
                  <img class = "image" src = "images/NoResult.png" width = "150" height = "150"><br><br>
                  <p>Er is op dit moment niks voor u om te bevestigen. Kom nog eens terug op een later moment.</p>
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
                  <h3 class = "media-heading"><b class = "white">Terug naar Match Menu</b></h3>
                  <img class = "image" src = "images/backarrow.png" width = "150" height = "150"><br><br>
                </div>

                <!-- Submit button -->
                <div class = "service_button">
                  <form action = "matchNavigationMenu.php">
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