<?php
  //In deze sql query worden mensen uit de database gehaald die hebben aangegeven
  //dat ze goed zijn in de categorie waar de huidige ingelogde slecht in is.
  $query_is_goed_in_slecht = "SELECT Gebruiker_Id
                              FROM gebruiker_is_goed_in_categorie
                              WHERE Categorie_Categorie = '$is_slecht_in_categorie' 
                              AND Gebruiker_Id != $id";

  // De resultaten van iedereen die goed is in een categorie waar jij slecht in bent worden
  // opgeslagen in een ??? (object? lijst? boolean. WTF is dat?)
  $result_is_goed_in_slecht = mysqli_query($connection, $query_is_goed_in_slecht);         

  //De gegevens worden in een assoc array gezet zodat ze later opgrvraagd kunnen worden door gebruik van de column naam. 
  while ($row_goed_in_slecht = $result_is_goed_in_slecht->fetch_assoc()) 
  {

    //De id van de gebruiker die goed is in de categorie waarin de ingelogde gebruiker slecht in is wordt opgeslagen in een varriable.
    //De reden hiervoor is dat het later makkelijk te gebruiken is. 
    $match_id_goed_in_slecht = $row_goed_in_slecht["Gebruiker_Id"];

    //In deze sql query worden mensen uit de database gehaald die hebben aangegeven
    //dat ze slecht zijn in de categorie waar de huidige ingelogde goed in is. 
    //ook moet deze het zelfde zijn als de id die eerder uit de db gehaald is. 
    $query_is_slecht_in_goed = "SELECT Gebruiker_Id
                                FROM gebruiker_is_slecht_in_categorie
                                WHERE Categorie_Categorie = '$is_goed_in_categorie'
                                AND Gebruiker_Id = $match_id_goed_in_slecht";

    $result_is_slecht_in_goed = mysqli_query($connection, $query_is_slecht_in_goed);

    while ($row_slecht_in_goed = $result_is_slecht_in_goed->fetch_assoc()) 
    {
      $match_id_slecht_in_goed = $row_slecht_in_goed["Gebruiker_Id"];

      $query_match_gebruiker = "SELECT id
                               FROM gebruiker
                               WHERE id = $match_id_slecht_in_goed";

      $result_match_gebruiker = mysqli_query($connection, $query_match_gebruiker);

      while ($match_gebruiker = $result_match_gebruiker->fetch_assoc()) 
      {
        $id_match = $match_gebruiker['id'];   

        $query_insert_match = "INSERT INTO  match_categorie
                                VALUES ($id, $id_match, 0, 0, 0)";

        mysqli_query($connection, $query_insert_match);

      }
    }
  }
?>