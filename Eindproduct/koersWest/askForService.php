<?php
  session_start();

  require 'databaseConnectionOpening.php';

  if (isset($_SESSION['user_id']))
  {
    $id = $_SESSION['user_id'];

    $users_services = "SELECT G.email, G.telefoonnummer, G.straat, G.postcode, G.woonplaats, GBDA.Dienst_dienst
                       FROM gebruiker G
                       INNER JOIN gebruiker_bied_dienst_aan GBDA
                       ON GBDA.Gebruiker_ID
                       WHERE GBDA.Gebruiker_ID = G.id";

    $result = mysqli_query($connection, $users_services);

    if ($result)
    {
        $row = mysqli_fetch_row($result);
        $email = $row[0];
        $telnummer = $row[1];
        $straat = $row[2];
        $postcode = $row[3];
        $woonplaats = $row[4];
        $dienst = $row[5];
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
            echo "<li><div>".$dienst."</div></li>";
            echo "<li><div>".$email."</div></li>";
            echo "<li><div>".$telnummer."</div></li>";
            echo "<li><div>".$straat."</div></li>";
            echo "<li><div>".$postcode."</div></li>";
            echo "<li><div>".$woonplaats."</div></li>";
            //echo "<div>".$row["Dienst_dienst"]."</div></li>";
            echo "<input type=\"submit\" name=\"submit\">";
          }
        ?>
      </ul>
    </div>

    <a href="index.php">Return</a>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
</html>