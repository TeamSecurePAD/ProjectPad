<?php
/* four steps of adding the match
Step 1
Get all the serveses the you offer
Step 2
Get all the services the other user asked and you offer.
Step 3
Get all the services the other user provide's.
step 4
get all the service's you asks and the other user offers, and insert it in the database.

*/

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

  if ($result_vraagt_aanbod)
  {

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

        $query_insert_match = "INSERT INTO  match_dienst
                               VALUES ($id, $match_id , 0, 0)";

        $result_test = mysqli_query($connection, $query_insert_match);

      }
    }
  }
}//end if
}

/*Adding the matche's based on categorie*/

// puting the categorie you are good and bad at in a variable. 
$query_is_goed_in_categorie  = "SELECT Categorie_Categorie
                                FROM gebruiker_is_goed_in_categorie
                                WHERE Gebruiker_Id = $id";

$query_is_slecht_in_categorie  = "SELECT Categorie_Categorie
                                  FROM gebruiker_is_slecht_in_categorie
                                  WHERE Gebruiker_Id = $id";

$result_is_goed_in_categorie = mysqli_query($connection, $query_is_goed_in_categorie);
$result_is_slecht_in_categorie = mysqli_query($connection, $query_is_slecht_in_categorie);

$row_goed = mysqli_fetch_assoc($result_is_goed_in_categorie);
$row_slecht = mysqli_fetch_assoc($result_is_slecht_in_categorie);

$is_goed_in_categorie = $row_goed["Categorie_Categorie"];
$is_slecht_in_categorie = $row_slecht["Categorie_Categorie"];

// Geting the Id's of the users who are good at the categorie the current user is bad at.
$query_is_goed_in_slecht  = "SELECT Gebruiker_Id
                             FROM gebruiker_is_goed_in_categorie
                             WHERE Categorie_Categorie = '$is_slecht_in_categorie'
                             AND Gebruiker_Id != $id";

$result_is_goed_in_slecht = mysqli_query($connection, $query_is_goed_in_slecht);         

while ($row_goed_in_slecht = $result_is_goed_in_slecht->fetch_assoc()) 
{

  // saving the other users id
  $match_id = $row_goed_in_slecht["Gebruiker_Id"];

  //Geting users who are bad at the categorie that the curent user is good at.
  $query_is_slecht_in_goed = "SELECT Gebruiker_Id
                              FROM gebruiker_is_slecht_in_categorie
                              WHERE Categorie_Categorie = '$is_goed_in_categorie'
                              AND Gebruiker_Id = $match_id";

  $result_is_slecht_in_goed = mysqli_query($connection, $query_is_slecht_in_goed);

  while ($row_slecht_in_goed = $result_is_slecht_in_goed->fetch_assoc()) 
  {

      $query_insert_match = "INSERT INTO  match_categorie
                             VALUES ($id, $match_id, 0, 0, 0)";

      mysqli_query($connection, $query_insert_match);

    }
  }
?>