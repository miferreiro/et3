<?php
/*
	Archivo php
	Nombre: ACCIONES_CONTROLLER.php
	Autor: 	miferreiro
	Fecha de creación: 26/11/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/

session_start();//solicito trabajar con la sesión

include '../Models/ACCIONES_MODEL.php';
include '../Views/ACCIONES_SHOWALL_View.php';
include '../Views/ACCIONES_SEARCH_View.php';
include '../Views/ACCIONES_ADD_View.php';
include '../Views/ACCIONES_EDIT_View.php';
include '../Views/ACCIONES_DELETE_View.php';
include '../Views/ACCIONES_SHOWCURRENT_View.php';
include '../Views/MESSAGE_View.php';

function get_data_form(){
	
	
	$idAccion = $_REQUEST['idaccion'];
	$nombreAc = $_REQUEST['nombreAc'];
	$descripAc = $_REQUEST['descripAc'];
	$action= $_REQUEST['action'];
	
	$ACCIONES = new ACCIONES_Model(
		$descripAc,
		$nombreAc,
		$descripAc
	);
	
	return $ACCIONES;
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			new ACCIONES_ADD();
		} else {
			$ACCIONES = get_data_form();
			$respuesta = $ACCIONES->ADD();
			new MESSAGE( $respuesta, '../Controllers/ACCIONES_CONTROLLER.php' );
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			$ACCIONES = new ACCIONES_Model( $_REQUEST[ 'idAccion' ], '', '');
			$valores = $ACCIONES->RellenaDatos( $_REQUEST[ 'idAccion' ]);
			new ACCIONES_DELETE( $valores );
		} else {
			$ACCIONES = get_data_form();
			$respuesta = $ACCIONES->DELETE();
			new MESSAGE( $respuesta, '../Controllers/ACCIONES_CONTROLLER.php' );
		}
		break;
	case 'EDIT':
		if ( !$_POST ) {
			$ACCIONES = new ACCIONES_Model( $_REQUEST[ 'idAccion' ], '', '');
			$valores = $ACCIONES->RellenaDatos( $_REQUEST[ 'idAccion' ] );
			new ACCIONES_EDIT( $valores );
		} else {
			$ACCIONES = get_data_form();
			$respuesta = $ACCIONES->EDIT();
			new MESSAGE( $respuesta, '../Controllers/ACCIONES_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
			new ACCIONES_SEARCH();
		} else {
			$ACCIONES = get_data_form();
			$datos = $ACCIONES->SEARCH();
			$lista = array( 'idAccion','nombreAc','descripAc' );
			new ACCIONES_SHOWALL( $lista, $datos );
		}
		break;
	default:
		if ( !$_POST ) {
			$ACCIONES = new ACCIONES_Model( '', '', '');
		} else {
			$ACCIONES = get_data_form();
		}
		$datos = $ACCIONES->SEARCH();
		$lista = array( 'idAccion','nombreAc','descripAc' );
		new ACCIONES_SHOWALL( $lista, $datos );
}

?>