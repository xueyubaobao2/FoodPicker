<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php

session_start();
header("Cache-control: private");
require 'database/connect.php';

$name = $_REQUEST['name'];
$sql="SELECT name,phone,snippet_text,profile_image_url,post_image_url,address,rating_image FROM webtech_db.yelpdata where name ='$name'";
$result = mysqli_query($conn,$sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $row = mysqli_fetch_assoc($result);
    
   
} else {
    echo "0 results";
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="import" href="bootstrap/bootstrap.html">
<link rel="stylesheet" href="css/teststyle.css" />
<title><?php echo $row["name"];?></title>
</head>

<body>
<?php 

$numbers = range (1,20); 
shuffle ($numbers); 
$image = array_slice($numbers,0,2); 
if (isset($_SESSION["ValidUser"]))
	include 'content/loginnavi.php';
else
	include 'content/navigation.html';?>
<?php include 'content/login.html';?>
<?php include 'content/signup.html';?>
<div class="container-fluid search-container">
  <form name=searchForm method=post action=googlemap.php>
    <input type="text" id="searchtext" name="searchkey"/>
    <button class="btn-primary" id="search-btn" type="submit">Search</button>
  </form>
</div>
<div class="container">
  <h2><?php echo $row["name"];?></h2>
  <img alt="rating" src="<?php echo $row["rating_image"];?>" />
  <h4>Phone: <?php echo $row["phone"];?></h4>
  <h4><?php echo $row["address"];?></h4>
</div>
<div class="container">
  <div id="carousel-example-generic" class="carousel slide" data-ride="carousel"> 
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
      <li data-target="#carousel-example-generic" data-slide-to="1"></li>
      <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    </ol>
    
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active"> <img class="img-responsive img-thumbnail imagecrop" src=" <?php echo $row["post_image_url"];?>" alt="aaa"> </div>
      <div class="item"> <img class="img-responsive img-rounded imagecrop" src="img/<?php echo $image[0];?>.jpg" alt="ccc"> </div>
      <div class="item"> <img class="img-responsive img-rounded imagecrop" src="img/<?php echo $image[1];?>.jpg" alt="ccc"> </div>
      <div class="carousel-caption"> </div>
    </div>
  </div>
</div>
<div class="container panel panel-default">
  <div class="panel-body">
  
    <div class="row">
      <div class="col-xs-3">
        <div class="row">
          <div class="col-xs-12" style=" padding:18px;"><img alt="image" src="<?php echo $row["profile_image_url"];?>" class="img-circle"></div>
          <div class="col-xs-12" >Ian Anderson Gray</div>
          <div class="col-xs-12" >Ari 01 2016 </div>
        </div>
      </div>
      <div class="col-xs-9">
        <div class="panel panel-default" style="height:150px;">
          <div class="panel-body"> <?php echo $row["snippet_text"];?> </div>
        </div>
      </div>
    </div>
    <?php
		require "loadreview.php"; 
	?>
    <hr />
    <?php if(isset($_SESSION["ValidUser"]))
				require "review.php";
	?>
  </div>
</div>

</body>
</html>