<?php

  // TO-DO //
  // 
  // Als een dienst aangeboden is door op de knop te drukken
  // moet de lijst diensten blijven staan en de zojuist
  // toegevoegde dienst in een andere kleur worden getoond
  // zodat de gebruiker weet dat deze dienst succesvol is
  // toegevoegd.
  //
  // TO-DO //



  session_start();

  // Make sure we're connected to the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, display a list of services for them to choose from
  if (isset($_SESSION['user_id']))
  {
    // User's session id, used to reference currently logged in user in database queries
    $id = $_SESSION['user_id'];

    // If a service has just been offered
    if (!empty($_POST['aan_te_bieden_dienst']))
    {
      $aan_te_bieden_dienst = $_POST['aan_te_bieden_dienst'];
      $insert_new_service = "INSERT INTO gebruiker_bied_dienst_aan
                             VALUES ('$id', '$aan_te_bieden_dienst')";
      mysqli_query($connection, $insert_new_service);
    }

    $my_services_query = "SELECT Dienst_dienst
                          FROM gebruiker_bied_dienst_aan
                          WHERE gebruiker_id = $id";

    $services_query = "SELECT *
                       FROM dienst";

    $my_services = mysqli_query($connection, $my_services_query);
    $services = mysqli_query($connection, $services_query);

    // If a category has just been selected
    if(!empty($_POST['geselecteerde_categorie']))
    {
      $geselecteerde_categorie = $_POST['geselecteerde_categorie'];
    }
    else
    {
      $geselecteerde_categorie = "NONE";
    }

    // Check if a service has just been offered
    if (!empty($_POST['aan_te_bieden_dienst']))
    {
      $aan_te_bieden_dienst = $_POST['aan_te_bieden_dienst'];
    }

    // Provides a list of all categories in the database
    $query_all_categories = "SELECT categorie FROM categorie";
    $categories = mysqli_query($connection, $query_all_categories);
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

    <!-- Container that houses all the elements on the page -->
    <div class = "container">
      <!-- Body div that contains all elements of the page - lighter gray backdrop than page background for emphasis on interactible environment -->
      <div class = "body col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <!-- Title div that surrounds colored title band - white backdrop to further emphasize subsection -->
        <div class = "title">
          <!-- Green band to indicate content section with actual title elements -->
          <div class = "tile_info">
            <h1><c class = "white">Dienst aanbieden</c></h1>
            <h2><c class = "white">Selecteer een categorie om diensten te tonen.</c></h2>
          </div>
        </div>

        <!-- Subbody div indicates main area of user interaction and important content -->
        <div class = "subbody">
          <?php
          $show_categories = false;
          $show_services = false;

          // Subbody title to indicate current page
          echo "<div class = \"tile_info\">";
          if ($geselecteerde_categorie != "NONE")
          {
            echo "<h3><b class = \"white\">".$geselecteerde_categorie."</b></h3>";
            $show_services = true;
          }
          else
          {
            echo "<h3><b class = \"white\">Categorieën</b></h3>";
            $show_categories = true;
          }
          echo "</div>";
          ?>

          <?php
          if ($show_categories)
          {
            ?>
            <?php
            while($current_category = $categories->fetch_assoc())
            {
              ?>
              <!-- Block that shows a service category -->
              <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class = "block_info_small">

                  <!-- Block text -->
                  <div class = "media-body">
                    <h3 class = "media-heading"><b class = "white"><?php echo $current_category['categorie'];?></b></h3>
                    <img class = "image" src = "<?php echo "images/".$current_category['categorie'].".png"; ?>" width = "86" height = "86"><br><br>
                  </div>

                  <!-- Submit button -->
                  <form action = "aanbiedMenu.php" method = "POST">
                    <button type = "submit" class = "btn btn-info" value = "Diensten bekijken">Diensten bekijken</button>
                    <input type = "hidden" value = "<?php echo $current_category['categorie']; ?>" name = "geselecteerde_categorie"/>
                  </form>

                </div>
              </div>
              <?php
            }//end while
            ?>

            <!-- Back button in category list - returns the user to the home page -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_info_small">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Home</b></h3>
                  <img class = "image" src = "images/backarrow.png" width = "86" height = "86"><br><br>
                </div>

                <!-- Submit button -->
                <form action = "index.php">
                  <button type = "submit" class = "btn btn-info">Klik om terug te gaan</button>
                </form>

              </div>
            </div>

          <?php
          }
          else if ($show_services)
          {
            ?>
            <?php
            // Used to check if the user offers all services in the current category
            $any_services = false;
            while($current_service = $services->fetch_assoc())
            {
              // Used to check if the user already owns a service
              $already_own_service = false;
              ?>

              <?php
              // Loops through the user's services to check if the current service is already being offered
              while($my_current_service = $my_services->fetch_assoc())
              {
                if($current_service['dienst'] == $my_current_service['Dienst_dienst'])
                {
                  $already_own_service = true;
                }
              }
              ?>

              <?php
              // If the current service is part of the current category and the user doesn't offer it yet, show it to the user
              if ($already_own_service == false && $current_service['Categorie_Categorie'] == $geselecteerde_categorie)
              {
                $any_services = true;
                ?>
                <!-- Block that shows a potentially offerable service -->
                <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
                  <div class = "block_info">

                    <!-- Block text -->
                    <div class = "media-body">
                      <h3 class = "media-heading"><b class = "white"><?php echo $current_service['dienst'];?></b></h3>
                      <img class = "image" src = "<?php echo "images/".$current_service["dienst"].".png"; ?>" width = "86" height = "86"><br>
                      <b>Omschrijving: </b><?php echo $current_service['omschijving'];?>
                    </div>

                    <!-- Submit button -->
                    <div class = "service_button">
                      <form action = "aanbiedMenu.php" method = "POST">
                        <button type = "submit" class = "btn btn-info" value = "Dienst aanbieden">Dienst aanbieden</button>
                        <input type = "hidden" value = "<?php echo $current_service['dienst']; ?>" name = "aan_te_bieden_dienst"/>
                        <input type = "hidden" value = "<?php echo $geselecteerde_categorie ?>" name = "geselecteerde_categorie"/>
                      </form>
                    </div>

                  </div>
                </div>
                <?php
              }
              ?>

              <?php
              // If the user has just clicked to offer this service, display it at the same location in a different color
              if (!empty($_POST['aan_te_bieden_dienst']) && $aan_te_bieden_dienst == $current_service['dienst'])
              {
                ?>
                <!-- Shows the service that has just been offered in a different color -->
                <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
                  <div class = "block_success">

                    <!-- Block text -->
                    <div class = "media-body">
                      <h3 class = "media-heading"><b class = "white"><?php echo $current_service['dienst'];?></b></h3>
                      <img class = "image" src = "<?php echo "images/".$current_service["dienst"].".png"; ?>" width = "86" height = "86"><br>
                      <b>Omschrijving: </b><?php echo $current_service['omschijving'];?><br>

                      <h3 class = "media-heading" style = "position: absolute; bottom: 20px; left: 20%; right: 20%;"><b class = "white">U biedt nu deze dienst aan.</b></h3>
                    </div>

                  </div>
                </div>
                <?php
              }
              ?>

              <?php
              // Reset $my_services array so it can be looped through in the next cycle
              $my_services->data_seek(0);
            }//end while
            ?>

            <?php
            // Check if the user offers all services in the current category
            if ($geselecteerde_categorie != "NONE" && !$any_services)
            {
              ?>
              <!-- Warning message to inform the user that they offer all services in the current category -->
              <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class = "block_success">

                  <!-- Block text -->
                  <div class = "media-body">
                    <h3 class = "media-heading"><b class = "white">Alle diensten aangeboden</b></h3>
                    <img class = "image" src = "images/warning.png" width = "110" height = "110"><br><br>
                    <h3 class = "media-heading"><b class = "white">U biedt alle diensten uit deze categorie al aan.</b></h3>
                  </div>

                </div>
              </div>
              <?php
            }
            ?>

            <!-- Back button in list of services - returns the user to the list of categories -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_info">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Terug naar categorieën</b></h3>
                  <img class = "image" src = "images/backarrow.png" width = "150" height = "150"><br><br>
                </div>

                <!-- Submit button -->
                <div class = "service_button">
                  <form action = "aanbiedMenu.php">
                    <button type = "submit" class = "btn btn-info">Klik om terug te gaan</button>
                  </form>
                </div>

              </div>
            </div>

            <?php
          }
          ?>
        </div>
      </div>
    </div>
    <br>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
</html>