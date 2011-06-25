<?php
$SID = session_id();
if(empty($SID)) session_start();
if(!isset($_SESSION['usuario']))
    return false;

require_once '../config.inc.php';
 
if(class_exists($_GET['action'],TRUE)){   
    $accion = new $_GET['action']; 

    if(!isset($_POST['id']) && !isset($_POST['opcion'])) {
        echo $accion->add($_POST);
    }
 
    if(isset($_POST['id']) && !isset($_POST['opcion'])) {
        echo $accion->update($_POST);
    }

    if(isset($_POST['id']) && isset($_POST['opcion'])){
        if($_POST['opcion']=='editar')
            include_once "{$_GET['action']}Form.php";
        if($_POST['opcion']=='borrar')
            echo $accion->delete($_POST['id']);
    }
}