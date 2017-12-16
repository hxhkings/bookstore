<?php

  $stat = session_status();
  if($stat === PHP_SESSION_NONE){
    session_start();
  }

  require_once('sys/config/admin_config.php');
  require_once('sys/admin_check.php');
  require_once('sys/config/db_config.php');
  require_once('sys/connection.php');
  require_once('sys/user_check.php');
  require_once('assets/common/log.php');
  $username = NULL;
  $password = NULL;
  
  if(isset($_POST['username']) && 
    !empty($_POST['username']) && 
    isset($_POST['password']) && 
    !empty($_POST['password']))
  {
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
    
    
  }
  $admin_check = (new Admin($username, $password))->check();
  $user_check = (new User($username, $password))->check();
  if($admin_check){
    $admin = new Log('admin_id');
    $admin->login();
  }elseif($user_check){

    $user = new Log('user_id');
    $user->login();

  }

  header('Location: /bookstore/');
?>