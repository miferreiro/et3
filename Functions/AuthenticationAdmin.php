<?php

/*	
	Autor:	Miguel Ferreiro
	Fecha de creación: 9/10/2017 
	En este fichero vamos a comprobar si existe una variable de sesión para el administrador
*/

//Esta función comprueba si existe una variable de sesión para el administrador
function IsAuthenticatedAdmin(){

	if (!isset($_SESSION['login'])){//mira si no existe una variable de sesión para el login
		return false;//retorna false
	}
	else{//si existe una variable de sesión
		if($_SESSION['login']=='admin'){//miramos si hay una variable de sesión del login para el administrador
		return true;//retorna true
		}else{//si el administrador no está logeado devolvemos false
		return false;
		}
	}

} //end of function IsAuthenticated()
?>