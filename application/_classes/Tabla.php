<?php

/**
 * Esta clase controla las consultas que se generen en el ambito de alumnos y
 * devuelve su resultado
 * @author Ruben Lacasa <rubendx@gmail.com>
 * @package Arale Framework
 * @version 0.1
 * @subpackage classes
 *
 */

class Tabla extends Sql
{
    /**
	 * Las variables publicas definidas aqui tienen que ser
	 * los campos de la base de datos de la tabla que se llama
	 * igual que la clase pero en minusculas.
	 * Se establecen como privadas el singular y el plural para que
	 * no interfieran en la devolucion de datos de la consulta
	 */
	/* Datos a rellenar por el usuario */
    public $id;/* IMPORTANTE que el id de tabla se llame id */
    public $var;
    /* TODO add fields of the db */
    /* Las siguientes variables deben definirse aunque esten vacias*/
    /* Estos dos son el singular y el plural de la visualizacion*/
    private $_singular = "Base"; /* Modificar el valor segun convenga */
    private $_plural = "Bases"; /* Modificar el valor segun convenga */
    private $notInsert = array('id'); /* Modificar segun convenga*/
   
    /* FUNCIONES GENERALES PARA NO MODIFICAR */
    /**
     * Llamada al constructor padre
     */
    public function __construct ()
    {
        parent::__construct(__CLASS__);
    }
    
    /**
     * Devuelve el singular de la accion
     * @return string
     */
    public function singular(){
        return $this->_singular;
    }
    /**
     * Devuelve el plural de la accion
     * @return string
     */
    public function plural(){
        return $this->_plural;
    }
    /**
     * Devuelve los campos que no queremos insertar en tabla
     * @return array
     */
    public function notInsert(){
        return $this->notInsert;
    }
    
    /**
     * Establecemos las columnas que aparecen en el listado
     * Estructura:
   	 * 'field' Es el nombre del campo en la tabla -Requerido-
     * 'label' Es como queremos mostrarlo' -Requerido-
     * 'function' Es la funcion que se lanza para tratar el dato - Opcional-
     * @return array
     */
    public function columnasListado(){
    	
    	/**
    	 * array('field'=>'nombre_campo',
    	 * 	'label'=>'Etiqueta campo',
    	 * 	['function'=>'funcion'])
    	 * @var array
    	 */
    	$columnas = array(
    	array('field'=>'','label'=>''),
    	);
    	return $columnas;
    }
    /**
     * Devuelve los campos con las opciones del formulario
     * @return array  
     */
    public function camposFormulario(){
    	/**
    	 * Estructura 
    	 * 'field' Es el nombre del campo en la tabla. -Requerido-
    	 * 'label' Es como queremos mostralo en el formulario. -Requerido-
    	 * 'type' Tipo de campo (text/label/textarea/select/date/hidden). -Requerido-
    	 * 'size' Tamaño del campo. -Opcional-
    	 * 'cols' Columnas Textarea. -Opcional- (Solo textarea)
    	 * 'rows' Filas Textarea Opcional. (Solo textarea)
    	 * 'function' Funcion que se lanza para tratar los datos o obtenerlos. -Opcional-
    	 * 'required' Establecemos el campo obligatorio. -Opcional-
    	 * 'value' Establecemos el valor por defecto del campo. -Opcional-
    	 * Importante: Para la validacion de email el campo debe llamarse email
    	 * @var $fields
    	 */
    	$fields = array(
    	array('field'=>'','label'=>'','type'=>''),
    	);
    	return $fields;
    }
    
    /**
     * Carga las funciones especificas de la list del modulo
     * @param array Se puede pasar un array con datos a tratar
     */
    public function especificosList(){
        
    }
     /**
     * Carga las funciones especificas de la list del modulo
     * @param array Se puede pasar un array con datos a tratar
     */
    public function especificosForm(){
        
    }
     /**
     * Carga las funciones especificas de la list del modulo
     * @param array Se puede pasar un array con datos a tratar
     */
    public function especificosView(){
        
    }
    /* FIN FUNCIONES GENERALES */
    
    /* FUNCIONES ESPECIFICAS DE ESTA CLASE NO GENERICAS */
   
}