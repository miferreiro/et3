<?php

/*	
	Autor:	Miguel Ferreiro
	Fecha de creaci�n: 9/10/2017 
	En este fichero vamos a comprobar si existe una variable de sesi�n para el administrador
*/

//Esta funci�n comprueba si existe una variable de sesi�n para el administrador
function IsAuthenticatedAdmin(){

	if (!isset($_SESSION['login'])){//mira si no existe una variable de sesi�n para el login
		return false;//retorna false
	}
	else{//si existe una variable de sesi�n
		if($_SESSION['login']=='admin'){//miramos si hay una variable de sesi�n del login para el administrador
		return true;//retorna true
		}else{//si el administrador no est� logeado devolvemos false
		return false;
		}
	}

} //end of function IsAuthenticated()
?>