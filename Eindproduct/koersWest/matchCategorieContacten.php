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
  $query_match_goedgekeurd = "SELECT gebruiker_Id
                              FROM  match_categorie
                              WHERE match_gebruiker_id = $id
                              AND match_goedgekeurd = 1
                              AND match_afgekeurd = 0"; 

  $result_match_goedgekeurd =  mysqli_query($connection, $query_match_goedgekeurd); 

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
        <div class = "tile purple">
          <h1>Categorie contacten</h1>
          <img class = "image" src = "images/contacts.png" width = "150" height = "150">
          <h2>Hier staan de goedgekeurde matches. Je kan nu zelf contact opnemen met je contacten.</h2>
        </div>
      </div>

      <!-- Subbody div indicates main area of user interaction and important content -->
      <div class = "subbody">

        <?php 

        // output the matches.
        while ($row_match_goedgekeurd = $result_match_goedgekeurd->fetch_assoc()) 
        {

         $match_gebruiker_id = $row_match_goedgekeurd['gebruiker_Id'];

            //Get the confirmd matches
         $query_match_goedgekeurd_user = "SELECT gebruiker_Id
         FROM  match_categorie
         WHERE match_gebruiker_Id = $match_gebruiker_id
         AND gebruiker_Id = $id
         AND match_goedgekeurd = 1
         AND match_afgekeurd = 0"; 

         $result_match_goedgekeurd_user =  mysqli_query($connection, $query_match_goedgekeurd_user); 

         while ($row_match_goedgekeurd_user = $result_match_goedgekeurd_user->fetch_assoc()) {


           $any_match = true;

           $query_match_gegevens = "SELECT naam, tussenvoegsel, achternaam, omschrijving, email, telefoonnummer
                                    FROM gebruiker
                                    WHERE Id = $match_gebruiker_id";

           $result_match_gegevens =  mysqli_query($connection, $query_match_gegevens); 
           $row_match_gegevens = mysqli_fetch_assoc($result_match_gegevens);

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

           $naam = $row_match_gegevens['naam'];
           $tussenvoegsel = $row_match_gegevens['tussenvoegsel'];
           $achternaam = $row_match_gegevens['achternaam'];
           $omschrijving = $row_match_gegevens['omschrijving'];
           $email = $row_match_gegevens['email'];
           $telefoonnummer = $row_match_gegevens['telefoonnummer'];
           $talent = $row_talent['Categorie_Categorie'];
           $hulpNodig = $row_hulp_nodig['Categorie_Categorie'];


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

            <!-- Start of Contact block -->
            <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block purple extra_large">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b>Match</b></h3>
                  <p><b>Naam:</b> <?php echo ($naam);?>  <?php echo ($tussenvoegsel);?>  <?php echo ($achternaam); ?> </p>
                  <br>
                  <p><?php echo ($naam);?> kan hulp gebruiken bij de categorie <b><?php echo ($hulpNodig); ?></b> en is 
                   goed in de categorie <b><?php echo ($talent);?></b> </p>
                   <img class = "image" src = "<?php echo "images/".$talent.".png"; ?>" width = "86" height = "86">
                   <br><br>

                   <p><b>Email: </b><?php echo ($email); ?></p>
                   <p><b>telefoonnummer: </b><?php echo ($telefoonnummer); ?></p>
                 </div>

                 <!-- Submit button -->
                 <div class = "service_button">

                   <form action="matchCategorieContacten.php" method="POST">
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
            <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block bright_orange extra_large">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b>Match</b></h3>
                  <p><b>Naam:</b> <?php echo ($naam);?>  <?php echo ($tussenvoegsel); echo ($achternaam); ?> </p>
                  <br>
                  <p><?php echo ($naam);?> kan hulp gebruiken bij de categorie <b><?php echo ($hulpNodig); ?></b> en is 
                    goed in de categorie <b><?php echo ($talent);?></b> </p>
                    <img class = "image" src = "<?php echo "images/".$talent.".png"; ?>" width = "86" height = "86">
                    <br>

                    <h3 class = "media-heading" style = "position: absolute; bottom: 15px; left: 20%; right: 20%;"><b><?php echo($naam)?> is uit de lijst verwijderd</b></h3>
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
          <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
            <div class = "block purple extra_large">

              <!-- Block text -->
              <div class = "media-body">
                <h3 class = "media-heading"><b>Geen match</b></h3>
                <img class = "image" src = "images/NoResult.png" width = "150" height = "150"><br><br>
                Helaas is er geen match gevonden. Tijdens de spreekuren van Boot kunt u langs komen
                met dringende problemen.
              </div>


            </div>
          </div>
          <!-- End of block -->


          <?php
        }
        ?>

        <!-- Back button in list of services - returns the user to the list of categories -->
        <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
          <div class = "block gray large">

            <!-- Block text -->
            <div class = "media-body">
              <h3 class = "media-heading"><b>Terug naar Categorie matches</b></h3><br><br><br>
              <img class = "image" src = "images/backarrow.png" width = "150" height = "150"><br><br>
            </div>

            <!-- Submit button -->
            <div class = "service_button">
              <form action = "matchCategorieIndex.php">
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