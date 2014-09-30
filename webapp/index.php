<!-- This is the main php file which contains the code for the home page of the web-application
-->
<!DOCTYPE html>
<html lang="en">
<head>
<?php require_once("includes/connection.php") ?>
<?php require_once("includes/functions.php") ?>
<?php
	//Handler when the user selects a particular Skype ID from the list
	if(isset($_GET['Id'])){
		$sel_Id=$_GET['Id'];
	} else {
		$result=get_first_record();
		$sel_Id=$result['ID']; 
	}
	
	//Handler when the user submits a new Skype ID
	if(isset($_POST['submitId'])){
		$SkypeId= $_POST["SkypeId"];
		if($SkypeId==""){
			echo "<script src=\"style/js/bootbox.min.js\"></script>";
			echo "<script type=\"text/javascript\"> bootbox.alert(\"Please enter a valid Skype ID\", function(e){
			});
			</script>";
		}
		else{
			$query= "INSERT INTO ipmapping.ip_info ( ID, IP_Public, IP_Internal, TimeStamp) Values ('{$SkypeId}', \"\", \"\", \"\")";
			$result = add_ID($SkypeId);
		}
		
	}
	
	//Handler when the user deletes a Skype ID
	if(isset($_POST['removeId'])){
		$SkypeId= $sel_Id;
		$query= "DELETE FROM ipmapping.ip_info WHERE ID='{$SkypeId}'";
		$query2= "DELETE FROM ipmapping.ip_status WHERE ID='{$SkypeId}'";
		$result2 = deleteQuery($query, $query2, $SkypeId);
	}
	
	//Handler when the user views details of a particular Skype ID
	if(isset($_POST['viewDetails'])){
		redirect_to("viewdetails.php?Id={$sel_Id}");
	}
	
?>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8">
    <title>Skype ID Mapping</title>
	<style type="text/css">
    </style>
	<link rel="stylesheet" href="style/css/bootstrap.css" type="text/css"/>	
	<link rel="stylesheet" href="style/css/bootstrap.min.css" type="text/css" >
	<link rel="stylesheet" href="style/css/lookup.css" type="text/css" > 
	<script type="text/javascript"src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

<!-- JS function for the lookup toggle switch -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#myonoffswitch').click(function(){
			var myonoffswitch=$('#myonoffswitch').val();
			if ($("#myonoffswitch:checked").length == 0)
				var a=1;
			else
				var a=0;
			var id = $(this).attr('user');
			$.ajax({
				type: "POST",
				url: "update_lookup.php",
				data: {
						'value': a,
						'userid': id
					},
				success: function(html){
					$("#display").html(html).show();
				}
			});

		});
	});
</script>
<script type="text/javascript">
	$(document).ready( function(){
		$(".cb-enable").click(function(){
			var parent = $(this).parents('.switch');
			$('.cb-disable',parent).removeClass('selected');
			$(this).addClass('selected');
			$('.checkbox',parent).attr('checked', true);
		});
		$(".cb-disable").click(function(){
			var parent = $(this).parents('.switch');
			$('.cb-enable',parent).removeClass('selected');
			$(this).addClass('selected');
			$('.checkbox',parent).attr('checked', false);
		});
	});
</script>

	<meta charset="utf-8">
    <title>Skype ID Mapping</title>
		
</head>
<body onload="loadmap()"> <!-- loadmap() function loads the Google map on page load -->
	
	<div class="container" >
		<h2><a href="”#”">Skype ID to IP Mapping</a></h1>
		<hr><br><br>
		<div class="row">
			<!-- Display the Google maps -->
			<div class="col-lg-9">
				<div id="skype_map" style="height: 300px; width: 850px; border: 3px solid #B22222; border-radius: 2px;"></div>				
			</div>
			<!-- Display the on-line users list -->
			<div class="col-lg-3" align="left">
				<div class="list-group" id="listBox">
					<?php
						$result=getAllSkypeId();
						while($row=mysql_fetch_array($result)){
							if($row['Status']>=1)
								$status="online";
							else{
								$status="offline";
							}
							echo "<a href=\"index.php?Id=" . urlencode($row['ID'])."\" class=\"list-group-item";							
							if($row['ID']==$sel_Id){
								echo " active\"";
							}
							echo "\"><img src=\"images/{$status}_icon.png\">&nbsp;&nbsp;{$row['ID']}</a>";
						}
					?>
				</div>			
				<br><br>
			</div>
		</div>
		<br><br>
		<div class="row">
			<!-- Display the data of the selected Skype ID in a tabular form -->
			<div class="col-lg-12" id="usertable" user="<?php echo $sel_Id ?>">
				<table class="table table-bordered" style="border: 2px solid #000000;" >
					<tr style="border: 2px solid #000000;">
						<td style="border: 2px solid #000000;"><b>Profile Picture</b></td>
						<td style="border: 2px solid #000000;"><b>Skype ID</b></td>
						<td style="border: 2px solid #000000;"><b>Last Public IP Accessed</b></td>
						<td style="border: 2px solid #000000;"><b>Last Internal IP Accessed</b></td>
						<td style="border: 2px solid #000000;"><b>City</b></td>
						<td style="border: 2px solid #000000;"><b>Country</b></td>
						<td style="border: 2px solid #000000;"><b>Last Online At</b></td>
					</tr>
						<?php 
							if(!($sel_Id==Null)){
								$result= get_ID_info_once($sel_Id);
								get_profile_picture($sel_Id);
								echo "<tr>";
								echo "<td style=\"border: 2px solid #000000;\"><img src=\"images/users/{$sel_Id}.jpg\" width=70px  height=70px style=\"border: 2px solid #000000;\"></td>";
								echo "<td style=\"border: 2px solid #000000;\">{$result['ID']}</td>";
								echo "<td style=\"border: 2px solid #000000;\">{$result['IP_Public']}</td>";
								echo "<td style=\"border: 2px solid #000000;\">{$result['IP_Internal']}</td>";
								echo "<td style=\"border: 2px solid #000000;\">{$result['City']}</td>";
								echo "<td style=\"border: 2px solid #000000;\">{$result['Country']}</td>";
								echo "<td style=\"border: 2px solid #000000;\">{$result['TimeStamp']}</td>";
								echo "</tr>";
							}
						?>
				</table>
			</div>
		</div>
		<br>
		<div class="row">
			<!-- Form for displaying the buttons, toggle switch -->
			<form class="form-horizontal" role="form" action="index.php?Id=<?php echo $sel_Id ?>" method="post"> 
				<div class="col-lg-4 col-lg-offset-4">
					<div class="form-group">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="submit" class="btn btn-default" name="viewDetails" style="border: 1px solid #000000;">View Details</button>&nbsp;&nbsp;&nbsp;
						<button type="submit" class="btn btn-default" name="removeId" style="border: 1px solid #000000;" onclick="return confirm('Are you sure you want to delete this ID?');">Delete ID</button>
						<!-- Code for the lookup toggle switch- "lookup.css" used for the same-->
						<div class="col-lg-1">
							<div class="onoffswitch">
								<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" user="<?php echo $sel_Id ?>" id="myonoffswitch"
									<?php
										$query=mysql_query("select * from ip_status where ID='{$sel_Id}'");
										$result=mysql_fetch_array($query);
										echo $result['Lookup'];
										if($result['Lookup']==1)
											echo "checked";
										else
											echo "not checked";
									?>>
								<label class="onoffswitch-label" for="myonoffswitch">
									<div class="onoffswitch-inner"></div>
									<div class="onoffswitch-switch"></div>
								</label>
							</div>
							<div id="display"></div>
						</div>	
					</div>
				</div>
			</form>
		</div>
		<br><br>
		<div class="row">
			<!-- Form to enter a new Skype ID -->
			<form id="enterSkypeId" class="form-horizontal" role="form" action="index.php" method="post">
					<div class="form-group">
						<br>
						<label for="enterSkypeId" class="col-lg-5 control-label">Enter a new Skype ID</label>
						<div class="col-lg-3">
							<input type="text" id="SkypeId" name = "SkypeId" class="form-control"  placeholder="Skype ID"  style="border: 1px solid #000000;">
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-offset-4 col-lg-4">
							<button type="submit" value = "Submit" name="submitId" class="btn btn-default" style="border: 1px solid #000000;">Submit</button>
						</div>
					</div>
			</form>	
		<br><br>
			<!-- Display a pop-up notification whenever a user comes online. "toastr alerts" used for the same -->
			<div id="showOnline">
			</div>
		</div>		
		<br><br>
	</div>	 
	
	<!-- JS function to update the online Skype IDs continuously after 30 seconds -->
	<script type="text/javascript">
		(function listBox() {
		  $.ajax({
			type: "POST",
			url: 'getOnlineList.php', 
			data: {
						'Id': "<?php  print $sel_Id; ?>",
					},
			success: function(list) {
			  $("#listBox").html(list);
			},
			complete: function() {
			  setTimeout(listBox, 30000);	// Schedule the next request after 30 seconds when the current one's complete
			}
		  });
		})();		
	</script>
	
	<!-- JS function to update the table for the Skype ID selected continuously after 30 seconds -->
	<script type="text/javascript">		
		(function updatetable() {
		  $.ajax({
			type: "POST",
			url: 'updateTable.php', 
			data: {
						'Id': "<?php  print $sel_Id; ?>",
					},
			success: function(table) {
			  $("#usertable").html(table);
			},
			complete: function() {
			  setTimeout(updatetable, 30000);	// Schedule the next request after 30 seconds when the current one's complete
			}
		  });
		})();
	</script>
	
	<script type="text/javascript">
		setInterval("showOnline()", 30000) // Display pop-up notification for users who are on-line every 30 seconds
	
		function showOnline() {
			$.post("displayOnline.php", function(list) {
				$("#showOnline").html(list);
			});
		}
	</script>
	
	<script src="style/js/jquery-1.11.0.js"></script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script src="style/js/bootstrap.js"></script>
	<script src="style/js/bootstrap.min.js"></script>
	<script src="style/js/jquery.bootstrap-growl.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="style/js/bootbox.min.js"></script>
	<script src="style/js/bootbox.js"></script>
	<script>
		$("[name='onoffswitch']").bootstrapSwitch();
	</script>
	
	<script type="text/javascript">
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

    function loadmap() {
      var map = new google.maps.Map(document.getElementById("skype_map"), {
        mapTypeId: 'roadmap'
      });
	  
      var infoWindow = new google.maps.InfoWindow({maxWidth: 500, maxHeight: 500});
	  var bounds = new google.maps.LatLngBounds ();
      downloadUrl("map1.php", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
		  var ID = markers[i].getAttribute("ID");
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
		  var html = "<b>" + ID + "</b> <br/>" + City + ", " + Country ;
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
