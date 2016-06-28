<?php 
    // Session starten 
    session_start (); 

    // Datenbankverbindung aufbauen 
	
	
	
	
  $connectionid = mysqli_connect ("localhost", "root", ""); 
   if (!mysqli_select_db ($connectionid, "test")) 
  { 
  die ("Keine Verbindung zur Datenbank"); 
} 

    $sql = "SELECT ". 
        "Id, Username, Nachname, Vorname ". 
      "FROM ". 
        "benutzerdaten ". 
      "WHERE ". 
        "(Username like '".$_REQUEST["name"]."') AND ". 
        "(Passwort = '".md5 ($_REQUEST["pwd"])."')"; 
    $result = mysqli_query ($connectionid, $sql); 

    if (mysqli_num_rows ($result) > 0) 
    { 
      // Benutzerdaten in ein Array auslesen. 
      $data = mysqli_fetch_array ($result); 

      // Sessionvariablen erstellen und registrieren 
      $_SESSION["user_id"] = $data["Id"]; 
      $_SESSION["user_username"] = $data["Username"]; 
      $_SESSION["user_nachname"] = $data["Nachname"]; 
      $_SESSION["user_vorname"] = $data["Vorname"]; 

      header ("Location: intern.php"); 
    } 
    else 
    { 
      header ("Location: formular.php?fehler=1"); 
    } 
    ?> 