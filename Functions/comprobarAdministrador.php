<?php

/*	Archivo php
	Nombre: pcomprobarAdministrador.php
	Autor:	fta875
	Fecha de creación: 9/10/2017 
	Función: Esta función valida si existen los permisos para la accion de la funcionalidad indicada.
*/
include_once '../Functions/BdAdmin.php';
function comprobarAdministrador($login){
	   $mysqli=ConectarBD();
	   $sql="SELECT DISTINCT login FROM USU_GRUPO WHERE login='$login' && IdGrupo='00000A' ";
	   $resultado = $mysqli->query( $sql );
	if($resultado->num_rows == 0){
	  return false;
	}else{
		return true;
	}
} //end of function comprobarAdministrador()
?>