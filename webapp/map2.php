<?php  
// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node); 

require_once("includes/connection.php");
// Select all the rows in the markers table

if(isset($_GET['Id']))
		$sel_Id=$_GET['Id'];
else
	$sel_Id='';

$query = "SELECT * from ip_info join ip_location ON ip_info.IP_Public=ip_location.IP_Public join ip_status ON ip_status.ID=ip_info.ID WHERE ip_status.ID='{$sel_Id}'";
$result = mysql_query($query);
if (!$result) {  
  die('Invalid query: ' . mysql_error());
} 

header("Content-type: text/xml"); 

// Iterate through the rows, adding XML nodes for each

while ($row = mysql_fetch_array($result)){  
  // ADD TO XML DOCUMENT NODE  
  $node = $dom->createElement("marker");  
  $newnode = $parnode->appendChild($node);   
  $newnode->setAttribute("IPAddr",$row['IP_Public']);
  $newnode->setAttribute("City", $row['City']);  
  $newnode->setAttribute("Country", $row['Country']);  
  $newnode->setAttribute("Latitude", $row['Latitude']);
  $newnode->setAttribute("Longitude", $row['Longitude']);
  $newnode->setAttribute("Status", $row['Status']);  
} 
ob_clean();
echo $dom->saveXML();


?>