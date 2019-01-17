<?php 

$conn = mysqli_connect('127.0.0.1', 'root', 'dtw900425','webtech_db');
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());}
$names=array();
?>
<?php
if(isset($_POST['name']))
{
$name=$_POST['name'];
$sql="SELECT * FROM yelpdata WHERE name LIKE '%$name%' OR category LIKE '%$name%' limit 5";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_array($result))
{
	$names[]=$row['name'].' | '. $row['category'];
}
}
?>
<?php
echo"<ul class='searchsugg' >";
foreach($names as $val) 
 {
	echo '<li onClick="fillSearch(\''.addslashes($val).'\');">'.$val.'</li>';
}
if(empty($names))
{
echo '';
}

echo"</ul>";
?>