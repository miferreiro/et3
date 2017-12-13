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
include '../Functions/permisosAcc.php';
include '../Views/HISTORIA/HISTORIA_SHOWALL_View.php';
include '../Views/HISTORIA/HISTORIA_SEARCH_View.php';
include '../Views/HISTORIA/HISTORIA_ADD_View.php';
include '../Views/HISTORIA/HISTORIA_EDIT_View.php';
include '../Views/HISTORIA/HISTORIA_DELETE_View.php';
include '../Views/HISTORIA/HISTORIA_SHOWCURRENT_View.php';
include '../Views/DEFAULT_View.php';
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
			if(permisosAcc($_SESSION['login'],10,0)==true){			
			new HISTORIA_ADD();
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/TRABAJO_CONTROLLER.php' );
			}
		} else {
			$HISTORIA = get_data_form();
			$respuesta = $HISTORIA->ADD();
			new MESSAGE( $respuesta, '../Controllers/HISTORIA_CONTROLLER.php' );
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			if(permisosAcc($_SESSION['login'],10,1)==true){
			$HISTORIA = new HISTORIA_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'IdHistoria' ], '');
			$valores = $HISTORIA->RellenaDatos( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'IdHistoria' ]);
			new HISTORIA_DELETE( $valores);
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/TRABAJO_CONTROLLER.php' );
			}
		} else {
			$HISTORIA = get_data_form();
			$respuesta = $HISTORIA->DELETE();
			new MESSAGE( $respuesta, '../Controllers/HISTORIA_CONTROLLER.php' );
		}
		break;
	case 'EDIT':
		if ( !$_POST ) {
			if(permisosAcc($_SESSION['login'],10,2)==true){
			$HISTORIA = new HISTORIA_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'IdHistoria' ], '');
			$valores = $HISTORIA->RellenaDatos( $_REQUEST[ 'IdTrabajo' ] ,$_REQUEST[ 'IdHistoria' ]);
			new HISTORIA_EDIT( $valores );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/TRABAJO_CONTROLLER.php' );
			}
		} else {
			$HISTORIA = get_data_form();
			$respuesta = $HISTORIA->EDIT();
			new MESSAGE( $respuesta, '../Controllers/HISTORIA_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
			if(permisosAcc($_SESSION['login'],10,3)==true){
			new HISTORIA_SEARCH();
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/TRABAJO_CONTROLLER.php' );
			}
		} else {
			$HISTORIA = get_data_form();
			$datos = $HISTORIA->SEARCH();
			$lista = array( 'IdTrabajo','IdHistoria','TextoHistoria' );
			new HISTORIA_SHOWALL( $lista, $datos );
		}
		break;
	case 'SHOWCURRENT':
	if(permisosAcc($_SESSION['login'],10,4)==true){
		$HISTORIA= new HISTORIA_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'IdHistoria' ], '');
		$valores = $HISTORIA->RellenaDatos( $_REQUEST[ 'IdTrabajo' ] ,$_REQUEST[ 'IdHistoria' ]);
		new HISTORIA_SHOWCURRENT( $valores );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/TRABAJO_CONTROLLER.php' );
			}
		break;
	default:
	if(permisosAcc($_SESSION['login'],10,5)==true){
		if ( !$_POST ) {
			$HISTORIA = new HISTORIA_MODEL( '', '', '');
		} else {
			$HISTORIA = get_data_form();
		}
		$datos = $HISTORIA->SEARCH();
		$lista = array( 'IdTrabajo','IdHistoria','TextoHistoria' );
		new HISTORIA_SHOWALL( $lista, $datos );
			}else{
				new USUARIO_DEFAULT();
			}
}

?>