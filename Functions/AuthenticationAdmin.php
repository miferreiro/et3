<?php

/*	Archivo php
	Nombre: Authentication.php
	Autor:	fta875
	Fecha de creación: 9/10/2017 
	Función: Esta función valida si existe la variable de session login. Si no existe redirige a la pagina de login.
			Si existe comprueba si el usuario tiene permisos para ejecutar la accion de ese controlador.
*/
function IsAuthenticatedAdmin(){

	if (!isset($_SESSION['login'])){
		return false;
	}
	else{
		if($_SESSION['login']=='admin'){
		return true;
		}else{
		return false;
		}
	}

} //end of function IsAuthenticated()
?>