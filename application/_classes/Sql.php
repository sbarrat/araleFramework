<?php
/**
 * Enter description here ...
 * @author ruben
 *
 */
class Sql
{
    private $_conexion = NULL;
    private $_query = NULL;
    
    public function __construct ()
    {
        $dbname = "arale"; //Our dbname
        $host = "localhost"; //Our host normally localhost
        $port = "3306"; //Our port normally 3306
        $username = "arale"; //Our user
        $password = "HDCe5wMGfncnyWcp";//Our password
        $dsn = "mysql:dbname={$dbname};host={$host};port={$port}";
        
        try{
            $this->_conexion = 
            new PDO($dsn, $username, $password,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        } catch (PDOException $e) {
            echo 'Connection failed: '. $e->getMessage();
        }
    }
    
    /**
     * Ejecuta la consulta y devuelve verdadero o Falso
     * @param string $sql
     * @param array|NULL $data
     * @return boolean
     */
    private function ejecuta($sql,$data = NULL){
       $this->_query = $this->_conexion->prepare($sql);
       return $this->_query->execute($data);
    }
    
    /**
     * Obtiene los resultados de la consulta
     * @param string $clase
     * @return object
     */
    private function resultado($clase){
        $result =  $this->_query->fetchAll(PDO::FETCH_CLASS, $clase);
        $this->_query->closeCursor();
        return $result;
    }
    
    /**
     * Obtiene un unico resultado
     * @param string $clase
     * @return object
     */
    private function resultadoUnico($clase){
        $this->_query->setFetchMode(PDO::FETCH_CLASS, $clase);
        $result = $this->_query->fetch();
        $this->_query->closeCursor();
        return $result;
    }
    
    /**
     * Devuelve los nombres de los campos de la tabla
     * @param string $tabla
     * @return object
     */
    protected function nombresCampos($tabla){
        $sql = "Describe `{$tabla}`";
        $result = $this->_conexion->query($sql);
        return $this->_conexion->query($sql);
    }
    protected function insert($tabla,$fields,$vars){
        
    }
    protected function update($tabla,$fields,$vars){
        
    }
    protected function delete($tabla,$vars){
        
    }
    protected function showAny($tabla,$fields,$vars){
        
    }
    protected function showAll($tabla){
        
    }
    protected function showOne($table,$fields,$var){
        $sql = "SELECT * FROM `{$table}` WHERE ";
        foreach($fields as $field){
        	$sql .= " `{$field}` LIKE :{$field} AND";
        	$data[":{$field}"] = $var[$field];
        }
        
        $sql = substr($sql, 0, (strlen($sql)-3));
        if($this->ejecuta($sql, $data)){
            return $this->resultadoUnico(ucfirst($table));
        }
    }
    
    /**
     * Cambia la fecha de formato normal-Sql y viceversa
     * @param string $fecha
     * @return string
     */
    public static function cambiaf($fecha){
        if(strlen($fecha)>3){
            $fechaNueva = explode("-",$fecha);
            return "{$fechaNueva[2]}-{$fechaNueva[1]}-{$fechaNueva[0]}";
        }
        else
            return "";
    }
}