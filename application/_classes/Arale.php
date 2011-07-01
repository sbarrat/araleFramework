<?php
/** 
 * @author ruben
 * 
 * 
 */
class Arale
{
    protected $_conexion = NULL; /* set con */
    protected $_query = NULL; /* set query */
    protected $_table = NULL; /* set table name */
    protected $_class = NULL; /* set class name */
    protected $_fields = NULL;/* set fields array name */
    
    function __construct ()
    {}
	
	/**
    * Devuelve los nombres de los campos de la tabla
    * @param string $tabla
    * @return Ambigous <boolean, string> 
    */
    public function nombresCampos(){
        
    	$sql = "DESCRIBE `{$this->_table}`";
    	
    	if( $this->ejecuta( $sql ) )
    	    $result = $this->_query->fetchAll();
    	else
    	    $result = FALSE;

    	return $result;    
    }
    
    /**
     * Ejecuta la consulta y devuelve verdadero o Falso
     * @param string $sql
     * @param array|NULL $data
     * @return boolean
     */
    protected function ejecuta( $sql, $data = NULL ){
        
    	try{
       		$this->_conexion->beginTransaction();
       		$this->_query = $this->_conexion->prepare( $sql );
       		$result = $this->_query->execute( $data );
       		$this->_conexion->commit();
       		/* var_dump($this->_query->debugDumpParams()); */
       		
    	} catch( Exception $e ){
    		$this->_conexion->rollBack();
    		$result = FALSE;
    	}
    	
    	return $result;
    }
    
    /**
     * Obtiene los resultados de la consulta
     * 
     * @return object
     */
    protected function resultado(){
        
    	$result = $this->_query->fetchAll( PDO::FETCH_CLASS, $this->_class );
        $this->_query->closeCursor();
        
        return $result;
    }
    
    /**
     * Obtiene un unico resultado
     * 
     * @return object
     */
    protected function resultadoUnico(){
        
        $this->_query->setFetchMode( PDO::FETCH_CLASS, $this->_class );
        $result = $this->_query->fetch();
        $this->_query->closeCursor();
        
        return $result;
    }
	
    /**
     * Funcion general de insercion de datos en la tabla
     * @param array $vars
     * @param array $notVars
     * @return Ambigous <boolean, string> 
     */
    public function insert( $vars, $notVars ){
        
    	$sql =
    	"INSERT INTO `{$this->_table}` (";
    	foreach( $this->_fields as $field ):
    		if( !in_array( $field[ 'Field' ], $notVars ) )
    		   $sql.="`{$field[ 'Field' ]}`, ";
    	endforeach;
    	
    	$sql = substr( $sql, 0, strlen($sql)-2 );
    	reset( $this->_fields );
    	
    	$sql .=") VALUES (";
    	foreach( $this->_fields as $field ):
    		if( !in_array( $field[ 'Field' ], $notVars ) ):
    			$sql .=":{$field[ 'Field' ]}, ";
    			if( $field[ 'Type' ] == 'date' )
    			    $data[ $field[ 'Field' ] ] = 
    			    $this->cambiaf( $vars[ $field[ 'Field' ] ] );
    			else
    			    $data[ $field[ 'Field' ] ] = $vars[ $field[ 'Field' ] ];
    		endif;
    	endforeach;
    	$sql = substr( $sql, 0, strlen( $sql ) - 2 );
    	reset( $this->_fields );
    	$sql .=")";
    	
    	return $this->ejecuta( $sql, $data );
    }
    
    /**
     * General delete function to all databases 
     * @param integer $id
     * @return Ambigous <boolean, string> 
     */
    public function delete( $id ){
        
    	$sql = "DELETE FROM `{$this->_table}` 
        WHERE `id` LIKE :id";
    	
        return $this->ejecuta( $sql, array( ':id' => $id ) );
    }
    
    /**
     * General update function to all databases
     * @param array $vars
     * @param array $notVars
     * @return Ambigous <boolean, string> 
     */
    public function update( $vars, $notVars = array() ){
        
    	$sql = "UPDATE `{$this->_table}` SET ";
    	foreach( $this->_fields as $field ):
    		if( !in_array( $field[ 'Field' ], $notVars ) ):
    			$sql .= "`{$field[ 'Field' ]}` = :{$field[ 'Field' ]}, ";
    			if( $field[ 'Type' ] == 'date' )
    			    $data[ $field[ 'Field' ] ] = 
    			    $this->cambiaf( $vars[ $field[ 'Field' ] ] );
    			else
    			    $data[ $field[ 'Field' ] ] = $vars[ $field[ 'Field' ] ];
    		endif;
    	endforeach;
    	$sql = substr( $sql, 0, strlen( $sql ) - 2 );
    	$sql .= " WHERE `id` LIKE :id";
    	$data[ "id" ] = $vars[ "id" ];
    	
    	return $this->ejecuta( $sql, $data );
	}
    
    /**
    * Devuelve los datos del registro seleccionado
    * @param integer|string $id
    * @return Ambigous <boolean, string> 
    */
    public function showOne( $id ){
    	$sql = "SELECT * FROM `{$this->_table}`
    	        WHERE `id` LIKE :id";
    	if( $this->ejecuta( $sql, array( ':id' => $id ) ) )
    	    $result = $this->resultadoUnico();
    	else
    	    $result = FALSE;

    	return $result;    
    }
    
    /**
     * General function to show any records filtered by field an limit by rows
     * @param string $field
     * @param string $filter
     * @param integer $rows
     * @return object
     */
    public function showAny( $field = FALSE, $filter = FALSE, $rows = FALSE ){
    	
    	$sql = "SELECT * FROM `$this->_table`";
    	if( $filter && $field ):
    		$sql .= " WHERE `{$field}` LIKE :{$field} ";
    		$data[ ":{$field}" ] = "%{$filter}%";
    	endif;
    	if( $rows ):
    		$sql .= " LIMIT {$rows} ";
    	endif;
    	if( isset( $data ) ):
   			$this->ejecuta( $sql, $data );
    	else:
    		$this->ejecuta( $sql );
    	endif;
    		
    	return $this->resultado();
    }
    
    /**
     * Devuelve todos los datos de la tabla como un objeto de su clase o 
     * FALSE si no se ha podido ejecutar la consulta
     * @return object|boolean
     */
    public function showAll(){
    	
    	$sql = "Select * FROM `{$this->_table}`";
    	if( $this->ejecuta( $sql ) )
    		return $this->resultado();
    	else
    		return FALSE;
    }
    
    /**
     * UTF8 encode string
     * @param string $string
     * @return string
     */
    public function encode( $string ){
        
        return utf8_encode( $string );
    }
    
    /**
     * UTF8 decode string
     * @param string $string
     * @return string
     */
    public function decode( $string ){
        
        return utf8_decode( $string );
    }
    
    /**
     * MySQL escape string
     * @param string $string
     * @return string
     */
    public function escapa($string){
        
        return mysql_escape_string( $string );
    }
    
	/**
     * Return associative array of results
     * @return array
     */
    protected function resultadoColumn(){
        
        return $this->_query->fetchAll( PDO::FETCH_ASSOC );
    }
    
    /**
     * Return one result
     * @return string
     */
    protected function resultadoUnicoColumn(){
        
        return $this->_query->fetch( PDO::FETCH_COLUMN );
    }
    
  	/**
     * Cambia la fecha de formato normal-Sql y viceversa
     * @param string $fecha
     * @return string
     */
    static public function cambiaf( $fecha ){
        
        if( strlen( $fecha ) > 3 ):
            $fechaNueva = explode( "-", $fecha );
            $result = "{$fechaNueva[2]}-{$fechaNueva[1]}-{$fechaNueva[0]}";
        else:
            $result = "";
        endif;
        
        return $result;    
    }
    
    /**
     * Formatea el stamp y lo devuelve en formato legible Fecha Hora
     * @param string $fecha
     * @return string
     */
    static public function formatoStamp( $fecha ){
        
        if( $fecha != null )
    	    $result = date( "d-m-Y H:i:s", strtotime( $fecha ) );
    	else
    	    $result = date( "d-m-Y H:i:s" );
    	    
    	return $result;    
    }
    
	/**
	 * @todo Acortar funcion si es posible
     * Generacion del Formulario 
     * @param array $vars Datos posteados
     * @param object $datos Objeto con los datos
     * @param string $singular nombre en singular
     * @param string $plural nombre en plural
     */
    public function generateForm( $vars, $datos, $singular, $plural ){
        
        $campos = $datos->camposFormulario();
        $tabindex = 0;
        
        /* Establecemos el titulo del formulario */
        $titulo = "Alta {$singular}"; 
	    if( isset( $vars['id'] ) ):
    	    $datos = $this->showOne( $_POST[ 'id' ] );
    	    if( $vars[ 'opcion' ] == 'show' )
    		    $titulo = "Datos del {$singular}"; 
    	    else
    		    $titulo = "Modificar {$singular}";
	    endif;
	    
	    /* Generamos el Formulario*/
        $form = "
		<form class='form' id='{$plural}' name='{$plural}' method='post' action=''>
		<div class='tituloSeccion'>
			<h2>{$titulo}</h2>
		</div>
		<div id='result'></div>
		<div id='rsvErrors'></div>
		<div class='formFields'>";
        if( isset( $_POST[ 'id' ] ) ): /* Solo se pone cuando se postea el id */
	        $form .="
	    	<input type='hidden' id='id' name='id' value='{$datos->id}' />";
        endif;
        
        foreach( $campos as $campo ):
	    $form .= "
		<label for='{$campo[ 'field' ]}'>";
	    if( array_key_exists( 'required',  $campo ) ) 
	        $form .= "*";
        
	    $form .= $campo[ 'label' ];
	    $form .= "</label>";
	    $form .= "<div class='campo'>";
	    if( isset( $_POST[ 'opcion' ] ) && ( $_POST[ 'opcion' ] == 'show' ) && 
        ( $campo['type'] != 'hidden' ) )
	        $campo['type'] = 'label';
	    
	    switch( $campo[ 'type' ] ):
		case( 'label' ):
			if( array_key_exists( 'function' , $campo ) )
				$form .= 
				$datos->$campo[ 'function' ]( $datos->$campo[ 'field' ] );
			else
				$form .= $datos->$campo[ 'field' ];
		break;
		
		case( 'text' ):
			$tabindex += 10;
			$form .= "<input type='text' id='{$campo[ 'field' ]}' 
			name='{$campo[ 'field' ]}' ";
			if( array_key_exists( 'size', $campo ) )
			    $form .= " size='{$campo[ 'size' ]}' ";
			if( array_key_exists( 'required', $campo ) )
			    $form .= " required ";
			if( array_key_exists( 'function', $campo ) )
				$form .= 
				" value='{$datos->$campo[ 'function' ]( $datos->$campo[ 'field' ] )}' ";
			else
				$form .= " value='{$datos->$campo[ 'field' ]}' ";
			if( array_key_exists( 'value', $campo ) )
				$form .= " value='{$campo[ 'value' ]}'";
			$form .= " tabindex='{$tabindex}' />";
		break;
		
		case( 'textarea' ):
			$tabindex += 10;
			$form .= 
			"<textarea id='{$campo[ 'field' ]}' name='{$campo[ 'field' ]}' ";
			if( array_key_exists( 'cols', $campo ) )
			    $form .= " cols='{$campo[ 'cols' ]}' ";
			if( array_key_exists( 'rows', $campo ) )
			    $form .= " rows='{$campo[ 'rows' ]}' ";
			if( array_key_exists( 'required', $campo ) )
			    $form .= " required ";
			$form .= " tabindex='{$tabindex}' >";
			if( array_key_exists( 'function', $campo ) )
			    $form .= 
			    $datos->$campo[ 'function' ]( $datos->$campo[ 'field' ] );
			else
			$form .= $datos->$campo[ 'field' ];
			$form .= "</textarea>";
		break;
			
		case( 'hidden' ):
			$form .= "<input type='hidden' id='{$campo[ 'field' ]}'
						name='{$campo[ 'field' ]}' ";
			if( isset( $vars[ 'id' ] ) ):
			    if( array_key_exists( 'function', $campo ) )
				    $form .= 
				    " value='{$campo[ 'function' ]( $datos->$campo[ 'field' ] )}' ";
			    else
				    $form .= " value='{$datos->$campo[ 'field' ]}' ";
			else:	    
			    if( array_key_exists( 'value', $campo ) )
				    $form .= " value='{$campo[ 'value' ]}'";
			endif;	    
			$form .= " />";
		break;
		
		case( 'date' ):
		    $tabindex += 10;
			$form .= "<input type='text' id='{$campo[ 'field' ]}' class='date' 
			name='{$campo[ 'field' ]}' ";
			if( array_key_exists( 'size', $campo ) )
			    $form .= " size='{$campo[ 'size' ]}' ";
			if( array_key_exists( 'required', $campo ) )
			    $form .= " required ";
			if( array_key_exists( 'function', $campo ) )
				$form .= " 
				value='{$datos->$campo[ 'function' ]( $datos->$campo[ 'field' ] )}' ";
			else
				$form .= " value='{$datos->$campo[ 'field' ]}' ";
			if( array_key_exists( 'value', $campo ) )
				$form .= " value='{$campo[ 'value' ]}'";
			$form .= " tabindex='{$tabindex}' />";
		break;
		             
	    endswitch;
	    
	    $form .= "</div>";
        endforeach;
        
        $tabindex += 10;
	    $form .="<label>&nbsp;</label>";
        $form .="<div class='campo'>";
        
        /* Establecemos el texto del boton y que botones mostramos */
        if( isset( $_POST[ 'id' ] ) ):
            if( $_POST[ 'opcion' ] == "show" )
            $form .= "<input type='button' value='Editar {$singular}' 
        			tabindex='{$tabindex}' />";
            else
            $form .= "<input type='submit' value='Actualizar {$singular}' 
        			tabindex='{$tabindex}' />";
        else:
            $form .= "<input type='submit' value='Agregar {$singular}' 
        			tabindex='{$tabindex}' />";
            $tabindex += 10;
            $form .= "<input type='reset' value='Limpiar Formulario' 
        			tabindex='{$tabindex}' />";
        endif;            
    
        $form .="</div>
			</div> 
		</form>";
        
    echo $form;
    }
    
     /**
      * Devuelve los datos de la tabla, filtra y busca
      * @param array $vars
      * @return string
      */
     public function shortTable( $vars ){
        
        $sTable = $this->_table;
        $aColumns[] = ""; //campo en blanco para los iconos de acciones
        foreach( $this->columnasListado() as $columna )
	        $aColumns[] = $columna[ 'field' ];
	
		/* Indexed column (used for fast and accurate table cardinality) */
	        $sIndexColumn = "id";
        /* 
		 * Paging
	 	*/
	    $sLimit = "";
	    if ( isset( $vars[ 'iDisplayStart' ] ) && $vars[ 'iDisplayLength' ] != '-1' ):
	        $sLimit = "LIMIT {$this->escapa( $vars[ 'iDisplayStart' ] )},
	        {$this->escapa( $vars[ 'iDisplayLength' ] )}";
	    endif;
		/*
		 * Ordering
	 	 */
	    if ( isset( $vars[ 'iSortCol_0' ] ) ):
	        $sOrder = "ORDER BY  ";
		    for ( $i=0 ; $i<intval( $vars[ 'iSortingCols' ] ) ; $i++ ):
		        if ( $vars[ 'bSortable_'.intval( $vars[ 'iSortCol_'.$i ] ) ] == "true" ):
			        $sOrder .= "`{$aColumns[ intval( $vars[ 'iSortCol_'.$i ] ) ]}` 
			         {$this->escapa( $vars[ 'sSortDir_'.$i ] )}, ";
			    endif;
		    endfor;
		
		    $sOrder = substr_replace( $sOrder, "", -2 );
		    if ( $sOrder == "ORDER BY" ):
		        $sOrder = "";
		    endif;    
		else: 
		    $sOrder = "";
	    endif;
		/* 
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables, and MySQL's regex functionality is very limited
		 */
	    $sWhere = "";
	    if ( $vars[ 'sSearch' ] != "" ):
	        $sWhere = "WHERE (";
		    for ( $i=0 ; $i < count( $aColumns ) ; $i++ ):
		        if( $aColumns[ $i ] != "" )
		        $sWhere .= "`{$aColumns[ $i ]}` 
		        LIKE '%{$this->escapa( $vars[ 'sSearch' ] )}%' OR ";
		    endfor;
		    $sWhere = substr_replace( $sWhere, "", -3 );
		    $sWhere .= ')';
	    endif;
	
		/* Individual column filtering */
	    for ( $i=0 ; $i < count( $aColumns ) ; $i++ ):
	        if ( $vars[ 'bSearchable_'.$i ] == "true" && $vars[ 'sSearch_'.$i ] != '' ):
		        if ( $sWhere == "" ):
			        $sWhere = "WHERE ";
			    else:
			        $sWhere .= " AND ";
			    endif;
			    
			    if( $aColumns[ $i ] != "" ):
			        $sWhere .= "`{$aColumns[ $i ]}` LIKE 
			        '%{$this->escapa( $vars[ 'sSearch_'.$i ] )}%' ";
                endif;
                		    
		    endif;
		    
	    endfor;
	
		/*
		 * SQL queries
		 * Get data to display
		 */
	    $sQuery = "SELECT SQL_CALC_FOUND_ROWS `{$sIndexColumn}`,";
	    foreach( $aColumns as $column ):
	      if( $column != "" )
	          $sQuery .= " `{$column}`, ";
	    endforeach;
	    
	    $sQuery = substr( $sQuery, 0, strlen( $sQuery )-2 );      
		$sQuery .= " FROM   `{$sTable}`
		{$sWhere}
		{$sOrder}
		{$sLimit}";
		$this->ejecuta( $sQuery );
	    $rResult = $this->resultadoColumn();
		
		/* Data set length after filtering */
	    $sQuery = "
			SELECT FOUND_ROWS()
		";
	    $this->ejecuta( $sQuery );
	    $aResultFilterTotal = $this->resultadoUnicoColumn();
	    $iFilteredTotal = $aResultFilterTotal;
	
		/* Total data set length */
	    $sQuery = "
			SELECT COUNT(".$sIndexColumn.")
			FROM   $sTable
		";
	    $this->ejecuta( $sQuery );
	    $aResultTotal = $this->resultadoUnicoColumn();
	    $iTotal = $aResultTotal;
		
		/*
	 	 * Output
	 	 */
	    $output = array(
			"sEcho" => intval( $vars[ 'sEcho' ] ),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
	    );
	    
	    foreach( $rResult as $aRow ):
	        $row = array();
	        $row[] = "
	        <span class='show icono' id='show_{$aRow[ $sIndexColumn ]}'>
    		<img src='_images/eye.png' alt='Ver' /></span>
    		<span class='edit icono' id='edit_{$aRow[ $sIndexColumn ]}'>
    		<img src='_images/b_inline_edit.png' alt='Editar' /></span>
    		<span class='delete icono' id='delete_{$aRow[ $sIndexColumn ]}'>
    		<img src='_images/bd_empty.png' alt='Borrar' /></span>";
    	    
    	    foreach( $this->columnasListado() as $columna ):
    	        if( $columna[ 'field' ] != "" ):
    	            if( array_key_exists( 'function' , $columna ) )
    	                $row[]=
    	                $this->$columna[ 'function' ]( $aRow[ $columna[ 'field' ] ] );
		            else
		                $row[]=$aRow[ $columna[ 'field' ] ];
		        endif;
		                
    	    endforeach;
    	    
		        $output[ 'aaData' ][] = $row;
	    
	endforeach;
	
	return json_encode( $output );
    }
}
?>