<?php
/*
	Fecha de creación: 2/12/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/
session_start(); //solicito trabajar con la session

include '../Models/HISTORIA_MODEL.php'; //incluye el contendio del modelo historia
include '../Views/HISTORIA_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/HISTORIA_SEARCH_View.php'; //incluye la vista search
include '../Views/HISTORIA_ADD_View.php'; //incluye la vista add
include '../Views/HISTORIA_EDIT_View.php'; //incluye la vista edit
include '../Views/HISTORIA_DELETE_View.php'; //incluye la vista delete
include '../Views/HISTORIA_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje


function get_data_form() {

	$IdTrabajo = $_REQUEST[ 'IdTrabajo' ]; //Variable que almacena el valor de IdTrabajo
	$IdHistoria = $_REQUEST[ 'IdHistoria' ]; //Variable que almacena el valor de IdHistoria
	$TextoHistoria = $_REQUEST[ 'TextoHistoria' ]; //Variable que almacena el valor de Textohistoria

	$HISTORIA = new HISTORIA_MODEL(
		$IdTrabajo,
		$IdHistoria,
		$TextoHistoria
	);
	//Devuelve el valor del objecto model creado
	return $HISTORIA;
}
//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
			new HISTORIA_ADD();
		} else {//Si recibe datos los recoge y mediante las funcionalidad de HISTORIA inserta los datos
			$HISTORIA = get_data_form();//Variable que almacena los datos recogidos
			$respuesta = $HISTORIA->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/HISTORIA_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			//Variable que recoge un objecto model con IdTrabajo y IdHistoria
			$HISTORIA = new HISTORIA_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'IdHistoria' ], '');
			//Variable que almacena el relleno de los datos utilizando el IdTrabajo y IdHistoria
			$valores = $HISTORIA->RellenaDatos();
			
			//Crea una vista delete para ver la tupla
			new HISTORIA_DELETE($valores);
			//Si recibe valores ejecuta el borrado
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$HISTORIA = get_data_form();
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $HISTORIA->DELETE();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/HISTORIA_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'EDIT'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			//Variable que almacena un objeto model con el IdGrupo
			$HISTORIA = new HISTORIA_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'IdHistoria' ],'');
			//Variable que almacena los datos de los atibutos rellenados
			$valores = $HISTORIA->RellenaDatos();
			//Muestra la vista del formulario editar
			new HISTORIA_EDIT( $valores );
			//Si se reciben valores
		} else {
			//Variable que almacena los datos recogidos
			$HISTORIA = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $HISTORIA->EDIT();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/HISTORIA_CONTROLLER.php' );
		}
		//Fin del bloque
		break;
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			new HISTORIA_SEARCH();
		//Si se reciben datos	
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$HISTORIA = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $HISTORIA->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'IdTrabajo','IdHistoria','TextoHistoria');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new HISTORIA_SHOWALL( $lista, $datos );
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		//Variable que almacena un objeto model con el IdTrabajo y IdHistoria
		$HISTORIA = new HISTORIA_MODEL( $_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'IdHistoria' ], '');
		$valores = $HISTORIA->RellenaDatos();
		//Variable que almacena array con el nombre de los atributos
		//$lista = array( 'IdTrabajo', 'IdHistoria','TextoHistoria');
		//Creación de la vista showcurrent
		new HISTORIA_SHOWCURRENT($valores);
		//Final del bloque
		break;
        
	default: //Caso que se ejecuta por defecto
		if ( !$_POST ) {//Si no se han recibido datos 
			$HISTORIA = new HISTORIA_MODEL( '', '', '');
		//Si se reciben datos
		} else {
			$HISTORIA = get_data_form();
		}
		//Variable que almacena los datos de la busqueda
		$datos = $HISTORIA->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array( 'IdTrabajo','IdHistoria','TextoHistoria');
		//Creacion de la vista showall con el array $lista, los datos .
		new HISTORIA_SHOWALL( $lista, $datos );
}

?>