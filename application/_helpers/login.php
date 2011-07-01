<?php
/**
 * @author Ruben Lacasa <rubendx@gmail.com>
 * @package Arale Framework
 * @subpackage helpers
 * @version 0.1
 */

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


