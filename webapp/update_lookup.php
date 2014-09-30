<!-- Handle the AJAX requests whenever the user turns the toggle switch on/off for a particular Skype ID and update it in the mysql database-->
<?php require_once("includes/connection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php
	if(isset($_POST['value']))
	{	$value=$_POST['value'];
		$id=$_POST['userid'];
		if($value==1)
			mysql_query("update ip_status set Lookup=$value where ID='{$id}'");
		else
			mysql_query("update ip_status set Lookup=$value, Status=0 where ID='{$id}'");
	}
?>