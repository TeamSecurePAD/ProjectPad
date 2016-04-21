<?php
  session_start();

  require 'databaseConnectionOpening.php';

  if (isset($_SESSION['user_id']))
  {
    $id = $_SESSION['user_id'];

    $users_services = "SELECT G.email, G.telefoonnummer, G.straat, G.postcode, G.woonplaats, D.dienst
                       FROM gebruiker_bied_dienst_aan GBDA
                       INNER JOIN gebruiker G
                       ON GBDA.Gebruiker_ID = G.id
                       INNER JOIN dienst D
                       ON GBDA.Dienst_dienst = D.dienst";

    $result = mysqli_query($connection, $users_services);
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
    <!-- code code code -->
    <h1>Diensten</h1>

    <div>
      <ul>
        <?php 
          while($row = $result->fetch_assoc())
          {
            echo "<div><b>Dienst: </b>".$row['dienst']."</div>";
            echo "<div><b>E-mail adres: </b>".$row['email']."</div>";
            echo "<div><b>Telefoon nummer: </b>".$row['telefoonnummer']."</div>";
            echo "<div><b>Straat: </b>".$row['straat']."</div>";
            echo "<div><b>Postcode: </b>".$row['postcode']."</div>";
            echo "<div><b>Woonplaats: </b>".$row['woonplaats']."</div><br>";
          }
        ?>
      </ul>
    </div>

    <a href="index.php">Terug naar profiel</a>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
</html>