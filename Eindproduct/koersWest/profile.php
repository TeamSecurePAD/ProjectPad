<?php
  session_start();

  // Make sure we're connected to the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, display their profile
  if (isset($_SESSION['user_id']))
  {
    // User's session id, used to reference currently logged in user in database queries
    $id = $_SESSION['user_id'];

    $page = "profile";

    if (!empty($_POST['show_data']))
    {
      $page = "user_data";
    }

    $edit_personal_information = false;
    $edit_contact_information = false;
    $edit_address_information = false;

    if (!empty($_POST['edit_personal_information']))
    {
      $edit_personal_information = $_POST['edit_personal_information'];
    }

    if (!empty($_POST['edit_contact_information']))
    {
      $edit_contact_information = $_POST['edit_contact_information'];
    }

    if (!empty($_POST['edit_address_information']))
    {
      $edit_address_information = $_POST['edit_address_information'];
    }

    $message = '';
    $error_number = 0;
    $new_voornaam = '';
    $new_tussenvoegsel = '';
    $new_achternaam = '';

    if (!empty($_POST['submit']))
    {
      if ($_POST['submit'] == "confirm")
      {
        if(!empty($_POST['new_voornaam']) || !empty($_POST['new_tussenvoegsel']) || !empty($_POST['new_achternaam']))
        {
          $new_voornaam = strip_tags($_POST['new_voornaam']);
          $new_tussenvoegsel = strip_tags($_POST['new_tussenvoegsel']);
          $new_achternaam = strip_tags($_POST['new_achternaam']);

          $insert_new_user_data = "UPDATE gebruiker
                                   SET naam = '$new_voornaam', tussenvoegsel = '$new_tussenvoegsel', achternaam = '$new_achternaam'
                                   WHERE id = '$id'";

          if(!empty($_POST['new_voornaam']) && !empty($_POST['new_achternaam']))
          {
            $insert_new_user_data_query = mysqli_query($connection, $insert_new_user_data);

            if ($insert_new_user_data_query)
            {
              $message = 'Uw gegevens zijn aangepast.';
              $error_number = 1;
            }
            else
            {
              $message = 'Er is een onbekende fout opgetreden in het aanpassen van uw gegevens.<br><br>Probeer later opnieuw uw gegevens aan te passen of neem contact op met een medewerker van BOOT als deze fout zich herhaalt.';
              $error_number = 21;
            }
          }
          else if (!empty($_POST['new_voornaam']))
          {
            $message = 'U dient een achternaam in te vullen.';
            $error_number = 11;
            $edit_personal_information = true;
          }
          else if (!empty($_POST['new_achternaam']))
          {
            $message = 'U dient een voornaam in te vullen.';
            $error_number = 12;
            $edit_personal_information = true;
          }
        }
      }
      else if ($_POST['submit'] == "cancel")
      {
        $message = 'De bewerking is ongedaan gemaakt.';
        $error_number = 2;
      }
    }

    $current_user_data = "SELECT email, naam, tussenvoegsel, achternaam, telefoonnummer, straat, postcode, woonplaats
                          FROM gebruiker
                          WHERE id = $id";

    $current_user_data_result = mysqli_query($connection, $current_user_data);

    $email = '';
    $straat = '';
    $telnummer = '';
    $postcode = '';
    $woonplaats = '';
    $voornaam = '';
    $tussenvoegsel = '';
    $achternaam = '';

    if ($current_user_data_result)
    {
      $row = mysqli_fetch_assoc($current_user_data_result);
      $email = $row['email'];
      $straat = $row['straat'];
      $telnummer = $row['telefoonnummer'];
      $postcode = $row['postcode'];
      $woonplaats = $row['woonplaats'];
      $voornaam = $row['naam'];
      $tussenvoegsel = $row['tussenvoegsel'];
      $achternaam = $row['achternaam'];
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

        <?php
        // ---------------------------------------------------------------------------- //
        // PROFILE PAGE - DISPLAYS VARIOUS USER DATA DEPENDING ON CURRENTLY ACTIVE TILE
        // ---------------------------------------------------------------------------- //
        // MENU OPTIONS:
        //   * Persoonlijke gegevens
        //     - Personalia
        //     - Contactgegevens
        //     - Adresgegevens
        //   * Aangeboden diensten
        //   * Gevraagde diensten
        //   * Contacten
        //   * Terug naar hoofdmenu
        // -------------------------------------------- //
        ?>
        <!-- Title div that surrounds colored title band - white backdrop to further emphasize subsection -->
        <div class = "title">
          <!-- Deep blue band to indicate content section containing the actual title elements -->
          <div class = "tile_profile">
            <h1><c class = "white">
              Profiel van <?php
                            if (!empty($tussenvoegsel))
                            {
                              echo $voornaam." ".$tussenvoegsel." ".$achternaam;
                            }
                            else
                            {
                              echo $voornaam." ".$achternaam;
                            }
                          ?>
            </c></h1>
            <h2><c class = "white">
            <?php
            if ($page == "user_data")
            {
              echo "Uw persoonlijke informatie.<br>Deze informatie is zichtbaar voor u en al uw contacten.";
            }
            else
            {
              echo "Selecteer een onderdeel van uw profiel om te bekijken.";
            }
            ?>
            </c></h2>
          </div>
        </div>

        <!-- Subbody div indicates main area of user interaction and important content -->
        <div class = "subbody">

          <div class = "tile_profile">
            <h3><b class = "white">
            <?php
            if ($page == "user_data")
            {
              echo "Uw gegevens";
            }
            else
            {
              echo "Onderdelen";
            }
            ?>
            </b></h3>
          </div>

          <?php
          if ($page == "user_data") // Display personal user data
          {
            ?>

            <?php
            // Show (error) message to the user after a failed edit attempt has been made
            if(!empty($message))
            {
              ?>

              <!-- Error message block - informs the user of any errors in the login process -->
              <div class = "block col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class = 
                  <?php
                  if ($error_number >= 0 && $error_number < 10)
                  {
                    echo "\"block_error_small_green\"";
                    if ($error_number == 1)
                    {
                      $error_title = "Bewerking voltooid";
                    }
                    else if ($error_number == 2)
                    {
                      $error_title = "Bewerking geannuleerd";
                    }
                  }
                  else if ($error_number > 10 && $error_number < 20)
                  {
                    echo "\"block_error_small_orange\"";
                    $error_title = "Ontbrekende gegevens";
                  }
                  else if ($error_number > 20 && $error_number < 30)
                  {
                    echo "\"block_error_small_red\"";
                    $error_title = "Error";
                  }
                  ?>
                >

                  <!-- Block text -->
                  <div class = "media-body">
                    <h3 class = "media-heading"><b class = "white"><?php echo $error_title; ?></b></h3>
                    <img class = "image" src = "images/warning.png" width = "86" height = "86"><br>
                    <b class = "white"><?php echo $message; ?></b>
                  </div>

                </div>
              </div>
              <!-- End of block -->

              <?php
            }
            ?>

            <?php
            // If the user wants to edit their personal information
            if ($edit_personal_information)
            {
              ?>

              <!-- Personal information block -->
              <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class = "block_profile_edit">

                  <!-- Block text -->
                  <div class = "media-body">
                    <h3 class = "media-heading"><b class = "white">Personalia</b></h3>
                  </div>

                  <!-- Input elements to edit data + confirmation & cancel buttons -->
                  <form action = "profile.php" method = "POST">

                    <div class = "tile_profile_dark">
                      <b>Voornaam* </b><br>
                      <input class = "form-control" type = "text" value = "<?php echo $voornaam; ?>" placeholder = "voer uw voornaam in" name = "new_voornaam">
                      <b>Tussenvoegsel </b><br>
                      <input class = "form-control" type = "text" value = "<?php echo $tussenvoegsel; ?>" placeholder = "(dit veld mag u leeglaten)" name = "new_tussenvoegsel">
                      <b>Achternaam* </b><br>
                      <input class = "form-control" type = "text" value = "<?php echo $achternaam; ?>" placeholder = "voer uw achternaam in" name = "new_achternaam">
                    </div>

                    <div class = "service_button">
                      <button type = "submit" class = "btn btn-success" value = "confirm" name = "submit">Gegevens bijwerken</button>
                      <button type = "submit" class = "btn btn-danger" value = "cancel" name = "submit">Annuleren</button>
                      <input type = "hidden" value = "true" name = "show_data"/>
                    </div>
                  </form>
                </div>
              </div>
              <!-- End of block -->

              <?php
            }
            else // Show personal information
            {
              ?>

              <!-- Personal information block -->
              <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class = "block_profile">

                  <!-- Block text -->
                  <div class = "media-body">
                    <h3 class = "media-heading"><b class = "white">Personalia</b></h3>
                    <img class = "image" src = "images/my_info.png" width = "64" height = "64">
                  </div>

                  <div class = "tile_profile_dark">
                    <b>Voornaam: </b><?php echo $voornaam; ?><br>
                    <b>Tussenvoegsel: </b><?php if (!empty($tussenvoegsel)) { echo $tussenvoegsel; } else { echo "(geen)"; } ?><br>
                    <b>Achternaam: </b><?php echo $achternaam; ?><br>
                  </div>

                  <!-- Submit button -->
                  <form action = "profile.php" method = "POST">
                    <div class = "service_button">
                      <button type = "submit" class = "btn btn-primary">Gegevens bewerken</button>
                      <input type = "hidden" value = "true" name = "edit_personal_information"/>
                      <input type = "hidden" value = "true" name = "show_data"/>
                    </div>
                  </form>
                </div>
              </div>
              <!-- End of block -->

              <?php
            }
            ?>

            <!-- Contact information block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <div class = "block_profile">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Contactgegevens</b></h3>
                  <img class = "image" src = "images/contact_information.png" width = "64" height = "64">
                </div>

                <div class = "tile_profile_dark">
                  <b>E-mail adres: </b><?php echo $email; ?><br>
                  <b>Telefoonnummer: </b><?php echo $telnummer; ?><br>
                </div>

                <!-- Submit button -->
                <form action = "profile.php" method = "POST">
                  <div class = "service_button">
                    <button type = "submit" class = "btn btn-primary">Gegevens bewerken</button>
                    <input type = "hidden" value = "true" name = "edit_contact_information"/>
                    <input type = "hidden" value = "true" name = "show_data"/>
                  </div>
                </form>
              </div>
            </div>
            <!-- End of block -->

            <!-- Address block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <div class = "block_profile">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Adresgegevens</b></h3>
                  <img class = "image" src = "images/address.png" width = "64" height = "64">
                </div>

                <div class = "tile_profile_dark">
                  <b>Straat: </b><?php echo $straat; ?><br>
                  <b>Postcode: </b><?php echo $postcode; ?><br>
                  <b>Woonplaats: </b><?php echo $woonplaats; ?><br>
                </div>

                <!-- Submit button -->
                <form action = "profile.php" method = "POST">
                  <div class = "service_button">
                    <button type = "submit" class = "btn btn-primary">Gegevens bewerken</button>
                    <input type = "hidden" value = "true" name = "edit_address_information"/>
                    <input type = "hidden" value = "true" name = "show_data"/>
                  </div>
                </form>
              </div>
            </div>
            <!-- End of block -->

            <!-- Back button block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <div class = "block_grey">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Terug naar profiel</b></h3>
                  <img class = "image" src = "images/backarrow.png" width = "150" height = "150"><br><br>
                </div>

                <!-- Submit button -->
                <form action = "profile.php">
                  <div class = "service_button">
                    <button type = "submit" class = "btn btn-secondary" style = "color: black;">Klik hier om terug te gaan</button>
                  </div>
                </form>

              </div>
            </div>
            <!-- End of block -->

            <?php
          }
          else // Main menu of profile page
          {
            ?>

            <!-- Profile page block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_profile_small">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Persoonlijke gegevens</b></h3>
                  <img class = "image" src = "images/personal_data.png" width = "86" height = "86"><br><br>
                </div>

                <!-- Submit button -->
                <form action = "profile.php" method = "POST">
                  <div class = "service_button">
                    <button type = "submit" class = "btn btn-primary">Bekijk uw gegevens</button>
                    <input type = "hidden" value = "true" name = "show_data"/>
                  </div>
                </form>
              </div>
            </div>
            <!-- End of block -->

            <!-- Offered-services block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_profile_small">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Aangeboden diensten</b></h3>
                  <img class = "image" src = "images/offer_service.png" width = "86" height = "86"><br><br>
                </div>

                <!-- Submit button -->
                <form action = "myServices.php" method = "POST">
                  <div class = "service_button">
                    <button type = "submit" class = "btn btn-primary">Bekijk diensten</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- End of block -->

            <!-- Asked-for-services block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_profile_small">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Gevraagde diensten</b></h3>
                  <img class = "image" src = "images/ask_for_service.png" width = "86" height = "86"><br><br>
                </div>

                <!-- Submit button -->
                <form action = "myServices.php" method = "POST">
                  <div class = "service_button">
                    <button type = "submit" class = "btn btn-primary">Bekijk diensten</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- End of block -->

            <!-- Contacts block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_profile_small">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Contacten</b></h3>
                  <img class = "image" src = "images/contacts.png" width = "86" height = "86"><br><br>
                </div>

                <!-- Submit button -->
                <form action = "myContacts.php" method = "POST">
                  <div class = "service_button">
                    <button type = "submit" class = "btn btn-primary">Bekijk uw contacten</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- End of block -->

            <!-- Back button block -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_grey_small">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Terug naar hoofdmenu</b></h3>
                  <img class = "image" src = "images/backarrow.png" width = "86" height = "86"><br><br>
                </div>

                <!-- Submit button -->
                <form action = "home.php">
                  <div class = "service_button">
                    <button type = "submit" class = "btn btn-secondary" style = "color: black;">Klik hier om terug te gaan</button>
                  </div>
                </form>

              </div>
            </div>
            <!-- End of block -->

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