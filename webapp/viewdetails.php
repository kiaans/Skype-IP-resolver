<!-- This file contains the code for the viewdetails.php page. It displays the detailed information for the Skype ID selected -->
<!DOCTYPE html>
<html lang="en">
<head>
<?php require_once("includes/connection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php
	if(isset($_GET['Id'])){
		$sel_Id=$_GET['Id'];
		get_profile_picture($sel_Id);
	} else { $sel_Id=0; }

	if(isset($_GET['homepage'])){
		redirect_to("index.php");
	}
?>
    <meta charset="utf-8">
    <title>Skype ID Mapping</title>
	<style type="text/css">
    </style>
	<link rel="stylesheet" href="style/css/bootstrap.css" type="text/css"/>	
	<link rel="stylesheet" href="style/css/bootstrap.min.css" type="text/css" >

    <meta charset="utf-8">
    <title>Skype ID Mapping</title>
	
</head>
<body onload="loadmap2()">
	<div class="container">
		<h1><a href="#">Skype ID to IP Mapping</a></h1>
		<hr><br>
		<form class="form-horizontal" role="form" action="index.php?Id=<?php echo $sel_Id ?>" method="post"> 
			<div class="form-group">
				<button type="submit" class="btn btn-default" name="homepage" style="border: 1px solid #000000;">Back to Home Page</button>&nbsp;&nbsp;&nbsp;
			</div>
		</form>
		<br>
		<div class="row" align="left">
			<div class="col-lg-10">
				<!--<h4><b>Skype ID:&nbsp;&nbsp;</b> -->
					<h3><img src="images/users/<?php echo $sel_Id ?>.jpg" width=80px  height=80px style="border: 2px solid #000000;">
					<span class="label label-primary" style="border: 1px solid #000000;"><?php echo $sel_Id ?></span></h3>
				<!--</h4> -->
			</div>
		</div>
		<br><br>
		<div class="row" align="center">
			<div class="col-lg-12">
				<table class="table table-bordered">
						<tr>
							<td style="border: 2px solid #000000;"><b>SNo.<b></td>
							<td style="border: 2px solid #000000;"><b>Public IPs Accessed<b></td>
							<td style="border: 2px solid #000000;"><b>Internal IPs Accessed<b></td>
							<td style="border: 2px solid #000000;"><b>City<b></td>
							<td style="border: 2px solid #000000;"><b>Country<b></td>
							<td style="border: 2px solid #000000;"><b>Time<b></td>
						</tr>
						<tr>
						<?php
							$result=get_ID_info_all($sel_Id);
							$i=1;
							while ($row=mysql_fetch_array($result)){
								echo "<tr>";
								echo "<td style=\"border: 2px solid #000000;\">{$i}</td>";
								echo "<td style=\"border: 2px solid #000000;\">{$row['IP_Public']}</td>";
								echo "<td style=\"border: 2px solid #000000;\">{$row['IP_Internal']}</td>";
								echo "<td style=\"border: 2px solid #000000;\">{$row['City']}</td>";
								echo "<td style=\"border: 2px solid #000000;\">{$row['Country']}</td>";
								echo "<td style=\"border: 2px solid #000000;\">{$row['TimeStamp']}</td>";
								echo "</tr>";
								++$i;
							}							
						?>
						</tr>
				</table>
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-lg-12">
				<div id="skype_map2" style="height: 200px; width: 1125px; border: 3px solid #B22222; border-radius: 2px;"></div>
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-lg-6">
				
					<?php
						$result=check_online_status($sel_Id);
						$row=mysql_fetch_array($result);
						if(($row['Status']==1)||($row['Status']==2)){
							echo "<div class=\"alert alert-success\" align=\"left\" style=\"border: 1px solid #000000;\">";
							echo "{$row['ID']} is <b>online</b> currently";
							echo "</div>";
						}
						else{
							echo "<div class=\"alert alert-danger\" align=\"left\" style=\"border: 1px solid #000000;\">";
							echo "{$row['ID']} is <b>offline</b> currently";
							echo "</div>";
						}
					?>
			</div>
		</div>		
		<br><br>
	</div>				
	
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script src="style/js/bootstrap.js"></script>
	<script src="style/js/bootstrap.min.js"></script>
	<script type="text/javascript">
    //<![CDATA[

    var customIcons = {
      1: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_green.png'
      },
	  2: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_green.png'
      },
      0: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
      }
    };

    function loadmap2() {
      var map = new google.maps.Map(document.getElementById("skype_map2"), {
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;
	  var bounds = new google.maps.LatLngBounds ();

      // Change this depending on the name of your PHP file
      downloadUrl("map2.php?Id=<?php echo $sel_Id; ?>", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var IPAddr = markers[i].getAttribute("IPAddr");
          var City = markers[i].getAttribute("City");
          var Country = markers[i].getAttribute("Country");
		  var status = markers[i].getAttribute("Status");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("Latitude")),
              parseFloat(markers[i].getAttribute("Longitude")));
		  bounds.extend (point);
		  //if (i==0)
			//map.setCenter(point);
          var html = "<b>" + IPAddr + "</b> <br/>" + City + ", " + Country ;
          var icon = customIcons[status] || {};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
	  map.fitBounds (bounds);
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}

  </script>
</body>
</html>