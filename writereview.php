<?php
session_start();
$rest_name=$_POST['rest_name'];
$username =$_SESSION["ValidUser"];
$time = date('m-d-y h:i:s',time());
$comment = $_POST['comment'];
$profile_pic=$_SESSION["profile_pic"];
require "database/connect.php";
$sql = "insert into review values('$rest_name','$username','$time','$comment','$profile_pic')";
$result = mysqli_query($conn,$sql);
if (!$result)
         echo "Error: ". $conn->error;
else{
	echo '<script>alert("Thank you for your review");</script>';
	echo "<script language=\"javascript\">location.href = 'javascript:history.back()'</script>";
}
?>