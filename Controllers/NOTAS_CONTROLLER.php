<?php
/*
	Fecha de creación: 4/12/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/
session_start(); //solicito trabajar con la session

include '../Models/NOTAS_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Views/NOTAS_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/NOTAS_SEARCH_View.php'; //incluye la vista search
include '../Views/NOTAS_ADD_View.php'; //incluye la vista add
include '../Views/NOTAS_EDIT_View.php'; //incluye la vista edit
include '../Views/NOTAS_DELETE_View.php'; //incluye la vista delete
include '../Views/NOTAS_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje


function get_data_form() {


	$IdTrabajo = $_REQUEST['IdTrabajo'];
    $login = $_REQUEST['login'];
    $NotaTrabajo = $_REQUEST['NotaTrabajo'];
    $action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action
	$NOTAS = new NOTAS_MODEL(
		$IdTrabajo,
        $login,
        $NotaTrabajo
	);
	//Devuelve el valor del objecto model creado
	return $NOTAS;
}
//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
			//Crea una vista add para ver la tupla
			new NOTAS_ADD();
		} else {//Si recibe datos los recoge y mediante las funcionalidad de NOTAS_MODEL inserta los datos
			$NOTAS = get_data_form();//Variable que almacena los datos recogidos
			$respuesta = $NOTAS->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/NOTAS_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			//Variable que recoge un objecto model
			$NOTAS = new NOTAS_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'login' ],'');
			//Variable que almacena el relleno de los datos
			$valores = $NOTAS->RellenaDatos();
            //Crea una vista delete para ver la tupla
			new NOTAS_DELETE($valores);
			//Si recibe valores ejecuta el borrado
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$NOTAS = get_data_form();
           
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $NOTAS->DELETE();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/NOTAS_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'EDIT'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			//Variable que almacena un objeto model
			$NOTAS = new NOTAS_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'login' ],'');
			//Variable que almacena los datos de los atibutos rellenados a traves de login
			$valores = $NOTAS->RellenaDatos();
			new NOTAS_EDIT($valores);
			//Si se reciben valores
		} else {
			//Variable que almacena los datos recogidos
			$NOTAS = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $NOTAS->EDIT();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/NOTAS_CONTROLLER.php' );
		}
		//Fin del bloque
		break;
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			new NOTAS_SEARCH();
		//Si se reciben datos	
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$NOTAS = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $NOTAS->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array('IdTrabajo','login','NotaTrabajo');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new NOTAS_SHOWALL( $lista, $datos );
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		//Variable que almacena un objeto model con el login
		$NOTAS = new NOTAS_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST['login'], '');
		//Variable que almacena los valores rellenados a traves de login
		$valores = $NOTAS->RellenaDatos();
		//Creación de la vista showcurrent
		new NOTAS_SHOWCURRENT( $valores );
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
		if ( !$_POST ) {//Si no se han recibido datos 
			$NOTAS = new NOTAS_MODEL('', '', '');
		//Si se reciben datos
		} else {
			$NOTAS = get_data_form();
		}
		//Variable que almacena los datos de la busqueda
		$datos = $NOTAS->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array('IdTrabajo','login','NotaTrabajo');
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new NOTAS_SHOWALL( $lista, $datos );
}

?>