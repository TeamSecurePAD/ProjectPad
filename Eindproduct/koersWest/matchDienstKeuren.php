<?php
session_start();

  // Make sure we're connected to the database
require 'databaseConnectionOpening.php';

  // If a user is logged in, load a list of all available services, sorted by user
if (isset($_SESSION['user_id']))
{
    // User's session id, used to reference currently logged in user in database queries
  $id = $_SESSION['user_id'];

    //Gets the matches that are not confirmed.
  $query_match_dient_gevonden = "SELECT match_gebruiker_Id, match_goedgekeurd, match_afgekeurd
                                 FROM  match_diensten
                                 WHERE gebruiker_Id = $id 
                                 AND match_goedgekeurd = 0
                                 AND match_afgekeurd = 0";

  $result_match_dienst_gevonden = mysqli_query($connection, $query_match_dient_gevonden);


          //gets all the service's you offer
  $query_bied_aan = "SELECT Dienst_dienst
                     FROM gebruiker_bied_dienst_aan
                     WHERE Gebruiker_Id = $id";

  $result_bied_aan = mysqli_query($connection, $query_bied_aan);

          //gets all the service's you offer
  $query_vraagt = "SELECT Dienst_dienst
                   FROM gebruiker_vraagt_dienst
                   WHERE Gebruiker_Id = $id";

  $result_vraagt = mysqli_query($connection, $query_vraagt);

  if (!empty($_POST['gekeurd']))
  {

    $match_id = $_POST['match_id'];

    if ($_POST['gekeurd'] == "goedgekeurd") 
    {
      if ($update = $connection->query("UPDATE match_diensten
                                        SET match_goedgekeurd = 1
                                        WHERE gebruiker_Id = $id
                                        AND match_gebruiker_Id = $match_id
                                        AND match_goedgekeurd = 0"))
      {
        $message = "de gebruiker is verwijderd uit de lijst";
      }
    }
    else if ($_POST['gekeurd'] == "afgekeurd")
    {
      if ($update = $connection->query("UPDATE match_diensten
                                        SET match_afgekeurd = 1
                                        WHERE gebruiker_Id = $id
                                        AND match_gebruiker_Id = $match_id
                                        AND match_afgekeurd = 0"))
      {
        $message = "de gebruiker is verwijderd uit de lijst";
      }
    }
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
  <title>Dienst aanbieden</title>
</head>

<body>
  <?php
  include("title.php");
  ?>

  <!-- Container that houses all the elements on the page -->
  <div class = "container">
    <!-- Body div that contains all elements of the page - lighter gray backdrop than page background for emphasis on interactible environment -->
    <div class = "body col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <!-- Title div that surrounds colored title band - white backdrop to further emphasize subsection -->
      <div class = "title">
        <!-- Green band to indicate content section with actual title elements -->
        <div class = "tile bright_blue">
          <h1>Dienst matches accepteren</h1>
          <img class = "image" src = "images/approve.png" width = "150" height = "150">
          <h2>In dit scherm staan alle matches gebaseerd op wat je aanbiedt en vraagt.
           Je kan kiezen of je wel of niet contactgegevens wilt uitwisselen.</h2>
         </div>
       </div>

       <!-- Subbody div indicates main area of user interaction and important content -->
       <div class = "subbody">

        <?php 
        
        $any_match = false;

        // output the matches.
        while ($row_match_dienst_gevonden = $result_match_dienst_gevonden->fetch_assoc()) 
        {
         $result_bied_aan -> data_seek(0);
         $result_vraagt -> data_seek(0);
         $any_match = true;
         $match_dienst_id = $row_match_dienst_gevonden['match_gebruiker_Id'];

         $verwijderd = false;
         $gebruikerBiedAan = "";
         $gebruikerVraagt = "";


         while ($row_bied_aan = $result_bied_aan->fetch_assoc()) 
         {
           $dienst = $row_bied_aan['Dienst_dienst'];

           $query_match_aanbod = "SELECT Dienst_dienst
                                  FROM gebruiker_vraagt_dienst
                                  WHERE Dienst_dienst = '$dienst'
                                                         And Gebruiker_Id = $match_dienst_id";

           $result_match_aanbod = mysqli_query($connection, $query_match_aanbod);
           $row_match_aanbod = mysqli_fetch_assoc($result_match_aanbod);

           if (!empty($row_match_aanbod['Dienst_dienst'])) 
           {
            $gebruikerBiedAan = ($row_match_aanbod['Dienst_dienst']);
          }

        }

        while ($row_vraagt = $result_vraagt->fetch_assoc()) 
        {
         $dienst = $row_vraagt['Dienst_dienst'];

         $query_match_vraag = "SELECT Dienst_dienst
                               FROM gebruiker_bied_dienst_aan
                               WHERE Dienst_dienst = '$dienst'
                               AND Gebruiker_Id = $match_dienst_id";

         $result_match_vraag = mysqli_query($connection, $query_match_vraag);
         $row_match_vraag = mysqli_fetch_assoc($result_match_vraag);

         if (!empty($row_match_vraag['Dienst_dienst'])) 
         {
          $gebruikerVraagt = ($row_match_vraag['Dienst_dienst']);
        }

      }

      if (empty($gebruikerVraagt) || empty($gebruikerBiedAan))
      {
        $query = "DELETE FROM match_diensten
                  WHERE gebruiker_Id = $id
                  AND match_gebruiker_Id = $match_dienst_id";

        mysqli_query($connection, $query);

        $query = "DELETE FROM match_diensten
                  WHERE gebruiker_Id = $match_dienst_id
                  AND match_gebruiker_Id = $id";

        mysqli_query($connection, $query);

        $verwijderd = true;

      }

      $query_match_dienst = "SELECT naam, tussenvoegsel, achternaam, omschrijving
                             FROM gebruiker
                             WHERE Id = $match_dienst_id";

      $result_match_dienst =  mysqli_query($connection, $query_match_dienst);

      $row_match_dienst = mysqli_fetch_assoc($result_match_dienst);

      $naam = $row_match_dienst['naam'];
      $tussenvoegsel = $row_match_dienst['tussenvoegsel'];
      $achternaam = $row_match_dienst['achternaam'];
      $omschrijving = $row_match_dienst['omschrijving'];

      $block_number = 1;  

      if (!empty($_POST['gekeurd']))
      {

        if  ($_POST['gekeurd'] == "goedgekeurd" && $_POST['match_id'] == $match_dienst_id ) 
        {  
          $block_number = 2;
        }

        if  ($_POST['gekeurd'] == "afgekeurd" && $_POST['match_id'] == $match_dienst_id ) 
        {             
          $block_number = 3;
        }

      }

      if ($block_number == 1 && !$verwijderd ){        
        ?>

        <!-- Start of block -->
        <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
          <div class = "block bright_blue medium">
            <!-- Block text -->
            <div class = "media-body">
              <h3 class = "media-heading"><b>Match</b></h3>
              <p><b>Naam:</b> <?php echo ($naam);?>  <?php echo ($tussenvoegsel);?> <?php echo ($achternaam); ?> </p>
              <p>Je bent gematcht op de diensten: <b><?php echo ($gebruikerBiedAan); ?> - <?php echo ($gebruikerVraagt)?></b></p>
              <img class = "image" src = "<?php echo "images/".$gebruikerVraagt.".png"; ?>" width = "86" height = "86">
            </div>

            <!-- Submit button -->
            <div class = "service_button">

              <form action = "matchDienstKeuren.php" method="POST">
                <button type="submit" class="btn btn-success" value= "goedgekeurd" name="gekeurd">Gegevens sturen</button>
                <button type="submit" class="btn btn-danger" value= "afgekeurd" name="gekeurd">Afwijzen</button>                    
                <input type="hidden" value= "<?php echo($id); ?>" name="id"/>
                <input type="hidden" value= "<?php echo($match_dienst_id); ?>" name="match_id"/>
              </form>

            </div>
          </div>
        </div>
        <!-- End of block -->
        <?php
      }
      else if ($block_number == 2) 
      {
        ?>
        <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
          <div class = "block bright_orange medium">

            <!-- Block text -->
            <div class = "media-body">
              <h3 class = "media-heading"><b>Match</b></h3>
              <p><b>Naam:</b> <?php echo ($naam);?>  <?php echo ($tussenvoegsel);?> <?php echo ($achternaam); ?> </p>
              <p>Je bent gematcht op de diensten: <?php echo ($gebruikerBiedAan); ?> - <?php echo ($gebruikerVraagt)?></p>
              <img class = "image" src = "<?php echo "images/".$gebruikerVraagt.".png"; ?>" width = "86" height = "86">


              <h3 class = "media-heading" style = "position: absolute; bottom: 15px; left: 20%; right: 20%;"><b>Je gegevens zijn naar <?php echo($naam)?> verstuurd. </b></h3>
            </div>

          </div>
        </div>         

        <?php
      }
      else if ($block_number == 3)
      {
        ?>
        <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
          <div class = "block bright_orange medium">

            <!-- Block text -->
            <div class = "media-body">
              <h3 class = "media-heading"><b>Match</b></h3>
              <p><b>Naam:</b> <?php echo ($naam);?>  <?php echo ($tussenvoegsel);?> <?php echo ($achternaam); ?> </p>
              <p>Je bent gematcht op de diensten: <?php echo ($gebruikerBiedAan); ?> - <?php echo ($gebruikerVraagt)?></p>
              <img class = "image" src = "<?php echo "images/".$gebruikerVraagt.".png"; ?>" width = "86" height = "86">

              <h3 class = "media-heading" style = "position: absolute; bottom: 15px; left: 20%; right: 20%;"><b><?php echo($naam)?> is uit de lijst verwijderd</b></h3>
            </div>

          </div>
        </div>

        <?php
      }
    }
    if (!$any_match) {
      ?>

      <!-- Start no match block-->
      <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
        <div class = "block bright_blue medium">

          <!-- Block text -->
          <div class = "media-body">
            <h3 class = "media-heading"><b>Geen match</b></h3>
            <img class = "image" src = "images/NoResult.png" width = "150" height = "150"><br><br>
            <p>Er is op dit moment niks voor u om te bevestigen. Kom nog eens terug op een later moment.</p>
          </div>


        </div>
      </div>
      <!-- End of block -->

      <?php
    }
    ?>

    <!-- Back button in list of services - returns the user to the match menu -->
    <div class = "block_divider col-xs-12 col-sm-6 col-md-4 col-lg-3">
      <div class = "block gray medium">

        <!-- Block text -->
        <div class = "media-body">
          <h3 class = "media-heading"><b>Terug naar dienst match menu</b></h3>
          <img class = "image" src = "images/backarrow.png" width = "150" height = "150"><br><br>
        </div>

        <!-- Submit button -->
        <div class = "service_button">
          <form action = "matchDienstIndex.php">
            <button type = "submit" class = "btn btn-secondary" style = "color: black;">Klik om terug te gaan</button>
          </form>
        </div>
      </div>
    </div>
    <!-- End of block -->
  </div>
</div>
</div>
<br>

<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script> 
<script src="js/script.js"></script>
</body>
</html>