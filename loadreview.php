<?php
$sql = "select * from review where rest_name ='$name'";
    $result = mysqli_query($conn,$sql);
$result = mysqli_query($conn,$sql);
if (!$result)
         echo "Error: ". $conn->error;
else{
	if (mysqli_num_rows($result) == 0){
    
		mysqli_free_result($result);
 	   //*** close this connection
  		mysqli_close($conn);
		
	}
	else{	 
		while($row = mysqli_fetch_assoc($result)) {
			
			if($row["profile_pic"]===''){
				echo "empty";
				$row["profile_pic"]="profile_img/default.jpg";
			}
			echo '<hr /><div class="row"><div class="col-xs-3"><div class="row">
          <div class="col-xs-12" style=" padding:18px;"><img alt="image" src="'.$row["profile_pic"].'" class="img-circle"></div>
          <div class="col-xs-12" >'.$row['username'].'</div>
          <div class="col-xs-12" >'.$row['time'].'</div>
        </div>
      </div>
      <div class="col-xs-9">
        <div class="panel panel-default" style="height:150px;">
          <div class="panel-body"> '.$row["comment"].' </div>
        </div>
      </div>
    </div>';
  	   }
	}
}
?>