<?php

/*	Archivo php
	Nombre: permisosFun.php
	Autor:	fta875
	Fecha de creación: 9/10/2017 
	Función: Esta función valida si existen los permisos para la funcionalidad indicada.
*/
include_once '../Functions/BdAdmin.php';
function permisosFun($login,$funcionalidad){
	   $mysqli=ConectarBD();
	   $sql = "SELECT DISTINCT U.login, P.IdGrupo, P.IdFuncionalidad FROM PERMISO P, USU_GRUPO U WHERE U.login = '$login' && (U.IdGrupo = '00000A' || (U.IdGrupo = P.IdGrupo && P.IdFuncionalidad = '$funcionalidad') )";
	   $resultado = $mysqli->query( $sql );
		if($resultado->num_rows == 0){//miramos si el numero de filas es 0
			return false;
		}else{
			return true;
		}

} //end of function permisosFun()
?>