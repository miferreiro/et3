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
include '../Models/USU_GRUPO_MODEL.php'; //incluye el contendio del modelo usuarios_grupo
include '../Models/GRUPO_MODEL.php'; //incluye el contendio del modelo de grupo
include '../Models/FUNCIONALIDAD_MODEL.php'; //incluye el contendio del modelo funcionalidad
include '../Views/PERMISO/PERMISO_SEARCH_View.php';
include '../Views/PERMISO/PERMISO_SHOWALL_View.php';
include '../Views/PERMISO/PERMISO_ADD_View.php';
include '../Views/PERMISO/PERMISO_ASSIGN_View.php';
include '../Views/PERMISO/PERMISO_DELETE_View.php';
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
	case 'ADD':
		if ( !$_POST ) { // si no existe dolar POST  se muestra la vista ADD de USU_GRUPO
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
				$GRUPO = new GRUPO( '', '', '');
				$PERMISO = new PERMISO_MODEL( $_REQUEST['IdGrupo'], '', '', '', '', '');
				$FUNCIONALIDAD = new FUNCIONALIDAD( '', '', '');

			    $DatosGrupo= $GRUPO->recuperarGrupo($_REQUEST['IdGrupo']);
				$Funcionalidad_accion= $FUNCIONALIDAD->recuperarFuncionalidades();
				
				new PERMISO_ADD($DatosGrupo,$Funcionalidad_accion);
			}else{
	            $cont=0;
				$PERMISO = $USUARIO->comprobarPermisos();
				while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
				if($fila['IdFuncionalidad']=='2'){
					if($fila['IdAccion']=='6'){
				    //Crea una vista add para ver la tupla
				     $cont=$cont+1;
					}
				   } 
				}
				if($cont==1){
					$GRUPO = new GRUPO( '', '', '');
					$PERMISO = new PERMISO_MODEL( $_REQUEST['IdGrupo'], '', '', '', '', '');
					$FUNCIONALIDAD = new FUNCIONALIDAD( '', '', '');
				    $DatosGrupo= $GRUPO->recuperarGrupo($_REQUEST['IdGrupo']);
					$Funcionalidad_accion= $FUNCIONALIDAD->recuperarFuncionalidades();
					new PERMISO_ADD($_REQUEST['IdGrupo'],$Funcionalidad_accion);
				} else {
					new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
				}
			}
		} else { // si existe dolar POST
			$PERMISO = get_data_form();// se pasa a la variable USU_GRUPO un objeto del modelo USU_GRUPO
			if($_REQUEST['IdFuncionalidad'] == ','){
				$at = "?IdGrupo=".$_REQUEST['IdGrupo']."&action=ASSIGN";
				new MESSAGE( 'No hay funcionalidad-accion disponible', "../Controllers/GRUPO_CONTROLLER.php" . $at );//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
			}
			else{
				$Porciones = explode(',',$_REQUEST['IdFuncionalidad']);
				$PERMISO->IdFuncionalidad = $Porciones[0];
				if (strlen($_REQUEST['IdFuncionalidad']) > 0) {
					$PERMISO->IdAccion = $Porciones[1];
				}
				$respuesta = $PERMISO->ADD();//obtenemos la respuesta que viene del método ADD() de la clase USU_GRUPO
				$at = "?IdGrupo=".$_REQUEST['IdGrupo']."&action=ASSIGN";
				new MESSAGE( $respuesta, "../Controllers/PERMISO_CONTROLLER.php" . $at );//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
			}
		}
		break;
	case 'DELETE':
		if ( !$_POST ) { // si no existe dolar POST  se muestra la vista ADD de USU_GRUPO
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
				$PERMISO = new PERMISO_MODEL( $_REQUEST['IdGrupo'], $_REQUEST['IdFuncionalidad'], $_REQUEST['IdAccion'], '', '', '');
				$datos = $PERMISO->RellenaDatos();
				$lista = array('NombreGrupo','NombreFuncionalidad','NombreAccion');
				new PERMISO_DELETE($datos,$lista);
			}else{
	            $cont=0;
				$PERMISO = $USUARIO->comprobarPermisos();
				while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
				if($fila['IdFuncionalidad']=='2'){
					if($fila['IdAccion']=='6'){
				    //Crea una vista add para ver la tupla
				     $cont=$cont+1;
					}
				   } 
				}
				if($cont==1){
					$PERMISO = new PERMISO_MODEL( $_REQUEST['IdGrupo'], $_REQUEST['IdFuncionalidad'], $_REQUEST['IdAccion'], '', '', '');
					$lista = array('NombreGrupo','NombreFuncionalidad','NombreAccion');
				new PERMISO_DELETE($datos,$lista);
				} else {
					new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
				}
			}
		} else { // si existe dolar POST
			$PERMISO = get_data_form();// se pasa a la variable USU_GRUPO un objeto del modelo USU_GRUPO
			if($_REQUEST['IdFuncionalidad'] == ','){
				$at = "?IdGrupo=".$_REQUEST['IdGrupo']."&action=ASSIGN";
				new MESSAGE( 'No hay funcionalidad-accion disponible', "../Controllers/GRUPO_CONTROLLER.php" . $at );//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
			}
			else{
				$PERMISO = get_data_form();
				$respuesta = $PERMISO->DELETE();//obtenemos la respuesta que viene del método ADD() de la clase USU_GRUPO
				$at = "?IdGrupo=".$_REQUEST['IdGrupo']."&action=ASSIGN";
				new MESSAGE( $respuesta, "../Controllers/PERMISO_CONTROLLER.php" . $at );//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
			}
		}
		break;
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
				if($fila['IdFuncionalidad']=='5'){
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
			$DatosGrupo= $PERMISO->recuperarGrupo('');
			$lista = array( 'NombreGrupo','NombreFuncionalidad','NombreAccion' );
			new PERMISO_SHOWALL( $lista, $datos, $DatosGrupo );
		}
		break;
	case 'ASSIGN':
		$USUARIO = new USU_GRUPO(  $_SESSION[ 'login' ], '', '', '', '', '', '', '','');
		$ADMIN = $USUARIO->comprobarAdmin();
		if($ADMIN == true){
			if ( !$_POST ) {//Si no se han recibido datos 
				$PERMISO = new PERMISO_MODEL($_REQUEST['IdGrupo'], '', '', '','','');
				//Si se reciben datos
			} else {
				$PERMISO = new PERMISO_MODEL($_REQUEST['IdGrupo'], '', '', '','','');
			}
			//Variable que almacena los datos de la busqueda
			$datos = $PERMISO->SEARCH();
			$GRUPO = new GRUPO( '', '', '');
			$DatosGrupo= $GRUPO->recuperarGrupo($_REQUEST['IdGrupo']);
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'NombreGrupo','NombreFuncionalidad','NombreAccion');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new PERMISO_ASSIGN( $lista, $datos, $DatosGrupo );
		}else{
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
            $cont=0;
			$ACL = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $ACL ) ) {
			if($fila['IdFuncionalidad']=='2'){
				if($fila['IdAccion']=='6'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
		if($cont==1){
			if ( !$_POST ) {
				$PERMISO = new PERMISO_MODEL( $_REQUEST['IdGrupo'], '', '', '', '', '');
			} else {
				$PERMISO = new PERMISO_MODEL( $_REQUEST['IdGrupo'], '', '', '', '', '');
			}
			$datos = $PERMISO->SEARCH();
			$GRUPO = new GRUPO( '', '', '');
			$DatosGrupo= $GRUPO->recuperarGrupo($_REQUEST['IdGrupo']);
			$lista = array( 'NombreGrupo','NombreFuncionalidad','NombreAccion' );
			new PERMISO_ASSIGN( $lista, $datos, $DatosGrupo );
		}else{
		 	new USUARIO_DEFAULT();
		}
	}											
	break;
	default:
		$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ], '', '', '', '', '', '', '','');
		$ADMIN = $USUARIO->comprobarAdmin();
		if($ADMIN == true){
			if ( !$_POST ) {//Si no se han recibido datos 
				$PERMISO = new PERMISO_MODEL('', '', '', '','','');
				//Si se reciben datos
			} else {
				$PERMISO = new PERMISO_MODEL('', '', '', '','','');
			}
			$GRUPO = new GRUPO( '', '', '');
			//Variable que almacena los datos de la busqueda
			$datos = $PERMISO->SEARCH2();
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'NombreGrupo','NombreFuncionalidad','NombreAccion');
			$DatosGrupo= $GRUPO->recuperarGrupo('');
			$ACL = $USUARIO->comprobarPermisos();
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new PERMISO_SHOWALL( $lista, $datos, $DatosGrupo, $ACL ,true);
		}else{
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
            $cont=0;
			$ACL = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $ACL ) ) {
			if($fila['IdFuncionalidad']=='5'){
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
				$PERMISO = new PERMISO_MODEL( '', '', '', '', '', '');
			}
			$datos = $PERMISO->SEARCH2();
			$GRUPO = new GRUPO( '', '', '');
			$DatosGrupo= $GRUPO->recuperarGrupo($_REQUEST['IdGrupo']);
			$lista = array( 'NombreGrupo','NombreFuncionalidad','NombreAccion' );
			$ACL = $USUARIO->comprobarPermisos();
			new PERMISO_SHOWALL( $lista, $datos, $DatosGrupo,$ACL,false);
		}else{
		 	new USUARIO_DEFAULT();
		}
	}

		
}


?>

