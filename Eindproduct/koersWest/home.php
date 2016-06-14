<?php
  session_start();

  // Make sure we're connected to the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, display a list of services for them to choose from
  if (isset($_SESSION['user_id']))
  {
    // User's session id, used to reference currently logged in user in database queries
    $id = $_SESSION['user_id'];

    // Includes the code that adds the matches to the database
    include ('matchAdd.php');
    
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

        <?php
        // --------------------------------------------------------- //
        // HOME PAGE -> MAIN MENU - DISPLAYED WHEN USER IS LOGGED IN
        // --------------------------------------------------------- //
        // MENU OPTIONS:
        //   * Mijn profiel
        //   * Dienst aanbieden
        //   * Dienst vragen
        //   * Matching
        //   * Uitloggen
        // -------------------------------------------- //
        if (isset($_SESSION['user_id']))
        {
          ?>
          <!-- Title div that surrounds colored title band - white backdrop to further emphasize subsection -->
          <div class = "title">
            <!-- Colored band to indicate content section containing the actual title elements -->
            <div class = "tile blue">
              <h1>Menu</h1>
            </div>
          </div>

          <!-- Subbody div indicates main area of user interaction and important content -->
          <div class = "subbody">

              <!-- Profile page block -->
              <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class = "block lime small">

                  <!-- Block text -->
                  <div class = "media-body">
                    <h3 class = "media-heading"><b>Mijn profiel</b></h3>
                    <img class = "image" src = "images/profile.png" width = "150" height = "150"><br><br>
                  </div>

                  <!-- Submit button -->
                  <form action = "profile.php">
                    <button type = "submit" class = "btn btn-primary">Bekijk uw profiel</button>
                  </form>
                </div>
              </div>
              <!-- End of block -->

              <!-- Offer-service block -->
              <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class = "block light_green small">

                  <!-- Block text -->
                  <div class = "media-body">
                    <h3 class = "media-heading"><b>Dienst aanbieden</b></h3>
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
              <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class = "block cyan small">

                  <!-- Block text -->
                  <div class = "media-body">
                    <h3 class = "media-heading"><b>Dienst vragen</b></h3>
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
              <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class = "block light_blue small">

                  <!-- Block text -->
                  <div class = "media-body">
                    <h3 class = "media-heading"><b>Matching</b></h3>
                    <img class = "image" src = "images/handshake_2.png" width = "150" height = "150"><br><br>
                  </div>

                  <!-- Submit button -->
                  <form action = "matchIndex.php">
                    <button type = "submit" class = "btn btn-primary">Bekijk uw matches</button>
                  </form>
                </div>
              </div>
              <!-- End of block -->

              <!-- Matching block -->
              <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class = "block gray small">

                  <!-- Block text -->
                  <div class = "media-body">
                    <h3 class = "media-heading"><b>Uitloggen</b></h3>
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

          <?php
        }
        // -------------------------------------------------------------------- //
        // HOME PAGE -> WELCOME PAGE - DISPLAYED WHEN USER IS NOT LOGGED IN YET
        // -------------------------------------------------------------------- //
        // MENU OPTIONS:
        //   * Inloggen
        //   * Registreren
        // -------------------------------------------------------------------- //
        else
        {
          ?>
          <!-- Title div that surrounds colored title band - white backdrop to further emphasize subsection -->
          <div class = "title">
            <!-- Deep blue band to indicate content section containing the actual title elements -->
            <div class = "tile blue">
              <h1>Welkom</h1>
            </div>
          </div>

          <!-- Subbody div indicates main area of user interaction and important content -->
          <div class = "subbody">

              <!-- Login block -->
              <div class = "block_divider col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class = "block blue small">

                  <!-- Block text -->
                  <div class = "media-body">
                    <h3 class = "media-heading"><b>Inloggen</b></h3>
                    <img class = "image" src = "images/login.png" width = "86" height = "86"><br><br>
                    Op deze pagina kunt u uw gegevens invoeren om in te loggen.<br><br>
                  </div>

                  <!-- Submit button -->
                  <form action = "login.php">
                    <button type = "submit" class = "btn btn-primary">Ga naar inlogscherm</button>
                  </form>
                </div>
              </div>
              <!-- End of block -->

              <!-- Register block -->
              <div class = "block_divider col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class = "block blue small">

                  <!-- Block text -->
                  <div class = "media-body">
                    <h3 class = "media-heading"><b>Registreren</b></h3>
                    <img class = "image" src = "images/register.png" width = "86" height = "86"><br><br>
                    Bent u hier voor de eerste keer, dan kunt u hier een account aanmaken.<br><br>
                  </div>

                  <!-- Submit button -->
                  <form action = "register.php">
                    <button type = "submit" class = "btn btn-primary">Ga naar registratiescherm</button>
                  </form>
                </div>
              </div>
              <!-- End of block -->
          </div>
          <?php
        }
        ?>
      </div>
    </div>
    <br>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>