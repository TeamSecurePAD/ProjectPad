<?php
  session_start();

  // Return to index page if already logged in
  if (isset($_SESSION['user_id']))
  {
    header('location:index.php');
  }

  require 'databaseConnectionOpening.php';

  if (!empty($_POST['email']) && !empty($_POST['wachtwoord']))
  {
    $message = '';

    $email = strip_tags($_POST['email']);
    $wachtwoord = strip_tags($_POST['wachtwoord']);

    $query = "SELECT id, email, wachtwoord
              FROM gebruiker
              WHERE email = '$email'";

    $result = mysqli_query($connection, $query);

    if ($result)
    {
        $row = mysqli_fetch_row($result);
        $gebruikerID = $row[0];
        $dbemail = $row[1];
        $dbwachtwoord = $row[2];
    }

    if ($email == $dbemail && $wachtwoord == $dbwachtwoord)
    {
      $_SESSION['user_id'] = $gebruikerID; 
      header('location:index.php');
    }
    else
    {
      $message .= '<b class="red">Uw wachtwoord en/of e-mail adres is incorrect ingevoerd.</b>';
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
        <title>Inloggen</title>
        <style>
            body {
                padding-bottom: 60px;
                font-size: 20px;
                margin-top: 110px;

            }
            #footer{
                color:white;
                text-align: center;
                padding: 0px;


            }
            #section{
                text-align: center;
                margin: auto;
                width: 90%;
                border: 5px solid #419641;
                padding: 10px;
                margin-top: 50px;
                margin-left: auto;


            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
      <?php 
      include("Navigation.php");
      ?>
      <div id="section">

          <form class="form-horizontal col-md-4 col-md-offset-4" action="login.php" method="POST">
              Voer uw e-mail en wachtwoord in:

              <input type="text" placeholder="Email" name="email" class="form-control">
              <input type="password" placeholder="Wachtwoord" name ="wachtwoord" class="form-control">
              <button type="submit" class="btn btn-success" type="submit" name="submit">Login</button>

          </form>

          <form>

              <div class="round-button"><div class="round-button-circle"><a href="register.php"> <img src ="http://image005.flaticon.com/1/svg/109/109705.svg"></a></div></div>

          </form>
      </div>

      <?php
        //This will output error message's << Waar we het over hebben gehad.
        if(!empty($message)):
          echo $message."<br><br>";
        endif;
      ?>

        <script src="js/jquery-2.1.4.min.js"></script>
        <script src="js/bootstrap.min.js"></script> 
        <script src="js/script.js"></script>
    </body>

</html>