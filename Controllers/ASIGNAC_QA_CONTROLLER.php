<?php
/*
	Archivo php
	Nombre: ASIGNA_QA_CONTROLLER.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/
session_start(); //solicito trabajar con la session

include '../Models/ASIGNAC_QA_MODEL.php'; //incluye el contendio del asignacion de qa
include '../Models/EVALUACION_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Views/ASIGNAC_QA_View.php'; //incluye la vista de asignación qa
include '../Views/ASIGNAC_QA_ADD_View.php'; //incluye la vista ADD
include '../Views/ASIGNAC_QA_DELETE_View.php'; //incluye la vista de DELETE
include '../Views/ASIGNAC_QA_EDIT_View.php'; //incluye la vista de EDIT
include '../Views/ASIGNAC_QA_SEARCH_View.php'; //incluye la vista de SEARCH
include '../Views/ASIGNAC_QA_SHOWCURRENT_View.php'; //incluye la vista de asignación qa
include '../Views/ASIGNAC_QA_SHOWALL_View.php'; //incluye la vista de asignación qa
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje

function get_data_form(){
	
	
	$IdTrabajo = $_REQUEST['IdTrabajo'];
	$LoginEvaluador = $_REQUEST['LoginEvaluador'];
	$LoginEvaluado = $_REQUEST['LoginEvaluado'];
	$AliasEvaluado = $_REQUEST['AliasEvaluado'];
	$action= $_REQUEST['action'];
	
	$ASIGNACION = new ASIGNAC_QA_MODEL(
		$IdTrabajo,
		$LoginEvaluador,
		$LoginEvaluado,
		$AliasEvaluado
	);
	
	return $ASIGNACION;
}

//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'HISTORIAS'://Caso generar QA
		//Variable que almacena un nuevo objecto model
		$ASIGNACION = new ASIGNAC_QA_MODEL('', '', '', '');
		//Variable que almacena el array de las tuplas de entrega.
		$QAs = $ASIGNACION->DevolverQAs();
		//Bucle que recorre todos los qua
		for ($i=0; $i < count($QAs); $i++) { 	
			//Variable que recoge el array de historias asociados al id trabajo
			$HISTORIAS = $ASIGNACION->DevolverHistorias($QAs[$i][0]);
			//Bucle que recorre las historias
			for ($j=0; $j < count($HISTORIAS); $j++) { 
				$IdTrabajo = $QAs[$i][0];//Variable que almacena $IdTrabajo
				$LoginEvaluador = $QAs[$i][1];//Variable que almacena $LoginEvaluador
				$AliasEvaluado = $QAs[$i][2];//Variable que almacena $AliasEvaluado
				$IdHistoria = $HISTORIAS[$j][0];//Variable que almacena IdHistoria
				
				$EVALUACION = new EVALUACION($IdTrabajo,$LoginEvaluador,$AliasEvaluado,$IdHistoria,'1', ' ', '1', ' ', '1');
				//Variable que almacena el mensaje de retorno de la sentencia
				$mensaje = $EVALUACION->ADD();//Añadimos los datos a la tabla
				}
			}
		//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $mensaje, '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
		//new MESSAGE( 'Asignacion generada con exito', '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
		//Finaliza el bloque
		break;
	case 'GENERAR'://Caso generar QA
		if ( !$_POST ) {
			new ASIGNAC_QA();
		} else {

		//Variable que almacena un nuevo objecto model
		$ASIGNACION = new ASIGNAC_QA_MODEL('', '', '', '');
		if ($ASIGNACION->DevolverArray($_REQUEST['ET']) == null) {
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( 'No hay entregas para realizar la asignación', '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
		}
		//Variable que almacena el array de las tuplas de entrega.
		$miarray = $ASIGNACION->DevolverArray($_REQUEST['ET']);
		//Bucle que llena las posiciones de cada trabajo, que nos sirve para ver que tengan el número deseado
		for ($i=0; $i < count($miarray); $i++) { $veces[] = 0; }
		//Variable que almacena el número de la posición del array en el que estamos
		$cont = 0;

		for ($i=0; $i < count($miarray); $i++) { 
				$pasadas = 0;
				while($pasadas != $_REQUEST['num']){
					$pasadas++;
					//Si el contador llega al número de datos, reinicia el contador
					if($cont == count($miarray)){ $cont = 0; }
					//Si coinciden los logins salta la posción
					if($miarray[$cont][1] == $miarray[$i][1]){ $cont++; }
					//Si la variable ya se asigno 5 veces pasa a la siguiente mientras sea 5 el valor
					while($veces[$cont] >= $_REQUEST['num']){ 
						$cont++;
						if($cont == count($miarray)){ $cont = 0; }
					}
					
					$IdTrabajo=$miarray[$cont][0];//Variable que almacena $IdTrabajo
					$LoginEvaluador=$miarray[$i][1];//Variable que almacena $LoginEvaluador
					$LoginEvaluado=$miarray[$cont][1];//Variable que almacena $LoginEvaluado
					$AliasEvaluado=$miarray[$cont][2];//Variable que almacena $AliasEvaluado
					//Creamos un nuevo objecto Asignacion Model para instanciar las variables
					$ASIGNACION = new ASIGNAC_QA_MODEL($IdTrabajo,$LoginEvaluador,$LoginEvaluado,$AliasEvaluado);

					$resultado = $ASIGNACION->ADD();//Añadimos los datos a la tabla
					$veces[$cont]++; //Incrementamos la posición del trabajo
					$cont++;//Incrementamos posición del array
					
				}
			}
		//crea una vista mensaje con la respuesta y la dirección de vuelta
		new MESSAGE( $resultado, '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
		//new MESSAGE( 'Asignacion generada con exito', '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
		//Finaliza el bloque
	}
		break;
	case 'ADD':
		if ( !$_POST ) {
			new ASIGNAC_QA_ADD();
		} else {
			$ASIGNACION = get_data_form();
			$respuesta = $ASIGNACION->ADD();
			new MESSAGE( $respuesta, '../Controllers/ACCION_CONTROLLER.php' );
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			$ASIGNACION = new ASIGNAC_QA_MODEL( $_REQUEST[ 'IdTrabajo' ], $_REQUEST['LoginEvaluador'], '', $_REQUEST['AliasEvaluado']);
			$valores = $ASIGNACION->RellenaDatos( $_REQUEST[ 'IdTrabajo' ], $_REQUEST['LoginEvaluador'], $_REQUEST['AliasEvaluado']);
			new ASIGNAC_QA_DELETE( $valores );
		} else {
			$ASIGNACION = get_data_form();
			$respuesta = $ASIGNACION->DELETE();
			new MESSAGE( $respuesta, '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
		}
		break;
	case 'EDIT':
		if ( !$_POST ) {
			$ASIGNACION = new ASIGNAC_QA_MODEL( $_REQUEST[ 'IdTrabajo' ], $_REQUEST['LoginEvaluador'], '', $_REQUEST['AliasEvaluado']);
			$valores = $ASIGNACION->RellenaDatos( $_REQUEST[ 'IdTrabajo' ], $_REQUEST['LoginEvaluador'], $_REQUEST['AliasEvaluado']);
			new ASIGNAC_QA_EDIT( $valores );
		} else {
			$ASIGNACION = get_data_form();
			$respuesta = $ASIGNACION->EDIT();
			new MESSAGE( $respuesta, '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		if ( !$_POST ) {
			new ASIGNAC_QA_SEARCH();
		} else {
			$ASIGNACION = get_data_form();
			$datos = $ASIGNACION->SEARCH();
			$lista = array( 'IdTrabajo','LoginEvaluador','LoginEvaluado', 'AliasEvaluado' );
			new ASIGNAC_QA_SHOWALL( $lista, $datos );
		}
		break;
	case 'SHOWCURRENT':
		$ASIGNACION = new ASIGNAC_QA_MODEL( $_REQUEST[ 'IdTrabajo' ], $_REQUEST['LoginEvaluador'], '', $_REQUEST['AliasEvaluado']);
		$valores = $ASIGNACION->RellenaDatos( $_REQUEST[ 'IdTrabajo' ], $_REQUEST['LoginEvaluador'], $_REQUEST['AliasEvaluado']);
		new ASIGNAC_QA_SHOWCURRENT( $valores );
		break;
	default:
		if ( !$_POST ) {
			$ASIGNACION = new ASIGNAC_QA_MODEL('', '', '', '');
		} else {
			$ASIGNACION = get_data_form();
		}
		$datos = $ASIGNACION->SEARCH();
		$lista = array( 'IdTrabajo','LoginEvaluador','LoginEvaluado', 'AliasEvaluado' );
		new ASIGNAC_QA_SHOWALL( $lista, $datos );


	//default: //Caso que se ejecuta por defecto
		//Creacion de la vista inicio 
		//new ASIGNAC_QA();
}

?>