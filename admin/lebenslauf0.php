<?php
//include ("checkuser.php");
header("Content-Type: text/html; charset=ISO-8859-1");
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

$seiten_titel="Lebenslauf";
$einleitung="Hier seht ihr was ich bisher in meinem Leben alles gemacht habe. Es gibt einen kleinen Überblick über meine bisherigen Tätigkeiten mit jeweils einem Foto dazu.";
$copyright="Copyright © 2016 - Eliane Bogo";

// Einstellungen Ende

$conn_id = mysqli_connect($host,$id,$pw);
mysqli_select_db($conn_id, $database);
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <title>Eliane - Lebenslauf</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="../css/tooplate_style.css" rel="stylesheet" type="text/css" />

  </head>
  <body>

    <div id="tooplate_wrapper">

	     <div id="tooplate_header">
          <div id="site_title"><h1><a href="#">Eliane - Lebenslauf</a></h1>
          </div>
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
        <h2>
          <?php echo htmlentities($seiten_titel); ?>
        </h2>
        <p>
          <?php echo htmlentities($einleitung); ?>
        </p>
      </div>
	     <div id="tooplate_content"><span class="content_top"></span><!-- end of middle -->
          <?php
          // Gibt alle Datensätze aus der Datenbank aus.
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
          ?>
    		<div class="post_box">
				<div class="comment"><br>
				<?php echo date("d.m.Y", $von) ?>
				<br> -  <br>
				<?php echo date("d.m.Y", $bis) ?>
				</div>


        <h2>
				<?php
        //echo htmlentities(
        echo $titel
        //, ENT_COMPAT, 'ISO-8859-1'); ?>
        </h2>


        <div class="image_wrapper image_fl"><span></span>
				<?php echo '<img src="../images/lebenslauf/'.$bild.'" /> '; ?>
				</div>

        <p>
                <?php
                echo htmlentities($text, null, 'ISO-8859-1');
                //echo $text
                 ?>
        </p>
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
          <?php echo htmlentities($copyright);?>
        <div class="cleaner"></div>
      </div>
</div> <!-- end of wrapper -->

</body>
</html>
