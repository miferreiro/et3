<?php
/*
	Archivo php
	Nombre: FUNCIONALIDAD_CONTROLLER.php
	Autor: 	miferreiro
	Fecha de creación: 27/11/2017 
	Función: controlador que realiza las FUNCIONALIDAD, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/

session_start();//solicito trabajar con la sesión

include '../Models/FUNCIONALIDAD_MODEL.php';
include '../Views/FUNCIONALIDAD_SHOWALL_View.php';
include '../Views/FUNCIONALIDAD_SEARCH_View.php';
include '../Views/FUNCIONALIDAD_ADD_View.php';
include '../Views/FUNCIONALIDAD_EDIT_View.php';
include '../Views/FUNCIONALIDAD_DELETE_View.php';
include '../Views/FUNCIONALIDAD_SHOWCURRENT_View.php';
include '../Views/MESSAGE_View.php';

function get_data_form(){
	
	
	$IdFuncionalidad = $_REQUEST['IdFuncionalidad'];
	$NombreFuncionalidad = $_REQUEST['NombreFuncionalidad'];
	$DescripFuncionalidad = $_REQUEST['DescripFuncionalidad'];
	$action= $_REQUEST['action'];
	
	$FUNCIONALIDAD = new FUNCIONALIDAD(
		$IdFuncionalidad,
		$NombreFuncionalidad,
		$DescripFuncionalidad
	);
	
	return $FUNCIONALIDAD;
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			new FUNCIONALIDAD_ADD();
		} else {
			$FUNCIONALIDAD = get_data_form();
			$respuesta = $FUNCIONALIDAD->ADD();
			new MESSAGE( $respuesta, '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			$FUNCIONALIDAD = new FUNCIONALIDAD( $_REQUEST[ 'IdFuncionalidad' ], '', '');
			$valores = $FUNCIONALIDAD->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ]);
			new FUNCIONALIDAD_DELETE( $valores );
		} else {
			$FUNCIONALIDAD = get_data_form();
			$respuesta = $FUNCIONALIDAD->DELETE();
			new MESSAGE( $respuesta, '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
		}
		break;
	case 'EDIT':
		if ( !$_POST ) {
			$FUNCIONALIDAD = new FUNCIONALIDAD( $_REQUEST[ 'IdFuncionalidad' ], '', '');
			$valores = $FUNCIONALIDAD->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ] );
			new FUNCIONALIDAD_EDIT( $valores );
		} else {
			$FUNCIONALIDAD = get_data_form();
			$respuesta = $FUNCIONALIDAD->EDIT();
			new MESSAGE( $respuesta, '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
			new FUNCIONALIDAD_SEARCH();
		} else {
			$FUNCIONALIDAD = get_data_form();
			$datos = $FUNCIONALIDAD->SEARCH();
			$lista = array( 'IdFuncionalidad','NombreFuncionalidad','DescripFuncionalidad' );
			new FUNCIONALIDAD_SHOWALL( $lista, $datos );
		}
		break;
		
	case 'SHOWCURRENT':
		$FUNCIONALIDAD= new FUNCIONALIDAD( $_REQUEST[ 'IdFuncionalidad' ], '', '');
		$valores = $FUNCIONALIDAD->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ] );
		new FUNCIONALIDAD_SHOWCURRENT( $valores );
		break;
	default:
		if ( !$_POST ) {
			$FUNCIONALIDAD = new FUNCIONALIDAD( '', '', '');
		} else {
			$FUNCIONALIDAD = get_data_form();
		}
		$datos = $FUNCIONALIDAD->SEARCH();
		$lista = array( 'IdFuncionalidad','NombreFuncionalidad','DescripFuncionalidad' );
		new FUNCIONALIDAD_SHOWALL( $lista, $datos );
}

?>