<?php

/**
 * Esta clase controla los usuarios de la aplicacion
 * @author Ruben Lacasa <ruben@ensenalia.com>
 * @package araleFramework
 * @subpackage classes
 *
 */

class Users extends Sql
{
    /**
     * 
     * Las variables publicas tienen que ser los campos de la tabla
     * en la base de datos
     * para luego poder acceder como objetos en el resto
     */
    public $id;
    public $username;
    public $password;
    public $nombre; 
    public $apellidos; 
    public $email;
    
    private $_table;
    private $_fields;
    /**
     * Llamada al constructor padre
     */
    public function __construct ()
    {
        parent::__construct();
        $this->password = sha1($password);
        $this->_table = strtolower(__CLASS__);
        $this->_fields = parent::nombresCampos($this->_table);
    }
    
    /**
     * Logea al usuario
     * @param array $vars
     * @return boolean
     */
    public function login($vars){
        $sql = "SELECT * from `{$this->_table}`
        WHERE `username` LIKE :username
        AND `password` LIKE sha1(:password)";
        parent::ejecuta($sql,$vars);
        $row = parent::resultadoUnico(__CLASS__);
        if($row->username == $vars['username'] && 
        $row->password == sha1($vars['password'])){
        session_start();
        $_SESSION['username'] = $row->username;
            return true;
        }
        else
            return false;
    }
    /**
     * Agrega el usuario seleccionado
     * @param array $vars
     * @return boolean
     */
   
    public function add($vars){
        $fields = get_object_vars($this);
        $sql =
        "INSERT INTO `{$this->_table}` (";
        foreach($fields as $key => $field){
            if($key!="id")
                $sql.= "`{$key}`, ";
        }
        $sql = substr($sql, 0, (strlen($sql)-2));
        $sql .= ") VALUES (";
        foreach($fields as $key => $field){
            if($key!="id")
            $sql.=":{$key}, ";
        }
        $sql = substr($sql, 0, (strlen($sql)-2));
        $sql.=")";
        
        return parent::ejecuta($sql,$vars);
    }
    
    /**
     * Actualiza el usuario seleccionado
     * @param array $vars
     * @return boolean
     */
    public function update($vars){
        $sql = "UPDATE `{$this->_table}` SET 
        `curso` = :curso, `nombre` = :nombre, `apellidos` = :apellidos, 
        `email` = :email, `telefono` = :telefono, `consulta` = :consulta, 
        `contacto` = :contacto, `horario` = :horario,
        `politica` = :politica, `fechaHora` = :fechaHora,
        `tratado` = :tratado
        WHERE `id` LIKE :id";
        
        return parent::ejecuta($sql, $vars);
    }
    
    /**
     * Borra el usuario seleccionado
     * @param integer|string $id
     * @return boolean
     */
    public function delete($id){
        $sql = "DELETE FROM `{$this->_table}` 
        WHERE `id` LIKE :id";
        return parent::ejecuta($sql, array(':id'=> $id));
    }
    
    /**
     * Lista todos los usuarios
     * @return object
     */
    public function listado($field = FALSE, $filter = FALSE, $rows = FALSE){
        $sql = "SELECT * FROM `$this->_table`";
        
        if($filter && $field){
            $sql .= " WHERE `{$field}` LIKE :{$field} ";
            $data[":{$field}"] = "%{$filter}%";
        }
        if($rows){
            $sql .= " LIMIT {$rows} ";
        }
        
        if(isset($data))
            parent::ejecuta($sql,$data);
        else
            parent::ejecuta($sql);
       
        return parent::resultado(__CLASS__);   
        
     }
    
    /**
     * Devuelve los datos del usuario seleccionado
     * @param integer|string $id
     * @return object
     */
    public function datos($id){
        return parent::showOne($this->_table, 'id', $id);
    }
}