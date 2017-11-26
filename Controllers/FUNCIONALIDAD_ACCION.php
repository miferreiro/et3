<?php
/*
	Archivo php
	Nombre: FUNCIONALIDAD_ACCION_CONTROLLER.php
	Autor: 	miferreiro
	Fecha de creación: 27/11/2017 
	Función: controlador que realiza las FUNCIONALIDAD_ACCION, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/

session_start();//solicito trabajar con la sesión

include '../Models/FUNCIONALIDAD_ACCION_MODEL.php';
include '../Views/FUNCIONALIDAD_ACCION_SHOWALL_View.php';
include '../Views/FUNCIONALIDAD_ACCION_SEARCH_View.php';
include '../Views/FUNCIONALIDAD_ACCION_ADD_View.php';
include '../Views/FUNCIONALIDAD_ACCION_EDIT_View.php';
include '../Views/FUNCIONALIDAD_ACCION_DELETE_View.php';
include '../Views/FUNCIONALIDAD_ACCION_SHOWCURRENT_View.php';
include '../Views/MESSAGE_View.php';

function get_data_form(){
	
	
	$idFuncionalidad = $_REQUEST['idFuncionalidad'];
	$idAccion = $_REQUEST['idAccion'];
	$action= $_REQUEST['action'];
	
	$FUNCIONALIDAD_ACCION = new FUNCIONALIDAD_ACCION_Model(
		$DescripFuncionalidad,
		$idAccion
	);
	
	return $FUNCIONALIDAD_ACCION;
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			new FUNCIONALIDAD_ACCION_ADD();
		} else {
			$FUNCIONALIDAD_ACCION = get_data_form();
			$respuesta = $FUNCIONALIDAD_ACCION->ADD();
			new MESSAGE( $respuesta, '../Controllers/FUNCIONALIDAD_ACCION_CONTROLLER.php' );
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			$FUNCIONALIDAD_ACCION = new FUNCIONALIDAD_ACCION_Model( $_REQUEST[ 'idFuncionalidad' ], $_REQUEST[ 'idAccion' ]);
			$valores = $FUNCIONALIDAD_ACCION->RellenaDatos( $_REQUEST[ 'idFuncionalidad' ], $_REQUEST[ 'idAccion' ]);
			new FUNCIONALIDAD_ACCION_DELETE( $valores );
		} else {
			$FUNCIONALIDAD_ACCION = get_data_form();
			$respuesta = $FUNCIONALIDAD_ACCION->DELETE();
			new MESSAGE( $respuesta, '../Controllers/FUNCIONALIDAD_ACCION_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
			new FUNCIONALIDAD_ACCION_SEARCH();
		} else {
			$FUNCIONALIDAD_ACCION = get_data_form();
			$datos = $FUNCIONALIDAD_ACCION->SEARCH();
			$lista = array( 'idFuncionalidad','idAccion' );
			new FUNCIONALIDAD_ACCION_SHOWALL( $lista, $datos );
		}
		break;
	default:
		if ( !$_POST ) {
			$FUNCIONALIDAD_ACCION = new FUNCIONALIDAD_ACCION_Model( '', '', '');
		} else {
			$FUNCIONALIDAD_ACCION = get_data_form();
		}
		$datos = $FUNCIONALIDAD_ACCION->SEARCH();
		$lista = array( 'idFuncionalidad','idAccion' );
		new FUNCIONALIDAD_ACCION_SHOWALL( $lista, $datos );
}

?>