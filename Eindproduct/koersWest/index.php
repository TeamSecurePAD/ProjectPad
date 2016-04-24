  <?php
  session_start();

  require 'databaseConnectionOpening.php';

  if (isset($_SESSION['user_id']))
  {
    $id = $_SESSION['user_id'];

    $query = "SELECT id, email, straat, telefoonnummer
              FROM gebruiker
              WHERE id = $id";

    $result = mysqli_query($connection, $query);

    if ($result)
    {
      $row = mysqli_fetch_row($result);
      $gebruikerID = $row[0];
      $dbemail = $row[1];
      $dbstraat = $row[2];
      $dbtelnummer = $row[3];
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
    <?php if (isset($_SESSION['user_id'])): ?>

    <?php 
    include("Navigation.php");
    ?>

    <div class="content container">
      <h1>Uw gegevens</h1>
      <p><?php echo($dbemail) ?></p>
      <p><?php echo($dbstraat); ?></p>
      <p><?php echo($dbtelnummer) ?></p>

      <?php
      $row_count_is_goed_in = mysqli_num_rows($result_is_goed_in_categorie);
      $row_count_is_slecht_in = mysqli_num_rows($result_is_slecht_in_categorie);


      if ($row_count_is_goed_in > 0 && $row_count_is_slecht_in > 0) 
      {
        while ($row_goed = $result_is_goed_in_categorie->fetch_assoc()) 
        {
              // sla de catogorie op waar de gebruiker goed in is.
          $is_goed_in_categorie = $row_goed["Categorie_Categorie"];
          echo "U heeft talent in de volgende categorie: ";
          echo "<b>";
          echo ($is_goed_in_categorie);
          echo "</b>";
        }
        echo("<br>");
        while ($row_slecht = $result_is_slecht_in_categorie->fetch_assoc()) 
        {
              // sla de catogorie op waar de gebruiker slecht in is.
          $is_slecht_in_categorie = $row_slecht["Categorie_Categorie"];
          echo "U heeft moeite in de volgende categorie: ";
          echo "<b>";
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
          echo "<h3>U biedt momenteel de volgende diensten aan</h3>";
          while($row = $result_diensten->fetch_assoc())
          {
            echo($row["dienst"]);
            echo "</br>";
          }
        } 
        else 
        {
          echo "<h3>U biedt momenteel geen diensten aan</h3>";
          echo "<p><a href=\"aanbiedMenu.php\">Klik hier</a> om een dienst toe te voegen<p>";
        }

        echo("<br>");

        $gevonden_match = false;

            //In deze sql query worden mensen uit de database gehaald die hebben aangegeven
            //dat ze goed zijn in de categorie waar de huidige ingelogde slecht in is.
        $query_is_goed_in_slecht = "SELECT Gebruiker_Id
                                    FROM gebruiker_is_goed_in_categorie
                                    WHERE Categorie_Categorie = '$is_slecht_in_categorie' 
                                    AND Gebruiker_Id != $id";

        $result_is_goed_in_slecht = mysqli_query($connection, $query_is_goed_in_slecht);         

        while ($row_goed_in_slecht = $result_is_goed_in_slecht->fetch_assoc()) 
        {

          $match_id_goed_in_slecht = $row_goed_in_slecht["Gebruiker_Id"];

              //In deze sql query worden mensen uit de database gehaald die hebben aangegeven
              //dat ze slecht zijn in de categorie waar de huidige ingelogde goed in is.
          $query_is_slecht_in_goed = "SELECT Gebruiker_Id
                                      FROM gebruiker_is_slecht_in_categorie
                                      WHERE Categorie_Categorie = '$is_goed_in_categorie' AND Gebruiker_Id != $id
                                      And Gebruiker_Id = $match_id_goed_in_slecht";

          $result_is_slecht_in_goed = mysqli_query($connection, $query_is_slecht_in_goed);

          while ($row_slecht_in_goed = $result_is_slecht_in_goed->fetch_assoc()) 
          {

            $match_id_slecht_in_goed = $row_slecht_in_goed["Gebruiker_Id"];

            if ($match_id_slecht_in_goed == $match_id_goed_in_slecht && $gevonden_match == false) 
            {
             $gevonden_match = true;
             echo "<br>";
             echo "<br>";
             echo "<h2>Er is een Match!</h2>";
             echo "<p>Op basis van de door u ingevulde gegevens hebben wij een match gevonden!</p>";
             echo "<br>";

             $query_match_gebruiker = "SELECT id, email, straat, telefoonnummer
                                       FROM gebruiker
                                       WHERE id = $match_id_slecht_in_goed";

             $result_match_gebruiker = mysqli_query($connection, $query_match_gebruiker);

             $match_gebruiker=mysqli_fetch_assoc($result_match_gebruiker);

             echo ($match_gebruiker['email']);
             echo "<br>";
             echo ($match_gebruiker['straat']);
             echo "<br>";
             echo ($match_gebruiker['telefoonnummer']);
           }
         }
       }


       if ($gevonden_match == false)
       {
        echo "<h2>Geen match </h2>";
        echo "<p> Helaas is er op dit moment voor u geen match gevonden. <br>
        Kijkt u later nog eens om te kijken of er een match is. <br>
        Nu kunt onder het kopje <a href=\"askForService.php\">dienst vragen</a> mensen vinden die u zouden kunnen helpen</p>";
      }
    }
    ?>
    <br>
    <br>
    <a href="logout.php">Uitloggen</a>
  </div>

<?php else: ?>
  <h1>Welcome</h1>
  <a href="login.php">Login</a>
  <a href="register.php">Register</a>
<?php endif; ?>

<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script> 
<script src="js/script.js"></script>
</body>
</html>