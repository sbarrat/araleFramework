<?php
if(isset($_SESSION['usuario'])){
    require_once 'config.inc.php';
    $html ="
    <div id='menu'>";
    foreach($menu as $opcion):
		$html.="<div id='{$opcion['controller']}' 
		class='opcion boton'>{$opcion['label']}</div>";
	endforeach;	
	$html .= <<<EOD
		<div id='Logout' class='logout boton'>Salir</div>
	</div>
	<div id="acciones">
	</div>
	<script type="text/javascript">
	$(".logout").click(function(){
		document.location = "logout.php";
	});
	$(".opcion").click(function(){
	$(".opcion").css("background-color","#CAD45F");
	$("#"+this.id).css("background-color","#656E00");
	$.post("../application/_helpers/bootstrap.php",{controller:this.id},function(data){
			$("#acciones").html(data);
		});
	});
	</script>
EOD;
     echo $html;
}