<?php

/*	Archivo php
	Nombre: permisosAcc.php
	Autor:	fta875
	Fecha de creación: 9/10/2017 
	Función: Esta función valida si existen los permisos para la accion de la funcionalidad indicada.
*/
include_once '../Functions/BdAdmin.php';
function permisosAcc($login,$funcionalidad,$accion){
	   $mysqli=ConectarBD();
	   $sql="SELECT DISTINCT login FROM USU_GRUPO WHERE login='$login' && IdGrupo='00000A' ";
	   $resultado = $mysqli->query( $sql );
	if($resultado->num_rows == 0){
	   $sql1 = "SELECT DISTINCT U.login, P.IdGrupo, P.IdFuncionalidad FROM PERMISO P, USU_GRUPO U WHERE U.login = '$login' && (U.IdGrupo = '00000A' || (U.IdGrupo = P.IdGrupo && P.IdFuncionalidad = '$funcionalidad' && P.IdAccion = '$accion') )";
	   $resultado1 = $mysqli->query( $sql1 );
		if($resultado1->num_rows == 0){//miramos si el numero de filas es 0
			return false;
		}else{
			return true;
		}
	}else{
		return true;
	}
} //end of function permisosFun()
?>