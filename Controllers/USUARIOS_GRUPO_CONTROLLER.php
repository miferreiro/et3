<?php
	/*
	Archivo php
	Nombre: USUARIOS_GRUPO_CONTROLLER.php
	Autor: 	miferreiro
	Fecha de creación: 9/10/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/
session_start();//solicito trabajar con la session
//incluimos las vistas asociadas para este controlador y el modelo adecuado
include '../Models/USUARIOS_GRUPO_MODEL.php';
include '../Views/USUARIOS_GRUPO_SHOWALL_View.php';
include '../Views/USUARIOS_GRUPO_SEARCH_View.php';
include '../Views/USUARIOS_GRUPO_ADD_View.php';
include '../Views/USUARIOS_GRUPO_DELETE_View.php';
include '../Views/USUARIOS_GRUPO_SHOWCURRENT_View.php';
include '../Views/MESSAGE_View.php';

//esta función asigna los valores que vinieron del formulario al modelo USUARIOS_GRUPO_Model
function get_data_form(){
	
	$login = $_REQUEST['login'];//asigna el valor de login que vino del formulario
	$grupo = $_REQUEST['idgroup'];//asigna el valor de grupo que vino del formulario.
	$action = $_REQUEST['action'];//asigna la acción que se eligió en el formulario.
	
	$USUARIOS_GRUPO = new USUARIOS_GRUPO_Model(
		$login,
		$grupo   
	);//instancia un objeto de la clase modelo USUARIOS_GRUPO_Model
	
	return $USUARIOS_GRUPO; //devuelve un objeto del modelo USUARIOS_GRUPO_Model
}

if ( !isset( $_REQUEST[ 'action' ] ) ) { //mira si no existe una acción
	$_REQUEST[ 'action' ] = ''; // si se cumple la condición se pone la acción vacía.
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD': //se hace este case en el caso de que queramos insertar
		if ( !$_POST ) { // si no existe dolar POST  se muestra la vista ADD de USUARIOS_GRUPO.
			new USUARIOS_ADD();
		} else { // si existe dolar POST
			$USUARIOS_GRUPO = get_data_form();// se pasa a la variable USUARIOS_GRUPO un objeto del modelo USUARIOS_GRUPO_Model
			$respuesta = $USUARIOS_GRUPO->ADD();//obtenemos la respuesta que viene del método ADD() de la clase USUARIOS_GRUPO_Model
			new MESSAGE( $respuesta, '../Controllers/USUARIOS_GRUPO_CONTROLLER.php' );//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
		}
		break;
	case 'SEARCH': //se hace este case en el caso de que queramos buscar
		if ( !$_POST ) { // si no existe dolar POST  se muestra la vista SEARCH de USUARIOS_GRUPO.
			new USUARIOS_GRUPO_SEARCH();
		} else { // si existe dolar POST
			$USUARIOS_GRUPO = get_data_form(); //se pasa a la variable USUARIOS_GRUPO un objeto del modelo USUARIOS_GRUPO_Model
			$datos = $USUARIOS_GRUPO->SEARCH();//obtenemos la respuesta que viene del método SEARCH() de la clase USUARIOS_GRUPO_Model
			$lista = array( 'login','idgroup');
			new USUARIOS_GRUPO_SHOWALL( $lista, $datos );// se muestra en una vista SHOWALL el resultado de la búsqueeda.
		}
		break;
	case 'DELETE': //se hace este case en el caso de que queramos eliminar
		if ( !$_POST ) { // si no existe dolar POST  se muestra la vista DELETE  de USUARIOS_GRUPO con todos sus valores.
			$USUARIOS = new USUARIOS_GRUPO_Model( $_REQUEST[ 'login' ], $_REQUEST[ 'idgroup' ] ); //en $USUARIOS se le pasará un login y un idgroup elegido en la vista de SHOWALL.
			$valores = $USUARIOS->RellenaDatos( $_REQUEST[ 'login' ], $_REQUEST[ 'idgroup' ]);//con el método RellenaDatos pasaremos el valor de login y de idgroup
			new USUARIOS_GRUPO_DELETE( $valores ); //se muestra la vista DELETE con el login y el idgroup.
		} else {//si existe dolar POST
			$USUARIOS = get_data_form(); // se le pasa a la variable $USUARIOS el login y idgroup a eliminar
			$respuesta = $USUARIOS->DELETE(); // con el método DELETE de USUARIOS_GRUPO_Model se elimna ese login y idgroup de la base de datos.
			new MESSAGE( $respuesta, '../Controllers/USUARIOS_GRUPO_CONTROLLER.php' );// se muestar en una vista un mensaje después del borrado.
		}
		break;
	case 'SHOWCURRENT': //se hace este case en el caso de que queramos  ver una tupla en detalle.
		$USUARIOS_GRUPO = new USUARIOS_GRUPO_Model( $_REQUEST[ 'login' ], $_REQUEST[ 'idgroup' ]);//en $USUARIOS se le pasará un login y un idgroup elegido en la vista de SHOWALL.
		$valores = $USUARIOS_GRUPO->RellenaDatos( $_REQUEST[ 'login' ],$_REQUEST[ 'idgroup' ] );//con el método RellenaDatos pasaremos el valor de login y de idgroup
		new USUARIOS_GRUPO_SHOWCURRENT( $valores );//se muestra la vista SHOWCURRENT con el login y el idgroup.
		break;
	default: // por defecto aparecerá la vista SHOWALL.
		if ( !$_POST ) {//si ni existe deolar POST
			$USUARIOS_GRUPO = new USUARIOS_GRUPO_Model( '', '');//se crea una instancia de la clase USUARIOS_GRUPO_Model con parametros vacíos para que nos coga todas las tuplas de la base de datos.
		} else {//si existe dolar POST
			$USUARIOS_GRUPO = get_data_form();//a la variable USUARIOS_GRUPO se le pasa el login y idgroup vacío.
		}
		$datos = $USUARIOS_GRUPO->SEARCH();//con el método SEARCH en este caso buscamos todos los valores que hay en la base de datos.
		$lista = array(  'login','idgroup' );
		new USUARIOS_GRUPO_SHOWALL( $lista, $datos );// se muestra la vista SHOWALL.
}


?>