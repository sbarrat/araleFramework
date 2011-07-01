<?php
/**
 * NO TOCAR GENERA AUTOMATICAMENTE EL FORMULARIO
 * SOlO IMPORTA EL NOMBRE DEL FICHERO <nombreAccion>Form.php
 * @author Ruben Lacasa <ruben@ensenalia.com>
 * @package araleFramework
 */
$SID = session_id();
if( empty( $SID ) ) session_start();
    if( isset( $_SESSION['usuario'] ) ):
        require_once '../config.inc.php';
        if( isset( $_GET['controller'] ) ):
            $controller = $_GET['controller'];
    endif;
  
    try {
        $datos = new $controller();
        $datos->especificosForm();
        $urlAction = "\"../application/_helpers/action.php?controller={$controller}\"";
        $singular = $datos->singular();
        $plural = $datos->plural();
        $columnas = $datos->columnasListado();
    } catch ( Exception $e ) {
        echo "Error {$e->getMessage()}";
        die();
    }

    if( !method_exists( $datos, "camposFormulario" ) ):
	    echo "<div class='error'>Debes definir el formato del fomulario</div>";
    else:
        echo $datos->generateForm( $_POST, $datos, $singular, $plural );
    
    /* Generamos las reglas de validacion RSV */
    $rules = "[";
    foreach( $datos->camposFormulario() as $dato ):
        if( array_key_exists( 'required' , $dato ) )
            $rules .= 
            "\"required,{$dato['field']},Por favor escribe un <strong>{$dato['label']}</strong>\",";
        if( $dato[ 'field' ] == 'email' )
            $rules .= 
            "\"valid_email,{$dato['field']},Por favor escribe una dirección de <strong>{$dato['label']} valida</strong>\",";
    endforeach;
    
    $rules = substr( $rules, 0, strlen( $rules ) - 1 );
    $rules .= "]";
    
?>    
<script type="text/javascript">
var myRules = <? print $rules; ?>;
var url = <?php echo $urlAction; ?>;
$(function(){
	$("form").RSV({
    	onCompleteHandler: Form,
    	displayType: "display-html",
        errorFieldClass: "errorField",
        rules: myRules
    });
	$('.date').datepicker({
		firstDay: 1, 
		dateFormat: 'dd-mm-yy',
		dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
		dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		changeYear: true,
		changeMonth: true
	});
	
});
$("form").ajaxComplete(function(){
	$("#container").height($("#container").height() + 300);
});
$("input[type='button']").click(function(){
	$.post(url,{id:$("#id").val(),opcion:"edit"},function(data){
		$("#actionResult").html(data);
	});
});
function Form(){
	$("#Errors").remove();
	$.post(url,$("form").serialize(),function(data){
		if(data)
			$("#result").html("<div class='okay'>Operacion Completada</div>");
		else
			$("#result").html("<div class='error'>No se ha completado la operacion</div>");
	});
	return false;
}

</script>
<?php 
endif;
endif;