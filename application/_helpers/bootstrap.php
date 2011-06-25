<?php
session_start();
require_once '../config.inc.php';
if(!isset($_SESSION['usuario'])){
  header("location:../public/index.php");  
}
if(isset($_POST['controller'])) {
    if($_POST['controller'] == 'Logout'){
        header("Location:logout.php");
    }
    else{
    include_once "{$_POST['controller']}View.php";
    }
} 
