  <?php
  require 'databaseConnectionOpening.php';
  
   $query = "SELECT Categorie
             FROM categorie";

   $result = mysqli_query($connection, $query);

   //The following SQL statements are being used to calculate the percentence of
   //the categorie.

   $query_goed_in_count = "SELECT COUNT(*) 
                           AS totalGoedInCount 
                           FROM gebruiker_is_goed_in_categorie";

   $result_goed_in_count = mysqli_query($connection, $query_goed_in_count);
   $row_goed_in_count = mysqli_fetch_assoc($result_goed_in_count);

   $totaalCategoriën = $row_goed_in_count['totalGoedInCount'];

   $query_slecht_in_count = "SELECT COUNT(*) 
                             AS totalSlechtInCount 
                             FROM gebruiker_is_slecht_in_categorie";

   $result_slecht_in_count = mysqli_query($connection, $query_slecht_in_count);
   $row_slecht_in_count = mysqli_fetch_assoc($result_slecht_in_count);

   $totaalCategoriën += $row_slecht_in_count['totalSlechtInCount'];

  ?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>CategoriënOverzicht</title>
  </head>

  <body>
    <?php 
    include("Navigation.php");
    ?>
    <div class="container">

      <table class="table">
        <thead>
          <tr>
            <th>Dienst</th>
            <th>Aantal goed in</th>
            <th>Aantal slecht </th>
            <th>Percentage geheel</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          while ($row = $result->fetch_assoc()) {

            $CategorieNaam = $row['Categorie'];

            $query_goed_in = "SELECT COUNT(*) 
                              AS totalGoedIn
                              FROM gebruiker_is_goed_in_categorie
                              WHERE Categorie_Categorie = '$CategorieNaam'";

            $result_goed_in = mysqli_query($connection, $query_goed_in);
            $row_goed_in = mysqli_fetch_assoc($result_goed_in);

            $totaalCategorieAanwezig = $row_goed_in['totalGoedIn'];

            $query_slecht_in = "SELECT COUNT(*) 
                                AS totalSlechtIn
                                FROM gebruiker_is_slecht_in_categorie
                                WHERE Categorie_Categorie = '$CategorieNaam'";

            $result_slecht_in = mysqli_query($connection, $query_slecht_in);
            $row_slecht_in = mysqli_fetch_assoc($result_slecht_in);

            $totaalCategorieAanwezig+= $row_slecht_in['totalSlechtIn'];

            $PercentageGeheel = (($totaalCategorieAanwezig/$totaalCategoriën) * 100);
            $PercentageGeheel =  number_format($PercentageGeheel);

            ?>

            <tr>
              <td><?php echo ($CategorieNaam); ?></td>
              <td><?php echo $row_goed_in['totalGoedIn'];?></td>
              <td><?php echo $row_slecht_in['totalSlechtIn'];?></td>
              <td><?php echo $PercentageGeheel; ?>% </td>
            </tr>
            <?php
          }
          ?>

        </tbody>
      </table>

    </div>

    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>
  </body>
  </html>