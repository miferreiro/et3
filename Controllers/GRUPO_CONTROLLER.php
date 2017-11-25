<?php
/*
	Archivo php
	Nombre: USUARIOS_CONTROLLER.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/
session_start(); //solicito trabajar con la session

include '../Models/USUARIOS_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Views/USUARIOS_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/USUARIOS_SEARCH_View.php'; //incluye la vista search
include '../Views/USUARIOS_ADD_View.php'; //incluye la vista add
include '../Views/USUARIOS_EDIT_View.php'; //incluye la vista edit
include '../Views/USUARIOS_DELETE_View.php'; //incluye la vista delete
include '../Views/USUARIOS_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje


function get_data_form() {

	$login = $_REQUEST[ 'login' ]; //Variable que almacena el valor de login
	$password = $_REQUEST[ 'password' ]; //Variable que almacena el valor de password
	$nombre = $_REQUEST[ 'nombre' ]; //Variable que almacena el valor de nombre
	$apellidos = $_REQUEST[ 'apellidos' ]; //Variable que almacena el valor de apellidos
	$email = $_REQUEST[ 'email' ]; //Variable que almacena el valor de email
	$action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action

	$USUARIOS = new USUARIOS_Model(
		$login,
		$password,
		$nombre,
		$apellidos,
		$email,
	);
	//Devuelve el valor del objecto model creado
	return $USUARIOS;
}
//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
			new USUARIOS_ADD();
		} else {//Si recive datos los recoge y mediante las funcionalidad de USUARIOS_MODEL inserta los datos
			$USUARIOS = get_data_form();//Variable que almacena los datos recogidos
			$respuesta = $USUARIOS->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/USUARIOS_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			//Variable que recoge un objecto model con solo el login
			$USUARIOS = new USUARIOS_Model( $_REQUEST[ 'login' ], '', '', '', '');
			//Variable que almacena el relleno de los datos utilizando el login
			$valores = $USUARIOS->RellenaDatos( $_REQUEST[ 'login' ] );
			//Crea una vista delete para ver la tupla
			new USUARIOS_DELETE( $valores );
			//Si recibe valores ejecuta el borrado
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$USUARIOS = get_data_form();
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $USUARIOS->DELETE();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/USUARIOS_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'EDIT'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			//Variable que almacena un objeto model con el login
			$USUARIOS = new USUARIOS_Model( $_REQUEST[ 'login' ], '', '', '', '');
			//Variable que almacena los datos de los atibutos rellenados a traves de login
			$valores = $USUARIOS->RellenaDatos( $_REQUEST[ 'login' ] );
			//Muestra la vista del formulario editar
			new USUARIOS_EDIT( $valores );
			//Si se reciben valores
		} else {
			//Variable que almacena los datos recogidos
			$USUARIOS = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $USUARIOS->EDIT();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/USUARIOS_CONTROLLER.php' );
		}
		//Fin del bloque
		break;
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			new USUARIOS_SEARCH();
		//Si se reciben datos	
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$USUARIOS = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $USUARIOS->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'login','nombre','apellidos','email');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new USUARIOS_SHOWALL( $lista, $datos );
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		//Variable que almacena un objeto model con el login
		$USUARIOS = new USUARIOS_Model( $_REQUEST[ 'login' ], '', '', '', '');
		//Variable que almacena los valores rellenados a traves de login
		$valores = $USUARIOS->RellenaDatos( $_REQUEST[ 'login' ] );
		//Creación de la vista showcurrent
		new USUARIOS_SHOWCURRENT( $valores );
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
		if ( !$_POST ) {//Si no se han recibido datos 
			$USUARIOS = new USUARIOS_Model( '', '', '', '', '');
		//Si se reciben datos
		} else {
			$USUARIOS = get_data_form();
		}
		//Variable que almacena los datos de la busqueda
		$datos = $USUARIOS->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array(  'login','nombre','apellidos','email' );
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new USUARIOS_SHOWALL( $lista, $datos );
}

?>