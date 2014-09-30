<!-- This file allows connection to the mysql database and handle any connection errors
-->
<?php require("constants.php");

	$connection= mysql_connect(DB_SERVER, DB_USER, DB_PASS);
	if (!$connection){
		die("Database Connection falied: " . mysql_error());
	}
	
	$db_select=mysql_select_db(DB_NAME,$connection);
	if(!$db_select){
		die("Database selection failed: " . mysql_error());
	}
	
?>