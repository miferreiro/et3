<?php
/*
	Archivo php
	Nombre: USUARIO_CONTROLLER.php
	Autor: 	Jonatan Couto
	Fecha de creación: 18/11/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/
session_start(); //solicito trabajar con la session

include '../Models/USUARIO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Models/USU_GRUPO_MODEL.php';//incluye el contendio del modelo usuarios grupo
include '../Views/USUARIO/USUARIO_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/USUARIO/USUARIO_SEARCH_View.php'; //incluye la vista search
include '../Views/USUARIO/USUARIO_ADD_View.php'; //incluye la vista add
include '../Views/USUARIO/USUARIO_EDIT_View.php'; //incluye la vista edit
include '../Views/USUARIO/USUARIO_DELETE_View.php'; //incluye la vista delete
include '../Views/USUARIO/USUARIO_SHOWCURRENT_View.php'; //incluye la vista showcurrent
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
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//miramos si este usuario es administrador
			if($ADMIN == true){//si el usuario es administrador mostramos la vista ADD
				new USUARIO_ADD();
			}else{//si no es administrador
            $cont=0;//iniciamos la variable a 0
			$PERMISO = $USUARIO->comprobarPermisos();//llamamos a la función comprobarPermisos para saber los permisos que tiene el usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos
			if($fila['IdFuncionalidad']=='1'){//miramos si este usuario tiene la funcionalidad de Gestión de usuarios
				if($fila['IdAccion']=='0'){//miramos si este usuario tiene la acción de añadir
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;//si se cumple estos if incrementamos el contador a uno
				}
			   } 
			}
			if($cont==1){//miramos si la variable contador es 1, si es así mostramos la vista ADD
			new USUARIO_ADD();
			}else{//si no es igual a unose muestra un mensaje de que este usuario no tiene dichos permisos
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
			}
		} else {//Si recibe datos los recoge y mediante las funcionalidad de USUARIO_MODEL inserta los datos
			$USUARIO = get_data_form();//Variable que almacena los datos recogidos
			$respuesta = $USUARIO->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/USUARIO_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//llamando a esta función podremos saber si este usuario es administrador
			if($ADMIN == true){//miramos si este usuario es administrador
			//Variable que recoge un objecto model con solo el login
			$USUARIO = new USUARIO_MODEL( $_REQUEST[ 'login' ], '', '', '', '', '', '', '');
			//Variable que almacena el relleno de los datos utilizando el login
			$valores = $USUARIO->RellenaDatos( $_REQUEST[ 'login' ] );
			
            //mostramos todas las dependencias que tiene  tabla USUARIOS a la hora de realizar el borrado
            $dependencias = $USUARIO->dependencias($_REQUEST['login']);
            $dependencias2 = $USUARIO->dependencias2($_REQUEST['login']);
            $dependencias3 = $USUARIO->dependencias3($_REQUEST['login']);
            $dependencias4 = $USUARIO->dependencias4($_REQUEST['login']);
            $dependencias5 = $USUARIO->dependencias5($_REQUEST['login']);
            $dependencias6 = $USUARIO->dependencias6($_REQUEST['login']);
                
            //Crea una vista delete para ver la tupla
			new USUARIO_DELETE( $valores,$dependencias, $dependencias2, $dependencias3, $dependencias4, $dependencias5, $dependencias6 );
			}else{//si el usuario no es administrador
			$cont=0;//inicializamos la variable cont a 0.
			$PERMISO = $USUARIO->comprobarPermisos();//llamamos a esta función para comprobar los permisos que tiene dicho usuario
						while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se repite mientras haya permisos
			if($fila['IdFuncionalidad']=='1'){//miramos si este usuario tiene la funcionalidad de Gestión de Usuarios
				if($fila['IdAccion']=='1'){//miramos si el usuario tiene la acción para borrar
			   
			     $cont=$cont+1;//incrementamos la variable cont a uno
				}
			  }
			}
			if($cont==1){//si la variable cont es igual a uno
			//Variable que recoge un objecto model con solo el login
			$USUARIO = new USUARIO_MODEL( $_REQUEST[ 'login' ], '', '', '', '', '', '', '');
			//Variable que almacena el relleno de los datos utilizando el login
			$valores = $USUARIO->RellenaDatos( $_REQUEST[ 'login' ] );
			
             //mostramos todas las dependencias que tiene  tabla USUARIOS a la hora de realizar el borrado   
            $dependencias = $USUARIO->dependencias($_REQUEST['login']);
            $dependencias2 = $USUARIO->dependencias2($_REQUEST['login']);
            $dependencias3 = $USUARIO->dependencias3($_REQUEST['login']);
            $dependencias4 = $USUARIO->dependencias4($_REQUEST['login']);
            $dependencias5 = $USUARIO->dependencias5($_REQUEST['login']);
            $dependencias6 = $USUARIO->dependencias6($_REQUEST['login']);
            //Crea una vista delete para ver la tupla
			new USUARIO_DELETE( $dependencias, $dependencias2, $dependencias3, $dependencias4, $dependencias5, $dependencias6 );
			}else{//si la variable cont no es uno mostramos un mensaje diciendo que dicho usuario no tiene permiso
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
			}
			//Si recibe valores ejecuta el borrado
		} else {//Si recibe datos los recoge y mediante las funcionalidad de USUARIO_MODEL borra los datos
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
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//comprobamos si dicho usuario es administrador
			if($ADMIN == true){//si es el usuario es administrador
						//Variable que almacena un objeto model con el login
			$USUARIO = new USUARIO_MODEL( $_REQUEST[ 'login' ], '', '', '', '', '', '', '');
			//Variable que almacena los datos de los atibutos rellenados a traves de login
			$valores = $USUARIO->RellenaDatos( $_REQUEST[ 'login' ] );

			$datos = $USUARIO->RellenaSelect();
             

			//Muestra la vista del formulario editar
			new USUARIO_EDIT( $valores);
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
			//Muestra la vista del formulario editar
			new USUARIO_EDIT( $valores);
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
			$lista = array( 'login','DNI','Nombre','Apellidos','Correo');
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
		$lista = array( 'login','DNI','Nombre','Apellidos','Correo');
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
		$lista = array( 'login','DNI','Nombre','Apellidos','Correo');
		$PERMISO = $USER->comprobarPermisos();
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new USUARIO_SHOWALL( $lista, $datos, $PERMISO,false);

   }else{
				new USUARIO_DEFAULT();
			}
			}
}

?>