<?php 
session_start();
session_destroy();
/**
 * @todo Cambiar el destino cuando estemos en produccion
 */
header("location:index.php");
