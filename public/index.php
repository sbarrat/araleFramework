<?php 
 /**
 * PHP Version 5.3
 * 
 * Pagina inicial
 * 
 * Este es el fichero que principal de la aplicacion
 * @author Ruben Lacasa <rubendx@gmail.com>
 * @package Arale Framework
 * @version 0.1
 * 
 */
session_start();
require_once '../application/config.inc.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title><?php echo $titulo; ?> - <?php echo date('Y'); ?></title>
<link rel="stylesheet" href="_css/ui-lightness/jquery-ui-1.8.13.custom.css" 
media="screen">
<link rel="stylesheet" href="_css/demo_page.css" media="screen">
<link rel="stylesheet" href="_css/demo_table_jui.css" media="screen">
<link rel="stylesheet" href="_css/arale.css" media="screen">
<script src="_js/jquery-1.6.1.js" ></script>
<script src="_js/jquery.rsv.js"></script>
<script src="_js/jquery-ui-1.8.13.custom.min.js"></script>
<script src="_js/modernizr.custom.35633.js"></script>
<script src="_js/jquery.dataTables.js"></script>
<script src="_js/arale.js"></script>	
<script>
var myRules = [
 "required,user,Por favor escribe un <strong>Usuario</strong>",
 "required,password,Por favor escribe una <strong>Contraseña</strong>",
];

function loginUser(){
	$("#Errors").remove();
		$.post("../application/_helpers/login.php",$("#login").serialize(),
				function(data){
			  		if(data!= false)
				   		$("#container").html(data);
			  		else
			  			$("#rsvErrors").html(
				 			"<strong>Usuario/Contraseña</strong> incorrectos");
				}
		);
		return false;
};

$(function() {
	$("#login").RSV({
    	onCompleteHandler: loginUser,
        displayType: "display-html",
        errorFieldClass: "errorField",
        rules: myRules
    });
	$("#login").submit(function(){ $("#Errors").remove(); });
});
</script>
</head>
<body>
	<header id="header">
	<h1><?php echo "{$titulo} - {$version}"; ?></h1>
	</header>
	<section id="container"><?php 
	if( isset( $_SESSION[ 'usuario' ] ) ):
        include_once 'menu.php';
	else:
	?>
	<form id="login" name="login" method="post" action="">
	<fieldset>
		<legend>Acceso Usuarios:</legend>
		<label for="user">Usuario:</label> 
		<input type="text" id="user" name="user"
		tabindex="10" placeholder="Nombre de usuario"/><br/> 
		<label for="password">Contraseña:</label> 
		<input type="password" id="password" name="password" 
		tabindex="20" placeholder="Contraseña"/><br/> 
		<label for="submit">&nbsp;</label>
		<input
		type="submit" value="Acceder" tabindex="30"/>
		<div id="rsvErrors"></div>
	</fieldset>
	</form>
    <?php endif; ?>
	</section>
	<footer id="footer">
	Devel by &copy;sbarrat::<?php echo date( "Y" ); ?> - 
	Powered by Arale Framework <?php echo $version; ?>&nbsp;&nbsp;
	</footer>
</body>
</html>