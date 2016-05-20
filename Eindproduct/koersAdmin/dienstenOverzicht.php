  <?php
  require 'databaseConnectionOpening.php';
  
   $query = "SELECT dienst
             FROM dienst";

   $result = mysqli_query($connection, $query);

   $query_aangeboden_count = "SELECT COUNT(*) 
                              AS totalAangebodenCount 
                              FROM gebruiker_bied_dienst_aan";

   $result_aangeboden_count = mysqli_query($connection, $query_aangeboden_count);
   $row_aangeboden_count = mysqli_fetch_assoc($result_aangeboden_count);

   $totaalDiensten = $row_aangeboden_count['totalAangebodenCount'];

   $query_gevraagd_count = "SELECT COUNT(*) 
                            AS totalGevraagdCount 
                            FROM gebruiker_vraagt_dienst";

   $result_gevraagd_count = mysqli_query($connection, $query_gevraagd_count);
   $row_gevraagd_count = mysqli_fetch_assoc($result_gevraagd_count);

   $totaalDiensten += $row_gevraagd_count['totalGevraagdCount'];

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
    <div class="container">

      <table class="table">
        <thead>
          <tr>
            <th>Dienst</th>
            <th>Aantal aangeboden</th>
            <th>Aantal gevraagd</th>
            <th>Percentage geheel</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          while ($row = $result->fetch_assoc()) {

            $dienstNaam = $row['dienst'];

            $query_aangeboden = "SELECT COUNT(*) 
                                 AS totalAangeboden 
                                 FROM gebruiker_bied_dienst_aan
                                 WHERE Dienst_dienst = '$dienstNaam'";

            $result_aangeboden = mysqli_query($connection, $query_aangeboden);
            $row_aangeboden = mysqli_fetch_assoc($result_aangeboden);

            $totaalVraagAanbod = $row_aangeboden['totalAangeboden'];

            $query_gevraagd = "SELECT COUNT(*) 
                               AS totalGevraagd 
                               FROM gebruiker_vraagt_dienst
                               WHERE Dienst_dienst = '$dienstNaam'";

            $result_gevraagd = mysqli_query($connection, $query_gevraagd);
            $row_gevraagd = mysqli_fetch_assoc($result_gevraagd);

            $totaalVraagAanbod += $row_gevraagd['totalGevraagd'];

            $PercentageGeheel = (($totaalVraagAanbod/$totaalDiensten) * 100);
            $PercentageGeheel =  number_format($PercentageGeheel);

            ?>

            <tr>
              <td><?php echo ($dienstNaam); ?></td>
              <td><?php echo $row_aangeboden['totalAangeboden'];?></td>
              <td><?php echo $row_gevraagd['totalGevraagd'];?></td>
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