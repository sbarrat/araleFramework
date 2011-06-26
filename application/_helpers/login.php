<?php
require_once '../config.inc.php';
session_start();
if(isset($_SESSION['usuario'])){
    include_once 'menu.php';
} elseif(isset($_POST['username']) && $_POST['username']!=""){
    $user = new Users();
    if($user->login($_POST)){
        include_once 'menu.php';
    }
    else 
      echo false;
} 


