<?php
/**
 * @author Ruben Lacasa <rubendx@gmail.com>
 * @package Arale Framework
 * @subpackage helpers
 * @version 0.1
 */
session_start();
require_once '../config.inc.php';
if(!isset($_SESSION['usuario'])):
  header("location:../index.php");  
endif;
if(isset($_POST['controller'])):
    if($_POST['controller'] == 'Logout'):
        header("Location:logout.php");
    else:
        $controller = $_POST['controller'];    
        include_once "View.php";
    endif;
endif;
