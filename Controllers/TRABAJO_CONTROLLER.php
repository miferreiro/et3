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
include '../Functions/permisosAcc.php';
include '../Views/TRABAJO/TRABAJO_SHOWALL_View.php';
include '../Views/TRABAJO/TRABAJO_SEARCH_View.php';
include '../Views/TRABAJO/TRABAJO_ADD_View.php';
include '../Views/TRABAJO/TRABAJO_EDIT_View.php';
include '../Views/TRABAJO/TRABAJO_DELETE_View.php';
include '../Views/TRABAJO/TRABAJO_SHOWCURRENT_View.php';
include '../Views/DEFAULT_View.php';
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
			if(permisosAcc($_SESSION['login'],11,0)==true){
			new TRABAJO_ADD();
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/TRABAJO_CONTROLLER.php' );
			}
		} else {
			$TRABAJO = get_data_form();
			$respuesta = $TRABAJO->ADD();
			new MESSAGE( $respuesta, '../Controllers/TRABAJO_CONTROLLER.php' );
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			if(permisosAcc($_SESSION['login'],11,1)==true){
			$TRABAJO = new TRABAJO( $_REQUEST[ 'IdTrabajo' ], '', '', '','');
			$valores = $TRABAJO->RellenaDatos( $_REQUEST[ 'IdTrabajo' ]);
			$dependencias = $TRABAJO->dependencias( $_REQUEST[ 'IdTrabajo' ]);
			$dependencias2 = $TRABAJO->dependencias2( $_REQUEST[ 'IdTrabajo' ]);
			$dependencias3 = $TRABAJO->dependencias3( $_REQUEST[ 'IdTrabajo' ]);
			$dependencias4 = $TRABAJO->dependencias4( $_REQUEST[ 'IdTrabajo' ]);
			$dependencias5 = $TRABAJO->dependencias5( $_REQUEST[ 'IdTrabajo' ]);
			new TRABAJO_DELETE( $valores, $dependencias, $dependencias2, $dependencias3, $dependencias4, $dependencias5 );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/TRABAJO_CONTROLLER.php' );
			}				
		} else {
			$TRABAJO = get_data_form();
			$respuesta = $TRABAJO->DELETE();
			new MESSAGE( $respuesta, '../Controllers/TRABAJO_CONTROLLER.php' );
		}
		break;
	case 'EDIT':
		if ( !$_POST ) {
			if(permisosAcc($_SESSION['login'],11,2)==true){			
			$TRABAJO = new TRABAJO( $_REQUEST[ 'IdTrabajo' ], '', '', '','');
			$valores = $TRABAJO->RellenaDatos( $_REQUEST[ 'IdTrabajo' ] );
			new TRABAJO_EDIT( $valores );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/TRABAJO_CONTROLLER.php' );
			}
		} else {
			$TRABAJO = get_data_form();
			$respuesta = $TRABAJO->EDIT();
			new MESSAGE( $respuesta, '../Controllers/TRABAJO_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
			if(permisosAcc($_SESSION['login'],11,3)==true){
			new TRABAJO_SEARCH();
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/TRABAJO_CONTROLLER.php' );
			}
		} else {
			$TRABAJO = get_data_form();
			$datos = $TRABAJO->SEARCH();
			$lista = array( 'IdTrabajo','NombreTrabajo','FechaIniTrabajo','FechaFinTrabajo','PorcentajeNota' );
			new TRABAJO_SHOWALL( $lista, $datos );
		}
		break;
    case 'SHOWCURRENT':
			if(permisosAcc($_SESSION['login'],11,4)==true){
		$TRABAJO = new TRABAJO( $_REQUEST[ 'IdTrabajo' ], '', '', '','');
		$valores = $TRABAJO->RellenaDatos( $_REQUEST[ 'IdTrabajo' ] );
		new TRABAJO_SHOWCURRENT( $valores );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/TRABAJO_CONTROLLER.php' );
			}
		break;
	default:
	if(permisosAcc($_SESSION['login'],11,5)==true){
		if ( !$_POST ) {
			$TRABAJO = new TRABAJO('','','','','');
		} 
        else {
			$TRABAJO = get_data_form();
		}
		$datos = $TRABAJO->SEARCH();
		$lista = array( 'IdTrabajo','NombreTrabajo','FechaIniTrabajo','FechaFinTrabajo','PorcentajeNota' );
		new TRABAJO_SHOWALL( $lista, $datos );
			}else{
				new USUARIO_DEFAULT();
			}
}

?>