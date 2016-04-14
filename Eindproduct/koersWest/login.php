<?php
require 'databaseConnectionOpening.php';

if (!empty($_POST['email']) && !empty($_POST['wachtwoord'])) {
  

  $email = strip_tags($_POST['email']);
  $wachtwoord = strip_tags($_POST['wachtwoord']);

  $query = "SELECT id, email, wachtwoord FROM gebruiker WHERE email =
  '$email' ";

  $result= mysqli_query($connection, $query);

  if ($result) {
      $row = mysqli_fetch_row($result);
      $gebruikerID = $row[0];
      $dbemail = $row[1];
      $dbwachtwoord = $row[2];
  }

  if ($email == $dbemail && $wachtwoord == $dbwachtwoord) {
    echo 'login succes';
  }
  else {
    echo 'login failed';
  }

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
<h1>login</h1>

<a href="register.php">Register</a>

	<form action="login.php" method="POST">
		<input type="text" placeholder="e-mail" name="email" />

		<input type"password" placeholder="wachtwoord" name="wachtwoord">

		<input type="submit" name="submit">

	</form>
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script> 
<script src="js/script.js"></script>
</body>
</html>