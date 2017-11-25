<?php
/*
	Archivo php
	Nombre: PERMISOS_CONTROLLER.php
	Autor: 	miferreiro
	Fecha de creación: 25/11/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/

session_start();//solicito trabajar con la sesión

include '../Models/PERMISOS_MODEL.php';
include '../Views/PERMISOS_SHOWALL_View.php';
include '../Views/PERMISOS_SEARCH_View.php';
include '../Views/PERMISOS_ADD_View.php';
include '../Views/PERMISOS_EDIT_View.php';
include '../Views/PERMISOS_DELETE_View.php';
include '../Views/PERMISOS_SHOWCURRENT_View.php';
include '../Views/MESSAGE_View.php';

function get_data_form(){
	
	
	$idGrupo = $_REQUEST['idGrupo'];
	$idFuncionalidad = $_REQUEST['idFuncionalidad'];
	$idAccion = $_REQUEST['idAccion'];
	$action= $_REQUEST['action'];
	
	$PERMISOS = new PERMISOS_Model(
		$idGrupo,
		$idFuncionalidad,
		$idAccion
	);
	
	return $PERMISOS;
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			new PERMISOS_ADD();
		} else {
			$PERMISOS = get_data_form();
			$respuesta = $PERMISOS->ADD();
			new MESSAGE( $respuesta, '../Controllers/PERMISOS_CONTROLLER.php' );
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			$PERMISOS = new PERMISOS_Model( $_REQUEST[ 'idGrupo' ], $_REQUEST[ 'idFuncionalidad' ], $_REQUEST[ 'idAccion' ]);
			$valores = $PERMISOS->RellenaDatos( $_REQUEST[ 'idGrupo' ], $_REQUEST[ 'idFuncionalidad' ], $_REQUEST[ 'idAccion' ] );
			new PERMISOS_DELETE( $valores );
		} else {
			$PERMISOS = get_data_form();
			$respuesta = $PERMISOS->DELETE();
			new MESSAGE( $respuesta, '../Controllers/PERMISOS_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
			new PERMISOS_SEARCH();
		} else {
			$PERMISOS = get_data_form();
			$datos = $PERMISOS->SEARCH();
			$lista = array( 'idGrupo','idFuncionalidad','idAccion' );
			new PERMISOS_SHOWALL( $lista, $datos );
		}
		break;
	default:
		if ( !$_POST ) {
			$PERMISOS = new PERMISOS_Model( '', '', '');
		} else {
			$PERMISOS = get_data_form();
		}
		$datos = $PERMISOS->SEARCH();
		$lista = array( 'idGrupo','idFuncionalidad','idAccion' );
		new PERMISOS_SHOWALL( $lista, $datos );
}


?>