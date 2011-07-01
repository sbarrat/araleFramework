<?php
/**
 * Fichero que genera el fichero excel descargable del listado generado
 * @author Ruben Lacasa <rubendx@gmail.com>
 * @package Arale Framework
 * @subpackage downloads
 * @version 0.1
 */
session_start();
if( isset( $_SESSION[ 'usuario' ] ) ):
    require_once '../../application/config.inc.php';
    if( isset( $_GET[ 'controller' ] ) ):
        $controller = $_GET[ 'controller' ];
    try {
        $datos = new $controller();
        $singular = $datos->singular();
        $plural = $datos->plural();
        $columnas = $datos->columnasListado();
        } catch ( Exception $e ) {
        echo "Error {$e->getMessage()}";
        die();
        }
header( "Content-type: application/vnd.ms-excel" );
header( "Content-Disposition: attachment; filename=\"Listado{$plural}.XLS\";" );
?>
<table id="tabla">
<thead>
<tr>
<?php 
foreach( $columnas as $columna )
	echo "<th>{$columna[ 'label' ]}</th>";
?>	
</tr>
</thead>
<tbody>
<?php
if( $datos->showAll() ):
	foreach( $datos->showAll() as $dato ):
    	echo "<tr>";
    	foreach( $columnas as $columna ):
    	    if( array_key_exists( 'function', $columna ) )
    	        echo 
    	        "<td>{$datos->$columna[ 'function' ]( $dato->$columna[ 'field' ] )}</td>";
    	    else
    	        echo 
    	        "<td>{$dato->$columna[ 'field' ]}</td>";
    	endforeach;    
    	echo "</tr>";
	endforeach;
endif;
?>
</tbody>
</table>
<?php 
endif; 
endif;