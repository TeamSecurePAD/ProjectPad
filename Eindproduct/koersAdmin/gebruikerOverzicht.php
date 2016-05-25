  <?php
  require 'databaseConnectionOpening.php';

  // looking for the user with the name
  $name = "";
  $lastName = "";
  $id = "";

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

    $email = '';
    $straat = '';
    $telnummer = '';
    $postcode = '';
    $woonplaats = '';
    $tussenvoegsel = '';

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

      <form action="gebruikerOverzicht.php" method="POST"> 

        <h4>Zoek gebruiker</h4>

          <input class="form-control" type="text" placeholder="Naam" name="name">
                 
          <input class="form-control" type="text" placeholder="Achternaam" name="lastName">

          <button type = "submit" class = "btn btn-primary" value= "StepOne" name="stepNumber">Verzenden</button>
      </form>

      <h1>Gegevens</h1>
      <p><b>Naam: </b> <?php echo ($name); ?> </p>
      <p><b>tussenvoegsel: </b> <?php echo ($tussenvoegsel); ?> </p>      
      <p><b>Achternaam: </b> <?php echo ($lastName); ?> </p>
      <p><b>Email: </b> <?php echo ($email); ?> </p>
      <p><b>Telefoonnummer: </b> <?php echo ($telnummer); ?> </p>
      <p><b>Postcode: </b> <?php echo ($postcode); ?> </p>
      <p><b>Woonplaats: </b> <?php echo ($woonplaats); ?> </p>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
  </html>