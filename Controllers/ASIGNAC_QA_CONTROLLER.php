<?php
/*
	Archivo php
	Nombre: ASIGNA_QA_CONTROLLER.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/
session_start(); //solicito trabajar con la session

include '../Models/ASIGNAC_QA_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Views/ASIGNAC_QA_View.php'; //incluye la vista de asignación qa
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje

//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'GENERAR'://Caso generar QA
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
					
					$ASIGNACION->ADD();//Añadimos los datos a la tabla
					$veces[$cont]++; //Incrementamos la posición del trabajo
					$cont++;//Incrementamos posición del array
					
				}
			}
		//crea una vista mensaje con la respuesta y la dirección de vuelta
		new MESSAGE( 'Asignacion generada con exito', '../Controllers/ASIGNAC_QA_CONTROLLER.php' );
		//Finaliza el bloque
		break;
	default: //Caso que se ejecuta por defecto
		//Creacion de la vista inicio 
		new ASIGNAC_QA();
}

?>