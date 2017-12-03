<?php
/*
	Archivo php
	Nombre: HISTORIA_CONTROLLER.php
	Autor: 	miferreiro
	Fecha de creación: 26/11/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/

session_start();//solicito trabajar con la sesión

include '../Models/HISTORIA_MODEL.php';
include '../Views/HISTORIA_SHOWALL_View.php';
include '../Views/HISTORIA_SEARCH_View.php';
include '../Views/HISTORIA_ADD_View.php';
include '../Views/HISTORIA_EDIT_View.php';
include '../Views/HISTORIA_DELETE_View.php';
include '../Views/HISTORIA_SHOWCURRENT_View.php';
include '../Views/MESSAGE_View.php';

function get_data_form(){
	
	
	$IdTrabajo = $_REQUEST['IdTrabajo'];
	$IdHistoria = $_REQUEST['IdHistoria'];
	$TextoHistoria = $_REQUEST['TextoHistoria'];
	$action= $_REQUEST['action'];
	
	$HISTORIA = new HISTORIA_MODEL(
		$IdTrabajo,
		$IdHistoria,
		$TextoHistoria
	);
	
	return $HISTORIA;
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			new HISTORIA_ADD();
		} else {
			$HISTORIA = get_data_form();
			$respuesta = $HISTORIA->ADD();
			new MESSAGE( $respuesta, '../Controllers/HISTORIA_CONTROLLER.php' );
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			$HISTORIA = new HISTORIA_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'IdHistoria' ], '');
			$valores = $HISTORIA->RellenaDatos( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'IdHistoria' ]);
			new HISTORIA_DELETE( $valores);
		} else {
			$HISTORIA = get_data_form();
			$respuesta = $HISTORIA->DELETE();
			new MESSAGE( $respuesta, '../Controllers/HISTORIA_CONTROLLER.php' );
		}
		break;
	case 'EDIT':
		if ( !$_POST ) {
			$HISTORIA = new HISTORIA_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'IdHistoria' ], '');
			$valores = $HISTORIA->RellenaDatos( $_REQUEST[ 'IdTrabajo' ] ,$_REQUEST[ 'IdHistoria' ]);
			new HISTORIA_EDIT( $valores );
		} else {
			$HISTORIA = get_data_form();
			$respuesta = $HISTORIA->EDIT();
			new MESSAGE( $respuesta, '../Controllers/HISTORIA_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
			new HISTORIA_SEARCH();
		} else {
			$HISTORIA = get_data_form();
			$datos = $HISTORIA->SEARCH();
			$lista = array( 'IdTrabajo','IdHistoria','TextoHistoria' );
			new HISTORIA_SHOWALL( $lista, $datos );
		}
		break;
	case 'SHOWCURRENT':
		$HISTORIA= new HISTORIA_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'IdHistoria' ], '');
		$valores = $HISTORIA->RellenaDatos( $_REQUEST[ 'IdTrabajo' ] ,$_REQUEST[ 'IdHistoria' ]);
		new HISTORIA_SHOWCURRENT( $valores );
		break;
	default:
		if ( !$_POST ) {
			$HISTORIA = new HISTORIA_MODEL( '', '', '');
		} else {
			$HISTORIA = get_data_form();
		}
		$datos = $HISTORIA->SEARCH();
		$lista = array( 'IdTrabajo','IdHistoria','TextoHistoria' );
		new HISTORIA_SHOWALL( $lista, $datos );
}

?>