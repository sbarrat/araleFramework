<?php
/**
 * NO TOCAR GENERACION AUTOMATICA BASADA EN <nombreControlador>
 * Fichero de control de Vista View.php?model=<nombreModelo>
 * Carga el submenu con el boton de formulario y el de listado
 * @author Ruben Lacasa <rubendx@gmail.com>
 * @package Arale Framework
 * @subpackage views
 * @version 0.1
 */ 

$SID = session_id();
if( empty( $SID ) ) session_start();
if( isset( $_SESSION['usuario'] ) ):
try {
    $datos = new $controller();
    $datos->especificosView();
    $urlForm = "../application/_forms/Form.php?controller={$controller}";
    $urlList = "../application/_lists/List.php?controller={$controller}";
    $singular = $datos->singular();
    $plural = $datos->plural();
} catch ( Exception $e ) {
    echo "Error {$e->getMessage()}";
    die();
}
?>
<section id="wrapper">
	<div class="submenu">
		<div id='alta' class="action boton">Nuevo/a <?php echo $singular; ?>
		</div>
		<div id='lista' class="action boton">Listado <?php echo $plural; ?>
		</div>
	</div>
	<div id="actionResult">
	</div>
</section>
<script type="text/javascript">
$(".action").click(function(){
	var url = "";
	$(".action").css("background-color","#CAD45F");
	$("#"+this.id).css("background-color","#656E00");
	if(this.id == "alta"){url = "<?php print $urlForm; ?>";}
	else {url = "<?php print $urlList; ?>";}
	$("#actionResult").load( url );
});
</script>
<?php 
endif;