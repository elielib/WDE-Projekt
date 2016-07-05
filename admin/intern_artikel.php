<?php
    include ("checkuser.php");
    ?>
    <html>
    <head>
      <title>Interne Seite</title>
    </head>
    <body>
      BenutzerId: <?php echo $_SESSION["user_id"]; ?><br>
      Username: <?php echo $_SESSION["user_username"]; ?><br>
      Nachname: <?php echo $_SESSION["user_nachname"]; ?><br>
      Vorname: <?php echo $_SESSION["user_vorname"]; ?>
      <hr>
      <a href="logout.php">Ausloggen</a>
	  <?php
include ("zeig-lebenslauf-inhalt.php");
?>
    </body>
    </html>
