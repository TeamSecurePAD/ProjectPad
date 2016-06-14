<?php
  session_start();

  // Make sure we're connected to the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, do nothing
  if (isset($_SESSION['user_id']))
  {
    // User's session id, used to reference currently logged in user in database queries
    $id = $_SESSION['user_id'];
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.min.css">
    <title>KoersWest</title>
  </head>

  <body>
    <?php 
    include("Navigation.php");
    ?>

    <div class="container">
      <h1>About</h1>

      <h3><b class="red">Ontwikkeld door:</b></h3>
      <b class="grey">Noah Jagtman</b><br>
      <b class="grey">Joël Kabeya Kalunga</b><br>
      <b class="grey">Rik Langeveld</b><br>
      <b class="grey">Gijs Sickenga</b><br>
      <b class="grey">Hussein Swadi</b><br><br>

      <b class="red">Project Agile Development - HVA - 2015-2016</b><br><br>

      <?php
      // If a user is logged in, display link back to profile
      if (isset($_SESSION['user_id']))
      {
        ?>
        <b><a href="index.php">Terug naar profiel</a></b>
        <?php
      }
      ?>
    </div>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
</html>