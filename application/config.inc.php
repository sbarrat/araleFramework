<?php
 /**
 * PHP Version 5.3
 * 
 * Pagina de configuracion de la aplicacion
 * 
 * Este es el fichero que carga en el include_path las rutas mas usadas
 * Y autocarga las clases
 * @author Ruben Lacasa <ruben@ensenalia.com>
 * @version 0.1
 * @package arale
 * 
 */
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
function __autoload($class_name) {
    include $class_name . '.php';
}

