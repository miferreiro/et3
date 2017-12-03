<?php
/*
	Archivo php
	Nombre: PERMISO_CONTROLLER.php
	Autor: 	miferreiro
	Fecha de creación: 25/11/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/

session_start();//solicito trabajar con la sesión

include '../Models/PERMISO_MODEL.php';
include '../Views/PERMISO_SHOWALL_View.php';
include '../Views/PERMISO_SEARCH_View.php';
include '../Views/PERMISO_ADD_View.php';
include '../Views/PERMISO_DELETE_View.php';
include '../Views/PERMISO_SHOWCURRENT_View.php';
include '../Views/MESSAGE_View.php';

function get_data_form(){
	
	
	$IdGrupo = $_REQUEST['IdGrupo'];
	$IdFuncionalidad = $_REQUEST['IdFuncionalidad'];
	$IdAccion = $_REQUEST['IdAccion'];
	$action= $_REQUEST['action'];
	
	$PERMISO = new PERMISO_MODEL(
		$IdGrupo,
		$IdFuncionalidad,
		$IdAccion
	);
	
	return $PERMISO;
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			$PERMISO = new PERMISO_MODEL( '', '', '');
			$Grupo = $PERMISO->recuperarGrupo($_REQUEST['IdGrupo']);
			$Funcionalidades = $PERMISO->recuperarFuncionalidades();
			new PERMISO_ADD($Grupo,$Funcionalidades);
		} else {
			$PERMISO = get_data_form();
			if($PERMISO->IdFuncionalidad == ""){
				new MESSAGE( 'Error: Funcionalidad no existente', '../Controllers/GRUPO_CONTROLLER.php' );
			} else {
				$porciones = explode(",", $_REQUEST['IdFuncionalidad']);
				$PERMISO->IdFuncionalidad = $porciones[0];
				if(strlen($_REQUEST['IdFuncionalidad'] > 0)){
					$PERMISO->IdAccion = $porciones[1];
				}
				$respuesta = $PERMISO->ADD();
				new MESSAGE( $respuesta, '../Controllers/GRUPO_CONTROLLER.php' );
			}
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			$PERMISO = new PERMISO_MODEL( $_REQUEST[ 'IdGrupo' ], $_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ] );
			$valores = $PERMISO->RellenaDatos( $_REQUEST[ 'IdGrupo' ], $_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ]  );
			new PERMISO_DELETE( $valores );
		} else {
			$PERMISO = get_data_form();
			$respuesta = $PERMISO->DELETE();
			new MESSAGE( $respuesta, '../Controllers/PERMISO_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
			new PERMISO_SEARCH();
		} else {
			$PERMISO = get_data_form();
			$datos = $PERMISO->SEARCH();
			$lista = array( 'IdGrupo','IdFuncionalidad','IdAccion' );
			new PERMISO_SHOWALL( $lista, $datos );
		}
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		//Variable que almacena un objeto model con el IdGrupo
		$PERMISO = new PERMISO_MODEL( $_REQUEST[ 'IdGrupo' ], $_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ] );
		//Variable que almacena los valores rellenados a traves de IdGrupo
		$valores = $PERMISO->RellenaDatos( $_REQUEST[ 'IdGrupo' ], $_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ]  );
		//Creación de la vista showcurrent
		new PERMISO_SHOWCURRENT( $valores );
		//Final del bloque
		break;
	default:
		if ( !$_POST ) {
			$PERMISO = new PERMISO_MODEL( '', '', '');
		} else {
			$PERMISO = get_data_form();
		}
		$datos = $PERMISO->SEARCH();
		$lista = array( 'IdGrupo','IdFuncionalidad','IdAccion' );
		new PERMISO_SHOWALL( $lista, $datos );
}


?>