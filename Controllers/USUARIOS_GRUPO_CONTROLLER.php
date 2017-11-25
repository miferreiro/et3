<?php
	/*
	Archivo php
	Nombre: USUARIOS_GRUPO_CONTROLLER.php
	Autor: 	miferreiro
	Fecha de creación: 9/10/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/
session_start();//solicito trabajar con la session

include '../Models/USUARIOS_GRUPO_MODEL.php';
include '../Views/USUARIOS_GRUPO_SHOWALL_View.php';
include '../Views/USUARIOS_GRUPO_SEARCH_View.php';
include '../Views/USUARIOS_GRUPO_ADD_View.php';
include '../Views/USUARIOS_GRUPO_DELETE_View.php';
include '../Views/USUARIOS_GRUPO_SHOWCURRENT_View.php';
include '../Views/MESSAGE_View.php';

function get_data_form(){
	
	$login = $_REQUEST['login'];
	$grupo = $_REQUEST['idgroup'];
	$action = $_REQUEST['action'];
	
	$USUARIOS_GRUPO = new USUARIOS_GRUPO_Model(
		$login,
		$idgroup
	);
	
	return $USUARIOS_GRUPO;
}

if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			new USUARIOS_GRUPO_ADD();
		} else {
			$USUARIOS_GRUPO = get_data_form();
			$respuesta = $USUARIOS_GRUPO->ADD();
			new MESSAGE( $respuesta, '../Controllers/USUARIOS_GRUPO_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
			new USUARIOS_GRUPO_SEARCH();
		} else {
			$USUARIOS_GRUPO = get_data_form();
			$datos = $USUARIOS_GRUPO->SEARCH();
			$lista = array( 'login','idgroup');
			new USUARIOS_GRUPO_SHOWALL( $lista, $datos );
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			$USUARIOS = new USUARIOS_Model( $_REQUEST[ 'login' ], $_REQUEST[ 'idgroup' ] );
			$valores = $USUARIOS->RellenaDatos( $_REQUEST[ 'login' ], $_REQUEST[ 'idgroup' ]);
			new USUARIOS_DELETE( $valores );
		} else {
			$USUARIOS = get_data_form();
			$respuesta = $USUARIOS->DELETE();
			new MESSAGE( $respuesta, '../Controllers/USUARIOS_GRUPO_CONTROLLER.php' );
		}
		break;
	case 'SHOWCURRENT':
		$USUARIOS_GRUPO = new USUARIOS_GRUPO_Model( $_REQUEST[ 'login' ], $_REQUEST[ 'idgroup' ]);
		$valores = $USUARIOS_GRUPO->RellenaDatos( $_REQUEST[ 'login' ],$_REQUEST[ 'idgroup' ] );
		new USUARIOS_GRUPO_SHOWCURRENT( $valores );
		break;
	default:
		if ( !$_POST ) {
			$USUARIOS_GRUPO = new USUARIOS_GRUPO_Model( '', '');
		} else {
			$USUARIOS_GRUPO = get_data_form();
		}
		$datos = $USUARIOS_GRUPO->SEARCH();
		$lista = array(  'login','idgroup' );
		new USUARIOS_GRUPO_SHOWALL( $lista, $datos );
}


?>