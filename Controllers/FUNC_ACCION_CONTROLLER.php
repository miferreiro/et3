<?php
/*
	Archivo php
	Nombre: FUNC_ACCION_CONTROLLER.php
	Autor: 	Alejandro Vila
	Fecha de creación: 27/11/2017 
	Función: controlador que realiza las FUNC_ACCION, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/

session_start();//solicito trabajar con la sesión

include '../Models/FUNC_ACCION_MODEL.php';//incluye el contendio del modelo de FUNC_ACCION
include '../Models/USU_GRUPO_MODEL.php';//incluye el contendio del modelo USU_GRUPO
include '../Models/ACCION_MODEL.php';//incluye el contendio del modelo ACCION
include '../Models/FUNCIONALIDAD_MODEL.php';//incluye el contendio del modelo FUNCIONALIDAD
include '../Views/FUNC_ACCION/FUNC_ACCION_SHOWALL_View.php';//incluye el contendio de la vista SHOWALL
include '../Views/FUNC_ACCION/FUNC_ACCION_SEARCH_View.php';//incluye el contendio de la vista SEARCH
include '../Views/FUNC_ACCION/FUNC_ACCION_ADD_View.php';//incluye el contendio de la vista SHOWALL
include '../Views/FUNC_ACCION/FUNC_ACCION_DELETE_View.php';//incluye el contendio de la vista DELETE
include '../Views/FUNC_ACCION/FUNC_ACCION_SHOWCURRENT_View.php';//incluye el contendio de la vista SHOWCURRENT
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php';//incluye el contendio de la vista message

//Esta función crea un objeto tipo FUNC_ACCION_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form(){
	
	
	$IdFuncionalidad = $_REQUEST['IdFuncionalidad'];//Variable que almacena el valor de IdFuncionalidad
	$IdAccion = $_REQUEST['IdAccion'];//Variable que almacena el valor de IdAccion
	
	$FUNC_ACCION = new FUNC_ACCION(
		$IdFuncionalidad,
		$IdAccion
	);//Devuelve el valor del objecto model creado
	
	return $FUNC_ACCION;
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

switch ( $_REQUEST[ 'action' ] ) {//Si la variable action no tiene contenido le asignamos ''
	case 'ADD'://caso añadir
		if ( !$_POST ) { // si no existe dolar POST  se muestra la vista ADD de FUNC_ACCION
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//miramos si este usuario es administrador
			if($ADMIN == true){//si el usuario es administrador mostramos la vista ADD
				$FUNC_ACCION = new FUNC_ACCION( $_REQUEST['IdFuncionalidad'], '');//Creamos un objeto de tipo FUNC_ACCION
			    $ACCION = new ACCION( '', '', '');//creamos un objeto de tipo ACCION
			    $acciones= $ACCION->DevolverAcciones();//llamamos a este metodo para devolver todas las acciones 
				$FUNCIONALIDAD = new FUNCIONALIDAD( '', '', '');//creamos un objeto de tipo FUNCIONALIDAD
				$DatosFuncionalidad = $FUNCIONALIDAD->DevolverDatosFuncionalidad($_REQUEST['IdFuncionalidad']);//llamamos a este metodo para devolver todas las funcionalidades
				new FUNC_ACCION_ADD($DatosFuncionalidad,$acciones);//mostramos una vista ADD
			}else{//si el usuario no es administrador
	            $cont=0;//iniciamos la variable cont a 0
				$PERMISO = $USUARIO->comprobarPermisos();//llamamos a esta función para comprobar los permisos del usuario
				while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos
				if($fila['IdFuncionalidad']=='3'){//miramos si este usuario tiene la funcionalidad de Gestión de FUNC_ACCION
					if($fila['IdAccion']=='6'){//miramos si este usuario tiene la acción add
				    
				     $cont=$cont+1;//incrementamos la variable con
					}
				   } 
				}
				if($cont==1){//miramos si la variable cont es uno, por tanto si el usuario tiene permiso
					$FUNC_ACCION = new FUNC_ACCION( $_REQUEST['IdFuncionalidad'], '');//creamos un objeto de tipo FUNC_ACCION
				    $ACCION = new ACCION( '', '', '');//creamos un objeto de tipo ACCION
			    	$acciones= $ACCION->DevolverAcciones();//llamamos a esta función para devolver todas las acciones
					$FUNCIONALIDAD = new FUNCIONALIDAD( '', '', '');//creamos un objeto de tipo FUNCIONALIDAD_MODEL
					$DatosFuncionalidad = $FUNCIONALIDAD->DevolverDatosFuncionalidad($_REQUEST['IdFuncionalidad']);//llamamos a este metodo para devolver todas las funcionalidades
					new FUNC_ACCION_ADD($_REQUEST['IdFuncionalidad'],$acciones);//mostramos una vista ADD
				} else {//si el usuario no tiene dicho permiso, se le indica en un mensaje
					new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
				}
			}
		} else { //Si recibe datos los recoge y mediante las funcionalidad de FUNC_ACCION_MODEL inserta los datos
			$FUNC_ACCION = get_data_form();// se pasa a la variable func_accion un objeto del modelo FUNC_ACCION
			$respuesta = $FUNC_ACCION->ADD();//obtenemos la respuesta que viene del método ADD() de la clase FUNC_ACCION
			$at = "?IdFuncionalidad=".$_REQUEST['IdFuncionalidad'];//le pasamos a la variable un valor de IdFuncionalidad
			new MESSAGE( $respuesta, "../Controllers/FUNC_ACCION_CONTROLLER.php" . $at );//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
		}
		break;
	case 'DELETE'://caso borrar
		if ( !$_POST ) { //Si no se han recibido datos se envia a la vista del formulario DELETE
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//llamamos a esta funcion para mirar si este usuario es administrador
			if($ADMIN == true){//si el usuario es administrador mostramos la vista ADD
				$FUNC_ACCION = new FUNC_ACCION( $_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ] ); //Creamos un objeto de tipo FUNC_ACCION
				$valores = $FUNC_ACCION->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ]);//con el método RellenaDatos pasaremos el valor de IdFuncionalidad y de IdAccion
                $dependencias = $FUNC_ACCION->dependencias($_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ]);//pasamos las dependencias de FUNC_ACCION a la hora de borrar
				new FUNC_ACCION_DELETE( $valores, $dependencias ); //se muestra la vista DELETE con IdFuncionalidad y IdAccion
			}else{//si el usuario no es administrador miramos si tiene dicho permiso
	            $cont=0;//iniciamos la variable cont a 0
				$PERMISO = $USUARIO->comprobarPermisos();//llamamos a esta función para comprobar los permisos del usuario
				while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos
				if($fila['IdFuncionalidad']=='3'){//miramos si este usuario tiene la funcionalidad de Gestión de FUNC_ACCION
					if($fila['IdAccion']=='6'){//miramos si este usuario tiene la acción de borrar
				   
				     $cont=$cont+1;//incrementamos la variable cont
					}
				   } 
				}
				if($cont==1){//si el usuario tiene dicho permiso
					$FUNC_ACCION = new FUNC_ACCION( $_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ] ); //en $FUNC_ACCION se le pasará un IdFuncionalidad y un IdAccion elegido en la vista DELETE.
					$valores = $FUNC_ACCION->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ]);//con el método RellenaDatos pasaremos el valor de IdFuncionalidad y de IdAccion
                    $dependencias = $FUNC_ACCION->dependencias($_REQUEST[ 'IdFuncionalidad' ], $_REQUEST[ 'IdAccion' ]);//pasamos a $dependencias las dependencias de FUNC_ACCION  a la hora de borrar
					new FUNC_ACCION_DELETE( $valores, $dependencias ); //se muestra la vista DELETE con el IdFuncionalidad y el IdAccion
				}else{//si el usuario no tiene dicho permiso, se le indica en un mensaje
				
				new MESSAGE( 'El usuario no tiene los permisos necesarios', "../Controllers/FUNCIONALIDAD_CONTROLLER.php" );//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
			}
			}			

		} else {//si existe dolar POST
			$USU_GRUPO = get_data_form(); // se le pasa a la variable $FUNC_ACCION  el IdFuncionalidad y IdAccion a eliminar
			$respuesta = $USU_GRUPO->DELETE(); // con el método DELETE de FUNC_ACCION se elimna ese IdFuncionalidad y IdAccion
			$at = "?IdFuncionalidad=".$_REQUEST['IdFuncionalidad'];//pasamos a la varianle el IdFuncionalidad
			new MESSAGE( $respuesta, "../Controllers/FUNC_ACCION_CONTROLLER.php" . $at );//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
		}
		break;
	default://caso por defecto
		$USER = new USU_GRUPO(  $_SESSION[ 'login' ],'');//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
		$ADMIN = $USER->comprobarAdmin();//llamamos a esta funcion para mirar si este usuario es administrador
		if($ADMIN == true){//miramos si el usuario  es administrador
			if ( !$_POST ) {//si no se reciben los datos
				$FUNC_ACCION = new FUNC_ACCION( $_REQUEST['IdFuncionalidad'], '');//creamos un objeto de tipo FUNC_ACCION 
			} else {//si se reciebn los datos
				$FUNC_ACCION = new FUNC_ACCION( $_REQUEST['IdFuncionalidad'], '');//creamos un objeto de tipo FUNC_ACCION 
				//$FUNC_ACCION = get_data_form();
			}
			$FUNCIONALIDAD = new FUNCIONALIDAD( '', '', '');//creamos un objeto de tipo FUNCIONALIDAD
			$DatosFuncionalidad = $FUNCIONALIDAD->DevolverDatosFuncionalidad($_REQUEST['IdFuncionalidad']);//llamamos a esta función para devolver los datos de una funcionalidad pasandole el IdFuncionalidad
			$datos = $FUNC_ACCION->SEARCH();//llamamos a la función SEARCH para buscar todas las FUNC_ACCION
			$lista = array( 'NombreFuncionalidad','NombreAccion' );//metemos e un array los campos que queremos mostrar
			new FUNC_ACCION_SHOWALL( $lista, $datos, $DatosFuncionalidad );//mostramos la vista SHOWALL de FUNC_ACCION
		} else {//si el usuario no es administrador
			$cont = 0;//iniciamos la variable cont a 0
			$PERMISO = $USER->comprobarPermisos();//llamamos a esta función para comprobar los permisos del usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos

			if($fila['IdFuncionalidad']=='3'){//miramos si este usuario tiene la funcionalidad de Gestión de FUNC_ACCION
				if($fila['IdAccion']=='6'){//miramos si este usuario tiene la acción SHOWALL
			    
			     $cont=$cont+1;//incrementamos la variable cont 
				}
			   }
			}
			if($cont>=1){//miramos si el usuario tiene dicho permiso
				if ( !$_POST ) {//si no existe dolar POST
					//se crea una instancia de la clase FUN_ACCION con parametros vacíos para que nos coga todas las tuplas de la base de datos.
					$FUNC_ACCION = new FUNC_ACCION( $_REQUEST['IdFuncionalidad'], '');
				} else {//si existe dolar POST
					//a la variable FUNC_ACCION se le pasa el IdFuncionalidad.
					$FUNC_ACCION = new FUNC_ACCION($_REQUEST['IdFuncionalidad'],'');
				}
				$FUNCIONALIDAD = new FUNCIONALIDAD( '', '', '');//creamos un objeto de tipo FUNCIONALIDAD
				$DatosFuncionalidad = $FUNCIONALIDAD->DevolverDatosFuncionalidad($_REQUEST['IdFuncionalidad']);//llamamos a esta función para que nos devuelva los datos de la funcionalidad pasandole el IdFuncionalidad

				$datos = $FUNC_ACCION->SEARCH();//con el método SEARCH en este caso buscamos todos los valores que hay en la base de datos.
				$lista = array( 'NombreFuncionalidad','NombreAccion' );//metemos en un array los campos que queremos mostrar en el SHOWALL 
				new FUNC_ACCION_SHOWALL( $lista, $datos, $DatosFuncionalidad );// se muestra la vista SHOWALL.
			}else{//si el usuario no tiene permiso se muestra una vista por defecto que no tiene nada
				new USUARIO_DEFAULT();
			}
		}
	}

?>