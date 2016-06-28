<?php session_start (); ?> 
    <html> 
    <head> 
      <title>Login</title> 
    </head> 

    <body> 
    <?php 
    if (isset ($_REQUEST["fehler"])) 
    { 
      echo "Die Zugangsdaten waren ungültig."; 
    } 
    ?> 
    <form action="login.php" method="post"> 
      Username: <input type="text" name="name" size="20"><br> 
      Passwort: <input type="password" name="pwd" size="20"><br>

      <input type="submit" value="Login"> 
    </form> 
    </body> 
    </html> 
