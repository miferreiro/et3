<?php

/*	Archivo php
	Nombre: Authentication.php
	Autor:	fta875
	Fecha de creación: 9/10/2017 
	Función: Esta función valida si existe la variable de session login. Si no existe redirige a la pagina de login.
			Si existe comprueba si el usuario tiene permisos para ejecutar la accion de ese controlador.
*/
function IsAuthenticated(){

	if (!isset($_SESSION['login'])){
		return false;
	}
	else{
		return true;
	}

} //end of function IsAuthenticated()
?>