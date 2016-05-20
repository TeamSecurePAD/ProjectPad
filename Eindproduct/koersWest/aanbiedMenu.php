<?php
  session_start();

  // Make sure we're connected to the database
  require 'databaseConnectionOpening.php';

  // If a user is logged in, display a list of services for them to choose from
  if (isset($_SESSION['user_id']))
  {
    $categorie = "NONE";

    if (!empty($_POST))
    {
      if (!empty($_POST['categorie']))
      {
        $categorie = ($_POST['categorie']);
      }
    }

    // User's session id, used to reference currently logged in user in database queries
    $id = $_SESSION['user_id'];

    $my_services_query = "SELECT Dienst_dienst
                          FROM gebruiker_bied_dienst_aan
                          WHERE gebruiker_id = $id";

    $services_query = "SELECT *
                       FROM dienst";

    $my_services = mysqli_query($connection, $my_services_query);
    $services = mysqli_query($connection, $services_query);

    if (!empty($_POST['dienst_name']))
    {
      $dienst_name = $_POST['dienst_name'];
      $insert_new_service = "INSERT INTO gebruiker_bied_dienst_aan
                             VALUES ('$id', '$dienst_name')";
      mysqli_query($connection, $insert_new_service);
    }


    // List of categories
    $list_categories = array();

    $query_all_categories = "SELECT Categorie FROM categorie";
    $result_all_categories = mysqli_query($connection, $query_all_categories);

    while ($row_categories = $result_all_categories->fetch_assoc())
    {
      $list_categories[] = $row_categories['Categorie'];
    }
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
    <title>Dienst aanbieden</title>
  </head>

  <body>
    <?php 
    include("Navigation.php");
    ?>

    <div class="container">
      <div class = "body">
        <div class = "title">
          <div class = "tile_green">
            <h1><c class = "white">Dienst aanbieden</c></h1>
            <h2><c class = "white">Selecteer een categorie om diensten te tonen.</c></h2>
          </div>
        </div>

        <form action="aanbiedMenu.php" method="POST">
        <nav class = "navbar navbar-inverse">
          <div class = "container">
            <ul class = "nav navbar-nav">
              <li><label style="padding: 5px; margin: 5px;" for="selectCategorie"><b class="white">Categorie:</b></label></li>
              <li><select style="padding: 5px; margin: 5px;" class="form-control" id="selectCategorie" name="categorie">
                <?php
                  foreach ($list_categories as $row)
                  {
                        echo"<option>";
                        echo ($row);
                        echo "</option>";
                  } 
                ?>
              </select></li>

              <li><input style="margin: 10px;" type="submit" name="submit" value="Zoeken"></li>
            </ul>
          </div>
        </nav>
        </form>

        <div class = "subbody col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <?php
          echo "<div class = \"tile_green\">";
          if ($categorie != "NONE")
          {
            echo "<h3><b class = \"white\">".$categorie."</b></h3>";
          }
          else
          {
            echo "<h3><c class = \"white\">Selecteer een categorie uit de lijst icoontjes om alle diensten van deze categorie te tonen.</b></h3>";
          }
          echo "</div>";

          $any_services = false;

          while($current_service = $services->fetch_assoc())
          {
            $already_own_service = false;

            while($my_current_service = $my_services->fetch_assoc())
            {
              if($current_service['dienst'] == $my_current_service['Dienst_dienst'])
              {
                $already_own_service = true;
              }
            }

            if ($already_own_service == false && $current_service['Categorie_Categorie'] == $categorie)
            {
              $any_services = true;
              ?>
              <div class="block_success col-xs-10 col-sm-6 col-md-4 col-lg-3">

                <!-- Block text -->
                <div class="media-body">
                  <h3 class="media-heading"><b class = "white"><?php echo ($current_service["dienst"]);?></b></h3>
                  <img class = "image" src = "<?php echo "images/".$current_service["dienst"].".png"; ?>" height="86" width="86"><br><br>
                  <b>Omschrijving: </b><?php echo ($current_service["omschijving"]);?>
                </div>

                <!-- Submit button -->
                <div class = "service_button">
                  <form action="aanbiedMenu.php" method="POST">
                    <button type="submit" class="btn btn-success" value="Dienst aanbieden">Dienst aanbieden</button>
                    <input type="hidden" value="<?php echo($current_service["dienst"]); ?>" name="dienst_name"/>
                  </form>
                </div>

              </div>
              <?php
            }
            ?>

          <?php
            $my_services->data_seek(0);
          }//end while

          if ($categorie != "NONE" && !$any_services)
          {
            echo "<b class = \"green\">U biedt alle diensten uit deze categorie al aan.</b>";
          }

          if (!empty($_POST['dienst_name']))
          {
            $dienst_name = $_POST['dienst_name'];
            ?>
            <div class="block_primary col-xs-10 col-sm-6 col-md-4 col-lg-3">

              <!-- Block text -->
              <div class="media-body">
                <h3 class="media-heading"><b class = "white"><?php echo $dienst_name;?></b></h3>
                <img class = "image" src = "<?php echo "images/".$dienst_name.".png"; ?>" height="86" width="86"><br><br>
                <b>Omschrijving: </b><?php echo $dienst_name;?>
              </div>

            </div>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
    <br>

    <div class="container">
      <?php
        if (!empty($_POST['dienst_name']))
        {
          $dienst_name = $_POST['dienst_name'];

          echo "U biedt nu de volgende dienst aan: <b class=\"green\">".$dienst_name.".</b><br>";
        }
      ?>
    </div>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
</html>