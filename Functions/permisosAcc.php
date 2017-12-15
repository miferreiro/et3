<?php

/*	Archivo php
	Nombre: permisosAcc.php
	Autor:	fta875
	Fecha de creación: 9/10/2017 
	Función: Esta función valida si existen los permisos para la accion de la funcionalidad indicada.
*/
include_once '../Functions/BdAdmin.php';
include_once '../Models/USU_GRUPO_MODEL.php';
include_once '../Models/PERMISO_MODEL.php';

function permisosAcc( $login, $funcionalidad, $accion ) {
	$ADMIN = new USU_GRUPO( $login, '' );

	if ( !$ADMIN->comprobarAdmin() ) {
		$PERMISO = new PERMISO_MODEL( '', $funcionalidad, $accion,'','','' );
		return $PERMISO->comprobarPermisos( $login );

	} else {
		return true;
	}
} //end of function permisosAcc()
?>