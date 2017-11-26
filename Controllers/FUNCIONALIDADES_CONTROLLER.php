<?php
/*
	Archivo php
	Nombre: FUNCIONALIDADES_CONTROLLER.php
	Autor: 	miferreiro
	Fecha de creación: 27/11/2017 
	Función: controlador que realiza las FUNCIONALIDADES, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/

session_start();//solicito trabajar con la sesión

include '../Models/FUNCIONALIDADES_MODEL.php';
include '../Views/FUNCIONALIDADES_SHOWALL_View.php';
include '../Views/FUNCIONALIDADES_SEARCH_View.php';
include '../Views/FUNCIONALIDADES_ADD_View.php';
include '../Views/FUNCIONALIDADES_EDIT_View.php';
include '../Views/FUNCIONALIDADES_DELETE_View.php';
include '../Views/FUNCIONALIDADES_SHOWCURRENT_View.php';
include '../Views/MESSAGE_View.php';

function get_data_form(){
	
	
	$idFuncionalidad = $_REQUEST['idFuncionalidad'];
	$NombreFuncionalidad = $_REQUEST['NombreFuncionalidad'];
	$DescripFuncionalidad = $_REQUEST['DescripFuncionalidad'];
	$action= $_REQUEST['action'];
	
	$FUNCIONALIDADES = new FUNCIONALIDADES_Model(
		$DescripFuncionalidad,
		$NombreFuncionalidad,
		$DescripFuncionalidad
	);
	
	return $FUNCIONALIDADES;
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			new FUNCIONALIDADES_ADD();
		} else {
			$FUNCIONALIDADES = get_data_form();
			$respuesta = $FUNCIONALIDADES->ADD();
			new MESSAGE( $respuesta, '../Controllers/FUNCIONALIDADES_CONTROLLER.php' );
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			$FUNCIONALIDADES = new FUNCIONALIDADES_Model( $_REQUEST[ 'idFuncionalidad' ], '', '');
			$valores = $FUNCIONALIDADES->RellenaDatos( $_REQUEST[ 'idFuncionalidad' ]);
			new FUNCIONALIDADES_DELETE( $valores );
		} else {
			$FUNCIONALIDADES = get_data_form();
			$respuesta = $FUNCIONALIDADES->DELETE();
			new MESSAGE( $respuesta, '../Controllers/FUNCIONALIDADES_CONTROLLER.php' );
		}
		break;
	case 'EDIT':
		if ( !$_POST ) {
			$FUNCIONALIDADES = new FUNCIONALIDADES_Model( $_REQUEST[ 'idFuncionalidad' ], '', '');
			$valores = $FUNCIONALIDADES->RellenaDatos( $_REQUEST[ 'idFuncionalidad' ] );
			new FUNCIONALIDADES_EDIT( $valores );
		} else {
			$FUNCIONALIDADES = get_data_form();
			$respuesta = $FUNCIONALIDADES->EDIT();
			new MESSAGE( $respuesta, '../Controllers/FUNCIONALIDADES_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
			new FUNCIONALIDADES_SEARCH();
		} else {
			$FUNCIONALIDADES = get_data_form();
			$datos = $FUNCIONALIDADES->SEARCH();
			$lista = array( 'idFuncionalidad','NombreFuncionalidad','DescripFuncionalidad' );
			new FUNCIONALIDADES_SHOWALL( $lista, $datos );
		}
		break;
		
	case 'SHOWCURRENT':
		$FUNCIONALIDADES= new FUNCIONALIDADES_Model( $_REQUEST[ 'idFuncionalidad' ], '', '');
		$valores = $FUNCIONALIDADES->RellenaDatos( $_REQUEST[ 'idFuncionalidad' ] );
		new FUNCINOALIDADES_SHOWCURRENT( $valores );
		break;
	default:
		if ( !$_POST ) {
			$FUNCIONALIDADES = new FUNCIONALIDADES_Model( '', '', '');
		} else {
			$FUNCIONALIDADES = get_data_form();
		}
		$datos = $FUNCIONALIDADES->SEARCH();
		$lista = array( 'idFuncionalidad','NombreFuncionalidad','DescripFuncionalidad' );
		new FUNCIONALIDADES_SHOWALL( $lista, $datos );
}

?>