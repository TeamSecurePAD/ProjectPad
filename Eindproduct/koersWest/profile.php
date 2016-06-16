<?php
  session_start();

  // Make sure we're connected to the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, display their profile
  if (isset($_SESSION['user_id']))
  {
    // User's session id, used to reference currently logged in user in database queries
    $id = $_SESSION['user_id'];

    // Determines the current content to display (either 'profile' or 'user_data')
    $page = 'profile';

    // If the user is in the personal information section of the profile page
    if (!empty($_POST['show_personal_information']))
    {
      $page = 'user_data';
    }

    // If the user is editing personal information
    if (!empty($_POST['edit_data']))
    {
      $edit_data = $_POST['edit_data'];
    }
    else
    {
      $edit_data = '';
    }

    $message = '';
    $error_number = 0;

    $new_voornaam = '';
    $new_tussenvoegsel = '';
    $new_achternaam = '';

    $new_email = '';
    $new_telnummer = '';

    // Check if the user is confirming or cancelling an edit
    if (!empty($_POST['submit']))
    {
      if ($_POST['submit'] == "confirm") // User clicked the confirm button to apply changes
      {
        if ($edit_data == "personal_information") // Personal information was changed
        {
          if (!empty($_POST['new_voornaam']) || !empty($_POST['new_tussenvoegsel']) || !empty($_POST['new_achternaam'])) // Any fields entered
          {
            // Get values stripped of tags
            $new_voornaam = strip_tags($_POST['new_voornaam']);
            $new_tussenvoegsel = strip_tags($_POST['new_tussenvoegsel']);
            $new_achternaam = strip_tags($_POST['new_achternaam']);

            if(!empty($_POST['new_voornaam']) && !empty($_POST['new_achternaam'])) // All required fields entered
            {
              // Setup database query
              $update_user_data = "UPDATE gebruiker
                                   SET naam = '$new_voornaam', tussenvoegsel = '$new_tussenvoegsel', achternaam = '$new_achternaam'
                                   WHERE id = '$id'";

              $update_user_data_query = mysqli_query($connection, $update_user_data);

              if ($update_user_data_query) // Database update successful - data updated
              {
                $message = 'Uw personalia zijn aangepast.';
                $error_number = 2;
                $edit_data = '';
              }
              else // Unknown error in database update
              {
                $message = 'Er is een onbekende fout opgetreden in het aanpassen van uw personalia.<br><br>Probeer later opnieuw uw gegevens aan te passen of neem contact op met een medewerker van BOOT als deze fout zich herhaalt.';
                $error_number = 101;
              }
            }
            else if (!empty($_POST['new_voornaam'])) // User neglected to enter last name
            {
              $message = 'U dient een achternaam in te vullen.';
              $error_number = 11;
            }
            else if (!empty($_POST['new_achternaam'])) // User neglected to enter first name
            {
              $message = 'U dient een voornaam in te vullen.';
              $error_number = 12;
            }
            else // User neglected to enter first and last name
            {
              $message = 'U dient een voor- en achternaam in te vullen.';
              $error_number = 13;
            }
          }
          else // No fields entered
          {
            $message = 'U dient een voor- en achternaam in te vullen.';
            $error_number = 14;
          }
        }
        
        if ($edit_data == "contact_information") // Contact information was changed
        {
          if (!empty($_POST['new_email']) || !empty($_POST['new_telnummer'])) // Any fields entered
          {
            // Get values stripped of tags
            $new_email = strip_tags($_POST['new_email']);
            $new_telnummer = strip_tags($_POST['new_telnummer']);

            if (!empty($_POST['new_email']) && !empty($_POST['new_telnummer'])) // All required fields entered
            {
              // Setup database query
              $update_contact_information = "UPDATE gebruiker
                                             SET email = '$new_email', telefoonnummer = '$new_telnummer'
                                             WHERE id = '$id'";

              $update_contact_information_query = mysqli_query($connection, $update_contact_information);

              if ($update_contact_information_query) // Database update successful - data updated
              {
                $message = 'Uw contactgegevens zijn aangepast.';
                $error_number = 3;
                $edit_data = '';
              }
              else // Unknown error in database update
              {
                $message = 'Er is een onbekende fout opgetreden in het aanpassen van uw contactgegevens.<br><br>Probeer later opnieuw uw gegevens aan te passen of neem contact op met een medewerker van BOOT als deze fout zich herhaalt.';
                $error_number = 102;
              }
            }
            else if (!empty($_POST['new_email'])) // User neglected to enter phone number
            {
              $message = 'U dient een telefoonnummer in te vullen.';
              $error_number = 15;
            }
            else if (!empty($_POST['new_telnummer'])) // User neglected to enter e-mail address
            {
              $message = 'U dient een e-mail adres in te vullen.';
              $error_number = 16;
            }
          }
          else // No fields entered
          {
            $message = 'U dient een e-mail adres en telefoonnummer in te vullen.';
            $error_number = 17;
          }
        }

        if ($edit_data == "address_information") // Address information was changed
        {
          if (!empty($_POST['new_straat']) || !empty($_POST['new_postcode']) || !empty($_POST['new_woonplaats'])) // Any fields entered
          {
            // Get values stripped of tags
            $new_straat = strip_tags($_POST['new_straat']);
            $new_postcode = strip_tags($_POST['new_postcode']);
            $new_woonplaats = strip_tags($_POST['new_woonplaats']);

            if(!empty($_POST['new_straat']) && !empty($_POST['new_postcode']) && !empty($_POST['new_woonplaats'])) // All required fields entered
            {
              // Setup database query
              $update_user_data = "UPDATE gebruiker
                                   SET straat = '$new_straat', postcode = '$new_postcode', woonplaats = '$new_woonplaats'
                                   WHERE id = '$id'";

              $update_user_data_query = mysqli_query($connection, $update_user_data);

              if ($update_user_data_query) // Database update successful - data updated
              {
                $message = 'Uw adresgegevens zijn aangepast.';
                $error_number = 4;
                $edit_data = '';
              }
              else // Unknown error in database update
              {
                $message = 'Er is een onbekende fout opgetreden in het aanpassen van uw adresgegevens.<br><br>Probeer later opnieuw uw gegevens aan te passen of neem contact op met een medewerker van BOOT als deze fout zich herhaalt.';
                $error_number = 103;
              }
            }
            else if (!empty($_POST['new_straat']) && !empty($_POST['new_postcode'])) // User neglected to enter city of residence
            {
              $message = 'U dient een woonplaats in te vullen.';
              $error_number = 18;
            }
            else if (!empty($_POST['new_postcode']) && !empty($_POST['new_woonplaats'])) // User neglected to enter street
            {
              $message = 'U dient een straat in te vullen.';
              $error_number = 19;
            }
            else if (!empty($_POST['new_straat']) && !empty($_POST['new_woonplaats'])) // User neglected to enter postal code
            {
              $message = 'U dient een postcode in te vullen.';
              $error_number = 20;
            }
            else if (!empty($_POST['new_straat'])) // User neglected to enter postal code and city of residence
            {
              $message = 'U dient een postcode en woonplaats in te vullen.';
              $error_number = 21;
            }
            else if (!empty($_POST['new_postcode'])) // User neglected to enter street and city of residence
            {
              $message = 'U dient een straat en woonplaats in te vullen.';
              $error_number = 22;
            }
            else if (!empty($_POST['new_woonplaats'])) // User neglected to enter street and postal code
            {
              $message = 'U dient een straat en postcode in te vullen.';
              $error_number = 23;
            }
          }
          else // No fields entered
          {
            $message = 'U dient een straat, postcode en woonplaats in te vullen.';
            $error_number = 24;
          }
        }
      }
      else if ($_POST['submit'] == "cancel") // User clicked the cancel button to revert changes
      {
        $edit_data = '';
      }
    }

    $current_user_data = "SELECT email, naam, tussenvoegsel, achternaam, telefoonnummer, straat, postcode, woonplaats
                          FROM gebruiker
                          WHERE id = $id";

    $current_user_data_query = mysqli_query($connection, $current_user_data);

    $email = '';
    $straat = '';
    $telnummer = '';
    $postcode = '';
    $woonplaats = '';
    $voornaam = '';
    $tussenvoegsel = '';
    $achternaam = '';

    if ($current_user_data_query)
    {
      $row = mysqli_fetch_assoc($current_user_data_query);
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
      <div class = "body">

        <?php
        // ----------------------------------------------------------------------------- //
        // PROFILE PAGE - DISPLAYS VARIOUS USER DATA DEPENDING ON CURRENTLY ACTIVE BLOCK
        // ----------------------------------------------------------------------------- //
        // MENU OPTIONS:
        //   * Persoonlijke gegevens
        //     - Personalia
        //     - Contactgegevens
        //     - Adresgegevens
        //   * Aangeboden diensten
        //   * Gevraagde diensten
        //   * Contacten
        //   * Terug naar menu
        // -------------------------------------------- //
        ?>
        <!-- Title div that surrounds colored title band - white backdrop to further emphasize subsection -->
        <div class = "title">
          <!-- Band to indicate content section containing the actual title elements -->
          <div class = "tile lime">
            <?php
            if ($page == "user_data")
            {
              ?>

              <h1>Persoonlijke gegevens</h1>

              <?php
            }
            else
            {
              ?>

              <?php
                // Determine user's full name
                if (!empty($tussenvoegsel))
                {
                  $user_name = $voornaam." ".$tussenvoegsel." ".$achternaam;
                }
                else
                {
                  $user_name = $voornaam." ".$achternaam;
                }
              ?>

              <h1>
                Profiel van <?php echo $user_name; ?>
              </h1>

              <?php
            }
            ?>
          </div>
        </div>

        <!-- Subbody div indicates main area of user interaction and important content -->
        <div class = "subbody">

          <?php
          if ($page == "user_data") // Display personal user data
          {
            ?>

            <?php
            // Show (error) message to the user after a failed edit attempt has been made
            if(!empty($message))
            {
              ?>

              <?php
                // Determines the error message title, icon and class, depending on error number
                if ($error_number >= 0 && $error_number < 10) // Positive feedback
                {
                  $error_class = "block error green";

                  $error_title = "Bewerking voltooid";
                  $error_icon = "success";
                }
                else if ($error_number >= 10 && $error_number < 100) // Warning
                {
                  $error_class = "block error orange";

                  $error_title = "Ontbrekende gegevens";
                  $error_icon = "warning";
                }
                else if ($error_number >= 100) // Fatal error
                {
                  $error_class = "block error red";

                  $error_title = "Error";
                  $error_icon = "warning";
                }
              ?>

              <!-- Error message block - informs the user of any errors in the login process -->
              <div class = "block_divider col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class = "<?php echo $error_class; ?>" >

                  <!-- Block text -->
                  <div class = "media-body">
                    <h3 class = "media-heading"><b><?php echo $error_title; ?></b></h3>
                    <img class = "image" src = "<?php echo "images/".$error_icon.".png"; ?>" width = "86" height = "86"><br>
                    <b><?php echo $message; ?></b>
                  </div>

                </div>
              </div>
              <!-- End of block -->

              <?php
            }
            ?>

            <?php
            // If the user wants to edit their personal information
            if ($edit_data == "personal_information")
            {
              ?>

              <!-- Personal information block -->
              <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class = "block extra_dark_lime medium">

                  <!-- Block text -->
                  <h3 class = "media-heading"><b>Personalia</b></h3>

                  <!-- Input elements to edit data + confirmation & cancel buttons -->
                  <form action = "profile.php" method = "POST">

                    <div class = "tile dark_lime edit_fields">
                      <b>Voornaam* </b><br>
                      <input class = "form-control" type = "text" value = "<?php echo $voornaam; ?>" placeholder = "voer uw voornaam in" name = "new_voornaam">
                      <b>Tussenvoegsel </b><br>
                      <input class = "form-control" type = "text" value = "<?php echo $tussenvoegsel; ?>" placeholder = "(dit veld mag u leeglaten)" name = "new_tussenvoegsel">
                      <b>Achternaam* </b><br>
                      <input class = "form-control" type = "text" value = "<?php echo $achternaam; ?>" placeholder = "voer uw achternaam in" name = "new_achternaam">
                    </div>

                    <div class = "service_button">
                      <button type = "submit" class = "btn btn-success" value = "confirm" name = "submit">Opslaan</button>
                      <button type = "submit" class = "btn btn-danger" value = "cancel" name = "submit">Annuleren</button>
                      <input type = "hidden" value = "personal_information" name = "edit_data"/>
                      <input type = "hidden" value = "true" name = "show_personal_information"/>
                    </div>
                  </form>

                </div>
              </div>
              <!-- End of block -->

              <?php
            }
            else // Display personal information
            {
              ?>

              <!-- Personal information block -->
              <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class = "block lime medium">

                  <!-- Block text -->
                  <h3 class = "media-heading"><b>Personalia</b></h3>
                  <img class = "image" src = "images/my_info.png" width = "64" height = "64">

                  <div class = "tile dark_lime edit_fields">
                    <b>Voornaam: </b><br><?php echo $voornaam; ?><br>
                    <b>Tussenvoegsel: </b><br><?php if (!empty($tussenvoegsel)) { echo $tussenvoegsel; } else { echo "(geen)"; } ?><br>
                    <b>Achternaam: </b><br><?php echo $achternaam; ?><br>
                  </div>

                  <!-- Submit button -->
                  <form action = "profile.php" method = "POST">
                    <div class = "service_button">
                      <button type = "submit" class = "btn btn-primary">Gegevens aanpassen</button>
                      <input type = "hidden" value = "personal_information" name = "edit_data"/>
                      <input type = "hidden" value = "true" name = "show_personal_information"/>
                    </div>
                  </form>

                </div>
              </div>
              <!-- End of block -->

              <?php
            }
            ?>

            <?php
            // If the user wants to edit their contact information
            if ($edit_data == "contact_information")
            {
              ?>

              <!-- Personal information block -->
              <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class = "block extra_dark_lime medium">

                  <!-- Block text -->
                  <h3 class = "media-heading"><b>Contactgegevens</b></h3>

                  <!-- Input elements to edit data + confirmation & cancel buttons -->
                  <form action = "profile.php" method = "POST">

                    <div class = "tile dark_lime edit_fields">
                      <b>E-mail adres* </b><br>
                      <input class = "form-control" type = "text" value = "<?php echo $email; ?>" placeholder = "voer uw e-mail adres in" name = "new_email">
                      <b>Telefoonnummer* </b><br>
                      <input class = "form-control" type = "text" value = "<?php echo $telnummer; ?>" placeholder = "voer uw telefoonnummer in" name = "new_telnummer">
                    </div>

                    <div class = "service_button">
                      <button type = "submit" class = "btn btn-success" value = "confirm" name = "submit">Opslaan</button>
                      <button type = "submit" class = "btn btn-danger" value = "cancel" name = "submit">Annuleren</button>
                      <input type = "hidden" value = "contact_information" name = "edit_data"/>
                      <input type = "hidden" value = "true" name = "show_personal_information"/>
                    </div>
                  </form>

                </div>
              </div>
              <!-- End of block -->

              <?php
            }
            else // Display contact information
            {
              ?>

              <!-- Contact information block -->
              <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class = "block lime medium">

                  <!-- Block text -->
                  <h3 class = "media-heading"><b>Contactgegevens</b></h3>
                  <img class = "image" src = "images/contact_information.png" width = "64" height = "64">

                  <div class = "tile dark_lime edit_fields">
                    <b>E-mail adres: </b><br><?php echo $email; ?><br>
                    <b>Telefoonnummer: </b><br><?php echo $telnummer; ?><br>
                  </div>

                  <!-- Submit button -->
                  <form action = "profile.php" method = "POST">
                    <div class = "service_button">
                      <button type = "submit" class = "btn btn-primary">Gegevens aanpassen</button>
                      <input type = "hidden" value = "contact_information" name = "edit_data"/>
                      <input type = "hidden" value = "true" name = "show_personal_information"/>
                    </div>
                  </form>

                </div>
              </div>
              <!-- End of block -->

              <?php
            }
            ?>

            <?php
            // If the user wants to edit their address information
            if ($edit_data == "address_information")
            {
              ?>

              <!-- Address information block -->
              <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class = "block extra_dark_lime medium">

                  <!-- Block text -->
                  <h3 class = "media-heading"><b>Adresgegevens</b></h3>

                  <!-- Input elements to edit data + confirmation & cancel buttons -->
                  <form action = "profile.php" method = "POST">

                    <div class = "tile dark_lime edit_fields">
                      <b>Straat* </b><br>
                      <input class = "form-control" type = "text" value = "<?php echo $straat; ?>" placeholder = "voer uw straat en huisnummer in" name = "new_straat">
                      <b>Postcode* </b><br>
                      <input class = "form-control" type = "text" value = "<?php echo $postcode; ?>" placeholder = "voer uw postcode in" name = "new_postcode">
                      <b>Woonplaats* </b><br>
                      <input class = "form-control" type = "text" value = "<?php echo $woonplaats; ?>" placeholder = "voer uw woonplaats in" name = "new_woonplaats">
                    </div>

                    <div class = "service_button">
                      <button type = "submit" class = "btn btn-success" value = "confirm" name = "submit">Opslaan</button>
                      <button type = "submit" class = "btn btn-danger" value = "cancel" name = "submit">Annuleren</button>
                      <input type = "hidden" value = "address_information" name = "edit_data"/>
                      <input type = "hidden" value = "true" name = "show_personal_information"/>
                    </div>
                  </form>

                </div>
              </div>
              <!-- End of block -->

              <?php
            }
            else // Display address information
            {
              ?>

              <!-- Address information block -->
              <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class = "block lime medium">

                  <!-- Block text -->
                  <h3 class = "media-heading"><b>Adresgegevens</b></h3>
                  <img class = "image" src = "images/address.png" width = "64" height = "64">

                  <div class = "tile dark_lime edit_fields">
                    <b>Straat: </b><br><?php echo $straat; ?><br>
                    <b>Postcode: </b><br><?php echo $postcode; ?><br>
                    <b>Woonplaats: </b><br><?php echo $woonplaats; ?><br>
                  </div>

                  <!-- Submit button -->
                  <form action = "profile.php" method = "POST">
                    <div class = "service_button">
                      <button type = "submit" class = "btn btn-primary">Gegevens aanpassen</button>
                      <input type = "hidden" value = "address_information" name = "edit_data"/>
                      <input type = "hidden" value = "true" name = "show_personal_information"/>
                    </div>
                  </form>

                </div>
              </div>
              <!-- End of block -->

              <?php
            }
            ?>

            <!-- Back button block -->
            <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <div class = "block gray medium">

                <!-- Block text -->
                <h3 class = "media-heading"><b>Terug naar profiel</b></h3><br>
                <img class = "image" src = "images/backarrow.png" width = "150" height = "150"><br><br>

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
            <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block lime small">

                <!-- Block text -->
                <h3 class = "media-heading"><b>Persoonlijke gegevens</b></h3>
                <img class = "image" src = "images/personal_data.png" width = "86" height = "86"><br><br>

                <!-- Submit button -->
                <form action = "profile.php" method = "POST">
                  <div class = "service_button">
                    <button type = "submit" class = "btn btn-primary">Bekijk uw gegevens</button>
                    <input type = "hidden" value = "true" name = "show_personal_information"/>
                  </div>
                </form>

              </div>
            </div>
            <!-- End of block -->

            <!-- Offered-services block -->
            <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block lime small">

                <!-- Block text -->
                <h3 class = "media-heading"><b>Aangeboden diensten</b></h3>
                <img class = "image" src = "images/offer_service.png" width = "86" height = "86"><br><br>\

                <!-- Submit button -->
                <form action = "myOfferedServices.php" method = "POST">
                  <div class = "service_button">
                    <button type = "submit" class = "btn btn-primary">Bekijk diensten</button>
                  </div>
                </form>

              </div>
            </div>
            <!-- End of block -->

            <!-- Asked-for-services block -->
            <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block lime small">

                <!-- Block text -->
                <h3 class = "media-heading"><b>Gevraagde diensten</b></h3>
                <img class = "image" src = "images/ask_for_service.png" width = "86" height = "86"><br><br>

                <!-- Submit button -->
                <form action = "myAskedForServices.php" method = "POST">
                  <div class = "service_button">
                    <button type = "submit" class = "btn btn-primary">Bekijk diensten</button>
                  </div>
                </form>

              </div>
            </div>
            <!-- End of block -->

            <!-- Competence category block -->
            <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block lime small">

                <!-- Block text -->
                <h3 class = "media-heading"><b>Competentie</b></h3>
                <img class = "image" src = "images/thumbsup.png" width = "86" height = "86"><br><br>

                <!-- Submit button -->
                <form action = "myCompetenceCategory.php" method = "POST">
                  <div class = "service_button">
                    <button type = "submit" class = "btn btn-primary">Bekijk categorieën</button>
                  </div>
                </form>

              </div>
            </div>
            <!-- End of block -->

            <!-- Help category block -->
            <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block lime small">

                <!-- Block text -->
                <h3 class = "media-heading"><b>Hulpvraag</b></h3>
                <img class = "image" src = "images/hulpvraag.png" width = "86" height = "86"><br><br>

                <!-- Submit button -->
                <form action = "myHelpCategory.php" method = "POST">
                  <div class = "service_button">
                    <button type = "submit" class = "btn btn-primary">Bekijk categorieën</button>
                  </div>
                </form>

              </div>
            </div>
            <!-- End of block -->

            <!-- Back button block -->
            <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block gray small">

                <!-- Block text -->
                <h3 class = "media-heading"><b>Terug naar menu</b></h3>
                <img class = "image" src = "images/backarrow.png" width = "86" height = "86"><br><br>

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