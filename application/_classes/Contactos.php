<?php

/**
 * Esta clase controla las consultas que se generen en el ambito de alumnos y
 * devuelve su resultado
 * @author Ruben Lacasa <ruben@ensenalia.com>
 * @package arale
 * @subpackage classes
 *
 */

class Contactos extends Sql
{
    public $id;
    public $curso;
    public $nombre;
    public $apellidos; 
    public $email; 
    public $telefono;
    public $consulta;
    public $contacto;
    public $horario;
    public $politica;
    public $fechaHora;
    public $tratado;
    private $_table;
    
    /**
     * Llamada al constructor padre
     */
    public function __construct ()
    {
        parent::__construct();
        $this->_table = strtolower(__CLASS__);
    }
    
    /**
     * Agrega el alumno seleccionado
     * @param array $vars
     * @return boolean
     */
    public function add($vars){
        $sql =
        "INSERT INTO `{$this->_table}` 
        (`curso`, `nombre`, `apellidos`, `email`, `telefono`,
        `consulta`, `contacto`,`horario`,`politica`,
        `tratado`) 
        VALUES (
        :curso, :nombre, :apellidos, :email, :telefono, :consulta,
        :contacto, :horario, :politica, :tratado
        )";
        
        return parent::ejecuta($sql,$vars);
    }
    
    /**
     * Actualiza el alumno seleccionado
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
     * Borra el alumno seleccionado
     * @param integer|string $id
     * @return boolean
     */
    public function delete($id){
        $sql = "DELETE FROM `{$this->_table}` 
        WHERE `id` LIKE :id";
        return parent::ejecuta($sql, array(':id'=> $id));
    }
    
    /**
     * Lista todos los alumnos
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
     * Devuelve los datos del alumnos seleccionado
     * @param integer|string $id
     * @return object
     */
    public function datos($id){
        $sql = "SELECT * FROM `{$this->_table}` 
        WHERE `id` LIKE :id";
        if(parent::ejecuta($sql, array(':id'=> $id)))
            return parent::resultadoUnico(__CLASS__);
    }
    
    public function trataDatosNuevos(){
        $sql = "SELECT * FROM `{$this->_table}`
        WHERE `tratado` LIKE 0";
        parent::ejecuta($sql);
        foreach(parent::resultado(__CLASS__) as $row){
            $vars["id"] = $row->id;
            $vars["curso"] = trim($this->traduce($row->curso,"Curso: "));
            $vars["nombre"] = trim($this->traduce($row->nombre,"Nombre: "));
            $vars["apellidos"] = trim($this->traduce($row->apellidos,"Apellidos: "));
            $vars["email"] = trim($this->traduce($row->email,"Email: "));
            $vars["telefono"] = trim($this->traduce($row->telefono,"TelÃ©fono de contacto: "));
            $this->trataConsulta($this->traduce($row->consulta,"Consulta: "))."\n";
            $vars["consulta"] = $this->consulta;
            $vars["contacto"] = $this->contacto;
            $vars["horario"] = $this->horario;
            $vars["politica"] = "Si";
            $vars["fechaHora"] = $row->fechaHora;
            $vars["tratado"] = 1;
            $this->update($vars);
        }
    }
    public function traduce($dato,$inicio){
        return utf8_decode(substr(trim($dato),strlen($inicio)));
    }
    public function trataConsulta($consulta){
       
        $primer  = preg_split("/Consulta:/",$consulta);
        $primer[1] = preg_replace("/--Quieres que contactemos contigo\?--/", "", $primer[1]);
        $segun = preg_split("/Como quieres que contactemos\? /",$primer[1]);
        $tercer = preg_split("/Horario de contacto:/",$segun[1]);
        if(isset($segun[0]))
        $this->consulta = trim($segun[0]);
        if(isset($tercer[0]))
        $this->contacto = trim($tercer[0]);
        if(isset($tercer[1]))
        $this->horario = trim(substr($tercer[1],0,(strlen($tercer[1])-303)));
    }    
}