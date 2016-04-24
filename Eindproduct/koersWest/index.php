<?php
  session_start();

  require 'databaseConnectionOpening.php';

  if (isset($_SESSION['user_id']))
  {
    $id = $_SESSION['user_id'];

    $query = "SELECT id, email, straat, telefoonnummer
              FROM gebruiker
              WHERE id = $id";

    $result = mysqli_query($connection, $query);

    if ($result)
    {
        $row = mysqli_fetch_row($result);
        $gebruikerID = $row[0];
        $dbemail = $row[1];
        $dbstraat = $row[2];
        $dbtelnummer = $row[3];
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
    <title>Home</title>
  </head>

  <body>
    <?php if (isset($_SESSION['user_id'])): ?>

    <?php 
    include("Navigation.php");
    ?>

    <div class="content container">
      <h1>Uw gegevens</h1>
      <p><?php echo($dbemail) ?></p>
      <p><?php echo($dbstraat); ?></p>
      <p><?php echo($dbtelnummer) ?></p>

      <?php
        $sql_get_diensten = "SELECT D.dienst
                             FROM gebruiker_bied_dienst_aan GBDA
                             INNER JOIN dienst D
                             ON GBDA.Dienst_dienst = D.dienst
                             WHERE GBDA.Gebruiker_Id = '$id'";

        $result_diensten = mysqli_query($connection, $sql_get_diensten);

        $row_count = mysqli_num_rows($result_diensten);

        if ($row_count > 0)
        {
          echo "<h3>U biedt momenteel de volgende diensten aan</h3>";
          while($row = $result_diensten->fetch_assoc())
          {
            echo($row["dienst"]);
            echo "</br>";
          }
        } 
        else 
        {
          echo "<h3>U biedt momenteel geen diensten aan</h3>";
          echo "<p><a href=\"aanbiedMenu.php\">Klik hier</a> om een dienst toe te voegen<p>";
        }
      ?>

      <a href="logout.php">Uitloggen</a>
    </div>
    
    <?php else: ?>
      <h1>Welcome</h1>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
    <?php endif; ?>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
</html>