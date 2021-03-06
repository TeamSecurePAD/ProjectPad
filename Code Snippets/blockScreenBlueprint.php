<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.min.css">
    <title>Dienst aanbieden</title>
  </head>

  <body>

    <!-- Container that houses all the elements on the page -->
    <div class = "container">
      <!-- Body div that contains all elements of the page - lighter gray backdrop than page background for emphasis on interactible environment -->
      <div class = "body col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <!-- Title div that surrounds colored title band - white backdrop to further emphasize subsection -->
        <div class = "title">
          <!-- Green band to indicate content section with actual title elements -->
          <div class = "tile light_blue">
            <h1>BluePrint</h1>
            <h2>handig enzo Je weet zelf JONUHH</h2>
          </div>
        </div>

        <!-- Subbody div indicates main area of user interaction and important content -->
        <div class = "subbody">

          <div class = "tile light_blue">
            <h3><b>Voorbeeld</b></h3>
          </div>

            <!-- Start of voorbeeld block -->
            <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block light_blue regular">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b>Voorbeeld</b></h3>
                  <img class = "image" src = "images/backarrow.png" width = "150" height = "150"><br><br>
                </div>

                <!-- Submit button -->
                <div class = "service_button">
                  <form action = "aanbiedMenu.php">
                    <button type = "submit" class = "btn btn-info">Voorbeeld</button>
                  </form>
                </div>
              </div>
            </div>
            <!-- End of block -->

            <!-- Back button in list of services - returns the user to the list of categories -->
            <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block light_blue regular">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b>Terug naar categorieën</b></h3>
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