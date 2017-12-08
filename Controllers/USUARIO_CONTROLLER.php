<?php
/*
	Archivo php
	Nombre: USUARIO_CONTROLLER.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/
session_start(); //solicito trabajar con la session

include '../Models/USUARIO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Models/USU_GRUPO_MODEL.php';//incluye el contendio del modelo usuarios grupo
include '../Views/USUARIO_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/USUARIO_SEARCH_View.php'; //incluye la vista search
include '../Views/USUARIO_ADD_View.php'; //incluye la vista add
include '../Views/USUARIO_EDIT_View.php'; //incluye la vista edit
include '../Views/USUARIO_DELETE_View.php'; //incluye la vista delete
include '../Views/USUARIO_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje


function get_data_form() {

	$login = $_REQUEST[ 'login' ]; //Variable que almacena el valor de login
	$password = $_REQUEST[ 'password' ]; //Variable que almacena el valor de password
	$dni = $_REQUEST[ 'DNI' ]; //Variable que almacena el valor de dni
	$nombre = $_REQUEST[ 'nombre' ]; //Variable que almacena el valor de nombre
	$apellidos = $_REQUEST[ 'apellidos' ]; //Variable que almacena el valor de apellidos
	$correo = $_REQUEST[ 'email' ]; //Variable que almacena el valor de correo
	$direccion = $_REQUEST[ 'direc' ]; //Variable que almacena el valor de direccion
	$telefono = $_REQUEST[ 'telefono' ]; //Variable que almacena el valor de telefono
	$action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action

	$USUARIO = new USUARIO_MODEL(
		$login,
		$password,
		$dni,
		$nombre,
		$apellidos,
		$correo,
		$direccion,
		$telefono
	);
	//Devuelve el valor del objecto model creado
	return $USUARIO;
}
//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
				new USUARIO_ADD();
			}else{
            $cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='1'){
				if($fila['IdAccion']=='0'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   } 
			}
			if($cont==1){
			new USUARIO_ADD();
			}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
			}
		} else {//Si recive datos los recoge y mediante las funcionalidad de USUARIO_MODEL inserta los datos
			$USUARIO = get_data_form();//Variable que almacena los datos recogidos
			$respuesta = $USUARIO->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/USUARIO_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
			//Variable que recoge un objecto model con solo el login
			$USUARIO = new USUARIO_MODEL( $_REQUEST[ 'login' ], '', '', '', '', '', '', '');
			//Variable que almacena el relleno de los datos utilizando el login
			$valores = $USUARIO->RellenaDatos( $_REQUEST[ 'login' ] );
			
            $dependencias = $USUARIO->dependencias($_REQUEST['login']);
            //Crea una vista delete para ver la tupla
			new USUARIO_DELETE( $valores, $dependencias );
			}else{
			$cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
						while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='1'){
				if($fila['IdAccion']=='1'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			  }
			}
			if($cont==1){
			//Variable que recoge un objecto model con solo el login
			$USUARIO = new USUARIO_MODEL( $_REQUEST[ 'login' ], '', '', '', '', '', '', '');
			//Variable que almacena el relleno de los datos utilizando el login
			$valores = $USUARIO->RellenaDatos( $_REQUEST[ 'login' ] );
			
            $dependencias = $USUARIO->dependencias($_REQUEST['login']);
            //Crea una vista delete para ver la tupla
			new USUARIO_DELETE( $valores, $dependencias );
			}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
			}
			//Si recibe valores ejecuta el borrado
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$USUARIO = get_data_form();
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $USUARIO->DELETE();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/USUARIO_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'EDIT'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
						//Variable que almacena un objeto model con el login
			$USUARIO = new USUARIO_MODEL( $_REQUEST[ 'login' ], '', '', '', '', '', '', '');
			//Variable que almacena los datos de los atibutos rellenados a traves de login
			$valores = $USUARIO->RellenaDatos( $_REQUEST[ 'login' ] );
			$datos = $USUARIO->RellenaSelect();
			//Muestra la vista del formulario editar
			new USUARIO_EDIT( $valores,$datos);
			}else{
			$cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
						while ( $fila = mysqli_fetch_array( $PERMISO ) ) {

			if($fila['IdFuncionalidad']=='1'){
				if($fila['IdAccion']=='2'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont>=1){
			//Variable que almacena un objeto model con el login
			$USUARIO = new USUARIO_MODEL( $_REQUEST[ 'login' ], '', '', '', '', '', '', '');
			//Variable que almacena los datos de los atibutos rellenados a traves de login
			$valores = $USUARIO->RellenaDatos( $_REQUEST[ 'login' ] );
			$datos = $USUARIO->RellenaSelect();
			//Muestra la vista del formulario editar
			new USUARIO_EDIT( $valores,$datos);
			}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
			}
			//Si se reciben valores
		} else {
			//Variable que almacena los datos recogidos
			$USUARIO = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $USUARIO->EDIT();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/USUARIO_CONTROLLER.php' );
		}
		//Fin del bloque
		break;
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
				new USUARIO_SEARCH();
			}else{
			$cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
						while ( $fila = mysqli_fetch_array( $PERMISO ) ) {

			if($fila['IdFuncionalidad']=='1'){
				if($fila['IdAccion']=='3'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont>=1){
			new USUARIO_SEARCH();
			}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
			}
		//Si se reciben datos	
		} else {
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$PERMISO = $USUARIO->comprobarPermisos();	
			$ADMIN = $USUARIO->comprobarAdmin();
			//Variable que almacena los datos recogidos de los atributos
			$USUARIO = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $USUARIO->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'login','password','DNI','Nombre','Apellidos','Correo','Direccion','Telefono');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			if($ADMIN == true){
				new USUARIO_SHOWALL( $lista, $datos,$PERMISO,true );
			}else{
				new USUARIO_SHOWALL( $lista, $datos,$PERMISO,false );
			}
			
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		$USUARIO = new USU_GRUPO(  $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
					//Variable que almacena un objeto model con el login
		           $USUARIO = new USUARIO_MODEL( $_REQUEST[ 'login' ], '', '', '', '', '', '', '');
		//Variable que almacena los valores rellenados a traves de login
		           $valores = $USUARIO->RellenaDatos( $_REQUEST[ 'login' ] );
		           //Creación de la vista showcurrent
		           new USUARIO_SHOWCURRENT( $valores );
			}else{
			$cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
						while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
	
			if($fila['IdFuncionalidad']=='1'){
				if($fila['IdAccion']=='4'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont>=1){
		//Variable que almacena un objeto model con el login
		$USUARIO = new USUARIO_MODEL( $_REQUEST[ 'login' ], '', '', '', '', '', '', '');
		//Variable que almacena los valores rellenados a traves de login
		$valores = $USUARIO->RellenaDatos( $_REQUEST[ 'login' ] );
		//Creación de la vista showcurrent
		new USUARIO_SHOWCURRENT( $valores );
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
		}
		}
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
		$USER = new USU_GRUPO(  $_SESSION[ 'login' ],'');
		$ADMIN = $USER->comprobarAdmin();
			if($ADMIN == true){
				if ( !$_POST ) {//Si no se han recibido datos 
			$USUARIO = new USUARIO_MODEL( '', '', '', '', '', '', '', '');
		//Si se reciben datos
		} else {
			$USUARIO = get_data_form();
		}
		//Variable que almacena los datos de la busqueda
		$datos = $USUARIO->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array( 'login','password','DNI','Nombre','Apellidos','Correo','Direccion','Telefono');
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		$PERMISO = $USER->comprobarPermisos();
		new USUARIO_SHOWALL( $lista, $datos, $PERMISO,true);
			}else{
		$cont=0;
		$PERMISO = $USER->comprobarPermisos();
		while ( $fila = mysqli_fetch_array( $PERMISO ) ) {

			if($fila['IdFuncionalidad']=='1'){
				if($fila['IdAccion']=='5'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont>=1){
		if ( !$_POST ) {//Si no se han recibido datos 
			$USUARIO = new USUARIO_MODEL( '', '', '', '', '', '', '', '');
		//Si se reciben datos
		} else {
			$USUARIO = get_data_form();
		}
		//Variable que almacena los datos de la busqueda
		$datos = $USUARIO->SEARCH();
		//Variable que almacena array con el nombre de los atributos
		$lista = array( 'login','password','DNI','Nombre','Apellidos','Correo','Direccion','Telefono');
		$PERMISO = $USER->comprobarPermisos();
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new USUARIO_SHOWALL( $lista, $datos, $PERMISO,false);

   }else{
				new USUARIO_DEFAULT();
			}
			}
}

?>