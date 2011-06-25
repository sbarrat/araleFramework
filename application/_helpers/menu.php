<?php
if(isset($_SESSION['usuario'])){
    $html = <<<EOD
	<div id="menu">
		<div id='Contactos' class='opcion boton'>Informaciones Web</div>
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
	$.post("_inc/_helpers/bootstrap.php",{controller:this.id},function(data){
			$("#acciones").html(data);
		});
	});
	</script>
EOD;
     echo $html;
}