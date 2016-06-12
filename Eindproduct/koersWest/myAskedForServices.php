<?php
  session_start();

  // Make sure we're connected to the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, display a list of services for them to choose from
  if (isset($_SESSION['user_id']))
  {
    // User's session id, used to reference currently logged in user in database queries
    $id = $_SESSION['user_id'];

    $removeService = '';

    if (!empty($_POST['removeService']))
    {
      $removeService = $_POST['removeService'];
      $message_title = "Dienst verwijderd";
      $message = "U vraagt niet langer om de dienst \"".$removeService."\".";

      $query_remove_service = "DELETE FROM gebruiker_vraagt_dienst
                               WHERE Gebruiker_Id = '$id'
                               AND Dienst_dienst = '$removeService'";

      mysqli_query($connection, $query_remove_service);
    }

    $my_services_query = "SELECT Dienst_dienst
                          FROM gebruiker_vraagt_dienst
                          WHERE gebruiker_id = '$id'";

    $services_query = "SELECT *
                       FROM dienst";

    $my_services = mysqli_query($connection, $my_services_query);
    $services = mysqli_query($connection, $services_query);

    // Provides a list of all categories in the database
    $query_all_categories = "SELECT categorie FROM categorie";
    $categories = mysqli_query($connection, $query_all_categories);
  }
  else // Return to the welcome page
  {
    header('location:home.php');
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
    <title>Gevraagde diensten</title>
  </head>

  <body>

    <?php
    include("title.php");
    ?>

    <!-- Container that houses all the elements on the page -->
    <div class = "container">

      <!-- Body div that contains all elements of the page - lighter gray backdrop than page background for emphasis on section -->
      <div class = "body col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <!-- Title div that surrounds colored title band - white backdrop to further emphasize subsection -->
        <div class = "title">
          <!-- Lime band to indicate content section containing the actual title elements -->
          <div class = "tile lime">
            <h1>Gevraagde diensten</h1>
            <img class = "image" src = "images/ask_for_service.png" width = "86" height = "86"><br><br>
            <!-- <h2>Om deze diensten vraagt u.</h2> -->
          </div>
        </div>

        <!-- Subbody div indicates main area of user interaction and important content -->
        <div class = "subbody">

          <?php
          if (!empty($message))
          {
            ?>
            <!-- Service removed notice -->
            <div class = "block_divider col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class = "block error green">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b><?php echo $message_title; ?></b></h3>
                  <img class = "image" src = "images/bin.png" width = "86" height = "86"><br>
                  <b><?php echo $message; ?></b>
                </div>

              </div>
            </div>
            <?php
          }
          ?>

          <?php
          while($current_category = $categories->fetch_assoc())
          {
          	?>

            <?php
            // Used to check if the user offers any services in the current category
            $any_services = false;
            while($current_service = $services->fetch_assoc())
            {
              // Used to check if the user already owns a service
              $own_current_service = false;
              ?>

              <?php
              // Loops through the user's services to check if the current service is being asked for
              while($my_current_service = $my_services->fetch_assoc())
              {
                if($current_service['dienst'] == $my_current_service['Dienst_dienst'])
                {
                  $own_current_service = true;
                }
              }
              ?>

              <?php
              // If the current service is part of the current category and the user needs help with it, show it to the user
              if ($current_service['Categorie_Categorie'] == $current_category['categorie'])
              {
                ?>
                <?php
                if ($own_current_service)
                {
                  $any_services = true;
                  ?>

                  <!-- Block that shows an owned service -->
                  <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <div class = "block cyan regular">

                      <!-- Block text -->
                      <div class = "media-body">
                        <img class = "image" src = "<?php echo "images/".$current_category["categorie"].".png"; ?>" width = "43" height = "43" style = "position: absolute; right: 30px; bottom: 15px;">
                        <h3 class = "media-heading"><b><?php echo $current_service['dienst']; ?></b></h3>
                        <img class = "image" src = "<?php echo "images/".$current_service["dienst"].".png"; ?>" width = "86" height = "86"><br>
                        <b>Omschrijving: </b><?php echo $current_service['omschijving']; ?>

                        <form action = "myAskedForServices.php" method = "POST">
                          <div class = "service_button">
                            <button type = "submit" class = "btn btn-danger" value = "cancel" name = "delete">Verwijderen</button>
                            <input type = "hidden" value = "<?php echo $current_service['dienst']; ?>" name = "removeService"/>
                          </div>
                        </form>
                      </div>

                    </div>
                  </div>

                  <?php
                }
                ?>
                <?php
              }
              ?>

              <?php
              // Reset $my_services array so it can be looped through in the next cycle
              $my_services->data_seek(0);
            }//end while
            ?>

          	<?php
            $services->data_seek(0);
          }
          ?>

          <!-- Back button in list of services - returns the user to the list of categories -->
          <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
            <div class = "block gray regular">

              <!-- Block text -->
              <div class = "media-body">
                <h3 class = "media-heading"><b>Terug naar profiel</b></h3>
                <img class = "image" src = "images/backarrow.png" width = "150" height = "150"><br><br>
              </div>

              <!-- Submit button -->
              <div class = "service_button">
                <form action = "profile.php">
                  <button type = "submit" class = "btn btn-secondary" style = "color: black;">Klik hier om terug te gaan</button>
                </form>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
</html>