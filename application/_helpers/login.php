<?php
session_start();
if(isset($_SESSION['usuario'])){
    include_once 'menu.php';
} elseif(isset($_POST['user']) && $_POST['user']!=""){
    require_once '../_classes/Users.php';
    $user = new Users();
    if($user->login($_POST)){
        include_once 'menu.php';
    }
    else 
      echo false;
    $user->close();
} 


