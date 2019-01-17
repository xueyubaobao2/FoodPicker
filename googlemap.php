<!DOCTYPE html>
<?php
session_cache_limiter('private'); 
session_start();

if (isset($_SESSION["ValidUser"]))
	include 'content/loginnavi.php';
else
	include 'content/navigation.html';
require 'database/connect.php';
if(isset($_REQUEST['searchkey']))
	$key = $_REQUEST['searchkey'];
else $key="";
$sql="SELECT name,litidute,longitude,category,rating_image FROM yelpdata where category like '%$key%' or name like '%$key%' limit 15";
$result = mysqli_query($conn,$sql);
if (!$result)
         echo "Error: ". $conn->error;
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $row = mysqli_fetch_assoc($result);
   
} else {
    $row["litidute"]=39.99;
	$row["longitude"] = -75.23;
}


?>
<html>
<head>
<title>Simple Map</title>
<meta name="viewport" content="initial-scale=1.0">
<meta charset="utf-8">
<link rel="import" href="bootstrap/bootstrap.html">
<link rel="stylesheet" href="css/teststyle.css" />
<link rel="stylesheet" href="css/googlemapstyle.css" />
<script>
      var map;
    function initMap() {
       var myLatLng = {lat: <?php echo $row["litidute"];?>, lng: <?php echo $row["longitude"];?>};

  		var map = new google.maps.Map(document.getElementById('map'), {
    	zoom: 12,
    	center: myLatLng
  	});
	
	<?php
	$result = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($result)) {
	$name = $row['name'];
	echo "drawAMarker(";
	echo $row['litidute'];
	echo ",";
	echo $row['longitude'];
	echo ',"';
	print addslashes($name);
	echo '",map,"'.$row['rating_image'].'");';
	
	
	}
	mysqli_close($conn);
	?>

  		
}
function drawAMarker(latidute,longtidute,name,map,rating){
	var myLatlng = new google.maps.LatLng(latidute,longtidute);
	
		var contentString = 
	  '<form name=searchForm method=get action=restaurant.php id="'+name+'">'+
	  '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<h4>'+name+'</h4>'+
      '<div id="bodyContent">'+
	  '<img src="'+rating+'"/>'+
	  '<input type="hidden" name="name" value="'+name+'"/>'+
      '<p><a href="#" name="submit" onclick="document.getElementById('+
	  '\''+name+'\''+
	  ').submit();">'+
      'View Detail</a> '+
      '</div>'+
      '</div>'+
	  '</form>';

  	var infowindow = new google.maps.InfoWindow({
    content: contentString
  });

	var marker = new google.maps.Marker({
    position: myLatlng,
    title:name
});
		marker.setMap(map);
		marker.addListener('click', function() {
    infowindow.open(map, marker);
  });
}

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmijqwd-Ul7xLTQV9GSTUH7Pnt0Nd3P_A&callback=initMap"
    async defer></script>

</head>
<body>
<?php 

?>
<?php include 'content/login.html';?>
<?php include 'content/signup.html';?>
<div class="container-fluid search-container">
    <form name=searchForm method=get action=googlemap.php>
      <input type="text" id="searchtext" name="searchkey"/>
      <button class="btn-primary" id="search-btn" type="submit">Search</button>
    </form>
</div>
<div style="margin-top:30px;" id="map"></div>




  
</body>
</html>