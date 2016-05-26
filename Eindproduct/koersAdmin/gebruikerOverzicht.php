  <?php
  require 'databaseConnectionOpening.php';

  // looking for the user with the name
  $name = "";
  $lastName = "";
  $id = "";
  $email = '';
  $straat = '';
  $telnummer = '';
  $postcode = '';
  $woonplaats = '';
  $tussenvoegsel = '';

  if (!empty($_POST['name']) && !empty($_POST['lastName']))
  {
    $name = $_POST['name'];
    $lastName = $_POST['lastName'];
  }

    $current_user_data = "SELECT id, email, tussenvoegsel, telefoonnummer, straat, postcode, woonplaats
                          FROM gebruiker
                          WHERE naam = '$name'
                          AND achternaam = '$lastName'";

    $current_user_data_result = mysqli_query($connection, $current_user_data);

    if ($current_user_data_result)
    {
      $row = mysqli_fetch_assoc($current_user_data_result);
      $id = $row['id'];
      $email = $row['email'];
      $straat = $row['straat'];
      $telnummer = $row['telefoonnummer'];
      $postcode = $row['postcode'];
      $woonplaats = $row['woonplaats'];
      $tussenvoegsel = $row['tussenvoegsel'];
    }

    if (!empty($id))
    {
      $query_bied_aan = "SELECT Dienst_dienst
                         FROM gebruiker_bied_dienst_aan
                         WHERE Gebruiker_Id = $id";

      $result_bied_aan = mysqli_query($connection, $query_bied_aan);

      $query_vraagt = "SELECT Dienst_dienst
                       FROM gebruiker_vraagt_dienst
                       WHERE Gebruiker_Id = $id";

      $result_vraagt = mysqli_query($connection, $query_vraagt);

      $query_is_goed_in = "SELECT Categorie_Categorie
                           FROM gebruiker_is_goed_in_categorie
                           WHERE Gebruiker_Id = $id";

      $result_is_goed_in = mysqli_query($connection, $query_is_goed_in);
      $row_is_goed_in = mysqli_fetch_assoc($result_is_goed_in);

      $query_heeft_hulp_nodig = "SELECT Categorie_Categorie
                                 FROM gebruiker_is_slecht_in_categorie
                                 WHERE Gebruiker_Id = $id";

      $result_heeft_hulp_nodig = mysqli_query($connection, $query_heeft_hulp_nodig);
      $row_heeft_hulp_nodig = mysqli_fetch_assoc($result_heeft_hulp_nodig);

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
    <title>DienstenOverzicht</title>
  </head>

  <body>
    <?php 
    include("Navigation.php");
    ?>
    <div class = "container">

      <form action="gebruikerOverzicht.php" method="POST"> 

        <h4>Zoek gebruiker</h4>

          <input class="form-control" type="text" placeholder="Naam" name="name">
                 
          <input class="form-control" type="text" placeholder="Achternaam" name="lastName">

          <button type = "submit" class = "btn btn-primary" value= "StepOne" name="stepNumber">Verzenden</button>
      </form>
      <?php 
      if (!empty($id))
      {
        ?>

        <h1>Gegevens</h1>
        <p><b>Naam: </b> <?php echo ($name); ?> </p>
        <p><b>tussenvoegsel: </b> <?php echo ($tussenvoegsel); ?> </p>      
        <p><b>Achternaam: </b> <?php echo ($lastName); ?> </p>
        <p><b>Email: </b> <?php echo ($email); ?> </p>
        <p><b>Telefoonnummer: </b> <?php echo ($telnummer); ?> </p>
        <p><b>Postcode: </b> <?php echo ($postcode); ?> </p>
        <p><b>Woonplaats: </b> <?php echo ($woonplaats); ?> </p><br>

        <p><b>Goed in categorie:</b>
        <?php 
        echo ($row_is_goed_in['Categorie_Categorie']);
        ?>
        </p>

        <p><b>hulp nodig in categorie:</b>
        <?php
        echo ($row_heeft_hulp_nodig['Categorie_Categorie']);
        ?>
        </p>

        <br><p><b>Bied aan:</b></p>

        <?php
        while ($row_bied_aan = $result_bied_aan->fetch_assoc()) 
        {
          echo ($row_bied_aan['Dienst_dienst']);
          echo "<br>";
        }
        ?>

        <br><p><b>Vraagt:</b></p>

        <?php
        while ($row_vraagt = $result_vraagt->fetch_assoc()) 
        {
          echo ($row_vraagt['Dienst_dienst']);
          echo "<br>";
        }
        ?>


        <?php
      }
      ?>
    </div>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
  </html>