<?php
/**
 * 
 * @author Ruben Lacasa <rubendx@gmail.com>
 * @package Arale Framework
 * @subpackage helpers
 * @version 0.1
 */

$SID = session_id();
if(empty($SID)) session_start();
if(isset($_SESSION['usuario'])):
require_once '../config.inc.php';

if(isset($_GET['controller'])):
    $controller = $_GET['controller'];
endif;
try {
    $datos = new $controller();
    $singular = $datos->singular();
    $plural = $datos->plural();
    $columnas = $datos->columnasListado();
} catch (Exception $e) {
    echo "Error {$e->getMessage()}";
    die();
}
echo $datos->shortTable($_GET);
endif;