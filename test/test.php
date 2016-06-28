<?php
//include ("checkuser.php");
// header("Content-Type: text/html; charset=utf-8");
header("Content-Type: text/html; charset=iso-8859-1");

GLOBAL $meldung;
$titel=$_REQUEST['titel'];
$inhalt=$_REQUEST['inhalt'];
$preis=$_REQUEST['preis'];

$action=$_REQUEST['action'];

$nr=$_REQUEST['nr'];
$PHP_SELF=$_SERVER['PHP_SELF'];

//error_reporting= E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED


function mysqli_result($res,$row=0,$col=0){ 
    $numrows = mysqli_num_rows($res); 
    if ($numrows && $row <= ($numrows-1) && $row >=0){
        mysqli_data_seek($res,$row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])){
            return $resrow[$col];
        }
    }
    return false;
}

/*create table artikel 
( 
nr INT NOT NULL AUTO_INCREMENT, 
titel character (255), 
inhalt text, 
PRIMARY KEY (nr) 
);
*/





// Systemeinstellungen 
$id = "root"; 
$pw = ""; 
$host = "localhost"; 
$database = "test"; 
$table = "artikel"; 

// Einstellungen Ende 

$conn_id = mysqli_connect($host,$id,$pw); 
mysqli_select_db($conn_id, $database); 

// Löscht einen Artikel aus der Datenbank 
if ($action == "loeschen") { 
  mysqli_query($conn_id, "delete from $table where nr = '$nr'"); 
  $meldung = "Der Artikel wurde gelöscht."; 

// Aktualisiert einen Datensatz 
} elseif($action == "save") { 
  mysqli_query($conn_id, "update $table set titel = '$titel', inhalt = '$inhalt', preis = '$preis' where nr = '$nr'"); 
  $meldung = "Der Artikel wurde upgedated."; 

// Fügt einen neuen Artikel hinzu 
} elseif ($action == "neu") { 
  mysqli_query($conn_id, "insert into $table (titel,inhalt,preis) VALUES ('$titel','$inhalt','$preis')"); 
  $meldung = "Der Artikel wurde hinzugefügt."; 

// Selektiert den ausgewählten Artikel zum Updaten 
} elseif ($action == "update") { 

  $result = mysqli_query($conn_id, "select * from $table where nr = '".$nr."'"); 
  $titel = mysqli_result($result,0,"titel"); 
  $inhalt = mysqli_result($result,0,"inhalt"); 
  $preis = mysqli_result($result,0,"preis"); 

?> 

  <table> 
    <form action=<?php echo $PHP_SELF; ?> method=post> 
    <input type=hidden name=action value="save"> 
    <input type=hidden name=nr VALUE="<?php echo $nr ?>"> 
  <tr> 
    <td>Titel</td> 
    <td><input type=text name="titel" value="<?php echo $titel ?>"></td> 
  </tr><tr> 
    <td>Text</td> 
    <td><textarea name="inhalt"><?php echo $inhalt ?></textarea></td> 
  </tr><tr> 
    <td>Preis</td> 
    <td><textarea name="preis"><?php echo $preis ?></textarea></td> 
  </tr><tr> 
    <td> </td> 
    <TD><input type=submit value="Artikel Updaten"></form></td> 
  </tr> 
  </table><p> 

<?php 

// Formular für ein neues Produkt 
} elseif($action == "formneu" ) { 

?> 
  <table> 
    <form action=<?php echo $PHP_SELF; ?> method=post> 
    <input type=hidden name=action value="neu"> 
  <tr> 
    <td>Titel</td> 
    <td><input type=text name="titel"></td> 
  </tr><tr> 
    <td>Text</td> 
    <td><textarea name="inhalt"></textarea></td> 
  </tr><tr> 
    <td>Preis</td> 
    <td><textarea name="preis"></textarea></td> 
  </tr><tr> 
    <td> </td> 
    <TD><input type=submit value="Neuen Artikel hinzufügen"></form></td> 
  </tr> 
  </table><p> 

<?php 
// Gibt alle Datensätze aus der Datenbank aus. 
} else { 
 
  echo "<ol><b>Alle Artikel in der Übersicht:</b> "; 

  $result = mysqli_query($conn_id, "select * from $table"); 
  if ($num = mysqli_num_rows($result)) { 
    // Ausgabe der Datensätze, wenn vorhanden 
    for($i=0;$i < $num; $i++) { 
      $nr = mysqli_result($result,$i,"nr"); 
      $titel = mysqli_result($result,$i,"titel"); 
      echo "<li> $titel - <A href=\"$PHP_SELF?nr=$nr&action=update\">Update</A>"; 
      echo "- <a href=\"$PHP_SELF?nr=$nr&action=loeschen\">Löschen</a></li>"; 
    } 
  } else echo "<li>Es gibt keine Datensätze in der Datenbank<p>"; 
  echo "</ol>"; 
}


  if (!$meldung) $meldung = "Optionen<P>"; 
  echo "$meldung";
 
echo "<p><a href=$PHP_SELF>Zur Startseite</a>"; 
echo " - <a href=$PHP_SELF?action=formneu>Neuen Artikel einfügen</a>"; 

?>
