<?php 
/**
 * @author Ruben Lacasa <rubendx@gmail.com>
 * @package Arale Framework
 * @subpackage helpers
 * @version 0.1
 */
session_start();
session_destroy();
header( "location:index.php" );
