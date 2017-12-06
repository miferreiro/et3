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
include '../Models/USU_GRUPO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Views/PERMISO_SEARCH_View.php';
include '../Views/PERMISO_SHOWALL_View.php';
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php';

function get_data_form(){
	
	
	$IdGrupo = $_REQUEST['IdGrupo'];
	$IdFuncionalidad = $_REQUEST['IdFuncionalidad'];
	$IdAccion = $_REQUEST['IdAccion'];

	$NombreGrupo = $_REQUEST['NombreGrupo'];
	$NombreFuncionalidad = $_REQUEST['NombreFuncionalidad'];
	$NombreAccion = $_REQUEST['NombreAccion'];

	$action= $_REQUEST['action'];
	
	$PERMISO = new PERMISO_MODEL(
		$IdGrupo,
		$IdFuncionalidad,
		$IdAccion,

		$NombreGrupo,
		$NombreFuncionalidad,
		$NombreAccion
	);
	
	return $PERMISO;
}

if ( !isset( $_REQUEST[ 'IdGrupo' ] ) ) {
	$_REQUEST[ 'IdGrupo' ] = '';
}

if ( !isset( $_REQUEST[ 'IdFuncionalidad' ] ) ) {
	$_REQUEST[ 'IdFuncionalidad' ] = '';
}

if ( !isset( $_REQUEST[ 'IdAccion' ] ) ) {
	$_REQUEST[ 'IdAccion' ] = '';
}

if ( !isset( $_REQUEST[ 'NombreGrupo' ] ) ) {
	$_REQUEST[ 'NombreGrupo' ] = '';
}

if ( !isset( $_REQUEST[ 'NombreFuncionalidad' ] ) ) {
	$_REQUEST[ 'NombreFuncionalidad' ] = '';
}

if ( !isset( $_REQUEST[ 'NombreAccion' ] ) ) {
	$_REQUEST[ 'NombreAccion' ] = '';
}

if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'SEARCH':
		if ( !$_POST ) {
			//Crea una nueva vista del formulario añadir
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
				new PERMISO_SEARCH();
			}else{
            $cont=0;
			$ACL = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $ACL) ) {
			if($fila['IdFuncionalidad']=='3'){
				if($fila['IdAccion']=='3'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont==1){
			new PERMISO_SEARCH();
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/PERMISO_CONTROLLER.php' );
		}
			};
		} else {
			$PERMISO = get_data_form();
			$datos = $PERMISO->SEARCH2();
			$lista = array( 'NombreGrupo','NombreFuncionalidad','NombreAccion' );
			new PERMISO_SHOWALL( $lista, $datos );
		}
		break;
	default:

		$USUARIO = new USU_GRUPO(  $_SESSION[ 'login' ], '', '', '', '', '', '', '','');
		$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
				if ( !$_POST ) {//Si no se han recibido datos 
			$USUARIO = new PERMISO_MODEL( '', '', '', '','','');
		//Si se reciben datos
		} else {
			$USUARIO = get_data_form();
		}
		//Variable que almacena los datos de la busqueda
		$datos = $USUARIO->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array( 'NombreGrupo','NombreFuncionalidad','NombreAccion');
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new PERMISO_SHOWALL( $lista, $datos );
			}else{
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
            $cont=0;
			$ACL = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $ACL ) ) {
			if($fila['IdFuncionalidad']=='3'){
				if($fila['IdAccion']=='5'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont==1){
		if ( !$_POST ) {
			$PERMISO = new PERMISO_MODEL( '', '', '', '', '', '');
		} else {
			$PERMISO = get_data_form();
		}
		$datos = $PERMISO->SEARCH();
		$lista = array( 'NombreGrupo','NombreFuncionalidad','NombreAccion' );
		new PERMISO_SHOWALL( $lista, $datos );
		}else{
		 new USUARIO_DEFAULT();
		}
			}

		
}


?>

