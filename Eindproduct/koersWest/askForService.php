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

    // Error message title
    if (!empty($_POST['message_title']))
    {
      $message_title = $_POST['message_title'];
    }
    else
    {
      $message_title = '';
    }

    // Error message body
    if (!empty($_POST['message']))
    {
      $message = $_POST['message'];
    }
    else
    {
      $message = '';
    }

    // If a service was just removed by the user, remove it from their services
    if (!empty($_POST['removeService']))
    {
      $removeService = $_POST['removeService'];

      $query_remove_service = "DELETE FROM gebruiker_vraagt_dienst
                               WHERE Gebruiker_Id = '$id'
                               AND Dienst_dienst = '$removeService'";

      mysqli_query($connection, $query_remove_service);
    }

    // If a service has just been asked for, add it to their services
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

    // Lists the user's services
    $my_services_query = "SELECT Dienst_dienst
                          FROM gebruiker_vraagt_dienst
                          WHERE gebruiker_id = $id";

    // Lists all services
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

    $show_categories = false;
    $show_services = false;

    if ($geselecteerde_categorie == "NONE")
    {
      $show_categories = true;
    }
    else
    {
      $show_services = true;
    }
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
    <link rel="stylesheet" href="css/styles.min.css">
    <title>Dienst vragen</title>
  </head>

  <body>

    <?php
    include("title.php");
    ?>

    <!-- Container that houses all the elements on the page -->
    <div class = "container">

      <!-- Body div that contains all elements of the page - lighter gray backdrop than page background for emphasis on section -->
      <div class = "body">
        <!-- Title div that surrounds colored title band - white backdrop to further emphasize subsection -->
        <div class = "title">
          <!-- Cyan band to indicate content section containing the actual title elements -->
          <div class = "tile cyan">
            <?php
            if ($show_categories)
            {
              ?>
              <h1>Dienst vragen</h1>
              <img class = "image" src = "images/ask_for_service.png" width = "86" height = "86">
              <h2>Selecteer een categorie om diensten te tonen.</h2>
              <?php
            }
            else if ($show_services)
            {
              ?>
              <h1>Dienst vragen <?php echo "uit categorie ".$geselecteerde_categorie ?></h1>
              <img class = "image" src = "images/<?php echo $geselecteerde_categorie; ?>.png" width = "86" height = "86">
              <h2>Selecteer een dienst om te vragen.</h2>
              <?php
            }
            ?>
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
                <h3 class = "media-heading"><b><?php echo $message_title; ?></b></h3>
                <img class = "image" src = "images/bin.png" width = "86" height = "86"><br>
                <b><?php echo $message; ?></b>

              </div>
            </div>
            <?php
          }
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
              <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class = "block cyan small">

                  <!-- Block text -->
                  <h3 class = "media-heading"><b><?php echo $current_category['categorie'];?></b></h3>
                  <img class = "image" src = "<?php echo "images/".$current_category['categorie'].".png"; ?>" width = "86" height = "86"><br><br>

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
            <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block gray small">

                <!-- Block text -->
                <h3 class = "media-heading"><b>Terug naar menu</b></h3>
                <img class = "image" src = "images/backarrow.png" width = "86" height = "86"><br><br>

                <!-- Submit button -->
                <form action = "home.php">
                  <button type = "submit" class = "btn btn-secondary" style = "color: black;">Klik hier om terug te gaan</button>
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
                  <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <div class = "block cyan regular">

                      <!-- Block text -->
                      <h3 class = "media-heading"><b><?php echo $current_service['dienst'];?></b></h3>
                      <img class = "image" src = "<?php echo "images/".$current_service["dienst"].".png"; ?>" width = "86" height = "86"><br>
                      <b>Omschrijving: </b><?php echo $current_service['omschijving'];?>

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
                  <!-- Block that shows a service that is already being asked for -->
                  <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <div class = "block dark_cyan regular">

                      <!-- Block text -->
                      <h3 class = "media-heading"><b><?php echo $current_service['dienst'];?></b></h3>
                      <img class = "image" src = "<?php echo "images/".$current_service["dienst"].".png"; ?>" width = "86" height = "86"><br><br>
                      <!-- <b>Omschrijving: </b><?php echo $current_service['omschijving'];?> -->
                      <h3 class = "media-heading"><b>U vraagt al om deze dienst.</b></h3>

                      <form action = "askForService.php" method = "POST">
                        <div class = "service_button">
                          <button type = "submit" class = "btn btn-danger" value = "cancel" name = "delete">Verwijderen</button>
                          <input type = "hidden" value = "<?php echo $current_service['dienst']; ?>" name = "removeService"/>
                          <input type = "hidden" value = "<?php echo $geselecteerde_categorie; ?>" name = "geselecteerde_categorie"/>
                          <input type = "hidden" value = "Dienst verwijderd" name = "message_title"/>
                          <input type = "hidden" value = "U vraagt niet langer om de dienst &quot;<?php echo $current_service['dienst']; ?>&quot;." name = "message"/>
                        </div>
                      </form>

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
                <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
                  <div class = "block bright_orange regular">

                    <!-- Block text -->
                    <h3 class = "media-heading"><b><?php echo $current_service['dienst'];?></b></h3>
                    <img class = "image" src = "<?php echo "images/".$current_service["dienst"].".png"; ?>" width = "86" height = "86"><br><br>
                    <!-- <b>Omschrijving: </b><?php echo $current_service['omschijving'];?><br> -->
                    <h3 class = "media-heading"><b>U vraagt vanaf nu om deze dienst.</b></h3>

                    <form action = "askForService.php" method = "POST">
                      <div class = "service_button">
                        <button type = "submit" class = "btn btn-danger" value = "cancel" name = "delete">Annuleren</button>
                        <input type = "hidden" value = "<?php echo $current_service['dienst']; ?>" name = "removeService"/>
                        <input type = "hidden" value = "<?php echo $geselecteerde_categorie; ?>" name = "geselecteerde_categorie"/>
                        <!-- <input type = "hidden" value = "Bewerking geannuleerd" name = "message_title"/> -->
                        <!-- <input type = "hidden" value = "Aanbieden <?php echo $current_service['dienst']; ?> geannuleerd." name = "message"/> -->
                      </div>
                    </form>

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

            <!-- Back button in list of services - returns the user to the list of categories -->
            <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block gray regular">

                <!-- Block text -->
                <h3 class = "media-heading"><b>Terug naar categorieën</b></h3>
                <img class = "image" src = "images/backarrow.png" width = "150" height = "150"><br><br>

                <!-- Submit button -->
                <div class = "service_button">
                  <form action = "askForService.php">
                    <button type = "submit" class = "btn btn-secondary" style = "color: black;">Klik hier om terug te gaan</button>
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