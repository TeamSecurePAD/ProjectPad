<?php
  
  //gets all the service's you offer
  $query_bied_aan = "SELECT Dienst_dienst
                     FROM gebruiker_bied_dienst_aan
                     WHERE Gebruiker_Id = $id";

   $result_bied_aan = mysqli_query($connection, $query_bied_aan);

   // In here we gonna add all matches on al service's. 
   while ($row_bied_aan = $result_bied_aan->fetch_assoc()) {
      
      $dienst = $row_bied_aan['Dienst_dienst'];

      // Gets Id's of people who ask the service you offer.
      $query_vraagt_aanbod = "SELECT Gebruiker_Id
                              FROM gebruiker_vraagt_dienst
                              WHERE Dienst_dienst = '$dienst'
                              AND Gebruiker_Id != $id";

        $result_vraagt_aanbod = mysqli_query($connection, $query_vraagt_aanbod);

        if ($result_vraagt_aanbod){

        while ($row_vraagt_aanbod = $result_vraagt_aanbod->fetch_assoc()) 
        { 
          $match_id = $row_vraagt_aanbod['Gebruiker_Id'];

            //Select service's provide'd by other user. 
            $query_match_bied_aan = "SELECT Dienst_dienst
                                     FROM gebruiker_bied_dienst_aan
                                     WHERE Gebruiker_Id = $match_id";

            $result_match_bied_aan = mysqli_query($connection, $query_match_bied_aan);

            while ($row_match_bied_aan = $result_match_bied_aan->fetch_assoc())
            {
               $match_dienst = $row_match_bied_aan['Dienst_dienst'];

                $query_vraag = "SELECT Dienst_dienst
                                FROM gebruiker_vraagt_dienst
                                WHERE Dienst_dienst = '$match_dienst'
                                AND Gebruiker_Id = $id";

                $result_vraag = mysqli_query($connection, $query_vraag);

                while ($row_vraag = $result_vraag->fetch_assoc()) {

                $query_insert_match = "INSERT INTO  match_diensten
                                       VALUES ($id, $match_id , 0, 0, 0)";

                $result_test = mysqli_query($connection, $query_insert_match);

                  }
              }
            }
          }//end if
          else {
            echo "error";
          }
        }   
    ?>