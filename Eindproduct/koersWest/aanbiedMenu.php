<?php
  session_start();

  // Make sure we're connected to the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, display a list of services for them to choose from
  if (isset($_SESSION['user_id']))
  {
    // User's session id, used to reference currently logged in user in database queries
    $id = $_SESSION['user_id'];

    $my_services_query = "SELECT Dienst_dienst
                          FROM gebruiker_bied_dienst_aan
                          WHERE gebruiker_id = $id";

    $services_query = "SELECT *
                       FROM dienst";

    $my_services = mysqli_query($connection, $my_services_query);
    $services = mysqli_query($connection, $services_query);

    if (!empty($_POST['dienst_name']))
    {
      $dienst_name = $_POST['dienst_name'];
      $insert_new_service = "INSERT INTO gebruiker_bied_dienst_aan
                             VALUES ('$id', '$dienst_name')";
      mysqli_query($connection, $insert_new_service);
    }
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
    <title>Dienst aanbieden</title>
  </head>

  <body>
    <?php 
    include("Navigation.php");
    ?>

    <div class="container">
      <h1>Dienst aanbieden</h1>
      <h2>Welke van de onderstaande diensten wilt u aanbieden?</h2>

      <?php
      while($current_service = $services->fetch_assoc())
      {
        $already_own_service = false;

        while($my_current_service = $my_services->fetch_assoc())
        {
          if($current_service['dienst'] == $my_current_service['Dienst_dienst'])
          {
            $already_own_service = true;
          }
        }

        if ($already_own_service == false)
        {
          ?>
          <div class="media col-xs-offset-0 col-xs-12 col-sm-6 col-md-offset-0 col-md-4 col-lg-3">
            <div class="media-body">
              <h3 class="media-heading"><?php echo ($current_service["dienst"]);?></h3>
              <p><b>Omschrijving: </b><?php echo ($current_service["omschijving"]);?></p>
              <form action="aanbiedMenu.php" method="POST">
                <button type="submit" class="btn btn-primary" value="Dienst aanbieden">dienst aanbieden</button>
                <input type="hidden" value="<?php echo($current_service["dienst"]); ?>" name="dienst_name"/>
              </form>
            </div>
          </div>
          <?php
        }
        ?>

        <?php
        $my_services->data_seek(0);
      }//end while
      ?>
    </div>
    <br>

    <div class="container">
      <?php
        if (!empty($_POST['dienst_name']))
        {
          $dienst_name = $_POST['dienst_name'];

          echo "U biedt nu de volgende dienst aan: <b class=\"green\">".$dienst_name.".</b><br>";
        }
      ?>
      <b><a href="index.php">Terug naar profiel</a></b>
    </div>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
</html>