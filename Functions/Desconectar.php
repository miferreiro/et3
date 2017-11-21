<?php
/*
	Archivo php
	Nombre: Desconectar.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: realiza la desconexión de la sesión
*/
session_start();
session_destroy();
header('Location:../index.php');

?>
