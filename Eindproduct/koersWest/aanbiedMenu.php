<?php
session_start();
require 'databaseConnectionOpening.php';
$id = $_SESSION['user_id'];

$query = "SELECT * FROM dienst";

$result= mysqli_query($connection, $query);

if (!empty($_POST['dienst_name']))
{
  $dienst_name = $_POST['dienst_name'];
  $query = "INSERT INTO gebruiker_bied_dienst_aan VALUES ('$id', '$dienst_name')";
  mysqli_query($connection, $query);

  echo "U bied nu de volgende dienst aan:".$dienst_name;
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
  <title>login</title>
</head>
<body>
  <h3>Welke van de onderstaande diensten wilt u aanbieden?</h3>
  <div>
     
     <?php while($row = $result->fetch_assoc())
     { ?>

      <div><?php echo ($row["dienst"]);?></div>
      <div><?php echo ($row["omschijving"]);?></div>
      <form action="aanbiedMenu.php" method="POST">
      <input type="submit" value="bied aan" />
      <input type="hidden" value=<?php echo($row["dienst"])?> name="dienst_name"/>
      </form>

    <?php
    }//end while
    ?>
     <a href="index.php">Return</a>
  </div>

<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script> 
<script src="js/script.js"></script>
</body>
</html>