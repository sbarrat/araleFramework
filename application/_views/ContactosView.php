<?php 
$SID = session_id();
if(empty($SID)) session_start();
if(isset($_SESSION['usuario'])):
?>
<section id="wrapper">
<div class="submenu">
<div id='alta' class="action boton">Alta</div>
<div id='lista' class="action boton">Listado</div>
</div>
<div id="actionResult">
</div>
</section>
<script type="text/javascript">
$(".action").click(function(){
	
	$(".action").css("background-color","#CAD45F");
	$("#"+this.id).css("background-color","#656E00");
	
	if(this.id == "alta"){
		var url = "_inc/_forms/ContactosForm.php";
	}
	else {
		var url = "_inc/_lists/ContactosList.php"; 
	}
	$("#actionResult").load(url);
});
</script>
<?php endif; ?>