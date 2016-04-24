<?php
  session_start();

  // Make sure we're connected to the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, load a list of all available services, sorted by user
  if (isset($_SESSION['user_id']))
  {
    // User's session id, used to reference currently logged in user in database queries
    $id = $_SESSION['user_id'];

    ////////////////////////////////////////////////////////////
    // * Get services offered by all users in database
    // * Services of currently logged in user are filtered out
    $users_services_query = "SELECT G.email, D.dienst
                             FROM gebruiker_bied_dienst_aan GBDA
                             INNER JOIN gebruiker G
                             ON GBDA.Gebruiker_ID = G.id
                             INNER JOIN dienst D
                             ON GBDA.Dienst_dienst = D.dienst
                             WHERE GBDA.Gebruiker_ID != $id
                             ORDER BY G.email";

    ///////////////////////////////////////////////
    // * Get data on all users
    // * Currently logged in user is filtered out
    $users_query = "SELECT email, telefoonnummer, straat, postcode, woonplaats
                    FROM gebruiker
                    WHERE id != $id
                    ORDER BY email";

    $users_services = mysqli_query($connection, $users_services_query);
    $users = mysqli_query($connection, $users_query);
  }
  else // Return to the welcome page
  {
    header('location:index.php');
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
    <title>Dienst aanvragen</title>
  </head>

  <body>
    <?php 
    include("Navigation.php");
    ?>

    <h1>Diensten</h1>

    <div>
      <?php
        while($users_row = $users->fetch_assoc())
        {
          echo "<b>E-mail adres: </b>".$users_row['email']."<br>";
          echo "<b>Telefoon nummer: </b>".$users_row['telefoonnummer']."<br>";
          echo "<b>Straat: </b>".$users_row['straat']."<br>";
          echo "<b>Postcode: </b>".$users_row['postcode']."<br>";
          echo "<b>Woonplaats: </b>".$users_row['woonplaats']."<br>";

          echo "<div><b>Diensten: </b><br>";
          while($users_services_row = $users_services->fetch_assoc())
          {
            if($users_services_row['email'] == $users_row['email'])
            {
              echo $users_services_row['dienst']."<br>";
            }
          }
          echo "</div><br>";

          $users_services->data_seek(0);
        }
      ?>
    </div>

    <b><a href="index.php">Terug naar profiel</a></b>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
</html>