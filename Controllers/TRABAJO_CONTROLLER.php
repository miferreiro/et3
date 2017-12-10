<?php
/*
	Archivo php
	Nombre: TRABAJO_CONTROLLER.php
	Autor: 	miferreiro
	Fecha de creación: 26/11/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/

session_start();//solicito trabajar con la sesión

include '../Models/TRABAJO_MODEL.php';
include '../Views/TRABAJO/TRABAJO_SHOWALL_View.php';
include '../Views/TRABAJO/TRABAJO_SEARCH_View.php';
include '../Views/TRABAJO/TRABAJO_ADD_View.php';
include '../Views/TRABAJO/TRABAJO_EDIT_View.php';
include '../Views/TRABAJO/TRABAJO_DELETE_View.php';
include '../Views/TRABAJO/TRABAJO_SHOWCURRENT_View.php';
include '../Views/MESSAGE_View.php';

function get_data_form(){
	
	
	$IdTrabajo = $_REQUEST['IdTrabajo'];
	$NombreTrabajo = $_REQUEST['NombreTrabajo'];
	$FechaIniTrabajo = $_REQUEST['FechaIniTrabajo'];
	$FechaFinTrabajo = $_REQUEST['FechaFinTrabajo'];
    $PorcentajeNota = $_REQUEST['PorcentajeNota'];
	$action= $_REQUEST['action'];
	
	$TRABAJO = new TRABAJO(
		$IdTrabajo,
		$NombreTrabajo,
		$FechaIniTrabajo,
		$FechaFinTrabajo,
        $PorcentajeNota
	);
	
	return $TRABAJO;
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			new TRABAJO_ADD();
		} else {
			$TRABAJO = get_data_form();
			$respuesta = $TRABAJO->ADD();
			new MESSAGE( $respuesta, '../Controllers/TRABAJO_CONTROLLER.php' );
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			$TRABAJO = new TRABAJO( $_REQUEST[ 'IdTrabajo' ], '', '', '','');
			$valores = $TRABAJO->RellenaDatos( $_REQUEST[ 'IdTrabajo' ]);
			new TRABAJO_DELETE( $valores );
		} else {
			$TRABAJO = get_data_form();
			$respuesta = $TRABAJO->DELETE();
			new MESSAGE( $respuesta, '../Controllers/TRABAJO_CONTROLLER.php' );
		}
		break;
	case 'EDIT':
		if ( !$_POST ) {
			$TRABAJO = new TRABAJO( $_REQUEST[ 'IdTrabajo' ], '', '', '','');
			$valores = $TRABAJO->RellenaDatos( $_REQUEST[ 'IdTrabajo' ] );
			new TRABAJO_EDIT( $valores );
		} else {
			$TRABAJO = get_data_form();
			$respuesta = $TRABAJO->EDIT();
			new MESSAGE( $respuesta, '../Controllers/TRABAJO_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
			new TRABAJO_SEARCH();
		} else {
			$TRABAJO = get_data_form();
			$datos = $TRABAJO->SEARCH();
			$lista = array( 'IdTrabajo','NombreTrabajo','FechaIniTrabajo','FechaFinTrabajo','PorcentajeNota' );
			new TRABAJO_SHOWALL( $lista, $datos );
		}
		break;
    case 'SHOWCURRENT':
		$TRABAJO = new TRABAJO( $_REQUEST[ 'IdTrabajo' ], '', '', '','');
		$valores = $TRABAJO->RellenaDatos( $_REQUEST[ 'IdTrabajo' ] );
		new TRABAJO_SHOWCURRENT( $valores );
		break;
	default:
		if ( !$_POST ) {
			$TRABAJO = new TRABAJO('','','','','');
		} 
        else {
			$TRABAJO = get_data_form();
		}
		$datos = $TRABAJO->SEARCH();
		$lista = array( 'IdTrabajo','NombreTrabajo','FechaIniTrabajo','FechaFinTrabajo','PorcentajeNota' );
		new TRABAJO_SHOWALL( $lista, $datos );
}

?>