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
include '../Models/USU_GRUPO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Views/GRUPO_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/GRUPO_SEARCH_View.php'; //incluye la vista search
include '../Views/GRUPO_ADD_View.php'; //incluye la vista add
include '../Views/GRUPO_EDIT_View.php'; //incluye la vista edit
include '../Views/GRUPO_DELETE_View.php'; //incluye la vista delete
include '../Views/GRUPO_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje


function get_data_form() {

	$IdGrupo = $_REQUEST[ 'IdGrupo' ]; //Variable que almacena el valor de idGrupo
	$NombreGrupo = $_REQUEST[ 'NombreGrupo' ]; //Variable que almacena el valor de NomnbreGrupo
	$DescripGrupo = $_REQUEST[ 'DescripGrupo' ]; //Variable que almacena el valor de DescripGrupo
    $Funcs = null;

	$GRUPOS = new GRUPO(
		$IdGrupo,
		$NombreGrupo,
		$DescripGrupo,
		$Funcs
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
			//Crea una nueva vista del formulario añadir
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
				new GRUPO_ADD();
			}else{
            $cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='2'){
				if($fila['IdAccion']=='0'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont==1){
			new GRUPO_ADD();
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
		}
			}
		} else {//Si recive datos los recoge y mediante las funcionalidad de GRUPO inserta los datos
			$GRUPOS = get_data_form();//Variable que almacena los datos recogidos
			$GRUPOS->IdGrupo = $GRUPOS->NumRows() + 1;
			$respuesta = $GRUPOS->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/GRUPO_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
			//Variable que recoge un objecto model con solo el idgrupo
			$GRUPOS = new GRUPO( $_REQUEST[ 'IdGrupo' ], '', '','');
			//Variable que almacena el relleno de los datos utilizando el IdGrupo
			$valores = $GRUPOS->RellenaShowCurrent( $_REQUEST[ 'IdGrupo' ] );
			$valores2 = $GRUPOS->RellenaDatos( $_REQUEST[ 'IdGrupo' ] );
            $dependencias = $GRUPOS->dependencias($_REQUEST['IdGrupo']);
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'login', 'IdGrupo');
			//Crea una vista delete para ver la tupla
			new GRUPO_DELETE( $valores, $valores2, $lista, $dependencias);
			}else{
            $cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='2'){
				if($fila['IdAccion']=='1'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont==1){
			//Variable que recoge un objecto model con solo el idgrupo
			$GRUPOS = new GRUPO( $_REQUEST[ 'IdGrupo' ], '', '','');
			//Variable que almacena el relleno de los datos utilizando el IdGrupo
			$valores = $GRUPOS->RellenaShowCurrent( $_REQUEST[ 'IdGrupo' ] );
			$valores2 = $GRUPOS->RellenaDatos( $_REQUEST[ 'IdGrupo' ] );
            $dependencias = $GRUPOS->dependencias($_REQUEST['IdGrupo']);
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'login', 'IdGrupo');
			//Crea una vista delete para ver la tupla
			new GRUPO_DELETE( $valores, $valores2, $lista, $dependencias);
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
		}
			}//Si recibe valores ejecuta el borrado
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$GRUPOS = get_data_form();
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $GRUPOS->DELETE();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/GRUPO_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'EDIT'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
			//Variable que almacena un objeto model con el login
			$GRUPOS = new GRUPO( $_REQUEST[ 'IdGrupo' ], '', '', '');
			//Variable que almacena los datos de los atibutos rellenados a traves de login
			$valores = $GRUPOS->RellenaDatos( $_REQUEST[ 'IdGrupo' ] );
			$datos = $GRUPOS->RellenaSelect();
			//Muestra la vista del formulario editar
			new GRUPO_EDIT( $valores,$datos);
			}else{
            $cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='2'){
				if($fila['IdAccion']=='2'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont==1){
			//Variable que almacena un objeto model con el login
			$GRUPOS = new GRUPO( $_REQUEST[ 'IdGrupo' ], '', '', '');
			//Variable que almacena los datos de los atibutos rellenados a traves de login
			$valores = $GRUPOS->RellenaDatos( $_REQUEST[ 'IdGrupo' ] );
			$datos = $GRUPOS->RellenaSelect();
			//Muestra la vista del formulario editar
			new GRUPO_EDIT( $valores,$datos);
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
		}
			}//Si se reciben valores
		} else {
			//Variable que almacena los datos recogidos
			$GRUPOS = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $GRUPOS->EDIT($_REQUEST['IdFuncionalidad']);
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/GRUPO_CONTROLLER.php' );
		}
		//Fin del bloque
		break;
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
            new GRUPO_SEARCH();
			}else{
            $cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='2'){
				if($fila['IdAccion']=='3'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont==1){
			new GRUPO_SEARCH();
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
		}
			}
		//Si se reciben datos	
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$GRUPOS = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $GRUPOS->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'NombreGrupo','DescripGrupo');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new GRUPO_SHOWALL( $lista, $datos );
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
		//Variable que almacena un objeto model con el IdGrupo
		$GRUPOS = new GRUPO( $_REQUEST[ 'IdGrupo' ], '', '','');
		//Variable que almacena los valores rellenados a traves de IdGrupo
		$valores = $GRUPOS->RellenaShowCurrent( $_REQUEST[ 'IdGrupo' ] );
		//Variable que almacena los valores rellenados a traves de IdGrupo
		$valores2 = $GRUPOS->RellenaDatos( $_REQUEST[ 'IdGrupo' ] );
		//Variable que almacena array con el nombre de los atributos
		$lista = array( 'login', 'IdGrupo');
		//Creación de la vista showcurrent
		new GRUPO_SHOWCURRENT( $lista, $valores, $valores2 );
			}else{
            $cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='2'){
				if($fila['IdAccion']=='4'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont==1){
		//Variable que almacena un objeto model con el IdGrupo
		$GRUPOS = new GRUPO( $_REQUEST[ 'IdGrupo' ], '', '','');
		//Variable que almacena los valores rellenados a traves de IdGrupo
		$valores = $GRUPOS->RellenaShowCurrent( $_REQUEST[ 'IdGrupo' ] );
		//Variable que almacena los valores rellenados a traves de IdGrupo
		$valores2 = $GRUPOS->RellenaDatos( $_REQUEST[ 'IdGrupo' ] );
		//Variable que almacena array con el nombre de los atributos
		$lista = array( 'login', 'IdGrupo');
		//Creación de la vista showcurrent
		new GRUPO_SHOWCURRENT( $lista, $valores, $valores2 );
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/GRUPO_CONTROLLER.php' );
		}
			}
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
				$USUARIO = new USU_GRUPO(  $_SESSION[ 'login' ], '', '', '', '', '', '', '','');
		$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
				if ( !$_POST ) {//Si no se han recibido datos 
			$USUARIO = new GRUPO_MODEL( '', '', '', '');
		//Si se reciben datos
		} else {
			$USUARIO = get_data_form();
		}
		//Variable que almacena los datos de la busqueda
		$datos = $USUARIO->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array( 'login','password','DNI','Nombre','Apellidos','Correo','Direccion','Telefono');
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new GRUPO_SHOWALL( $lista, $datos );
			}else{
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
            $cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='2'){
				if($fila['IdAccion']=='5'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont==1){
		if ( !$_POST ) {//Si no se han recibido datos 
			$GRUPOS = new GRUPO( '', '', '','');
		//Si se reciben datos
		} else {
			$GRUPOS = get_data_form();
		}
		//Variable que almacena los datos de la busqueda
		$datos = $GRUPOS->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array( 'NombreGrupo','DescripGrupo');
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new GRUPO_SHOWALL( $lista, $datos );
		}else{
		 new USUARIO_DEFAULT();
		}
			}
}

?>