
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
include '../Models/USU_GRUPO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Models/ENTREGA_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Functions/permisosAcc.php';
include '../Views/EVALUACION/EVALUACION_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/ENTREGA/ENTREGA_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/EVALUACION/EVALUACION_SEARCH_View.php'; //incluye la vista search
include '../Views/EVALUACION/EVALUACION_ADD_View.php'; //incluye la vista add
include '../Views/EVALUACION/EVALUACION_EDIT_View.php'; //incluye la vista edit
include '../Views/EVALUACION/EVALUACION_DELETE_View.php'; //incluye la vista delete
include '../Views/EVALUACION/EVALUACION_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje
include '../Views/EVALUACION/EVALUACION_SELECT_QA_View.php'; //incluye la vista del showall
include '../Views/EVALUACION/EVALUACION_SELECT_ALL_QA_View.php'; //incluye la vista del showall
include '../Views/EVALUACION/EVALUACION_USUARIO_EDIT_HISTORIAS_View.php'; //incluye la vista del showall
include '../Views/DEFAULT_View.php';
include '../Views/EVALUACION/EVALUACION_ADMIN_EVALUAR_View.php';
include '../Views/EVALUACION/EVALUACION_USUARIO_EVALUAR_View.php';

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
			if(permisosAcc($_SESSION['login'],12,0)==true){
				new EVALUACION_ADD();
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php' );
			}
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
			if(permisosAcc($_SESSION['login'],12,1)==true){
			//Variable que recoge un objecto model con solo el LoginEvaluador
			$EVALUACION = new EVALUACION( $_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ], '', '', '', '','');
			//Variable que almacena el relleno de los datos utilizando el LoginEvaluador
			$valores = $EVALUACION->RellenaDatos( $_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ]);
			//Crea una vista delete para ver la tupla
			new EVALUACION_DELETE( $valores );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php' );
			}
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
			if(permisosAcc($_SESSION['login'],12,2)==true){
                $EVALUACION = new EVALUACION($_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ], '', '', '', '','');
                    //Variable que almacena los datos de los atibutos rellenados a traves de LoginEvaluador
                $valores = $EVALUACION->RellenaDatos();
                //Muestra la vista del formulario editar
                new EVALUACION_EDIT( $valores );
                //Si se reciben valores

            }else{
			  new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php' );	 
			 }	
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
	case 'EDITUSU':
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			if(permisosAcc($_SESSION['login'],12,12)==true){
                $EVALUACION = new EVALUACION($_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ], '', '', '', '','');
                    //Variable que almacena los datos de los atibutos rellenados a traves de LoginEvaluador
                $valores = $EVALUACION->RellenaDatos();
                //Muestra la vista del formulario editar
                new EVALUACION_USUARIO_EDIT_HISTORIAS( $valores );
                //Si se reciben valores
            }else{
			  new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php' );	 
			 }
            } else {
			$EVALUACION = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $EVALUACION->EDIT();
			//crea una vista mensaje con la respuesta y la ComentIncorrectoPción de vuelta
			$at = "?IdTrabajo=".$_REQUEST['IdTrabajo']."&AliasEvaluado=".$_REQUEST['AliasEvaluado']."&action=EVALUAR";
			//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
			new MESSAGE( $respuesta, '../Controllers/EVALUACION_CONTROLLER.php'.$at );
			}
	case 'EVALUARADMIN'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			if((permisosAcc($_SESSION['login'],12,11)==true)){
				//Variable que almacena un objeto model con el LoginEvaluador
                $EVALUACION = new EVALUACION($_REQUEST[ 'IdTrabajo' ],'', $_REQUEST[ 'AliasEvaluado' ], '', '', '', '', '','');
                    //Variable que almacena los datos de los atibutos rellenados a traves de LoginEvaluador
                $valores = $EVALUACION->EvaluacionesQa($_REQUEST['AliasEvaluado']);
                //Muestra la vista del formulario editar
                new EVALUACION_ADMIN_EVALUAR( $valores );
                //Si se reciben valores

            }
            else{
				if(permisosAcc($_SESSION['login'],12,10)==true){
	            $EVALUACION = new EVALUACION($_REQUEST['IdTrabajo'],$_SESSION['login'],$_REQUEST['AliasEvaluado'], '', '', '', '', '', '');
	            $lista = array( 'IdTrabajo','LoginEvaluador','AliasEvaluado','CorrectoA','ComenIncorrectoA');
	            //Variable que almacena los datos de la busqueda
	    		$datos = $EVALUACION->SEARCH2();
	    		//Variable que almacena array con el CorrectoA de los atributos
	    
	    		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
	    		new EVALUACION_USUARIO_EVALUAR( $lista, $datos );
				}else{
			  new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php' );	 
			 }
            }
		} else {
			$contenido = $_SESSION['contenido'];
			$EVALUACION = new EVALUACION('','', '', '', '', '', '', '','');
			for ($i=0; $i < count($contenido); $i++) { 
				$id = $contenido[$i][0];
				$login = $contenido[$i][1];
				$Alias = $contenido[$i][2];

				$OK = $_REQUEST[$login . $id];
				$ComentIncorrectoP = $_REQUEST[$id . $Alias];
				$CorrectoP = $_REQUEST[$id];

				$miarray = $EVALUACION->DevolverCommentAlumno($login,$Alias,$id,$_REQUEST['IdTrabajo']);

				$CorrectoA = $miarray[0][0];
				$ComentIncorrectoA = $miarray[0][1];

				$EVALUACION = new EVALUACION($_REQUEST['IdTrabajo'],$login,$Alias,$id,$CorrectoA,$ComentIncorrectoA,$CorrectoP,$ComentIncorrectoP,$OK);
				$respuesta = $EVALUACION->EDIT();
				//echo "id: " . $id . "login: " . $login . "alias: " . $Alias . "correctoP: " . $CorrectoP . "ok: " . $OK ."comp " . $ComentIncorrectoP;
				//echo "--------------------------<br>";

 			}
 			//echo $_REQUEST['diego7'];
			//Variable que almacena los datos recogidos
			//$EVALUACION = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			/*$respuesta = $EVALUACION->EDIT();*/
			//crea una vista mensaje con la respuesta y la ComentIncorrectoPción de vuelta
			$at = "?action=EVALUACION_HISTORIAS";
			new MESSAGE( $respuesta, '../Controllers/EVALUACION_CONTROLLER.php' . $at);
		}
		//Fin del bloque
		break;
	case 'EVALUARUSU'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT

				if(permisosAcc($_SESSION['login'],12,10)==true){
	            $EVALUACION = new EVALUACION($_REQUEST['IdTrabajo'],$_SESSION['login'],$_REQUEST['AliasEvaluado'], '', '', '', '', '', '');
	            $lista = array( 'IdTrabajo','LoginEvaluador','AliasEvaluado','CorrectoA','ComenIncorrectoA');
	            //Variable que almacena los datos de la busqueda
	    		$datos = $EVALUACION->SEARCH2();
	    		//Variable que almacena array con el CorrectoA de los atributos
	    
	    		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
	    		new EVALUACION_USUARIO_EVALUAR( $lista, $datos );
				}else{
			  new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php' );	 
			 }
         
		} 
		//Fin del bloque
		break;
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			if(permisosAcc($_SESSION['login'],12,3)==true){
				new EVALUACION_SEARCH();
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php' );
			}
		//Si se reciben datos	
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$EVALUACION = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $EVALUACION->SEARCH();
			//Variable que almacena array con el CorrectoA de los atributos
			$lista = array( 'NombreTrabajo','LoginEvaluador','AliasEvaluado','IdHistoria','CorrectoA','ComenIncorrectoA','CorrectoP','ComentIncorrectoP','OK');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new EVALUACION_SHOWALL( $lista, $datos );
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		if(permisosAcc($_SESSION['login'],12,4)==true){
		//Variable que almacena un objeto model con el LoginEvaluador
		$EVALUACION = new EVALUACION( $_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ], '', '', '', '','');
		//Variable que almacena los valores rellenados a traves de LoginEvaluador
		$valores = $EVALUACION->RellenaDatos( $_REQUEST[ 'IdTrabajo' ], $_REQUEST[ 'LoginEvaluador' ], $_REQUEST[ 'AliasEvaluado' ], $_REQUEST[ 'IdHistoria' ] );
		//Creación de la vista showcurrent
		new EVALUACION_SHOWCURRENT( $valores );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/EVALUACION_CONTROLLER.php' );
			}
		//Final del bloque
		break;
        
    case 'EVALUACION_HISTORIAS':  
    	if ( !$_POST ) {//Si no se han recibido datos 
    		if(permisosAcc($_SESSION['login'],12,11)==true){
                 $EVALUACION = new EVALUACION('','', '', '', '', '', '', '', '');
                 $datos=$EVALUACION->DevolverEntregas(); 
                 $lista = array('login','NombreTrabajo','Alias','Horas','Ruta');	
            }
			 new EVALUACION_SELECT_ALL_QA( $lista, $datos );
		}
    break;
    case 'EVALUACION_HISTORIAS_ASIGNADAS':		
    	if ( !$_POST ) {//Si no se han recibido datos	
			if(permisosAcc($_SESSION['login'],12,10)==true){
                $EVALUACION = new EVALUACION('','', '', '', '', '', '', '', '');
                $datos=$EVALUACION->entregasUsu($_SESSION['login']);
                //Variable que almacena array con el CorrectoA de los atributos
		        $lista = array('NombreTrabajo','Alias','Horas','Ruta');
		       //Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		    }
		    new EVALUACION_SELECT_QA( $lista, $datos );
		}
    break;
    
	default: //Caso que se ejecuta por defecto
		if ( !$_POST ) {//Si no se han recibido datos 
		   //Comprobamos los permisos, si tiene permisos se ejecuta el código dentro del if
           if(permisosAcc($_SESSION['login'],12,5)==true){
	            $EVALUACION = new EVALUACION('','','', '', '', '', '', '', '');
	            $lista = array( 'NombreTrabajo','LoginEvaluador','AliasEvaluado','CorrectoA','ComenIncorrectoA','CorrectoP','ComentIncorrectoP','OK');
				//Variable que almacena los datos de la busqueda
				$datos = $EVALUACION->SEARCH();
				//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
				new EVALUACION_SHOWALL( $lista, $datos );
			//Si no tiene permisos muestra pantalla en blanco
			} else {
				new USUARIO_DEFAULT();
			}
		}
	}

?>
