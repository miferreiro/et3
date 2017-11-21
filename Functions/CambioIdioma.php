<?php
/*
	Archivo php
	Nombre: CambioIdioma.php
	Autor: 	fta875
	Fecha de creación: 23/10/2017 
	Función: controla el cambio de idioma
*/
	session_start();
	$idioma = $_POST['idioma'];
	$_SESSION['idioma'] = $idioma;
	header('Location:' . $_SERVER["HTTP_REFERER"]);
?>