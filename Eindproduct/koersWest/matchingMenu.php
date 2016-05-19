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

  if (!empty($_POST['match_id']))

    {
      $match_id = $_POST['match_id'];

      if ($update = $connection->query("UPDATE match_categorie
                                        SET match_goedgekeurd = 1
                                        WHERE gebruiker_Id = $id
                                        AND match_gebruiker_Id = $match_id
                                        AND match_goedgekeurd = 0"))
      {

          $message = "de gegevens zijn naar verstuurd";
      }
    }

  //Gets the matches that are not confirmed.
  $query_match_gevonden = "SELECT match_gebruiker_Id, match_goedgekeurd, match_afgekeurd
                           FROM  match_categorie
                           WHERE gebruiker_Id = $id 
                           AND match_goedgekeurd = 0
                           AND match_afgekeurd = 0";  

  $result_match_gevonden =  mysqli_query($connection, $query_match_gevonden);

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
  <title>Match menu</title>
</head>

<body>
  <?php 
  include("Navigation.php");
  ?>
  <div class="container">
    <h1>Matches</h1>

    <!-- Added a extra nav bar for searching -->
    <nav class= "navbar navbar-inverse">
      <div class="container">
        <ul class= "nav navbar-nav">

          <li><a href="matchingMenu.php">Matches Categorieën</a></li>
          <li><a href="DienstMatchMenu.php">Matches Diensten</a></li>
          <li><a href="confirmCategorieMenu.php">Matches goedgekeurd catergorieën</a></li>
          <li><a href="confirmDienstMatchMenu.php">Matches goedgekeurd diensten</a></li>

        </ul>
      </div>
    </nav>

    <!-- Div with all unconfirmed matches -->
    <h3>Gevonden matches<h3>
      <p><?php echo ($message);?></p>
      <?php 
        // output the matches.
      while ($row_match_gevonden = $result_match_gevonden->fetch_assoc()) 
      {
       $match_gebruiker_id = $row_match_gevonden['match_gebruiker_Id'];

       $query_match_gegevens = "SELECT id, naam, tussenvoegsel, achternaam, omschrijving
       FROM gebruiker
       WHERE Id = $match_gebruiker_id";

       $result_match_gegevens =  mysqli_query($connection, $query_match_gegevens);

       if ( $result_match_gegevens) 
       {

         $row_match_gegevens = mysqli_fetch_assoc($result_match_gegevens);

         $id = $row_match_gegevens['id'];
         $naam = $row_match_gegevens['naam'];
         $tussenvoegsel = $row_match_gegevens['tussenvoegsel'];
         $achternaam = $row_match_gegevens['achternaam'];
         $omschrijving = $row_match_gegevens['omschrijving'];

         ?>
         <div class="list service-content col-xs-offset-0 col-xs-12 col-sm-6 col-md-offset-0 col-md-4 col-lg-3">
          <h3>Match</h3>
          <p><b>Naam:</b> <?php echo ($naam);?>  <?php echo ($tussenvoegsel); echo ($achternaam); ?> </p>
          <p><b>Omschrijving:</b> <?php echo ($omschrijving); ?> </p>

          <form action="matchingMenu.php" method="POST">
            <button type="submit" class="btn btn-primary">Gegevens sturen</button>
            <input type="hidden" value= "<?php echo($id); ?>" name="match_id"/>
          </form>

        </div>
        <?php
      }
      else 
      {
        ?>
        <h3>Op dit moment is er geen match gevonden.<h3>
          <?php
        }
      }
      ?>
    </div>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
  </html>