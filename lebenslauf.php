<?php
//include ("checkuser.php");
header("Content-Type: text/html; charset=utf-8");
//header("Content-Type: text/html; charset=iso-8859-1");

//GLOBAL $meldung;
//$titel=$_REQUEST['titel'];
//$text=$_REQUEST['text'];
//$bild=$_REQUEST['bild'];

//$action=$_REQUEST['action'];

//$nr=$_REQUEST['nr'];
//$PHP_SELF=$_SERVER['PHP_SELF'];

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
$database = "projekt_wde"; 
$table = "lebenslauf"; 

// Einstellungen Ende 

$conn_id = mysqli_connect($host,$id,$pw); 
mysqli_select_db($conn_id, $database); 
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Eliane - Lebenslauf</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="css/tooplate_style.css" rel="stylesheet" type="text/css" />

</head>
<body>

<div id="tooplate_wrapper">

	<div id="tooplate_header">
        <div id="site_title"><h1><a href="#">Eliane - Lebenslauf</a></h1></div>
        <div id="tooplate_menu">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="ueber_mich.html">Über mich</a></li>
                <li><a href="lebenslauf.html" class="current">Lebenslauf</a></li>
                <li><a href="galerie.html">Galerie</a></li>
                <li><a href="kontakt.html">Kontakt</a></li>
            </ul>    	
        </div> <!-- end of tooplate_menu -->
    </div> <!-- end of forever header -->
    
    <div id="tooplate_middle_sub">
    	<h2>Lebenslauf</h2>
        <p> Hier seht ihr was ich bisher in meinem Leben alles gemacht habe. Es gibt einen kleinen Überblick über meine bisherigen Tätigkeiten mit jeweils einem Foto dazu. </p>
    </div> 
	<div id="tooplate_content"><span class="content_top"></span><!-- end of middle -->
   
<?php
// Gibt alle Datensätze aus der Datenbank aus. 
//echo "<ol>";
  $result = mysqli_query($conn_id, "select * from $table"); 
  if ($num = mysqli_num_rows($result)) { 
    // Ausgabe der Datensätze, wenn vorhanden 
    for($i=0;$i < $num; $i++) { 
      $nr = mysqli_result($result,$i,"nr");
      $titel = mysqli_result($result,$i,"titel"); 	
      $text = mysqli_result($result,$i,"text"); 
      $bild = mysqli_result($result,$i,"bild");	  
	  $von = strtotime(mysqli_result($result,$i,"von")); 
      $bis = strtotime(mysqli_result($result,$i,"bis"));
//	  echo "<li> $nr $titel"; 

	  //echo "<li> $titel"; 


?>
 

    		<div class="post_box">
            	<!--<div class="comment"><br> 16.06.2014 <br> -  <br> 30.07.2014</div>-->
				<div class="comment"><br> 
				<!--01.08.2013--> 
				<?php echo date("d.m.Y", $von) ?>	
				<br> -  <br> 
				<!--13.06.2014-->
				<?php echo date("d.m.Y", $bis) ?>		
				</div>
            	<!--<h2>Aupair - Italien</h2> -->
				<?php echo "<h2> $titel</h2>"; ?>
                <div class="image_wrapper image_fl"><span></span>
				<!--calabria.png-->
				<?php echo '<img src="images/lebenslauf/'.$bild.'" alt="Image 02" />'; ?>
				</div>
                <!--<p>Ich habe 6 Wochen bei einer Italienischen Familie in Kalabrien verbracht. Wir verbrachten die grösste Zeit am Strand. Das Wetter war ein wenig durchzogen aber es war schön warm. </p>-->
                <?php echo "<p> $text</p>"; ?>
				<div class="cleaner"></div>
			</div>

   <?php
    } 
  } 
  //else echo "<li>Es gibt keine Datensätze in der Datenbank<p>"; 
  //echo "</ol>"; 
  //echo "$meldung";

?>     
        <div class="cleaner"></div>
    </div> <!-- end of content -->
    
    <div id="tooplate_footer">
    	Copyright © 2014 - Eliane Bogo
        <div class="cleaner"></div>
	</div>

</div> <!-- end of wrapper -->

</body>
</html>
