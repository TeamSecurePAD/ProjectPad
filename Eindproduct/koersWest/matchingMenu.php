<?php
  session_start();

  // Make sure we're connected to the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, load a list of all available services, sorted by user
  if (isset($_SESSION['user_id']))
  {
    // User's session id, used to reference currently logged in user in database queries
    $id = $_SESSION['user_id'];

    //Gets the matches that are not confirmed.
    $query_match_gevonden = "SELECT match_gebruiker_Id, match_goedgekeurd, match_afgekeurd
                             FROM  match_categorie
                             WHERE gebruiker_Id = $id 
                             AND match_goedgekeurd = 0
                             AND match_afgekeurd = 0";  

    $result_match_gevonden =  mysqli_query($connection, $query_match_gevonden);   

    //Get the confirmd matches
    $query_match_goedgekeurd = "SELECT match_gebruiker_Id, match_goedgekeurd, match_afgekeurd
                             FROM  match_categorie
                             WHERE gebruiker_Id = $id 
                             AND match_goedgekeurd = 1
                             AND match_afgekeurd = 0";  

    $result_match_goedgekeurd =  mysqli_query($connection, $query_match_gevonden);      

    //Gets the matches that are not confirmed.
    $query_match_dient_gevonden = "SELECT match_gebruiker_Id, match_goedgekeurd, match_afgekeurd
                                   FROM  match_dienst
                                   WHERE gebruiker_Id = $id 
                                   AND match_goedgekeurd = 0
                                   AND match_afgekeurd = 0";  

    $result_match_dienst_gevonden =  mysqli_query($connection, $query_match_dient_gevonden);   
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
      <div class="list service-content col-xs-offset-0 col-xs-12 col-sm-6 col-md-offset-0 col-md-4 col-lg-3">
      <h3>Gevonden matches<h3>
      <?php 
        // output the matches.
        while ($row_match_gevonden = $result_match_gevonden->fetch_assoc()) 
        {
           $match_gebruiker_id = $row_match_gevonden['match_gebruiker_Id'];

           $query_match_gegevens = "SELECT naam, tussenvoegsel, achternaam, omschrijving
                                    FROM gebruiker
                                    WHERE Id = $match_gebruiker_id";

           $result_match_gegevens =  mysqli_query($connection, $query_match_gegevens);
           
           if ( $result_match_gegevens) 
           {

             $row_match_gegevens = mysqli_fetch_assoc($result_match_gegevens);

             $naam = $row_match_gegevens['naam'];
             $tussenvoegsel = $row_match_gegevens['tussenvoegsel'];
             $achternaam = $row_match_gegevens['achternaam'];
             $omschrijving = $row_match_gegevens['omschrijving'];


           

        ?>
        <h3>Matches</h3>
          <p><b>Naam:</b> <?php echo ($naam);?>  <?php echo ($tussenvoegsel); echo ($achternaam); ?> </p>
          <p><b>Omschrijving:</b> <?php echo ($omschrijving); ?> </p>
        <form action="matchingMenu.php" method="POST">


          <input type="submit" name="Goedkeuren" value="Goedkeuren" />
          <input type="submit" name="Afkeuren" value="Afkeuren   " />
        </form><br>
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

      <div class="list service-content col-xs-offset-0 col-xs-12 col-sm-6 col-md-offset-0 col-md-4 col-lg-3">
      <h3>Goedgekeurde match<h3>
      <?php 
       
        if (mysql_num_rows($result_match_goedgekeurd)>0) 
        {
        // output the matches.
          while ($row_match_gevonden = $result_match_goedgekeurd->fetch_assoc()) 
          {
             $match_gebruiker_id = $row_match_goedgekeurd['match_gebruiker_Id'];

             $query_match_goedgekeurd = "SELECT naam, tussenvoegsel, achternaam, omschrijving
                                         FROM gebruiker
                                         WHERE Id = $match_gebruiker_id";

             $result_match_goedgekeurd =  mysqli_query($connection, $query_match_goedgekeurd);

               $row_match_goedgekeurd = mysqli_fetch_assoc($result_match_goedgekeurd);

               $naam = $row_match_goedgekeurd['naam'];
               $tussenvoegsel = $row_match_goedgekeurd['tussenvoegsel'];
               $achternaam = $row_match_goedgekeurd['achternaam'];
               $omschrijving = $row_match_goedgekeurd['omschrijving'];

          ?>
          <h3>Matches</h3>
            <p><b>Naam:</b> <?php echo ($naam);?>  <?php echo ($tussenvoegsel); echo ($achternaam); ?> </p>
            <p><b>Omschrijving:</b> <?php echo ($omschrijving); ?> </p>
          <form action="matchingMenu.php" method="POST">


            <input type="submit" name="Goedkeuren" value="Goedkeuren" />
            <input type="submit" name="Afkeuren" value="Afkeuren   " />
          </form><br>
        <?php
          }
            }
            else 
            {
        ?>
            <h3>Op dit moment is er geen match gevonden.<h3>
        <?php
        }
      ?>
      </div>

      <div class="list service-content col-xs-offset-0 col-xs-12 col-sm-6 col-md-offset-0 col-md-4 col-lg-3">
      <h3>Dienst matches<h3>
      <?php 
       
        if (mysql_num_rows($result_match_dienst_gevonden)>0) 
        {
        // output the matches.
          while ($row_match_dienst_gevonden = $result_match_dienst_gevonden->fetch_assoc()) 
          {
             $match_dienst_id = $row_match_dienst_gevonden['match_gebruiker_Id'];

             $query_match_dienst = "SELECT naam, tussenvoegsel, achternaam, omschrijving
                                    FROM gebruiker
                                    WHERE Id = $match_gebruiker_id";

              $result_match_dienst =  mysqli_query($connection, $query_match_dienst);

               $row_match_dienst = mysqli_fetch_assoc($result_match_dienst);

               $naam = $row_match_dienst['naam'];
               $tussenvoegsel = $row_match_dienst['tussenvoegsel'];
               $achternaam = $row_match_dienst['achternaam'];
               $omschrijving = $row_match_dienst['omschrijving'];

          ?>
          <h3>Matches</h3>
            <p><b>Naam:</b> <?php echo ($naam);?>  <?php echo ($tussenvoegsel); echo ($achternaam); ?> </p>
            <p><b>Omschrijving:</b> <?php echo ($omschrijving); ?> </p>
          <form action="matchingMenu.php" method="POST">


            <input type="submit" name="Goedkeuren" value="Goedkeuren" />
            <input type="submit" name="Afkeuren" value="Afkeuren   " />
          </form><br>
        <?php
          }
            }
            else 
            {
        ?>
            <h3>Op dit moment is er geen match gevonden.<h3>
        <?php
        }
      ?>
      </div>

    </div>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
</html>