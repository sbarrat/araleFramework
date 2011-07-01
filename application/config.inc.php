<?php
 /**
 * PHP Version 5.3
 * 
 * Pagina de configuracion de la aplicacion
 * 
 * Este es el fichero que carga en el include_path las rutas mas usadas
 * Y autocarga las clases
 * @author Ruben Lacasa <rubendx@gmail.com>
 * @package Arale Framework
 * @subpackage application
 * @version 0.1
 * 
 */
date_default_timezone_set( 'Europe/Madrid' ); /* SET YOUR TIMEZONE */
/**
 * Arale Framework Version
 * @var string
 */
$version = "0.1";
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__);
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/_forms');
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/_classes');
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/_views');
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/_helpers');
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/_lists');
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__.'/_controllers');

/**
 * Funcion de carga automatica de Clases
 * @param string $class_name
 */
function __autoload( $class_name ) {
    include $class_name . '.php';
}

/**
 * Application Title - You can rename it as you like
 * @var string
 */
$titulo = "Arale Framework";

/**
 * Array of options menu applications add controller name and label
 * @var array
 */
$menu = array(
array( 'controller'=>'Option', 'label'=>'Option Label' )
);