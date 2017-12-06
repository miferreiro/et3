<?php
/*
	Archivo php
	Nombre: FUNC_ACCION_CONTROLLER.php
	Autor: 	miferreiro
	Fecha de creación: 27/11/2017 
	Función: controlador que realiza las FUNC_ACCION, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/

session_start();//solicito trabajar con la sesión

include '../Models/FUNC_ACCION_MODEL.php';
include '../Views/FUNC_ACCION_SHOWALL_View.php';
include '../Views/FUNC_ACCION_SEARCH_View.php';
include '../Views/FUNC_ACCION_ADD_View.php';
include '../Views/FUNC_ACCION_DELETE_View.php';
include '../Views/FUNC_ACCION_SHOWCURRENT_View.php';
include '../Views/MESSAGE_View.php';

function get_data_form(){
	
	
	$IdFuncionalidad = $_REQUEST['IdFuncionalidad'];
	$IdAccion = $_REQUEST['IdAccion'];
	
	$FUNC_ACCION = new FUNC_ACCION(
		$IdFuncionalidad,
		$IdAccion
	);
	
	return $FUNC_ACCION;
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			new FUNC_ACCION_ADD();
		} else {
			$FUNC_ACCION = get_data_form();
			$respuesta = $FUNC_ACCION->ADD();
			new MESSAGE( $respuesta, '../Controllers/FUNC_ACCION_CONTROLLER.php' );
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			$FUNC_ACCION = new FUNC_ACCION( $_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ]);
			$valores = $FUNC_ACCION->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ]);
            $dependencias = $FUNC_ACCION->dependencias($_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ]);
			new FUNC_ACCION_DELETE( $valores, $dependencias );
		} else {
			$FUNC_ACCION = get_data_form();
			$respuesta = $FUNC_ACCION->DELETE();
			new MESSAGE( $respuesta, '../Controllers/FUNC_ACCION_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
			new FUNC_ACCION_SEARCH();
		} else {
			$FUNC_ACCION = get_data_form();
			$datos = $FUNC_ACCION->SEARCH();
			$lista = array( 'IdFuncionalidad','IdAccion' );
			new FUNC_ACCION_SHOWALL( $lista, $datos );
		}
		break;
	default:
		if ( !$_POST ) {
			$FUNC_ACCION = new FUNC_ACCION( '', '', '');
		} else {
			$FUNC_ACCION = get_data_form();
		}
		$datos = $FUNC_ACCION->SEARCH();
		$lista = array( 'IdFuncionalidad','IdAccion' );
		new FUNC_ACCION_SHOWALL( $lista, $datos );
}

?>