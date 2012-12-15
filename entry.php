<?php
$con = mysql_connect("localhost","root","");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

mysql_select_db("my_db", $con);
$result = mysql_query("SELECT * FROM dealsandyou");
while ($row = mysql_fetch_array($result)) {
	print_r($row);;
	echo"<br><br>";
}

?>
<form action="entry.php" method="post">
	<input type="text" name="url">
</form>