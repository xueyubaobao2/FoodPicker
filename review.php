<?php

			if(!isset($_SESSION["profile_pic"])){
				
				$_SESSION["profile_pic"]="profile_img/default.jpg";
			} 
?>
  <form method="post" action="writereview.php">
    <div class="row">
      <div class="col-xs-3">
        <div class="row">
          <div class="col-xs-12" style=" padding:18px;"><img alt="image" src="<?php echo $_SESSION["profile_pic"];?>" class="img-circle"></div>
          <div class="col-xs-12" ><?php echo $_SESSION["ValidUser"];?></div>
          <div class="col-xs-12" ></div>
        </div>
      </div>
      <div class="col-xs-9">
        
            <input type="hidden" value="<?php echo $name;?>" name="rest_name"/>
          	<textarea name="comment" class="form-control" rows="5" placeholder="Write your comments here"></textarea> 
            <button type="submit" class="btn btn-primary" id="submit-btn">Submit</button>
          
         
       
      </div>
    </div>   
    </form>