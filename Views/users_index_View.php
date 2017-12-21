<?php
/*  Archivo php
	Nombre: users_index_View.php
	Autor: 	fta875
	Fecha de creación: 23/10/2017 
	Función: vista de los elementos que va a contar la sesión del usuario, realizada con una clase
*/
class Index {

	function __construct(){
		//session_start();
		$this->render();
	}

	function render(){
	
		include '../Locales/Strings_SPANISH.php';
		include '../Views/Header.php';
		include '../Views/Footer.php';
	}

}

?>