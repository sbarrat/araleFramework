<?php
$SID = session_id();
if(empty($SID)) session_start();
if(isset($_SESSION['usuario'])):
require_once '../config.inc.php';
$contacto = new Contactos();
$titulo = "Alta Contactos";
if(isset($_POST['id'])){
    $contacto = $contacto->datos($_POST['id']);
    $titulo = "Modificacion Contactos";
}
?>
<form id="contactos" name="contactos" method="post" action="">
<div class='tituloSeccion'>
<h2><?php echo $titulo; ?></h2>
</div>
<div id="result"></div>
<div id="rsvErrors"></div>
<div class='formFields'>
<?php if(isset($_POST['id'])): ?>
<input type='hidden' id="id" name="id" 
value='<?php echo $contacto->id; ?>' />
<label for="Recibido">Recibido</label>
<div class="campo">
    <?php echo date("d-m-Y H:m:s",strtotime($contacto->fechaHora)); ?>
</div>
<?php endif; ?>
<label for="curso">*Curso</label>
<div class="campo">
<input type="text" id="curso" name="curso" tabindex="10" size='60'
value='<?php echo $contacto->curso; ?>'/>
</div>
<label for="nombre">*Nombre</label>
<div class="campo">
<input type="text" id="nombre" name="nombre" tabindex="20" size='60'
value='<?php echo $contacto->nombre; ?>'/>
</div>

<label for="apellidos">*Apellidos</label>
<div class="campo">
<input type="text" id="apellidos" name="apellidos" tabindex="30" size='60'
value='<?php echo $contacto->apellidos; ?>'/>
</div>
<label for="email">*Email</label>
<div class="campo">
<input type="text" id="email" name="email" tabindex="40" size='60'
value='<?php echo $contacto->email; ?>'/>
</div>
<label for="telefono">*Teléfono de Contacto</label>
<div class="campo">
<input type="text" id="telefono" name="telefono" tabindex="50" size='20'
value='<?php echo $contacto->telefono; ?>'/>
</div>
<label for="consulta">*Consulta</label>
<div class="campo">
<textarea id="consulta" name="consulta" tabindex="60" cols="80" rows="10">
<?php echo $contacto->consulta; ?>
</textarea>
</div> 

<label for="contacto">¿Como quieres que contactemos?</label>
<div class="campo">
<input type="text" id="contacto" name="contacto" tabindex="70" 
value='<?php echo $contacto->contacto; ?>'/>
</div>
<label for="horario">Horario</label>
<div class="campo">
<input type="text" id="horario" name="horario" tabindex="80" 
value='<?php echo $contacto->horario; ?>'/>
</div>
<label for="politica">Politica de proteccion de datos</label>
<div class="campo">
<input type="text" id="politica" name="politica" tabindex="90" 
value='<?php echo $contacto->politica; ?>'/>
</div>
<input type="hidden" id="tratado" name="tratado" 
value='1'/>
<label>&nbsp;</label>
<div class="campo">
<?php if(isset($_POST['id'])):?>

<input type="submit" value="Actualizar Contacto" tabindex="160"/>
<?php else: ?>
<input type="submit" value="Agregar Contacto" tabindex="160"/>
<input type="reset" value="Limpiar Formulario" tabindex="170" />
<?php endif; ?>
</div>
</div> 
</form>
<script type="text/javascript">
var myRules = [
"required,curso,Por favor escribe un <strong>Curso</strong>",               
"required,nombre,Por favor escribe un <strong>Nombre</strong>",
"required,apellidos,Por favor escribe un <strong>Apellidos</strong>",
"required,email,Por favor escribe una dirección de <strong>Correo electronico</strong>",
"valid_email,email,Por favor escribe una dirección de <strong>correo electronico valida</strong>",
"required,telefono,Por favor escribe un <strong>telefono</strong>",
"required,consulta,Por favor escribe una <strong>Consulta</strong>"
];

$(function(){
	$("form").RSV({
    	onCompleteHandler: Contactos,
    	displayType: "display-html",
        errorFieldClass: "errorField",
        rules: myRules
    });
});

$("form").ajaxComplete(function(){
	$("#container").height($("#container").height() + 300);
	
});

function Contactos(){
	$("#Errors").remove();
	$.post("_inc/_helpers/action.php?action=Contactos",$("form").serialize(),
			function(data){
				if(data)
					$("#result").html("<div class='okay'>Operacion Completada</div>");
				else
					$("#result").html("<div class='error'>No se ha completado la operacion</div>");
	});
	return false;
};
</script>
<?php endif; ?>
