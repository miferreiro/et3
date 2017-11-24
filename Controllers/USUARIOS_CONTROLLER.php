<?php
/*
	Archivo php
	Nombre: USUARIOS_CONTROLLER.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/
session_start(); //solicito trabajar con la session

include '../Models/USUARIOS_MODEL.php';
include '../Views/USUARIOS_SHOWALL_View.php';
include '../Views/USUARIOS_SEARCH_View.php';
include '../Views/USUARIOS_ADD_View.php';
include '../Views/USUARIOS_EDIT_View.php';
include '../Views/USUARIOS_DELETE_View.php';
include '../Views/USUARIOS_SHOWCURRENT_View.php';
include '../Views/MESSAGE_View.php';


function get_data_form() {

	$login = $_REQUEST[ 'login' ];
	$password = $_REQUEST[ 'password' ];
	$nombre = $_REQUEST[ 'nombre' ];
	$apellidos = $_REQUEST[ 'apellidos' ];
	$email = $_REQUEST[ 'email' ];
	$action = $_REQUEST[ 'action' ];

	$USUARIOS = new USUARIOS_Model(
		$login,
		$password,
		$nombre,
		$apellidos,
		$email,
	);

	return $USUARIOS;
}

if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			new USUARIOS_ADD();
		} else {
			$USUARIOS = get_data_form();
			$respuesta = $USUARIOS->ADD();
			new MESSAGE( $respuesta, '../Controllers/USUARIOS_CONTROLLER.php' );
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			$USUARIOS = new USUARIOS_Model( $_REQUEST[ 'login' ], '', '', '', '');
			$valores = $USUARIOS->RellenaDatos( $_REQUEST[ 'login' ] );
			new USUARIOS_DELETE( $valores );
		} else {
			$USUARIOS = get_data_form();
			$respuesta = $USUARIOS->DELETE();
			new MESSAGE( $respuesta, '../Controllers/USUARIOS_CONTROLLER.php' );
		}
		break;
	case 'EDIT':
		if ( !$_POST ) {

			$USUARIOS = new USUARIOS_Model( $_REQUEST[ 'login' ], '', '', '', '');
			$valores = $USUARIOS->RellenaDatos( $_REQUEST[ 'login' ] );
			new USUARIOS_EDIT( $valores );
		} else {

			$USUARIOS = get_data_form();
			$respuesta = $USUARIOS->EDIT();
			new MESSAGE( $respuesta, '../Controllers/USUARIOS_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
			new USUARIOS_SEARCH();
		} else {
			$USUARIOS = get_data_form();
			$datos = $USUARIOS->SEARCH();
			$lista = array( 'login','nombre','apellidos','email');
			new USUARIOS_SHOWALL( $lista, $datos );
		}
		break;
	case 'SHOWCURRENT':
		$USUARIOS = new USUARIOS_Model( $_REQUEST[ 'login' ], '', '', '', '');
		$valores = $USUARIOS->RellenaDatos( $_REQUEST[ 'login' ] );
		new USUARIOS_SHOWCURRENT( $valores );
		break;
	default:
		if ( !$_POST ) {
			$USUARIOS = new USUARIOS_Model( '', '', '', '', '');
		} else {
			$USUARIOS = get_data_form();
		}
		$datos = $USUARIOS->SEARCH();
		$lista = array(  'login','nombre','apellidos','email' );
		new USUARIOS_SHOWALL( $lista, $datos );
}

?>