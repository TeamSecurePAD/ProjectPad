<?php
  session_start();

  // Make sure we're connected to the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, display a list of services for them to choose from
  if (isset($_SESSION['user_id']))
  {
    // User's session id, used to reference currently logged in user in database queries
    $id = $_SESSION['user_id'];

    $selectedCategory = '';
    $newCategory = '';
    $currect_category_is_question = false;

    if (!empty($_POST['message_title']))
    {
      $message_title = $_POST['message_title'];
    }
    else
    {
      $message_title = '';
    }

    if (!empty($_POST['message']))
    {
      $message = $_POST['message'];
    }
    else
    {
      $message = '';
    }

    if (!empty($_POST['selectedCategory']))
    {
      $selectedCategory = $_POST['selectedCategory'];
    }

    if (!empty($_POST['submit']))
    {
      if ($_POST['submit'] == "confirm") // User clicked the confirm button to confirm category change
      {
        // Deletes the old category from the database and inserts the new one
        // Also deletes any matches with the old category (since those are no longer relevant)
        if (!empty($_POST['newCategory']))
        {
          $newCategory = $_POST['newCategory'];

          $query_remove_category_matches = "DELETE FROM match_categorie
                                            WHERE gebruiker_Id = '$id'
                                            OR match_gebruiker_Id = '$id'";

          mysqli_query($connection, $query_remove_category_matches);

          $query_remove_category = "DELETE FROM gebruiker_is_slecht_in_categorie
                                    WHERE Gebruiker_Id = '$id'";

          mysqli_query($connection, $query_remove_category);

          $query_insert_new_category = "INSERT INTO gebruiker_is_slecht_in_categorie
                                        VALUES ('$id', '$newCategory')";

          mysqli_query($connection, $query_insert_new_category);

          $message_title = 'Categorie aangepast';
          $message = 'U vraagt vanaf nu om hulp in de categorie '.$newCategory.'.';
        }
      }
      else if ($_POST['submit'] == "cancel") // User clicked the cancel button to cancel category change
      {

      }
    }

    // Provides a list of all categories in the database
    $query_all_categories = "SELECT categorie FROM categorie";
    $categories = mysqli_query($connection, $query_all_categories);

    // The category the current user is competent in
    $query_user_question = "SELECT Categorie_Categorie FROM gebruiker_is_slecht_in_categorie WHERE Gebruiker_Id = '$id'";
    $user_question = mysqli_query($connection, $query_user_question);
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
    <title>Hulpvraag</title>
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
            <?php
            if (!empty($selectedCategory))
            {
              ?>
              <h1><c class = "white">Hulpvraag</c></h1>
              <img class = "image" src = "images/hulpvraag.png" width = "86" height = "86">
              <h2><c class = "white">Bevestig uw keuze.</c></h2>
              <?php
            }
            else
            {
              ?>
              <h1><c class = "white">Hulpvraag</c></h1>
              <img class = "image" src = "images/hulpvraag.png" width = "86" height = "86">
              <h2><c class = "white">De categorie waar u hulp bij nodig hebt.</c></h2>
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
            <div class = "block col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class = "block_error_small_green">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white"><?php echo $message_title; ?></b></h3>
                  <img class = "image" src = "images/success.png" width = "86" height = "86"><br>
                  <b class = "white"><?php echo $message; ?></b>
                </div>

              </div>
            </div>
            <?php
          }
          ?>

          <?php
          if (!empty($selectedCategory))
          {
            ?>

            <!-- Alert that informs the user that they're about to delete all their current matches -->
            <div class = "block col-xs-12 col-sm-6 col-md-6 col-lg-6">
              <div class = "block_warning_small">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Let op!</b></h3>
                  <img class = "image" src = "images/warning.png" width = "86" height = "86"><br>
                  <b class = "white">Als u deze nieuwe categorie selecteert worden al uw huidige matches verwijderd!<br>Weet u zeker dat u wilt veranderen?</b>
                </div>

              </div>
            </div>

            <!-- Shows the category that the user is about to switch to in bright orange -->
            <div class = "block col-xs-12 col-sm-6 col-md-6 col-lg-6">
              <div class = "block_confirmed_small">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white"><?php echo $selectedCategory;?></b></h3>
                  <img class = "image" src = "<?php echo "images/".$selectedCategory.".png"; ?>" width = "86" height = "86"><br><br>
                </div>

                <!-- Submit buttons -->
                <form action = "myHelpCategory.php" method = "POST">
                  <button type = "submit" class = "btn btn-success" value = "confirm" name = "submit">Bevestigen</button>
                  <button type = "submit" class = "btn btn-danger" value = "cancel" name = "submit">Annuleren</button>
                  <input type = "hidden" value = "<?php echo $selectedCategory; ?>" name = "newCategory"/>
                </form>

              </div>
            </div>

            <?php
          }
          else
          {
            ?>

            <?php
            while($current_category = $categories->fetch_assoc())
            {
              $currect_category_is_question = false;
              ?>

              <?php
              while($current_user_question = $user_question->fetch_assoc())
              {
                ?>

                <?php
                if ($current_category['categorie'] == $current_user_question['Categorie_Categorie'])
                {
                  $currect_category_is_question = true;
                }
                ?>

                <?php
              }
              ?>

              <?php
              if ($currect_category_is_question)
              {
                ?>
                <!-- Shows the category that the user is currently asking for help with in a different color -->
                <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
                  <div class = "block_success2_small">

                    <!-- Block text -->
                    <div class = "media-body">
                      <h3 class = "media-heading"><b class = "white"><?php echo $current_category['categorie'];?></b></h3>
                      <img class = "image" src = "<?php echo "images/".$current_category['categorie'].".png"; ?>" width = "86" height = "86"><br><br>
                      <h3 class = "media-heading" style = "margin-bottom: 0px;"><b class = "white">Dit is uw huidige hulpvraag.</b></h3>
                    </div>

                  </div>
                </div>
                <?php
              }
              else
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
                    <form action = "myHelpCategory.php" method = "POST">
                      <button type = "submit" class = "btn btn-primary" value = "Diensten bekijken">Categorie veranderen</button>
                      <input type = "hidden" value = "<?php echo $current_category['categorie']; ?>" name = "selectedCategory"/>
                    </form>

                  </div>
                </div>
                <?php
              }
              ?>

              <?php
              // Reset $user_question array so it can be looped through in the next cycle
              $user_question->data_seek(0);
              ?>

              <?php
            }//end while
            ?>

            <!-- Back button in category list - returns the user to the profile page -->
            <div class = "block col-xs-12 col-sm-6 col-md-4 col-lg-3">
              <div class = "block_grey_small">

                <!-- Block text -->
                <div class = "media-body">
                  <h3 class = "media-heading"><b class = "white">Terug naar profiel</b></h3>
                  <img class = "image" src = "images/backarrow.png" width = "86" height = "86"><br><br>
                </div>

                <!-- Submit button -->
                <form action = "profile.php">
                  <button type = "submit" class = "btn btn-secondary" style = "color: black;">Klik hier om terug te gaan</button>
                </form>

              </div>
            </div>

            <?php
          }//end if
          ?>
        </div>
      </div>
    </div>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
</html>