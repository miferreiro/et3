<?php
/*
	Archivo php
	Nombre: PERMISO_CONTROLLER.php
	Autor: 	miferreiro
	Fecha de creación: 25/11/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/

session_start();//solicito trabajar con la sesión

include '../Models/PERMISO_MODEL.php';
include '../Views/PERMISO_SHOWALL_View.php';
include '../Views/PERMISO_SEARCH_View.php';
include '../Views/PERMISO_ADD_View.php';
include '../Views/PERMISO_DELETE_View.php';
include '../Views/PERMISO_SHOWCURRENT_View.php';
include '../Views/MESSAGE_View.php';

function get_data_form(){
	
	
	$IdGrupo = $_REQUEST['IdGrupo'];
	$IdFuncionalidad = $_REQUEST['IdFuncionalidad'];
	$IdAccion = $_REQUEST['IdAccion'];
	$action= $_REQUEST['action'];
	
	$PERMISO = new PERMISO(
		$IdGrupo,
		$IdFuncionalidad,
		$IdAccion
	);
	
	return $PERMISO;
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			new PERMISO_ADD();
		} else {
			$PERMISO = get_data_form();
			$respuesta = $PERMISO->ADD();
			new MESSAGE( $respuesta, '../Controllers/PERMISO_CONTROLLER.php' );
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			$PERMISO = new PERMISO( $_REQUEST[ 'IdGrupo' ], $_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ] );
			$valores = $PERMISO->RellenaDatos( $_REQUEST[ 'IdGrupo' ], $_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccionI' ]  );
			new PERMISO_DELETE( $valores );
		} else {
			$PERMISO = get_data_form();
			$respuesta = $PERMISO->DELETE();
			new MESSAGE( $respuesta, '../Controllers/PERMISO_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
			new PERMISO_SEARCH();
		} else {
			$PERMISO = get_data_form();
			$datos = $PERMISO->SEARCH();
			$lista = array( 'IdGrupo','IdFuncionalidad','IdAccion' );
			new PERMISO_SHOWALL( $lista, $datos );
		}
		break;
	default:
		if ( !$_POST ) {
			$PERMISO = new PERMISO( '', '', '');
		} else {
			$PERMISO = get_data_form();
		}
		$datos = $PERMISO->SEARCH();
		$lista = array( 'IdGrupo','IdFuncionalidad','IdAccion' );
		new PERMISO_SHOWALL( $lista, $datos );
}


?>