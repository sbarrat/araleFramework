<?php
/**
 * NO TOCAR GENERA AUTOMATICAMENTE EL FORMULARIO
 * SOlO IMPORTA EL NOMBRE DEL FICHERO <nombreAccion>List.php
 * Fichero que se encarga del listado de los datos de una tabla.
 * El manejo es simple copiamos el fichero y le ponemos el nombre
 * de la accion y list "AccionList.php"
 * Cambiamos los nombres de action, singular y plural por el nombre
 * de la accion el nombre que queramos mostrar en singular y el nombre
 * mostrar en plural
 * @author Ruben Lacasa <rubendx@gmail.com>
 * @package Arale Framework
 * @subpackage lists
 * @version 0.1
 */
$SID = session_id();
if( empty( $SID ) ) session_start();

if( isset( $_SESSION[ 'usuario' ] ) ):
    require_once '../config.inc.php';
    if( isset( $_GET[ 'controller' ] ) ):
        $controller = $_GET[ 'controller' ];
    endif;
    try {
        $datos = new $controller();
        $datos->especificosList();
        $urlAction = 
        "../application/_helpers/action.php?controller={$controller}";
        $urlDelete = 
        "../application/_lists/List.php?controller={$controller}&borrado=";
        $urlData = 
        "../application/_helpers/data.php?controller={$controller}";
        $singular = $datos->singular();
        $plural = $datos->plural();
        $columnas = $datos->columnasListado();
    } catch ( Exception $e ) {
        echo "Error {$e->getMessage()}";
        die();
    }

    $msg = "";/*Delete feedback*/
    if( isset( $_GET[ 'borrado' ] ) ):
        if( $_GET[ 'borrado' ] == 1 )
            $msg = "<div class='okay'>{$singular} borrado</div>";
        else
            $msg = "<div class='error'>No se ha borrado el {$singular}</div>";        
    endif;
?>
<div class='tituloSeccion'>
	<h2>Listado <?php echo $plural; ?></h2>
</div>
<div class='descargas'>
	<a href="downloads/XLS.php?controller=<?php echo $controller; ?>" 
	target='_blank'>
	<img src='_images/Page_excel.png' alt='Descargar listado en excel'/>
	Descargar listado en excel
	</a>
</div>
<div id="result"><?php echo $msg; ?></div>
<table id="tabla" class="display">
	<thead>
	<tr>
		<th></th>
<?php 
        foreach( $columnas as $columna ) 
            echo "<th>{$columna[ 'label' ]}</th>"; 
?>	
	</tr>
	</thead>
	<tfoot>
	<tr>
		<th></th>
<?php 
        foreach( $columnas as $columna ) 
            echo "<th><strong>{$columna[ 'label' ]}</strong></th>";
?>	
	</tr>
	</tfoot>
	<tbody>
	<tr>
	</tr>
	</tbody>
</table>
<script type="text/javascript">
var url = "<?php echo $urlAction; ?>";
$(function(){
	$("#tabla").dataTable({
		"bProcessing": true,
		"bServerSide": true,
		"bStateSave": true,
		"oLanguage": {
			"sLengthMenu": "Mostrando _MENU_ registros por pagina",
			"sZeroRecords": "No hay resultados",
			"sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
			"sInfoFiltered": "(filtrando de _MAX_ total registros)",
			"sSearch": "Buscar"
		},
		"aoColumnDefs": [  
			{ "bSortable": false, "aTargets": [ 0 ] },
			{ "bSearchable": false, "aTargets": [ 0 ] } 
		],
		"sAjaxSource": "<?php echo $urlData; ?>" 
		});
	
	$("#tabla").ajaxStop(function(){
		$("#container").height($("#tabla").height() + 300);
	});
});

$('.icono').live('click',function(){
	var pars = this.id.split("_");
	var action = true;
	if(pars[0] == "delete"){
		action = confirm("Desea borrar este <?php echo $singular; ?>?");
	}
	if(action == true){
		$.post(url,{id:pars[1],opcion:pars[0]},function(data){
			if(pars[0] == "delete")
				$("#actionResult").load("<?php echo $urlDelete; ?>" + data);
			else
				$("#actionResult").html(data);
		$('.icono').die('click');
		});
	}
});
</script>
<?php
endif;