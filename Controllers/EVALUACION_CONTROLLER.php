<?php
/*
	Archivo php
	CorrectoA: EVALUACION_CONTROLLER.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/
session_start(); //solicito trabajar con la session

include '../Models/EVALUACION_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Views/EVALUACION_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/EVALUACION_SEARCH_View.php'; //incluye la vista search
include '../Views/EVALUACION_ADD_View.php'; //incluye la vista add
include '../Views/EVALUACION_EDIT_View.php'; //incluye la vista edit
include '../Views/EVALUACION_DELETE_View.php'; //incluye la vista delete
include '../Views/EVALUACION_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje


function get_data_form() {

	$IdTrabajo = $_REQUEST[ 'IdTrabajo' ]; //Variable que almacena el valor de IdTrabajo
	$LoginEvaluador = $_REQUEST[ 'LoginEvaluador' ]; //Variable que almacena el valor de LoginEvaluador
	$AliasEvaluado = $_REQUEST[ 'AliasEvaluado' ]; //Variable que almacena el valor de AliasEvaluado
	$IdHistoria = $_REQUEST[ 'IdHistoria' ]; //Variable que almacena el valor de IdHistoria
	$CorrectoA = $_REQUEST[ 'CorrectoA' ]; //Variable que almacena el valor de CorrectoA
	$ComenIncorrectoA = $_REQUEST[ 'ComenIncorrectoA' ]; //Variable que almacena el valor de ComenIncorrectoA
	$CorrectoP = $_REQUEST[ 'CorrectoP' ]; //Variable que almacena el valor de CorrectoP
	$ComentIncorrectoP = $_REQUEST[ 'ComentIncorrectoP' ]; //Variable que almacena el valor de ComentIncorrectoP
	$OK = $_REQUEST[ 'OK' ]; //Variable que almacena el valor de OK
	$action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action

	$EVALUACION = new EVALUACION(
		$IdTrabajo,
		$LoginEvaluador,
		$AliasEvaluado,
		$IdHistoria,
		$CorrectoA,
		$ComenIncorrectoA,
		$CorrectoP,
		$ComentIncorrectoP,
		$OK
	);
	//Devuelve el valor del objecto model creado
	return $EVALUACION;
}
//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
			new EVALUACION_ADD();
		} else {//Si recive datos los recoge y mediante las funcionalidad de EVALUACION_MODEL inserta los datos
			$EVALUACION = get_data_form();//Variable que almacena los datos recogidos
			$respuesta = $EVALUACION->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/EVALUACION_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			//Variable que recoge un objecto model con solo el LoginEvaluador
			$EVALUACION = new EVALUACION( $_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ], '', '', '', '','');
			//Variable que almacena el relleno de los datos utilizando el LoginEvaluador
			$valores = $EVALUACION->RellenaDatos( $_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ]);
			//Crea una vista delete para ver la tupla
			new EVALUACION_DELETE( $valores );
			//Si recibe valores ejecuta el borrado
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$EVALUACION = get_data_form();
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $EVALUACION->DELETE();
			//crea una vista mensaje con la respuesta y la ComentIncorrectoPción de vuelta
			new MESSAGE( $respuesta, '../Controllers/EVALUACION_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'EDIT'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			//Variable que almacena un objeto model con el LoginEvaluador
			$EVALUACION = new EVALUACION($_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ], '', '', '', '','');
			//Variable que almacena los datos de los atibutos rellenados a traves de LoginEvaluador
			$valores = $EVALUACION->RellenaDatos( $_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ] );
			//Muestra la vista del formulario editar
			new EVALUACION_EDIT( $valores );
			//Si se reciben valores
		} else {
			//Variable que almacena los datos recogidos
			$EVALUACION = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $EVALUACION->EDIT();
			//crea una vista mensaje con la respuesta y la ComentIncorrectoPción de vuelta
			new MESSAGE( $respuesta, '../Controllers/EVALUACION_CONTROLLER.php' );
		}
		//Fin del bloque
		break;
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			new EVALUACION_SEARCH();
		//Si se reciben datos	
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$EVALUACION = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $EVALUACION->SEARCH();
			//Variable que almacena array con el CorrectoA de los atributos
			$lista = array( 'IdTrabajo','LoginEvaluador','AliasEvaluado','IdHistoria','CorrectoA','ComenIncorrectoA','CorrectoP','ComentIncorrectoP','OK');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new EVALUACION_SHOWALL( $lista, $datos );
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		//Variable que almacena un objeto model con el LoginEvaluador
		$EVALUACION = new EVALUACION( $_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ], '', '', '', '','');
		//Variable que almacena los valores rellenados a traves de LoginEvaluador
		$valores = $EVALUACION->RellenaDatos( $_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ] );
		//Creación de la vista showcurrent
		new EVALUACION_SHOWCURRENT( $valores );
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
		if ( !$_POST ) {//Si no se han recibido datos 
			$EVALUACION = new EVALUACION( '','', '', '', '', '', '', '', '');
		//Si se reciben datos
		} else {
			$EVALUACION = get_data_form();
		}
		//Variable que almacena los datos de la busqueda
		$datos = $EVALUACION->SEARCH();
		//Variable que almacena array con el CorrectoA de los atributos
		$lista = array( 'IdTrabajo','LoginEvaluador','AliasEvaluado','IdHistoria','CorrectoA','ComenIncorrectoA','CorrectoP','ComentIncorrectoP','OK');
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new EVALUACION_SHOWALL( $lista, $datos );
}

?>