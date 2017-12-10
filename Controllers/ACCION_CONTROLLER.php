<?php
/*
	Archivo php
	Nombre: ACCION_CONTROLLER.php
	Autor: 	miferreiro
	Fecha de creación: 26/11/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/

session_start();//solicito trabajar con la sesión

include '../Models/ACCION_MODEL.php';
include '../Models/USU_GRUPO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Views/ACCION/ACCION_SHOWALL_View.php';
include '../Views/ACCION/ACCION_SEARCH_View.php';
include '../Views/ACCION/ACCION_ADD_View.php';
include '../Views/ACCION/ACCION_EDIT_View.php';
include '../Views/ACCION/ACCION_DELETE_View.php';
include '../Views/ACCION/ACCION_SHOWCURRENT_View.php';
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php';

function get_data_form(){
	
	
	$IdAccion = $_REQUEST['IdAccion'];
	$NombreAccion = $_REQUEST['NombreAccion'];
	$DescripAccion = $_REQUEST['DescripAccion'];
	$action= $_REQUEST['action'];
	
	$ACCION = new ACCION(
		$IdAccion,
		$NombreAccion,
		$DescripAccion
	);
	
	return $ACCION;
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			//Crea una nueva vista del formulario añadir
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
				new ACCION_ADD();
			}else{
            $cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='5'){
				if($fila['IdAccion']=='0'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont==1){
			new ACCION_ADD();
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ACCION_CONTROLLER.php' );
		}
			}
		} else {
			$ACCION = get_data_form();
			$respuesta = $ACCION->ADD();
			new MESSAGE( $respuesta, '../Controllers/ACCION_CONTROLLER.php' );
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			//Crea una nueva vista del formulario borrar
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
			$ACCION = new ACCION( $_REQUEST[ 'IdAccion' ], '', '');
			$valores = $ACCION->RellenaDatos( $_REQUEST[ 'IdAccion' ]);
			$dependencias = $ACCION->dependencias( $_REQUEST[ 'IdAccion' ]);
			new ACCION_DELETE( $valores, $dependencias );
			}else{
            $cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='5'){
				if($fila['IdAccion']=='1'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont==1){
			$ACCION = new ACCION( $_REQUEST[ 'IdAccion' ], '', '');
			$valores = $ACCION->RellenaDatos( $_REQUEST[ 'IdAccion' ]);
			$dependencias = $ACCION->dependencias( $_REQUEST[ 'IdAccion' ]);
			new ACCION_DELETE( $valores, $dependencias );
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ACCION_CONTROLLER.php' );
		}
			}

		} else {
			$ACCION = get_data_form();
			$respuesta = $ACCION->DELETE();
			new MESSAGE( $respuesta, '../Controllers/ACCION_CONTROLLER.php' );
		}
		break;
	case 'EDIT':
		if ( !$_POST ) {
						//Crea una nueva vista del formulario editar
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
			$ACCION = new ACCION( $_REQUEST[ 'IdAccion' ], '', '');
			$valores = $ACCION->RellenaDatos( $_REQUEST[ 'IdAccion' ] );
			new ACCION_EDIT( $valores );
			}else{
            $cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='5'){
				if($fila['IdAccion']=='2'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont==1){
			$ACCION = new ACCION( $_REQUEST[ 'IdAccion' ], '', '');
			$valores = $ACCION->RellenaDatos( $_REQUEST[ 'IdAccion' ] );
			new ACCION_EDIT( $valores );
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ACCION_CONTROLLER.php' );
		}
			}

		} else {
			$ACCION = get_data_form();
			$respuesta = $ACCION->EDIT();
			new MESSAGE( $respuesta, '../Controllers/ACCION_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		
		$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
		if ( !$_POST ) {
			
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
				new ACCION_SEARCH();
			}else{
            $cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='5'){
				if($fila['IdAccion']=='3'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont==1){
			new ACCION_SEARCH();
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ACCION_CONTROLLER.php' );
		}
			}
		} else {
			$PERMISO = $USUARIO->comprobarPermisos();
			$ACCION = get_data_form();
			$datos = $ACCION->SEARCH();
			$lista = array( 'IdAccion','NombreAccion','DescripAccion' );
			new ACCION_SHOWALL( $lista, $datos,$PERMISO,true );
		}
		break;
	case 'SHOWCURRENT':
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
			$ACCION= new ACCION( $_REQUEST[ 'IdAccion' ], '', '');
		    $valores = $ACCION->RellenaDatos( $_REQUEST[ 'IdAccion' ] );
		    new ACCION_SHOWCURRENT( $valores );
			}else{
            $cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='5'){
				if($fila['IdAccion']=='4'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont==1){
		    $ACCION= new ACCION( $_REQUEST[ 'IdAccion' ], '', '');
		    $valores = $ACCION->RellenaDatos( $_REQUEST[ 'IdAccion' ] );
		    new ACCION_SHOWCURRENT( $valores );
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ACCION_CONTROLLER.php' );
		}
			}
		break;
	default:

		$USUARIO = new USU_GRUPO(  $_SESSION[ 'login' ], '', '', '', '', '', '', '','');
		$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
				if ( !$_POST ) {//Si no se han recibido datos 
			$ACCION = new ACCION( '', '', '');
		//Si se reciben datos
		} else {
			$ACCION = get_data_form();
		}
		//Variable que almacena los datos de la busqueda
		$datos = $ACCION->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array('IdAccion','NombreAccion','DescripAccion');
		$PERMISO = $USUARIO->comprobarPermisos();
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new ACCION_SHOWALL( $lista, $datos,$PERMISO,true);
			}else{
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
            $cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='5'){
				if($fila['IdAccion']=='5'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont==1){
		if ( !$_POST ) {//Si no se han recibido datos 
			$ACCION = new ACCION( '', '', '','');
		//Si se reciben datos
		} else {
			$GACCION = get_data_form();
		}
		//Variable que almacena los datos de la busqueda
		$datos = $ACCION->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array( 'IdAccion','NombreAccion','DescripAccion');
		$PERMISO = $USUARIO->comprobarPermisos();
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new ACCION_SHOWALL( $lista, $datos,$PERMISO,false);
		}else{
		 new USUARIO_DEFAULT();
		}
			}
}

?>