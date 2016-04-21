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
    <title>Welcome</title>
  </head>

  <body>
    <?php if (isset($_SESSION['user_id'])): ?>

    <h1>Uw gegevens</h1>
    <p><?php echo($dbemail) ?></p>
    <p><?php echo($dbstraat); ?></p>
    <p><?php echo($dbtelnummer) ?></p>

    <p><b><a href="askForService.php">Dienst aanvragen</a></b></p>
    <p><b><a href="aanbiedMenu.php">Dienst aanbieden</a></b></p>

    <a href="logout.php">Uitloggen</a>

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