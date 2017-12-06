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
include '../Views/ASIGNAC_QA_GENERAR_View.php'; //incluye la vista de asignación qa
include '../Views/ASIGNAC_QA_HISTORIAS_View.php'; //incluye la vista de asignación qa
include '../Views/ASIGNAC_QA_ADD_View.php'; //incluye la vista ADD
include '../Views/ASIGNAC_QA_DELETE_View.php'; //incluye la vista de DELETE
include '../Views/ASIGNAC_QA_EDIT_View.php'; //incluye la vista de EDIT
include '../Views/ASIGNAC_QA_SEARCH_View.php'; //incluye la vista de SEARCH
include '../Views/ASIGNAC_QA_SHOWCURRENT_View.php'; //incluye la vista de asignación qa
include '../Views/ASIGNAC_QA_SHOWALL_View.php'; //incluye la vista de asignación qa
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje

function get_data_form(){
	
	
	$IdTrabajo = $_REQUEST['IdTrabajo']; //Variable que almacena el idTrabajo
	$LoginEvaluador = $_REQUEST['LoginEvaluador']; //Variable que almacena el LoginEvaluador
	$LoginEvaluado = $_REQUEST['LoginEvaluado']; //Variable que almacena el LoginEvaluado
	$AliasEvaluado = $_REQUEST['AliasEvaluado']; //Variable que almacena el AliasEvaluado
	$action= $_REQUEST['action'];//Variable que almacena el action
	
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
	case 'HISTORIAS'://Caso generar HISTORIAS
		//Si no se reciben parametros crea un vista de generar historias
		if ( !$_POST ) {
			//Creación vista para generación de qas
			new ASIGNAC_QA_HISTORIAS();
		//Si se reciben parametros
		} else {
		//Variable que almacena el mensaje por defecto
		$mensaje = 'No se enentra la asignacion de QAs';
		//Variable que almacena un nuevo objecto model
		$ASIGNACION = new ASIGNAC_QA_MODEL($_REQUEST['IdTrabajo'], '', '', '');
		//Variable que almacena el array de las tuplas de entrega.
		$QAs = $ASIGNACION->DevolverQAs();
		//Variable que recoge el array de historias asociados al id trabajo
		$HISTORIAS = $ASIGNACION->DevolverHistorias($_REQUEST['IdTrabajo']);
		//Si no hay historias pero hay QAs cambia el mensaje de salida
		if (count($HISTORIAS) <= 0 && count($QAs) != 0) {
			//mensaje
			$mensaje = 'No se enentra la asignacion de QAs';
		}
		//Bucle que recorre todos los qua
		for ($i=0; $i < count($QAs); $i++) { 	
			//Bucle que recorre las historias
			for ($j=0; $j < count($HISTORIAS); $j++) { 
				$IdTrabajo = $QAs[$i][0];//Variable que almacena $IdTrabajo
				$LoginEvaluador = $QAs[$i][1];//Variable que almacena $LoginEvaluador
				$AliasEvaluado = $QAs[$i][2];//Variable que almacena $AliasEvaluado
				$IdHistoria = $HISTORIAS[$j][0];//Variable que almacena IdHistoria
				//Variable que almacena un nuevo objecto Evaluación
				$EVALUACION = new EVALUACION($IdTrabajo,$LoginEvaluador,$AliasEvaluado,$IdHistoria,'1', ' ', '1', ' ', '1');
				//Variable que almacena el mensaje de retorno de la sentencia
				$mensaje = $EVALUACION->ADD();//Añadimos los datos a la tabla
				}
			}
		//crea una vista mensaje con la respuesta y la dirección de vuelta
		new MESSAGE( $mensaje, '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
		//new MESSAGE( 'Asignacion generada con exito', '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
		//Finaliza el bloque
		}
		break;
	case 'GENERAR'://Caso generar QA
		//Si no se reciben parametros
		if ( !$_POST ) {
			//Variable que almacena un nuevo objecto model
			$ASIGNACION = new ASIGNAC_QA_MODEL('', '', '', '');
			//Variable que almacena el array de las tuplas de entrega.
			$ET = $ASIGNACION->DevolverET();
			//Creación de una nueva vista para generar QAs
			new ASIGNAC_QA_GENERAR($ET);
		//Si se reciben parámetros
		} else {
		//Variable que almacena un nuevo objecto model
		$ASIGNACION = new ASIGNAC_QA_MODEL($_REQUEST['IdTrabajo'], '', '', '');
		//Si no se encuentra la ET que se desea generar, muestra un mensaje y no se realiza
		if ($ASIGNACION->DevolverArray($_REQUEST['IdTrabajo']) == null) {
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( 'No hay entregas para realizar la asignación', '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
		}
		//Variable que almacena el array de las tuplas de entrega.
		$miarray = $ASIGNACION->DevolverArray($_REQUEST['IdTrabajo']);
		//Variable que guarda el nombre de la QA
		$NombreQA = "QA" . substr($_REQUEST['IdTrabajo'], 2);
		//Bucle que llena las posiciones de cada trabajo, que nos sirve para ver que tengan el número deseado
		for ($i=0; $i < count($miarray); $i++) { $veces[] = 0; }
		//Variable que almacena el número de la posición del array en el que estamos
		$cont = 0;
		//Bucle que recorre todas las tuplas para obtener el LoginEvaluador.
		for ($i=0; $i < count($miarray); $i++) { 
				//Variable que almacena el número de pasadas a realizar con cada login sobre el array de trabajos
				$pasadas = 0;//Inicializamos la variable a 0
				while($pasadas != $_REQUEST['num']){
					$pasadas++;//Se incrementa la variable
					//Si el contador llega al número de datos, reinicia el contador
					if($cont == count($miarray)){ $cont = 0; }
					//Si coinciden los logins salta la posción
					if($miarray[$cont][1] == $miarray[$i][1]){ $cont++; }
					//Si la variable ya se asigno 5 veces pasa a la siguiente mientras sea 5 el valor
					while($veces[$cont] >= $_REQUEST['num']){ 
						$cont++;//Se incrementa contador
						//Si la variable es mayor que el tamaño del array reinicia la variable contador
						if($cont == count($miarray)){ $cont = 0; }
					}
					
					$IdTrabajo=$NombreQA;//Variable que almacena $IdTrabajo
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