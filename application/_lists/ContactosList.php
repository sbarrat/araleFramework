<?php
session_start();
if(isset($_SESSION['usuario'])):
require_once '../config.inc.php';
$msg = ""; 
if(isset($_GET['borrado'])){
    if($_GET['borrado']==1)
        $msg = "<div class='okay'>Contacto borrado</div>";
    else
        $msg = "<div class='error'>No se ha borrado el contacto</div>";        
}

?>
<div class='tituloSeccion'>
<h2>Listado Contactos</h2>
</div>
<div class='descargas'><a href="public/ContactosXLS.php" target='_blank'>
<img src='_images/Page_excel.png' alt='Descargar listado en excel'/>
Descargar listado en excel
</a>
</div>
<div id="result"><?php echo $msg; ?></div>
<table id="tabla" class="display">
<thead>
<tr>
<th></th>
	<th>Curso</th><th>Nombre</th><th>Apellidos</th><th>Email</th>
	<th>Telefono</th><th>Recibida</th>
</tr>
</thead>
<tbody>
<?php
$contactos = new Contactos();
$contactos->trataDatosNuevos();
foreach($contactos->listado() as $contacto){
    $fechaHora = date("d-m-Y H:m:s",strtotime($contacto->fechaHora));
    echo "<tr><td><span class='editar icono' id='{$contacto->id}'>
    <img src='_images/b_inline_edit.png' alt='Editar' /></span>
    <span class='borrar icono' id='{$contacto->id}'>
    <img src='_images/bd_empty.png' alt='Borrar' /></span></td>
    <td>{$contacto->curso}</td>
    <td>{$contacto->nombre}</td><td>{$contacto->apellidos}</td>
    <td>{$contacto->email}</td><td>{$contacto->telefono}</td>
    <td>{$fechaHora}</td>
    </tr>";
}
?>
</tbody>
</table>
<script type="text/javascript">
var url = "_inc/_helpers/action.php?action=Contactos";

$(function(){
	$("#tabla").dataTable({
		
		"aoColumns": [  
			{ "bSortable": false }, 
			null, 
			null, 
			null, 
			null,
			null,
			null
		],
		"aaSorting": [[1,'asc'], [2,'asc'], [3,'asc'],[4,'asc'],[5,'asc'], [6,'asc']],
		"oLanguage": {
			"sLengthMenu": "Mostrando _MENU_ registros por pagina",
			"sZeroRecords": "No hay resultados",
			"sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
			"sInfoFiltered": "(filtrando de _MAX_ total registros)",
			"sSearch": "Buscar"
		},
		"bSearchable": false, "aTargets": [ 0 ] 
		});
	
	$("#container").height($("#tabla").height() + 300);
});
$('.editar').live('click', function() {
	$.post(url,{id: this.id,opcion: "editar"},
			function(data){
				$("#actionResult").html(data);
			}
		);
	});

$(".borrar").live('click',function(){
		var borrar = confirm("Desea borrar este Contacto?");
		if(borrar == true){
			$.post(url,{id: this.id,opcion: "borrar"},
				function(data){
					$("#actionResult").load(
							"_inc/_lists/ContactosList.php?borrado="+data
					);
				}
		);
		}
	});

</script>
<?php endif; ?>