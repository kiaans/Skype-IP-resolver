<!-- This file contains various user functions which are used in the web-application 
-->
<!DOCTYPE html>
<html lang="en">
<head>
	<style type="text/css">
    </style>
	<link rel="stylesheet" href="style/css/bootstrap.css" type="text/css"/>	
	<link rel="stylesheet" href="style/css/bootstrap.min.css" type="text/css" >	
</head>
<body>
<?php
	//Function to confirm that a query was successfully executed in the database
    function confirm_query($result_set){
        if(!$result_set){
            die("Database query failed: ". mysql_error());
        }
    }
         
	//Function to delete the selected Skype ID
	//2 queries to delete ID from ip_status and ip_info tables
	function deleteQuery($query, $query2, $username) {
		global $connection;
		$result= mysql_query($query, $connection);
		confirm_query($result);
		$result2= mysql_query($query2, $connection);
		confirm_query($result2);
		if (($result > 0)&&($result2 > 0)) {
			echo "<script src=\"style/js/bootbox.min.js\"></script>";
			echo "<script type=\"text/javascript\"> bootbox.alert(\"This Skype ID <b>{$username}</b> was successfully removed from the database\"); </script>";
		}
    }
	
	//Function to add new Skype ID to the database
    function add_ID($username){
		global $connection;
        if(is_ID_present($username)){
			echo "<script src=\"style/js/bootbox.min.js\"></script>";
			echo "<script type=\"text/javascript\"> bootbox.alert(\"This Skype ID <b>{$username}</b> already exists\"); </script>";
		}
		else{
			$date = date('Y-m-d H:i:s', time());
			$query= "INSERT INTO ipmapping.ip_status ( ID, Status, Lookup) Values ('{$username}', 0, 1)";
			$result=mysql_query($query, $connection);
			confirm_query($result);
			echo "<script src=\"style/js/bootbox.min.js\"></script>";
			echo "<script type=\"text/javascript\"> bootbox.alert(\"The Skype ID <b>{$username}</b> was successfully added to the database\"); </script>";
		}
	}
	
	//Function to get all the skype IDs present in the database
    function getAllSkypeId(){
        global $connection;
        $query="SELECT * FROM ip_status Order by Status DESC";
		$result= mysql_query($query, $connection);
		confirm_query($result);
        return $result;
    }
	
	//Function to get the latest info recorded in the database of the selected Skype ID
	function get_ID_info_once($username){
        global $connection;
        $query="SELECT * from ip_info join ip_location ON ip_info.IP_Public=ip_location.IP_Public where ID =" . "\"" . $username . "\" ORDER BY TimeStamp DESC LIMIT 1";
        $result=mysql_query($query, $connection);
        confirm_query($result);
        if ($row=mysql_fetch_array($result)){
            return $row;
        } else {
            return NULL;
        }
    }
	
	//Function to get all the information available of the selected Skype ID order by time
	function get_ID_info_all($username){
        global $connection;
        $query="SELECT * from ip_info join ip_location ON ip_info.IP_Public=ip_location.IP_Public where ID =" . "\"" . $username . "\" ORDER BY TimeStamp DESC";
        $result=mysql_query($query, $connection);
        confirm_query($result);
        return $result;
    }
	
	//Function to check if the ID is present in the database or not
	function is_ID_present($username){
		global $connection;
        $query="SELECT * from ip_status where ID ='{$username}'";
        $result=mysql_query($query, $connection);
        confirm_query($result);
        if (!($row=mysql_fetch_array($result))){
            return 0;
        } else {
            return 1;
        }
	}
	
	//Function to get the first record from the database. Used when the user first loads the page without selecting any particular Skype ID
	function get_first_record(){
		global $connection;
        //$query="SELECT * FROM ip_info LIMIT 1";
        $query= "SELECT * FROM ip_status Order by Status DESC, ID LIMIT 1";
		$result=mysql_query($query, $connection);
        confirm_query($result);
        if ($row=mysql_fetch_array($result)){
            return $row;
        } else {
            return NULL;
        }
	}
	
	//Function to get the list of online users.
	function get_online_users(){
		global $connection;
        $query="SELECT * FROM ip_status where STATUS>=1";
        $result=mysql_query($query, $connection);
        confirm_query($result);
		return $result;
	}
	
	//Function to check if a particular user is online or not
	function check_online_status($user){
		global $connection;
        $query="SELECT * FROM ip_status where ID='{$user}'";
        $result=mysql_query($query, $connection);
        confirm_query($result);
		return $result;
	}
	
	function redirect_to($location){
        if($location!=NULL){
            header("Location: {$location}");
            exit;
        }
    }
	
	//Function to update the Status field to '2' when the user has been given a notification when a particular Skype ID comes online
	function update_notification($username){
        global $connection;
        $query= "UPDATE ip_status SET Status=2 WHERE ID='{$username}'";
        $result=mysql_query($query, $connection);
        confirm_query($result);
    }
	
	//Function to get the profile picture of the users
	function get_profile_picture($username){
		if (!file_exists("images/users/{$username}.jpg")){
			$url = "http://91.190.218.17/users/{$username}/profile/avatar";
			$img = "images/users/{$username}.jpg";
			file_put_contents($img, file_get_contents($url));
		}
	}
   
   //Function to 
    function mysql_prep($value){
        $magic_quotes_active=get_magic_quotes_gpc();
        $new_enough_php=function_exists("mysql_real_escape_string");
        if($new_enough_php){
            if($magic_quotes_active){$value=stripslashes($value);}
            $value=mysql_real_escape_string($value);
        }else {
            if(!$magic_quotes_active){ $value=addslashes($value); }
        }
        return $value;
    }
	
		/*function update_online_status(){
        global $connection;
        $query="SELECT * FROM ip_info where TIMESTAMPDIFF(MINUTE, `TIMESTAMP`, NOW()) < 15";
        $result=mysql_query($query, $connection);
        confirm_query($result);
		$users="";
		while ($row=mysql_fetch_array($result)){
            $user=$row['ID'];
			$query2="UPDATE ip_info SET Status=1 WHERE ID='{$user}'";
			$result2=mysql_query($query2, $connection);
			confirm_query($result2);
        }
    }
	
	function update_offline_status(){
        global $connection;
        $query="SELECT * FROM ip_info where TIMESTAMPDIFF(MINUTE, `TIMESTAMP`, NOW()) > 15";
        $result=mysql_query($query, $connection);
        confirm_query($result);
		while ($row=mysql_fetch_array($result)){
            $user=$row['ID'];
			$query2="UPDATE ip_info SET Status=0 WHERE ID='{$user}'";
			$result2=mysql_query($query2, $connection);
			confirm_query($result2);
        }
    }*/
  
?>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="style/js/bootstrap.js"></script>
	<script src="style/js/bootstrap.min.js"></script>
</body>
</html>