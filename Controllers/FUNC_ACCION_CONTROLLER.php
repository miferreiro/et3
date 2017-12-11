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
include '../Models/USU_GRUPO_MODEL.php';
include '../Models/ACCION_MODEL.php';
include '../Models/FUNCIONALIDAD_MODEL.php';
include '../Views/FUNC_ACCION/FUNC_ACCION_SHOWALL_View.php';
include '../Views/FUNC_ACCION/FUNC_ACCION_SEARCH_View.php';
include '../Views/FUNC_ACCION/FUNC_ACCION_ADD_View.php';
include '../Views/FUNC_ACCION/FUNC_ACCION_DELETE_View.php';
include '../Views/FUNC_ACCION/FUNC_ACCION_SHOWCURRENT_View.php';
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
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
		if ( !$_POST ) { // si no existe dolar POST  se muestra la vista ADD de USU_GRUPO
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
				$FUNC_ACCION = new FUNC_ACCION( $_REQUEST['IdFuncionalidad'], '');
			    $ACCION = new ACCION( '', '', '');
			    $acciones= $ACCION->DevolverAcciones();
				$FUNCIONALIDAD = new FUNCIONALIDAD( '', '', '');
				$DatosFuncionalidad = $FUNCIONALIDAD->DevolverDatosFuncionalidad($_REQUEST['IdFuncionalidad']);
				new FUNC_ACCION_ADD($DatosFuncionalidad,$acciones);
			}else{
	            $cont=0;
				$PERMISO = $USUARIO->comprobarPermisos();
				while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
				if($fila['IdFuncionalidad']=='3'){
					if($fila['IdAccion']=='6'){
				    //Crea una vista add para ver la tupla
				     $cont=$cont+1;
					}
				   } 
				}
				if($cont==1){
					$FUNC_ACCION = new FUNC_ACCION( $_REQUEST['IdFuncionalidad'], '');
				    $ACCION = new ACCION( '', '', '');
			    	$acciones= $ACCION->DevolverAcciones();
					$FUNCIONALIDAD = new FUNCIONALIDAD( '', '', '');
					$DatosFuncionalidad = $FUNCIONALIDAD->DevolverDatosFuncionalidad($_REQUEST['IdFuncionalidad']);
					new FUNC_ACCION_ADD($_REQUEST['IdFuncionalidad'],$acciones);
				} else {
					new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
				}
			}
		} else { // si existe dolar POST
			$FUNC_ACCION = get_data_form();// se pasa a la variable USU_GRUPO un objeto del modelo USU_GRUPO
			$respuesta = $FUNC_ACCION->ADD();//obtenemos la respuesta que viene del método ADD() de la clase USU_GRUPO
			$at = "?IdFuncionalidad=".$_REQUEST['IdFuncionalidad'];
			new MESSAGE( $respuesta, "../Controllers/FUNC_ACCION_CONTROLLER.php" . $at );//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
		}
		break;
	case 'DELETE':
		if ( !$_POST ) { // si no existe dolar POST  se muestra la vista DELETE  de USU_GRUPO con todos sus valores.
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
				$FUNC_ACCION = new FUNC_ACCION( $_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ] ); //en $USU se le pasará un login y un IdGrupo elegido en la vista de SHOWALL.
				$valores = $FUNC_ACCION->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ]);//con el método RellenaDatos pasaremos el valor de login y de IdGrupo
				new FUNC_ACCION_DELETE( $valores ); //se muestra la vista DELETE con el login y el IdGrupo.
			}else{
	            $cont=0;
				$PERMISO = $USUARIO->comprobarPermisos();
				while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
				if($fila['IdFuncionalidad']=='3'){
					if($fila['IdAccion']=='6'){
				    //Crea una vista add para ver la tupla
				     $cont=$cont+1;
					}
				   } 
				}
				if($cont==1){
					$FUNC_ACCION = new FUNC_ACCION( $_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ] ); //en $USU se le pasará un login y un IdGrupo elegido en la vista de SHOWALL.
					$valores = $FUNC_ACCION->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ]);//con el método RellenaDatos pasaremos el valor de login y de IdGrupo
					new FUNC_ACCION_DELETE( $valores ); //se muestra la vista DELETE con el login y el IdGrupo.
				}else{
				
				new MESSAGE( 'El usuario no tiene los permisos necesarios', "../Controllers/FUNCIONALIDAD_CONTROLLER.php" );//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
			}
			}			

		} else {//si existe dolar POST
			$USU_GRUPO = get_data_form(); // se le pasa a la variable $USU el login y IdGrupo a eliminar
			$respuesta = $USU_GRUPO->DELETE(); // con el método DELETE de USU_GRUPO se elimna ese login y 
			$at = "?IdFuncionalidad=".$_REQUEST['IdFuncionalidad'];
			new MESSAGE( $respuesta, "../Controllers/FUNC_ACCION_CONTROLLER.php" . $at );//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
		}
		break;
	default:
		$USER = new USU_GRUPO(  $_SESSION[ 'login' ],'');
		$ADMIN = $USER->comprobarAdmin();
		if($ADMIN == true){
			if ( !$_POST ) {
				$FUNC_ACCION = new FUNC_ACCION( $_REQUEST['IdFuncionalidad'], '');
			} else {
				$FUNC_ACCION = new FUNC_ACCION( $_REQUEST['IdFuncionalidad'], '');
				//$FUNC_ACCION = get_data_form();
			}
			$FUNCIONALIDAD = new FUNCIONALIDAD( '', '', '');
			$DatosFuncionalidad = $FUNCIONALIDAD->DevolverDatosFuncionalidad($_REQUEST['IdFuncionalidad']);
			$datos = $FUNC_ACCION->SEARCH();
			$lista = array( 'NombreFuncionalidad','NombreAccion' );
			new FUNC_ACCION_SHOWALL( $lista, $datos, $DatosFuncionalidad );
		} else {
			$cont = 0;
			$PERMISO = $USER->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {

			if($fila['IdFuncionalidad']=='3'){
				if($fila['IdAccion']=='6'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont>=1){
				if ( !$_POST ) {//si ni existe dolar POST
					//se crea una instancia de la clase FUN_ACCION con parametros vacíos para que nos coga todas las tuplas de la base de datos.
					$FUNC_ACCION = new FUNC_ACCION( $_REQUEST['IdFuncionalidad'], '');
				} else {//si existe dolar POST
					//a la variable USU_GRUPO se le pasa el login y IdGrupo vacío.
					$FUNC_ACCION = new FUNC_ACCION($_REQUEST['IdFuncionalidad'],'');
				}
				$FUNCIONALIDAD = new FUNCIONALIDAD( '', '', '');
				$DatosFuncionalidad = $FUNCIONALIDAD->DevolverDatosFuncionalidad($_REQUEST['IdFuncionalidad']);

				$datos = $FUNC_ACCION->SEARCH();//con el método SEARCH en este caso buscamos todos los valores que hay en la base de datos.
				$lista = array( 'NombreFuncionalidad','NombreAccion' );
				new FUNC_ACCION_SHOWALL( $lista, $datos, $DatosFuncionalidad );// se muestra la vista SHOWALL.
			}else{
				new USUARIO_DEFAULT();
			}
		}
	}

?>