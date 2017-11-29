<?php
/*
	Archivo php
	Nombre: ACCION_CONTROLLER.php
	Autor: 	miferreiro
	Fecha de creación: 26/11/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/

session_start();//solicito trabajar con la sesión

include '../Models/ACCION_MODEL.php';
include '../Views/ACCION_SHOWALL_View.php';
include '../Views/ACCION_SEARCH_View.php';
include '../Views/ACCION_ADD_View.php';
include '../Views/ACCION_EDIT_View.php';
include '../Views/ACCION_DELETE_View.php';
include '../Views/ACCION_SHOWCURRENT_View.php';
include '../Views/MESSAGE_View.php';

function get_data_form(){
	
	
	$IdAccion = $_REQUEST['IdAccion'];
	$NombreAccion = $_REQUEST['NombreAccion'];
	$DescripAccion = $_REQUEST['DescripAccion'];
	$action= $_REQUEST['action'];
	
	$ACCION = new ACCION(
		$IdAccion,
		$NombreAccion,
		$DescripAccion
	);
	
	return $ACCION;
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			new ACCION_ADD();
		} else {
			$ACCION = get_data_form();
			$respuesta = $ACCION->ADD();
			new MESSAGE( $respuesta, '../Controllers/ACCION_CONTROLLER.php' );
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			$ACCION = new ACCION( $_REQUEST[ 'IdAccion' ], '', '');
			$valores = $ACCION->RellenaDatos( $_REQUEST[ 'IdAccion' ]);
			$dependencias = $ACCION->dependencias( $_REQUEST[ 'IdAccion' ]);
			new ACCION_DELETE( $valores, $dependencias );
		} else {
			$ACCION = get_data_form();
			$respuesta = $ACCION->DELETE();
			new MESSAGE( $respuesta, '../Controllers/ACCION_CONTROLLER.php' );
		}
		break;
	case 'EDIT':
		if ( !$_POST ) {
			$ACCION = new ACCION( $_REQUEST[ 'IdAccion' ], '', '');
			$valores = $ACCION->RellenaDatos( $_REQUEST[ 'IdAccion' ] );
			new ACCION_EDIT( $valores );
		} else {
			$ACCION = get_data_form();
			$respuesta = $ACCION->EDIT();
			new MESSAGE( $respuesta, '../Controllers/ACCION_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
			new ACCION_SEARCH();
		} else {
			$ACCION = get_data_form();
			$datos = $ACCION->SEARCH();
			$lista = array( 'IdAccion','NombreAccion','DescripAccion' );
			new ACCION_SHOWALL( $lista, $datos );
		}
		break;
	default:
		if ( !$_POST ) {
			$ACCION = new ACCION( '', '', '');
		} else {
			$ACCION = get_data_form();
		}
		$datos = $ACCION->SEARCH();
		$lista = array( 'IdAccion','NombreAccion','DescripAccion' );
		new ACCION_SHOWALL( $lista, $datos );
}

?>