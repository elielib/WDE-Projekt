<?php
//include ("checkuser.php");
// header("Content-Type: text/html; charset=utf-8");
header("Content-Type: text/html; charset=iso-8859-1");

GLOBAL $meldung;
$titel=$_REQUEST['titel'];
$inhalt=$_REQUEST['text'];

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

// Systemeinstellungen 
$id = "root"; 
$pw = ""; 
$host = "localhost"; 
$database = "test"; 
$table = "artikel"; 

// Einstellungen Ende 

$conn_id = mysqli_connect($host,$id,$pw); 
mysqli_select_db($conn_id, $database); 
 

// Gibt alle Datensätze aus der Datenbank aus. 
echo "<ol>";
  $result = mysqli_query($conn_id, "select * from $table"); 
  if ($num = mysqli_num_rows($result)) { 
    // Ausgabe der Datensätze, wenn vorhanden 
    for($i=0;$i < $num; $i++) { 
      $nr = mysqli_result($result,$i,"nr");
      $titel = mysqli_result($result,$i,"titel"); 	  
	  echo "<li> $nr $titel"; 

	  //echo "<li> $titel"; 
    } 
  } else echo "<li>Es gibt keine Datensätze in der Datenbank<p>"; 
  echo "</ol>"; 
  echo "$meldung";

?>