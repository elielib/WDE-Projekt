<?php
include ("checkuser.php");
// header("Content-Type: text/html; charset=utf-8");
header("Content-Type: text/html; charset=ISO-8859-1");

GLOBAL $meldung;
$titel=$_REQUEST['titel'];
$text=$_REQUEST['text'];
$bild=$_REQUEST['bild'];
$von=$_REQUEST['von'];
$bis=$_REQUEST['bis'];

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
$database = "projekt_wde";
$table = "lebenslauf";

// Einstellungen Ende

$conn_id = mysqli_connect($host,$id,$pw);
mysqli_select_db($conn_id, $database);

// Löscht einen Artikel aus der Datenbank
if ($action == "loeschen") {
  mysqli_query($conn_id, "delete from $table where nr = '$nr'");
  $meldung = "Der Artikel $nr wurde gel&oumlscht.";

// Aktualisiert einen Datensatz
} elseif($action == "save") {
  mysqli_query($conn_id, "update $table set titel = '$titel', text = '$text', bild = '$bild', von = '$von', bis = '$bis' where nr = '$nr'");
  $meldung = "Der Artikel $titel wurde upgedated.";

// Fügt einen neuen Artikel hinzu
} elseif ($action == "neu") {
  mysqli_query($conn_id, "insert into $table (titel,text,bild,von,bis) VALUES ('$titel','$text','$bild','$von','$bis')");
  $meldung = "Der Artikel $titel wurde hinzugef&uumlgt.";

// Selektiert den ausgewählten Artikel zum Updaten
} elseif ($action == "update") {

  $result = mysqli_query($conn_id, "select * from $table where nr = '".$nr."'");
  $titel = mysqli_result($result,0,"titel");
  $text = mysqli_result($result,0,"text");
  $bild = mysqli_result($result,0,"bild");
  $von = mysqli_result($result,0,"von");
  $bis = mysqli_result($result,0,"bis");

?>
<body>
  <table>
    <form action=<?php echo $PHP_SELF; ?> method=post>
    <input type=hidden name=action value="save">
    <input type=hidden name=nr VALUE="<?php echo $nr ?>">
  <tr>
    <td>Titel</td>
    <td><input type=text name="titel" value="<?php echo $titel ?>"></td>
  </tr><tr>
    <td>Text</td>
    <td><input type=text name="text" value=<?php echo $text ?>></td>
  </tr><tr>
    <td>Bild</td>
    <td><textarea name="bild"><?php echo $bild ?></textarea></td>
  </tr><tr>
    <td>Von</td>
    <td><input type=date name="von" value=<?php echo $von ?>></td>
  </tr><tr>
    <td>Bis</td>
    <td><input type=date name="bis" value=<?php echo $bis ?>></td>
  </tr><tr>
    <td> </td>
    <TD><input type=submit value="Artikel Updaten"></form></td>
  </tr>
  </table><p>

<?php

// Formular f�r ein neues Produkt
} elseif($action == "formneu" ) {

?>
  <table>
    <form action=<?php echo $PHP_SELF; ?> method=post>
    <input type=hidden name=action value="save">
    <tr>
      <td>Titel</td>
      <td><input type=text name="titel"></td>
    </tr><tr>
      <td>Text</td>
      <td><textarea name="text"></textarea></td>
    </tr><tr>
      <td>Bild</td>
      <td><textarea name="bild"></textarea></td>
    </tr><tr>
      <td>Von</td>
      <td><textarea name="von"></textarea></td>
    </tr><tr>
      <td>Bis</td>
      <td><textarea name="bis"></textarea></td>
    </tr><tr>
      <td> </td>
      <td><input type=submit value="Neuen Artikel hinzufügen"></form></td>
    </tr>
  </table><p>
<?php
// Gibt alle Datensätze aus der Datenbank aus.
} else {

  echo "<ol><b>Alle Artikel in der &Uumlbersicht: </b> ";

  $result = mysqli_query($conn_id, "select * from $table order by bis desc");
  if ($num = mysqli_num_rows($result)) {
    // Ausgabe der Datensätze, wenn vorhanden
    for($i=0;$i < $num; $i++) {
      $nr = mysqli_result($result,$i,"nr");
      $titel = mysqli_result($result,$i,"titel");
      $text = mysqli_result($result,$i,"text");
      $bild = mysqli_result($result,$i,"bild");
  //    $von = mysqli_result($result,$i,"von");
  //    $bis = mysqli_result($result,$i,"bis");

      $von = strtotime(mysqli_result($result,$i,"von"));
      $bis = strtotime(mysqli_result($result,$i,"bis"));

//      echo "<li> $titel - $text <A href=\"$PHP_SELF?nr=$nr&action=update\">Update</A>";
//      echo "- <a href=\"$PHP_SELF?nr=$nr&action=loeschen\">Löschen</a></li>";
      echo
      "<table><tr>
      <td width=120>"
        .date("d.m.Y", $bis).
        "<br>"
        .date("d.m.Y", $von).
      "</td>
      <td width=160>$titel</td><td width=360> $text </td>
      <td >  <img width=300px height=150px src=../images/lebenslauf/$bild /></td>
      <td width=100><A href=\"$PHP_SELF?nr=$nr&action=update\">Update</A></td>
      <td width=100><a href=\"$PHP_SELF?nr=$nr&action=loeschen\">L&oumlschen</a></td>
      </tr></table>";
    }
  } else echo "<li>Es gibt keine Datensätze in der Datenbank<p>";
  echo "</ol>";
}


  if (!$meldung) $meldung = "Optionen<P>";
  echo "$meldung";

echo "<p><a href=$PHP_SELF>Zur Startseite</a>";
echo " - <a href=$PHP_SELF?action=formneu>Neuen Artikel einf&uumlgen</a>";

?>
</body>
