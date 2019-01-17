<?php
       //*** kill current session
       session_start();
       session_destroy();
	   
	    echo "<script language=\"javascript\">location.href = 'javascript:history.back()'</script>";
?>