<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>login connect</title>
</head>

<body>
<?php 
	$email = $_POST['email'];
	$passwd = $_POST['passwd'];
	//*** create a connection object
    require 'database/connect.php';

   
    //*** execute the query
	$sql = "select * from user_info where email ='$email' and password = '$passwd'";
    $result = mysqli_query($conn,$sql);
	 //*** die if no result
    if (!$result)
         die("Query Failed.");

    if (mysqli_num_rows($result) == 0){
		session_start();
    	$_SESSION["InvalidUser"] ="yes"; 
		header("Location: index.php");
		mysqli_free_result($result);

 	   //*** close this connection
  		  mysqli_close($conn);
		exit;
	}
	else{	 
	 //*** start a new session
	 	
         session_start();
		 $row = mysqli_fetch_assoc($result);
         //*** set a session variable
         $_SESSION["ValidUser"] = $_POST['email'];
		 $_SESSION["profile_pic"] = $row["profile_pic"];
         //*** redirect when all is well; otherwise, loop here
         echo "<script language=\"javascript\">location.href = 'javascript:history.back()'</script>";
		//*** Free the resources associated with the result
   		mysqli_free_result($result);

 	   //*** close this connection
  		  mysqli_close($conn);
		 exit;}
	
		 
?>
</body>
</html>