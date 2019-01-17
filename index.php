<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="import" href="bootstrap/bootstrap.html">
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/suggestionStyle.css"/>
<script type="text/javascript" src="js/suggestion.js"></script>
<title>Index Page</title>
</head>

<body>
<?php 
session_start();
if(isset($_SESSION["InvalidUser"])){
	require "content/warning.php";
	session_destroy();
}
if (isset($_SESSION["ValidUser"]))
	include 'content/loginnavi.php';
else
	include 'content/navigation.html';?>
<?php include 'content/login.html';?>
<?php include 'content/signup.html';?>
<div class="jumbotron head_jumbotron">
  <div class="container headtitle">
    <h1 class="text-color-white">WELCOME HOME</h1>
    <h4 class="text-color-white">This is a simple hero unit, a simple jumbotron-style component.</h4>
  </div>
  <div class="container-fluid search-container">
    <form name=searchForm method=get action=googlemap.php id="SearchForm">
      <div id="wrapjsuggest">
        <input type="text" name="searchkey" autocomplete="off"  id="SearchBox" class="jsuggest" onKeyUp="suggestme(this.value,event)" />
        <button class="btn-primary" id="search-btn" type="submit">Search</button>
        <div id="suggestme">
          <div id="suggestmeList"></div>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="container" >
  <div class="row">
    <div class="col-sm-4" style=" "><img src="img/1.jpg" class="img-thumbnail"/></div>
    <div class="col-sm-4" style=""><img src="img/2.jpg" class="img-thumbnail"/></div>
    <div class="col-sm-4" style=" "><img src="img/3.jpg" class="img-thumbnail"/></div>
  </div>
</div>
</body>
</html>
