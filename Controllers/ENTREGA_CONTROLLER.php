<?php
/*
	Controlador que gestiona las entregas
    Fecha de creación:28/11/2017
*/
session_start(); //solicito trabajar con la session

include '../Models/ENTREGA_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Views/ENTREGA_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/ENTREGA_SEARCH_View.php'; //incluye la vista search
include '../Views/ENTREGA_ADD_View.php'; //incluye la vista add
include '../Views/ENTREGA_EDIT_View.php'; //incluye la vista edit
include '../Views/ENTREGA_DELETE_View.php'; //incluye la vista delete
include '../Views/ENTREGA_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje


function get_data_form() {

	$login = $_REQUEST['login'];
    $IdTrabajo = $_REQUEST['IdTrabajo'];
    $Alias = $_REQUEST['Alias'];
    $Horas = $_REQUEST['Horas'];
    $Ruta= $_REQUEST['Ruta'];
	$action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action

	$EVALUACION = new EVALUACION(
		$login,
        $IdTrabajo,
        $Alias,
        $Horas,
        $Ruta
	);
	//Devuelve el valor del objecto model creado
	return $ENTREGA;
}
//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
			new ENTREGA_ADD();
		} else {//Si recibe datos los recoge y mediante la clase ENTREGA_MODEL inserta los datos
			$ENTREGA = get_data_form();//Variable que almacena los datos recogidos
			$respuesta = $ENTREGA->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/EVALUACION_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			//Variable que recoge un objecto model.
			$ENTREGA = new ENTREGA( $_REQUEST[ 'login' ], $_REQUEST[ 'IdTrabajo' ], '','', '');
			//Variable que almacena el relleno de los datos.
			$valores = $ENTREGA->RellenaDatos();
			//Crea una vista delete para ver la tupla
			new ENTREGA_DELETE( $valores );
			//Si recibe valores ejecuta el borrado
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$ENTREGA = get_data_form();
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $ENTREGA>DELETE();
			//crea una vista mensaje con la respuesta.
			new MESSAGE( $respuesta, '../Controllers/EVALUACION_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'EDIT'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			//Variable que almacena un objeto model 
			$ENTREGA = new ENTREGA($_REQUEST[ 'login' ], $_REQUEST[ 'IdTrabajo' ],'', '', '');
			//Variable que almacena los datos de los atibutos rellenados 
			$valores = $ENTREGA->RellenaDatos();
			//Muestra la vista del formulario editar
			new ENTREGA_EDIT( $valores );
			//Si se reciben valores
		} else {
			//Variable que almacena los datos recogidos
			$ENTREGA = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $ENTREGA->EDIT();
			//crea una vista mensaje con la respuesta
			new MESSAGE( $respuesta, '../Controllers/EVALUACION_CONTROLLER.php' );
		}
		//Fin del bloque
		break;
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			new ENTREGA_SEARCH();
		//Si se reciben datos	
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$ENTREGA = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $ENTREGA->SEARCH();
			//Variable que almacena array con el CorrectoA de los atributos
			$lista = array('login','IdTrabjo','Alias','Horas','Ruta');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new ENTREGA_SHOWALL( $lista, $datos );
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		//Variable que almacena un objeto model
		$ENTREGA = new ENTREGA( $_REQUEST[ 'login' ], $_REQUEST[ 'IdTrabajo' ], '', '','');
		//Variable que almacena los valores rellenados 
		$valores = $ENTREGA->RellenaDatos();
		//Creación de la vista showcurrent
		new ENTREGA_SHOWCURRENT( $valores );
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
		if ( !$_POST ) {//Si no se han recibido datos 
			$ENTREGA = new ENTREGA( '','', '', '', '');
		//Si se reciben datos
		} else {
			$ENTREGA = get_data_form();
		}
		//Variable que almacena los datos de la busqueda
		$datos = $ENTREGA->SEARCH();
		//Variable que almacena array con el CorrectoA de los atributos
		$lista = array('login','IdTrabjo','Alias','Horas','Ruta');
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new ENTREGA_SHOWALL( $lista, $datos );
}

?>