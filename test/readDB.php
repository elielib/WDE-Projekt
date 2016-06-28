<?php
// Make a MySQL Connection
$query = "SELECT * FROM lebenslauf"; 
	 
$result = mysql_query($query) or die(mysql_error());


while($row = mysql_fetch_array($result)){
	echo $row['titel']. " - ". $row['text'];
	echo "<br />";
}
?>