<?php
  session_start();

  // Establish a connection with the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, send them back to the home page (main menu)
  if (isset($_SESSION['user_id']))
  {
    header('location:home.php');
  }

  $message = '';
  $error_number = 0;
  $error_title = '';

  if ($connection) // A successful connection to the database has been established
  {
    if (!empty($_POST['email']) || !empty($_POST['wachtwoord'])) // Either password or e-mail (or both) entered successfully
    {
      if (!empty($_POST['email']) && !empty($_POST['wachtwoord'])) // E-mail and password entered successfully
      {
        $email = strip_tags($_POST['email']);
        $wachtwoord = strip_tags($_POST['wachtwoord']);

        $get_user_data = "SELECT id, email, wachtwoord
                          FROM gebruiker
                          WHERE email = '$email'";

        $user_data = mysqli_query($connection, $get_user_data);

        if ($user_data) // The database query was successful
        {
          $row = mysqli_fetch_row($user_data);
          $gebruikerID = $row[0];
          $dbemail = $row[1];
          $dbwachtwoord = $row[2];

          if ($email == $dbemail) // Verify that a user was found with the provided e-mail address
          {
            if ($wachtwoord == $dbwachtwoord)
            {
              $_SESSION['user_id'] = $gebruikerID; 
              header('location:home.php');
            }
            else // Username and password incompatible
            {
              $message = 'Wachtwoord en e-mail adres komen niet overeen.';
              $error_number = 11;
            }
          }
          else // Given e-mail does not appear in database
          {
            $message = 'Wij kennen geen gebruiker met het zojuist ingevoerde e-mail adres.';
            $error_number = 12;
          }
        }
        else // Query failed for unknown reason
        {
          $message = 'Er is een onbekende fout opgetreden in het inlogproces.<br><br>Probeer later opnieuw in te loggen of neem contact op met een medewerker van BOOT als deze fout zich herhaalt.';
          $error_number = 21;
        }
      }
      else if (!empty($_POST['email'])) // Password was not entered
      {
        $message = 'Bent u uw wachtwoord vergeten in te vullen?';
        $error_number = 1;
      }
      else // E-mail was not entered
      {
        $message = 'Bent u uw e-mail adres vergeten in te vullen?';
        $error_number = 2;
      }
    }
    else // Neither e-mail nor password were entered
    {
      $message = 'U dient uw e-mail adres en wachtwoord in te vullen alvorens u kunt inloggen.';
      $error_number = 3;
    }
  }
  else // A database connection could not be established
  {
    $message = 'Er is een onbekende fout opgetreden in het verbinden met de database.<br><br>Probeer later opnieuw in te loggen of neem contact op met BOOT als deze fout zich herhaalt.';
    $error_number = 22;
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
    <title>Inloggen</title>
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
        // ------------------------------------------------------------------------- //
        // LOGIN PAGE - ALLOWS THE USER TO ENTER THEIR USERNAME & PASSWORD AND LOGIN
        // ------------------------------------------------------------------------- //
        ?>
        <!-- Title div that surrounds colored title band - white backdrop to further emphasize subsection -->
        <div class = "title">
          <!-- Deep blue band to indicate content section containing the actual title elements -->
          <div class = "tile blue">
            <h1>Inlogscherm</h1>
            <!-- <h2>Voer uw gegevens in om in te loggen bij KoersWest.</h2> -->
          </div>
          <!-- End of colored title band -->
        </div>
        <!-- End of title div -->

        <!-- Subbody div indicates main area of user interaction and important content -->
        <div class = "subbody">

          <?php
          // Show (error) message to the user after a failed login attempt has been made
          if(!empty($message) && !empty($_POST['login_attempt']))
          {
            ?>

            <!-- Error message block - informs the user of any errors in the login process -->
            <div class = "block_divider col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class = 
                <?php
                if ($error_number >= 0 && $error_number < 10)
                {
                  echo "\"block error blue\"";
                  $error_title = "Ontbrekende gegevens";
                }
                else if ($error_number > 10 && $error_number < 20)
                {
                  echo "\"block error orange\"";
                  $error_title = "Let op";
                }
                else if ($error_number > 20 && $error_number < 30)
                {
                  echo "\"block error red\"";
                  $error_title = "Error";
                }
                ?>
              >

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b><?php echo $error_title; ?></b></h3>
                  <img class = "image" src = "images/warning.png" width = "86" height = "86"><br>
                  <b><?php echo $message; ?></b>
                </div>

              </div>
            </div>
            <!-- End of block -->

            <?php
          }
          ?>

          <!-- Login block -->
          <div class = "block_divider col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class = "block blue small">

              <!-- Block text -->
              <div class = "media-body">
                <h3 class = "media-heading"><b>Inloggen</b></h3><br>
              </div>

              <!-- User data input windows and submit button -->
              <form action = "login.php" method = "POST">
                <div class = "form-block">
                  <input type = "text" <?php if (!empty($_POST['email'])) { echo "value = \"".$_POST['email']."\""; } ?> placeholder = "E-mail" name = "email" class = "form-control">
                  <input type = "password" placeholder = "Wachtwoord" name = "wachtwoord" class = "form-control">
                  <input type = "hidden" value = "true" name = "login_attempt"/>
                </div>

                <div class = "service_button">
                  <button type = "submit" class = "btn btn-success">Klik hier om in te loggen</button>
                </div>
              </form>

            </div>
          </div>
          <!-- End of block -->

          <!-- Back button - returns the user to the home page -->
          <div class = "block_divider col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class = "block gray small">

              <!-- Block text -->
              <div class = "media-body">
                <h3 class = "media-heading"><b>Terug naar welkomstpagina</b></h3>
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

          

        </div>
        <!-- End of subbody div -->
        
      </div>
      <!-- End of body div -->
    </div>
    <!-- End of page container -->
    <br>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>