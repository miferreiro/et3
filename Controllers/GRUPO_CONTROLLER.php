<?php
/*
	Archivo php
	Nombre: GRUPO_CONTROLLER.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/
session_start(); //solicito trabajar con la session

include '../Models/GRUPO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Views/GRUPO_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/GRUPO_SEARCH_View.php'; //incluye la vista search
include '../Views/GRUPO_ADD_View.php'; //incluye la vista add
include '../Views/GRUPO_EDIT_View.php'; //incluye la vista edit
include '../Views/GRUPO_DELETE_View.php'; //incluye la vista delete
include '../Views/GRUPO_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje


function get_data_form() {

	$idGrupo = $_REQUEST[ 'idgroup' ]; //Variable que almacena el valor de idGrupo
	$NombreGrupo = $_REQUEST[ 'nombreG' ]; //Variable que almacena el valor de NomnbreGrupo
	$DescripGrupo = $_REQUEST[ 'descrip' ]; //Variable que almacena el valor de DescripGrupo

	$USUARIOS = new USUARIOS_Model(
		$idGrupo,
		$NombreGrupo,
		$DescripGrupo,
	);
	//Devuelve el valor del objecto model creado
	return $GRUPOS;
}
//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
			new GRUPO_ADD();
		} else {//Si recive datos los recoge y mediante las funcionalidad de USUARIOS_MODEL inserta los datos
			$GRUPOS = get_data_form();//Variable que almacena los datos recogidos
			$respuesta = $GRUPOS->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/GRUPO_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			//Variable que recoge un objecto model con solo el login
			$USUARIOS = new GRUPO_MODEL( $_REQUEST[ 'idgroup' ], '', '');
			//Variable que almacena el relleno de los datos utilizando el login
			$valores = $GRUPOS->RellenaDatos( $_REQUEST[ 'idgroup' ] );
			//Crea una vista delete para ver la tupla
			new GRUPO_DELETE( $valores );
			//Si recibe valores ejecuta el borrado
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$USUARIOS = get_data_form();
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $GRUPOS->DELETE();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/GRUPO_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'EDIT'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			//Variable que almacena un objeto model con el login
			$USUARIOS = new GRUPO_MODEL( $_REQUEST[ 'idgroup' ], '', '');
			//Variable que almacena los datos de los atibutos rellenados a traves de login
			$valores = $GRUPOS->RellenaDatos( $_REQUEST[ 'idgroup' ] );
			//Muestra la vista del formulario editar
			new GRUPO_EDIT( $valores );
			//Si se reciben valores
		} else {
			//Variable que almacena los datos recogidos
			$GRUPOS = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $GRUPOS->EDIT();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/GRUPO_CONTROLLER.php' );
		}
		//Fin del bloque
		break;
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			new GRUPO_SEARCH();
		//Si se reciben datos	
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$GRUPOS = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $GRUPOS->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'idGrupo','Nombre Grupo','Descripcion Grupo');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new GRUPO_SHOWALL( $lista, $datos );
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		//Variable que almacena un objeto model con el login
		$USUARIOS = new GRUPO_MODEL( $_REQUEST[ 'login' ], '', '', '', '');
		//Variable que almacena los valores rellenados a traves de login
		$valores = $GRUPOS->RellenaDatos( $_REQUEST[ 'login' ] );
		//Creación de la vista showcurrent
		new GRUPO_SHOWCURRENT( $valores );
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
		if ( !$_POST ) {//Si no se han recibido datos 
			$GRUPOS = new USUARIOS_Model( '', '', '');
		//Si se reciben datos
		} else {
			$GRUPOS = get_data_form();
		}
		//Variable que almacena los datos de la busqueda
		$datos = $GRUPOS->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array( 'idGrupo','Nombre Grupo','Descripcion Grupo');
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new GRUPO_SHOWALL( $lista, $datos );
}

?>