<?php

/*	Archivo php
	Nombre: pcomprobarAdministrador.php
	Autor:	fta875
	Fecha de creación: 9/10/2017 
	Función: Esta función valida si existen los permisos para la accion de la funcionalidad indicada.
*/
include_once '../Functions/BdAdmin.php';
include_once '../Models/USU_GRUPO_MODEL.php';
function comprobarAdministrador($login){
	
	
	$ADMIN = new USU_GRUPO($login,'');
	
	return $ADMIN->comprobarAdmin();
} //end of function comprobarAdministrador()
?>