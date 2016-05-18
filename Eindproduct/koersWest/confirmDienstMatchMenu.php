<?php
  session_start();

  // Make sure we're connected to the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, load a list of all available services, sorted by user
  if (isset($_SESSION['user_id']))
  {
    // User's session id, used to reference currently logged in user in database queries
    $id = $_SESSION['user_id'];

        //Get the confirmd matches
    $query_match_dient_goedgekeurd = "SELECT match_gebruiker_Id, match_goedgekeurd, match_afgekeurd
                                      FROM  match_diensten
                                      WHERE gebruiker_Id = $id 
                                      AND match_goedgekeurd = 1
                                      AND match_afgekeurd = 0";  

    $result_match_dienst_goedgekeurd =  mysqli_query($connection, $query_match_dient_goedgekeurd); 

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
      
      <!-- Div with all the confirmed matches based on Service's  -->
      <h3>Goedgekeurde match<h3>
      <?php 
       
        // output the matches.
          while ($row_match_dienst_gevonden = $result_match_dienst_goedgekeurd->fetch_assoc()) 
          {
             $match_gebruiker_id = $row_match_dienst_gevonden['match_gebruiker_Id'];

             $query_match_dienst_goedgekeurd = "SELECT naam, tussenvoegsel, achternaam, omschrijving
                                         FROM gebruiker
                                         WHERE Id = $match_gebruiker_id";

               $result_match_dienst_goedgekeurd =  mysqli_query($connection, $query_match_dienst_goedgekeurd);

               $row_match_dienst_goedgekeurd = mysqli_fetch_assoc($result_match_dienst_goedgekeurd);

               $naam = $row_match_dienst_goedgekeurd['naam'];
               $tussenvoegsel = $row_match_dienst_goedgekeurd['tussenvoegsel'];
               $achternaam = $row_match_dienst_goedgekeurd['achternaam'];
               $omschrijving = $row_match_dienst_goedgekeurd['omschrijving'];

          ?>
          <div class="list service-content col-xs-offset-0 col-xs-12 col-sm-6 col-md-offset-0 col-md-4 col-lg-3">
            <h3>Match</h3>
              <p><b>Naam:</b> <?php echo ($naam);?>  <?php echo ($tussenvoegsel); echo ($achternaam); ?> </p>
              <p><b>Omschrijving:</b> <?php echo ($omschrijving); ?> </p>
            <form action="matchingMenu.php" method="POST">

              <input type="submit" name="Goedkeuren" value="Goedkeuren" />
              <input type="submit" name="Afkeuren" value="Afkeuren   " />

            </form><br>
          </div>

        <?php
        }
      ?>

    </div>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
</html>