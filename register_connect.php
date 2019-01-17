<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>try regester</title>
</head>

<body>
<?php 
	$email = $_POST['email'];
	$passwd = $_POST['passwd'];
	$nickname = $_POST['nickname'];
	//*** create a connection object
    require 'database/connect.php';

$target_dir = "profile_img/";
$rand = mt_rand(0,100) ;
 
$target_file = $target_dir .$nickname.$rand .".jpg";
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

	
    //*** execute the query
	$sql="insert into user_info values('$email','$passwd','$nickname','$target_file')";
    $result = mysqli_query($conn,$sql);


    //*** die if no result
    if (!$result)
         echo "Error: ". $conn->error;
	else{ 
	 //*** start a new session
         session_start();

         //*** set a session variable
         $_SESSION["ValidUser"] = $email;
		 $_SESSION["profile_pic"] = $target_file;
         //*** redirect when all is well; otherwise, loop here
        
       //*** redirect somewhere
       header("Location: index.php");
		//*** Free the resources associated with the result
   		mysqli_free_result($result);

 	   //*** close this connection
  		  mysqli_close($conn);
		 exit;
	}
?>
</body>
</html>