<?php
/**
 * @author Ruben Lacasa <rubendx@gmail.com>
 * @package Arale Framework
 * @subpackage classes
 * @version 0.1
 *
 */
class Sql extends Arale
{
	/* Variables a modificar por el usuario */
    /**
     * Nombre de la base de datos
     * @var string
     */
    private $_dbname = "";/*DBNAME*/
    /**
     * Nombre del Host
     * @var string
     */
	private $_host ="127.0.0.1";/*HOST IP*/
	/**
	 * Puerto del servidor
	 * @var string
	 */
	private $_port = "3306";/*HOST PORT*/
	/**
	 * Usuario de la base de datos
	 * @var string
	 */
	private $_usuario = "";/*DB USER*/
	/**
	 * Contraseña de la base de datos
	 * @var string
	 */
	private $_password = "";/*DB PASSWORD*/
	/* Fin Variables a modificar por el usuario */
	
    function __construct ($class)
    {
    	$dsn = 
        "mysql:dbname={$this->_dbname};host={$this->_host};port={$this->_port}";
        try{
            $this->_conexion = 
            new PDO( $dsn, $this->_usuario, $this->_password,
            array( PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'' ) );
        } catch ( PDOException $e ) {
            echo 'Connection failed: '. $e->getMessage();
        }
        $this->_class = $class;
        $this->_table = strtolower( $class );
        $this->_fields = $this->nombresCampos();
    }
}