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
    include("title.php");
    ?>

    <!-- Container that houses all the elements on the page -->
    <div class = "container">
      <!-- Body div that contains all elements of the page - lighter gray backdrop than page background for emphasis on interactible environment -->
      <div class = "body col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <!-- Title div that surrounds colored title band - white backdrop to further emphasize subsection -->
        <div class = "title">
          <!-- Green band to indicate content section with actual title elements -->
          <div class = "tile_info">
            <h1><c class = "white">Soort match kiezen</c></h1>
            <h2><c class = "white">Selecteer naar wat voor soort match u opzoek bent.</c></h2>
          </div>
        </div>

        <!-- Subbody div indicates main area of user interaction and important content -->
        <div class = "subbody">

          <div class = "tile_info">
            <h3><b class = "white">Soorten matching</b></h3>
          </div>

            <!-- Start of voorbeeld block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_info_extra_large">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Gevonden matches diensten</b></h3>
                  <img class = "image" src = "images/matcharrow.png" width = "150" height = "150"><br>
                  <p>Hier vind je alle gevonden matches die gebaseerd zijn op wat je aanbied en wat je vraagt.
                  Je kan hier zelf kiezen wie je je contactgegevens stuurt</p>
                </div>

                <!-- Submit button -->
                <div class = "service_button">
                  <form action = "DienstMatchMenu.php">
                    <button type = "submit" class = "btn btn-primary">Matches Bekijken</button>
                  </form>
                </div>
              </div>
            </div>
            <!-- End of block -->

            <!-- Start of voorbeeld block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_info_extra_large">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Gevonden matches talenten</b></h3>
                  <img class = "image" src = "images/matcharrow.png" width = "150" height = "150"><br>
                  <p>Hier kan mensen vinden die tegenovergestelde talenten hebben. Je kan zelf kiezen wie je
                    je contact gegevens stuurt</p>
                </div>

                <!-- Submit button -->
                <div class = "service_button">
                  <form action = "matchingMenu.php">
                    <button type = "submit" class = "btn btn-primary">Matches Bekijken</button>
                  </form>
                </div>
              </div>
            </div>
            <!-- End of block -->

                        <!-- Start of voorbeeld block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_info_extra_large">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Netwerk diensten</b></h3>
                  <img class = "image" src = "images/handshake.png" width = "150" height = "150"><br>
                  <p>Iedereen die jouw heeft goedgekeurd en van wie je de contact gegevens ziet zijn hier te vinden. Je kan zelf contact met deze mensen opnemen.</p>
                </div>

                <!-- Submit button -->
                <div class = "service_button">
                  <form action = "confirmDienstmatchMenu.php">
                    <button type = "submit" class = "btn btn-primary">Matches Bekijken</button>
                  </form>
                </div>
              </div>
            </div>
            <!-- End of block -->

                        <!-- Start of voorbeeld block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_info_extra_large">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Netwerk talenten</b></h3>
                  <img class = "image" src = "images/handshake.png" width = "150" height = "150"><br>
                  <p>Hier vind je mensen die tegenovergestelde talenten hebben, en contact gegevens naar je verstuurd hebben.
                     Je kan zelf contact met deze mensen opnemen.</p>
                </div>

                <!-- Submit button -->
                <div class = "service_button">
                  <form action = "ConfirmCategorieMenu.php">
                    <button type = "submit" class = "btn btn-primary">Matches Bekijken</button>
                  </form>
                </div>
              </div>
            </div>
            <!-- End of block -->



            <!-- Back button in list of services - returns the user to the list of categories -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_grey">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Terug naar hoofdmenu</b></h3>
                  <img class = "image" src = "images/backarrow.png" width = "150" height = "150"><br><br>
                </div>

                <!-- Submit button -->
                <div class = "service_button">
                  <form action = "home.php">
                    <button type = "submit" class = "btn btn-secondary" style = "color: black;">Klik om terug te gaan</button>
                  </form>
                </div>
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