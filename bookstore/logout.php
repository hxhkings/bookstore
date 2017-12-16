<?php

  
 	require_once('assets/common/log.php');
  	if(isset($_COOKIE['admin_id'])){
 	  $admin = new Log('admin_id');
 	  $admin->logout();
  	} elseif (isset($_COOKIE['user_id'])){
		$user = new Log('user_id');
   		$user->logout();
	}
  
 	header('Location: /bookstore/');
	

?>