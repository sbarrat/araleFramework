<?php
/**
 * 
 * Controla las acciones de la aplicacion 
 * NO TOCAR
 * @author Ruben Lacasa <ruben@ensenalia.com>
 * @package AraleFramework
 */
$SID = session_id();
if(empty($SID)) session_start();
if(!isset($_SESSION['usuario']))
    return false;

require_once '../config.inc.php';
if(class_exists($_GET['controller'],TRUE)):   
    $accion = new $_GET['controller'];
    $controller = $_GET['controller']; 
	if(!isset($_POST['id']) && !isset($_POST['opcion'])):
        echo $accion->insert($_POST,$action->notInsert());
    endif;
 	if(isset($_POST['id']) && !isset($_POST['opcion'])):
        echo $accion->update($_POST);
    endif;
	if(isset($_POST['id']) && isset($_POST['opcion'])):
        if($_POST['opcion']=='show')
        	include_once"Form.php";	
        if($_POST['opcion']=='edit')
            include_once "Form.php";
        if($_POST['opcion']=='delete')
            echo $accion->delete($_POST['id']);
    endif;
endif;