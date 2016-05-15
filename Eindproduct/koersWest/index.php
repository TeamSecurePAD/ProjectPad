  <?php
  session_start();
  require 'databaseConnectionOpening.php';

  if (isset($_SESSION['user_id']))
  {
    $id = $_SESSION['user_id'];

    $query = "SELECT id, email, omschrijving, naam, tussenvoegsel, achternaam, telefoonnummer, straat, postcode, woonplaats
              FROM gebruiker
              WHERE id = $id";

    $result = mysqli_query($connection, $query);

    if ($result)
    {
      $row = mysqli_fetch_assoc($result);
      $gebruikerID = $row['id'];
      $dbemail = $row['email'];
      $dbstraat = $row['straat'];
      $dbtelnummer = $row['telefoonnummer'];
      $dbpostcode = $row['postcode'];
      $dbwoonplaats = $row['woonplaats'];
      $dbomschrijving = $row['omschrijving'];
      $dbnaam = $row['naam'];
      $dbtussenvoegsel = $row['tussenvoegsel'];
      $dbachternaam = $row['achternaam'];
    }


      // In dit gedeelte van de code haal ik alle informatie op
      // die nodig is om gebruikers aan elkaar te matchen
      // op basis van de vaardigheden waar ze goed en slecht in zijn

    $query_is_goed_in_categorie = "SELECT Categorie_Categorie
                                   FROM gebruiker_is_goed_in_categorie
                                   WHERE Gebruiker_Id = $id";

    $query_is_slecht_in_categorie = "SELECT Categorie_Categorie
                                     FROM gebruiker_is_slecht_in_categorie
                                     WHERE Gebruiker_Id = $id";

    $result_is_goed_in_categorie = mysqli_query($connection, $query_is_goed_in_categorie);
    $result_is_slecht_in_categorie = mysqli_query($connection, $query_is_slecht_in_categorie);

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
    include("Navigation.php");
    ?>

    <?php if (isset($_SESSION['user_id']))
    { 
      ?>

    <div class="content container">
      <h1>Profiel</h1>
      <h3><b class="green">Uw gegevens</b></h3>
      <div class = "list">
        <b>Naam: </b><?php echo($dbnaam." "); echo($dbtussenvoegsel." "); echo($dbachternaam); ?><br>
        <b>Omschrijving van jezelf:</b> <?php echo ($dbomschrijving);?> <br> <br>
        <b>Email: </b><?php echo($dbemail); ?><br>
        <b>Adres: </b><?php echo($dbstraat.", ".$dbpostcode.", ".$dbwoonplaats); ?><br>
        <b>Telefoonnummer: </b><?php echo($dbtelnummer) ?><br>
      </div>
      <br>
      <br>

      <?php
        $row_count_is_goed_in = mysqli_num_rows($result_is_goed_in_categorie);
        $row_count_is_slecht_in = mysqli_num_rows($result_is_slecht_in_categorie);

        if ($row_count_is_goed_in > 0 && $row_count_is_slecht_in > 0) 
        {
          while ($row_goed = $result_is_goed_in_categorie->fetch_assoc()) 
          {
            // Save category that the user excells at
            $is_goed_in_categorie = $row_goed["Categorie_Categorie"];
            echo "Talent: ";
            echo "<b class=\"green\">";
            echo ($is_goed_in_categorie);
            echo "</b>";
          }
          echo("<br>");
          while ($row_slecht = $result_is_slecht_in_categorie->fetch_assoc()) 
          {
            // Save category that the user needs help with
            $is_slecht_in_categorie = $row_slecht["Categorie_Categorie"];
            echo "Hulpvraag: ";
            echo "<b class=\"red\">";
            echo ($is_slecht_in_categorie);
            echo "</b>";
          }

          $sql_get_diensten = "SELECT D.dienst
                               FROM gebruiker_bied_dienst_aan GBDA
                               INNER JOIN dienst D
                               ON GBDA.Dienst_dienst = D.dienst
                               WHERE GBDA.Gebruiker_Id = '$id'";

          $result_diensten = mysqli_query($connection, $sql_get_diensten);

          $row_count = mysqli_num_rows($result_diensten);

          if ($row_count > 0)
          {
            echo "<h3><b class=\"green\">U biedt momenteel de volgende diensten aan:</b></h3>";
            echo "<div class = \"list\">";
              while($row = $result_diensten->fetch_assoc())
              {
                echo($row["dienst"]);
                echo "<br>";
              }
            echo "</div>";
          } 
          else 
          {
            echo "<h3><b class=\"red\">U biedt momenteel geen diensten aan.</b></h3>";
            echo "<b><a href=\"aanbiedMenu.php\">Klik hier</a></b> om een dienst toe te voegen.<br>";
          }
          echo "<br>";

          include ('matchCategorie.php');

          echo "<h3><b class=\"green\"><a href=\"matchingMenu.php\">Match Menu</a></b><br></h3>";
        }
        else
        {
          echo "Het lijkt erop dat u de vragenlijst nog niet heeft ingevuld.<br>";
          echo "<b><a href = \"about.php\">Vragenlijst invullen</a></b>";
        }
      ?>
      <br>
      <br>
      <!--<b><a href="logout.php">Uitloggen</a></b>-->
    </div>

    <?php 
      } 
      else 
      { 
    ?>
      <div class="container">
        <h1>KoersWest</h1>

        Welkom bij <b class="green">KoersWest</b>, de app die je helpt je netwerk op te bouwen en mensen te vinden die je kunnen helpen.<br>
        <b><a href="login.php">Login</a></b><br><br>

        Als je nog niet geregistreerd bent, dan kan dat hier:<br>
        <b><a href="register.php">Register</a></b>
      </div>
    <?php 
      }; 
    ?>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
</html>