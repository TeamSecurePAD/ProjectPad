<?php
  session_start();

  // Make sure we're connected to the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, display a list of services for them to choose from
  if (isset($_SESSION['user_id']))
  {
    // User's session id, used to reference currently logged in user in database queries
    $id = $_SESSION['user_id'];

    // If a service has just been asked for
    if (!empty($_POST['te_vragen_dienst']))
    {
      $te_vragen_dienst = $_POST['te_vragen_dienst'];
      $insert_new_service = "INSERT INTO gebruiker_vraagt_dienst
                             VALUES ('$id', '$te_vragen_dienst')";
      mysqli_query($connection, $insert_new_service);
    }
    else
    {
      $te_vragen_dienst = "NONE";
    }

    $my_services_query = "SELECT Dienst_dienst
                          FROM gebruiker_vraagt_dienst
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
    if (!empty($_POST['te_vragen_dienst']))
    {
      $te_vragen_dienst = $_POST['te_vragen_dienst'];
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
    <title>Dienst vragen</title>
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
          <!-- Cyan band to indicate content section containing the actual title elements -->
          <div class = "tile_ask_for_service">
            <h1><c class = "white">Dienst vragen</c></h1>
            <?php
            if ($geselecteerde_categorie == "NONE")
            {
              ?>
              <h2><c class = "white">Selecteer een categorie om diensten te tonen.</c></h2>
              <?php
            }
            else
            {
              ?>
              <h2><c class = "white">Selecteer een dienst om hulp bij te vragen.</c></h2>
              <?php
            }
            ?>
          </div>
        </div>

        <!-- Subbody div indicates main area of user interaction and important content -->
        <div class = "subbody">
          <?php
          $show_categories = false;
          $show_services = false;

          // Subbody title to indicate current page
          echo "<div class = \"tile_ask_for_service\">";
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
                <div class = "block_ask_for_service_small">

                  <!-- Block text -->
                  <div class = "media-body">
                    <h3 class = "media-heading"><b class = "white"><?php echo $current_category['categorie'];?></b></h3>
                    <img class = "image" src = "<?php echo "images/".$current_category['categorie'].".png"; ?>" width = "86" height = "86"><br><br>
                  </div>

                  <!-- Submit button -->
                  <form action = "askForService.php" method = "POST">
                    <button type = "submit" class = "btn btn-primary" value = "Diensten bekijken">Diensten bekijken</button>
                    <input type = "hidden" value = "<?php echo $current_category['categorie']; ?>" name = "geselecteerde_categorie"/>
                  </form>

                </div>
              </div>
              <?php
            }//end while
            ?>

            <!-- Back button in category list - returns the user to the home page -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_grey_small">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Terug naar hoofdmenu</b></h3>
                  <img class = "image" src = "images/backarrow.png" width = "86" height = "86"><br><br>
                </div>

                <!-- Submit button -->
                <form action = "home.php">
                  <button type = "submit" class = "btn btn-secondary" style = "color: black;">Klik om terug te gaan</button>
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
              // If the current service is part of the current category and the user doesn't ask for help with it yet, show it to the user
              if ($current_service['Categorie_Categorie'] == $geselecteerde_categorie)
              {
                $any_services = true;
                if (!$already_own_service)
                {
                  ?>
                  <!-- Block that shows a potentially askable service -->
                  <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <div class = "block_ask_for_service">

                      <!-- Block text -->
                      <div class = "media-body">
                        <h3 class = "media-heading"><b class = "white"><?php echo $current_service['dienst'];?></b></h3>
                        <img class = "image" src = "<?php echo "images/".$current_service["dienst"].".png"; ?>" width = "86" height = "86"><br>
                        <b>Omschrijving: </b><?php echo $current_service['omschijving'];?>
                      </div>

                      <!-- Submit button -->
                      <div class = "service_button">
                        <form action = "askForService.php" method = "POST">
                          <button type = "submit" class = "btn btn-primary" value = "Dienst vragen">Dienst vragen</button>
                          <input type = "hidden" value = "<?php echo $current_service['dienst']; ?>" name = "te_vragen_dienst"/>
                          <input type = "hidden" value = "<?php echo $geselecteerde_categorie ?>" name = "geselecteerde_categorie"/>
                        </form>
                      </div>

                    </div>
                  </div>
                  <?php
                }
                else if (!($te_vragen_dienst == $current_service['dienst']))
                {
                  ?>
                  <!-- Block that shows a potentially askable service -->
                  <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <div class = "block_success2">

                      <!-- Block text -->
                      <div class = "media-body">
                        <h3 class = "media-heading"><b class = "white"><?php echo $current_service['dienst'];?></b></h3>
                        <img class = "image" src = "<?php echo "images/".$current_service["dienst"].".png"; ?>" width = "86" height = "86"><br>
                        <b>Omschrijving: </b><?php echo $current_service['omschijving'];?>

                        <h3 class = "media-heading" style = "position: absolute; bottom: 15px; left: 20%; right: 20%;"><b class = "white">U vraagt al om deze dienst.</b></h3>
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
              // If the user has just clicked to ask for help with this service, display it at the same location in a different color
              if (!empty($_POST['te_vragen_dienst']) && $te_vragen_dienst == $current_service['dienst'])
              {
                ?>
                <!-- Shows the service that has just been asked for in a different color -->
                <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
                  <div class = "block_confirmed">

                    <!-- Block text -->
                    <div class = "media-body">
                      <h3 class = "media-heading"><b class = "white"><?php echo $current_service['dienst'];?></b></h3>
                      <img class = "image" src = "<?php echo "images/".$current_service["dienst"].".png"; ?>" width = "86" height = "86"><br>
                      <b>Omschrijving: </b><?php echo $current_service['omschijving'];?><br>

                      <h3 class = "media-heading" style = "margin-left: -5px; margin-right: -5px; position: absolute; bottom: 15px; left: 20%; right: 20%;"><b class = "white">U vraagt vanaf nu om deze dienst.</b></h3>
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
            // UNUSED // UNUSED // UNUSED // UNUSED // UNUSED // UNUSED // UNUSED // UNUSED // UNUSED // UNUSED // UNUSED // UNUSED //
            // Check if the user asks for all services in the current category
            if ($geselecteerde_categorie != "NONE" && !$any_services)
            {
              ?>
              <!-- Warning message to inform the user that they have asked for all services in the current category -->
              <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class = "block_ask_for_service">

                  <!-- Block text -->
                  <div class = "media-body">
                    <h3 class = "media-heading"><b class = "white">Alle diensten gevraagd</b></h3>
                    <img class = "image" src = "images/warning.png" width = "110" height = "110"><br><br>
                    <h3 class = "media-heading"><b class = "white">U vraagt al om hulp voor alle diensten uit deze categorie.</b></h3>
                  </div>

                </div>
              </div>
              <?php
            }
            // UNUSED // UNUSED // UNUSED // UNUSED // UNUSED // UNUSED // UNUSED // UNUSED // UNUSED // UNUSED // UNUSED // UNUSED //
            ?>

            <!-- Back button in list of services - returns the user to the list of categories -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_grey">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Terug naar categorieën</b></h3>
                  <img class = "image" src = "images/backarrow.png" width = "150" height = "150"><br><br>
                </div>

                <!-- Submit button -->
                <div class = "service_button">
                  <form action = "askForService.php">
                    <button type = "submit" class = "btn btn-secondary" style = "color: black;">Klik om terug te gaan</button>
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