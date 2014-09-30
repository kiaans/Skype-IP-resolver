<!-- This file used to handle AJAX requests for updating the list of online users in the list box displayed -->
<?php require_once("includes/connection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php
	if(isset($_POST['Id'])){
		$sel_Id=$_POST['Id'];
	} else {
		$result=get_first_record();
		$sel_Id=$result['ID']; 
	}
	$result=getAllSkypeId();
	$output="";
	while($row=mysql_fetch_array($result)){
		if(($row['Status']==1)||($row['Status']==2))
			$status="online";
		else
			$status="offline";
		$output .= "<a href=\"index.php?Id=" . urlencode($row['ID'])."\" class=\"list-group-item";							
		if($row['ID']==$sel_Id){
			$output .= " active\"";
		}
		$output .= "\"><img src=\"images/{$status}_icon.png\">&nbsp;&nbsp;{$row['ID']}</a>";
	}
	print $output;
?>