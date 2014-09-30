<!-- This file used to handle AJAX requests for displaying a pop-up notification for list of users who are online -->
<?php require_once("includes/connection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php
	echo "<link href=\"style/css/toastr.css\" rel=\"stylesheet\"/>";
	echo "<script src=\"style/js/jquery-1.11.0.js\"></script>";
	echo "<script src=\"style/js/toastr.js\"></script>";
	$result=get_online_users();
	$output="";
	while ($row=mysql_fetch_array($result)){
		$user=$row['ID'];
		if($row['Status']==1){
			$output .= "<script type=\"text/javascript\">
			toastr.options = {
				\"closeButton\": true,
				\"debug\": false,
				\"positionClass\": \"toast-bottom-left\",
				\"onclick\": null,
				\"showDuration\": \"10000\",
				\"hideDuration\": \"5000\",
				\"timeOut\": \"10000\",
				\"extendedTimeOut\": \"5000\",
				\"showEasing\": \"swing\",
				\"hideEasing\": \"linear\",
				\"showMethod\": \"fadeIn\",
				\"hideMethod\": \"fadeOut\"
			};
			toastr.info('The user {$user} is online');
			var audio = new Audio('notification.wav');
			audio.play();
			</script>";
			update_notification($user);
		}
	}
	print $output;
?>