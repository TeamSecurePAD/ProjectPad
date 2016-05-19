  <?php
  require 'databaseConnectionOpening.php';
  
   $query = "SELECT dienst
             FROM dienst";

   $result = mysqli_query($connection, $query);


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

            if ($result_aangeboden){
              $row_aangeboden = mysqli_fetch_assoc($result_aangeboden);
            }
            else {
              echo "error";
            }
            

            $query_gevraagd = "SELECT COUNT(*) 
                               AS totalGevraagd 
                               FROM gebruiker_vraagt_dienst
                               WHERE Dienst_dienst = '$dienstNaam'";

            $result_gevraagd = mysqli_query($connection, $query_gevraagd);
            $row_gevraagd = mysqli_fetch_assoc($result_gevraagd);


            ?>

            <tr>
              <td><?php echo ($dienstNaam); ?></td>
              <td><?php echo $row_aangeboden['totalAangeboden'];?></td>
              <td><?php echo $row_gevraagd['totalGevraagd'];?></td>
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