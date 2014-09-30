<!-- Handle the AJAX requests to update the tabular data regularly of a particular Skype ID-->
<?php require_once("includes/connection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php
	if(isset($_POST['Id'])){
		$sel_Id=$_POST['Id'];
	} else {
		$result=get_first_record();
		$sel_Id=$result['ID']; 
	}
	$output="";
	$output .="<table class=\"table table-bordered\" style=\"border: 2px solid #000000;\" >
				<tr style=\"border: 2px solid #000000;\">
					<td style=\"border: 2px solid #000000;\"><b>Profile Picture</b></td>
					<td style=\"border: 2px solid #000000;\"><b>Skype ID</b></td>
					<td style=\"border: 2px solid #000000;\"><b>Last Public IP Accessed</b></td>
					<td style=\"border: 2px solid #000000;\"><b>Last Internal IP Accessed</b></td>
					<td style=\"border: 2px solid #000000;\"><b>City</b></td>
					<td style=\"border: 2px solid #000000;\"><b>Country</b></td>
					<td style=\"border: 2px solid #000000;\"><b>Last Online At</b></td>
					</tr>";
					
					if(!($sel_Id==Null)){
								$result= get_ID_info_once($sel_Id);
								get_profile_picture($sel_Id);
								$output .= "<tr>
								<td style=\"border: 2px solid #000000;\"><img src=\"images/users/{$sel_Id}.jpg\" width=70px  height=70px style=\"border: 2px solid #000000;\"></td>
								<td style=\"border: 2px solid #000000;\">{$result['ID']}</td>
								<td style=\"border: 2px solid #000000;\">{$result['IP_Public']}</td>
								<td style=\"border: 2px solid #000000;\">{$result['IP_Internal']}</td>
								<td style=\"border: 2px solid #000000;\">{$result['City']}</td>
								<td style=\"border: 2px solid #000000;\">{$result['Country']}</td>
								<td style=\"border: 2px solid #000000;\">{$result['TimeStamp']}</td>
								</tr>";
							}
				$output .= "</table>";
	print $output;
?>