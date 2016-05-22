<?php
  session_start();

  // Make sure we're connected to the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, display a list of services for them to choose from
  if (isset($_SESSION['user_id']))
  {
    // User's session id, used to reference currently logged in user in database queries
    $id = $_SESSION['user_id'];
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
    <title>Home</title>
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
          <!-- Grey band to indicate content section containing the actual title elements -->
          <div class = "tile_primary">
            <h1><c class = "white">Hoofdmenu</c></h1>
            <h2><c class = "white">Selecteer een optie uit het menu om naar die pagina te gaan.</c></h2>
          </div>
        </div>

        <!-- Subbody div indicates main area of user interaction and important content -->
        <div class = "subbody">

          <div class = "tile_primary">
            <h3><b class = "white">Pagina's</b></h3>
          </div>

            <!-- Profile page block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_primary_small">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Mijn profiel</b></h3>
                  <img class = "image" src = "images/profile.png" width = "150" height = "150"><br><br>
                </div>

                <!-- Submit button -->
                <form action = "index.php">
                  <button type = "submit" class = "btn btn-primary">Ga naar uw profiel</button>
                </form>
              </div>
            </div>
            <!-- End of block -->

            <!-- Offer-service block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_primary_small">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Dienst aanbieden</b></h3>
                  <img class = "image" src = "images/offer_service.png" width = "150" height = "150"><br><br>
                </div>

                <!-- Submit button -->
                <form action = "aanbiedMenu.php">
                  <button type = "submit" class = "btn btn-primary">Bied een dienst aan</button>
                </form>
              </div>
            </div>
            <!-- End of block -->

            <!-- Ask-for-service block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_primary_small">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Dienst vragen</b></h3>
                  <img class = "image" src = "images/ask_for_service.png" width = "150" height = "150"><br><br>
                </div>

                <!-- Submit button -->
                <form action = "askForService.php">
                  <button type = "submit" class = "btn btn-primary">Vraag om een dienst</button>
                </form>
              </div>
            </div>
            <!-- End of block -->

            <!-- Matching block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_primary_small">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Matching</b></h3>
                  <img class = "image" src = "images/handshake_2.png" width = "150" height = "150"><br><br>
                </div>

                <!-- Submit button -->
                <form action = "matchNavigationMenu.php">
                  <button type = "submit" class = "btn btn-primary">Ga naar matching menu</button>
                </form>
              </div>
            </div>
            <!-- End of block -->

            <!-- Matching block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_grey_small">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Uitloggen</b></h3>
                  <img class = "image" src = "images/logout.png" width = "150" height = "150"><br><br>
                </div>

                <!-- Submit button -->
                <form action = "logout.php">
                  <button type = "submit" class = "btn btn-secondary" style = "color: black;">Klik hier om uit te loggen</button>
                </form>
              </div>
            </div>
            <!-- End of block -->
        </div>
      </div>
    </div>
    <br>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>