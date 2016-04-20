<?php
session_start();
require 'databaseConnectionOpening.php';

$query = "SELECT * FROM dienst";

$result= mysqli_query($connection, $query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <title>login</title>
</head>
<body>
  <h3>Welke van de onderstaande diensten wilt u aanbieden?</h3>
  <div>
    <?php 
     while($row = $result->fetch_assoc()){


      echo "<div>".$row["dienst"]."</div>";
      echo "<div>".$row["omschijving"]."</div>";
      echo "<input type=\"submit\" name=\"submit\">";
    }//end while
    ?>
  </div>

<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script> 
<script src="js/script.js"></script>
</body>
</html>