<?php
	/*
	Archivo php
	Nombre: USU_GRUPO_CONTROLLER.php
	Autor: 	Miguel Ferreiro
	Fecha de creación: 20/11/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas en la tabla USU_GRUPO
*/
session_start();//solicito trabajar con la session
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
//Si no esta autenticado se redirecciona al index
if (!IsAuthenticated()){
	//Redireción al index
 	header('Location:../index.php');
}
//incluimos las vistas asociadas para este controlador y el modelo adecuado
include '../Models/USU_GRUPO_MODEL.php';//incluye el contenido del modelo USU_GRUPO_MODEL
include '../Views/USU_GRUPO/USU_GRUPO_SHOWALL_View.php';//incluye el contenido de la vista SHOWALL de USU_GRUPO
include '../Views/USU_GRUPO/USU_GRUPO_SEARCH_View.php';//incluye el contenido de la vista SEARCH de USU_GRUPO
include '../Views/USU_GRUPO/USU_GRUPO_ADD_View.php';//incluye el contenido de la vista ADD de USU_GRUPO
include '../Views/USU_GRUPO/USU_GRUPO_DELETE_View.php';//incluye el contenido de la vista DELETE de USU_GRUPO
include '../Views/USU_GRUPO/USU_GRUPO_SHOWCURRENT_View.php';//incluye el contenido de la vista SHOWCURRENT de USU_GRUPO
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php';//incluye una vista que muestra un mensaje y vuelta atrás

//esta función asigna los valores que vinieron del formulario al modelo USU_GRUPO
function get_data_form(){
	
	$login = $_REQUEST['login'];//asigna el valor de login que vino del formulario
	$IdGrupo = $_REQUEST['IdGrupo'];//asigna el valor de grupo que vino del formulario.
	$action = $_REQUEST['action'];//asigna la acción que se eligió en el formulario.
	
	$USU_GRUPO = new USU_GRUPO(
		$login,
		$IdGrupo   
	);//instancia un objeto de la clase modelo USU_GRUPO
	
	return $USU_GRUPO; //devuelve un objeto del modelo USU_GRUPO
}

if ( !isset( $_REQUEST[ 'action' ] ) ) { //mira si no existe una acción
	$_REQUEST[ 'action' ] = ''; // si se cumple la condición se pone la acción vacía.
}


//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD': //se hace este case en el caso de que queramos insertar
		if ( !$_POST ) { // si no existe dolar POST  se muestra la vista ADD de USU_GRUPO
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//miramos si este usuario es administrador
			if($ADMIN == true){//si el usuario es administrador
				$USU_GRUPO = new USU_GRUPO( $_REQUEST['login'], '');//creamos un objeto de tipo USU_GRUPO
			    $grupos= $USU_GRUPO->RellenaShowCurrent();//llamamos este metodo para coger todos los grupos
				new USU_GRUPO_ADD($_REQUEST['login'],$grupos);//mostramos la vista ADD de USU_GRUPO
			}else{//si el usuario no es administrador
            $cont=0;//iniciamos la variable cont a 0
			$PERMISO = $USUARIO->comprobarPermisos();//llamamos a esta función para comprobar los permisos que tiene dicho usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se repite mientras haya permisos
			if($fila['IdFuncionalidad']=='1'){//miramos si este usuario tiene la funcionalidad de USU_GRUPO
				if($fila['IdAccion']=='6'){//miramos si el usuario tiene la acción para añadir
			    
			     $cont=$cont+1;//incrementamos el contador
				}
			   } 
			}
			if($cont==1){//miramos si cont es 1, por tanto si el usuario tiene el permiso de añadir.
				$USU_GRUPO = new USU_GRUPO( $_REQUEST['login'], '');//creamos un objeto de tipo USU_GRUPO pasando el login del usuario conectado
			    $grupos= $USU_GRUPO->RellenaShowCurrent();//llamamos este metodo para coger todos los grupos
				new USU_GRUPO_ADD($_REQUEST['login'],$grupos);//mostramos la vista ADD de USU_GRUPO
			}else{//si el usuario no tiene dicho permiso de añadir
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );//se muestra en una vista un mensaje diciendo que no tiene permiso el usuario y haciendo la vuelta atrás
			}
			}
		} else { // si existe dolar POST
			$USU_GRUPO = get_data_form();// se pasa a la variable USU_GRUPO un objeto del modelo USU_GRUPO
			$respuesta = $USU_GRUPO->ADD();//obtenemos la respuesta que viene del método ADD() de la clase USU_GRUPO
			$aux = "?login=".$_REQUEST['login'];//pasamos el valor del login
			new MESSAGE( $respuesta, '../Controllers/USU_GRUPO_CONTROLLER.php'.$aux );//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
		}
		break;
	case 'DELETE': //se hace este case en el caso de que queramos eliminar
		if ( !$_POST ) { // si no existe dolar POST  se muestra la vista DELETE  de USU_GRUPO con todos sus valores.
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');//creamos un objeto de tipo USU_GRUPO pasando el login del usuario conectado
			$ADMIN = $USUARIO->comprobarAdmin();//miramos si este usuario es administrador
			if($ADMIN == true){//si el usuario es administrador
			$USU_GRUPO = new USU_GRUPO( $_REQUEST[ 'login' ], $_REQUEST[ 'IdGrupo' ] ); //en $USU_GRUPO se le pasará un login y un IdGrupo elegido en la vista de SHOWALL.
			$valores = $USU_GRUPO->RellenaDatos( $_REQUEST[ 'login' ], $_REQUEST[ 'IdGrupo' ]);//con el método RellenaDatos pasaremos el valor de login y de IdGrupo
			new USU_GRUPO_DELETE( $valores ); //se muestra la vista DELETE con el login y el IdGrupo.
			}else{//si el usuario no es administrador
            $cont=0;//iniciamos la variable cont a 0
			$PERMISO = $USUARIO->comprobarPermisos();//llamamos a esta función para comprobar los permisos que tiene dicho usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se repite mientras haya permisos
			if($fila['IdFuncionalidad']=='1'){//miramos si este usuario tiene la funcionalidad de USU_GRUPO
				if($fila['IdAccion']=='6'){//miramos si el usuario tiene la acción para borrar
			  
			     $cont=$cont+1;//incrementamos la variable cont
				}
			   } 
			}
			if($cont==1){//miramos si cont es 1, por tanto si el usuario tiene el permiso de borrar
			$USU_GRUPO = new USU_GRUPO( $_REQUEST[ 'login' ], $_REQUEST[ 'IdGrupo' ] ); //en $USU_GRUPO se le pasará un login y un IdGrupo elegido en la vista de SHOWALL.
			$valores = $USU_GRUPO->RellenaDatos( $_REQUEST[ 'login' ], $_REQUEST[ 'IdGrupo' ]);//con el método RellenaDatos pasaremos el valor de login y de IdGrupo
			new USU_GRUPO_DELETE( $valores ); //se muestra la vista DELETE con el login y el IdGrupo.
			}else{//si el usuario no tiene dicho permiso
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );//se le muestra en una vista un mensaje diciendo que el usuario no tiene dichos permisos
			}
			}			

		} else {//si existe dolar POST
			$USU_GRUPO = get_data_form(); // se le pasa a la variable $USU_GRUPO el login y IdGrupo a eliminar
			$respuesta = $USU_GRUPO->DELETE(); // con el método DELETE de USU_GRUPO se elimna ese login y IdGrupo de la base de datos.
			$aux = "?login=".$_REQUEST['login'];//pasamos a la variable el valor del login
			new MESSAGE( $respuesta, '../Controllers/USU_GRUPO_CONTROLLER.php'.$aux );// se muestra en una vista un mensaje después del borrado.
		}
		break;
	default: // por defecto aparecerá la vista SHOWALL.
		$USER = new USU_GRUPO(  $_SESSION[ 'login' ],'');//se crea un objeto de tipo USU_GRUPO pasandole el login del usuario que está conectado
		$ADMIN = $USER->comprobarAdmin();//miramos si este usuario es administrador
		if($ADMIN == true){//miramos si este usuario es administrador
        if ( !$_POST ) {//si no existe dolar POST
			$USU_GRUPO = new USU_GRUPO(  $_REQUEST['login'], '');//se crea una instancia de la clase USU_GRUPO con el valor del login 
		} else {//si existe dolar POST
			$USU_GRUPO = new USU_GRUPO( $_REQUEST['login'], '');;//a la variable USU_GRUPO se le pasa un objeto USU_GRUPO con el login
		}
		$datos = $USU_GRUPO->SEARCH();//con el método SEARCH en este caso buscamos todos los valores que hay en la base de datos.
		$lista = array(  'login','NombreGrupo' );//metemos en un array los campos que queremos mostrar
		new USU_GRUPO_SHOWALL( $lista, $datos ,$_REQUEST['login']);// se muestra la vista SHOWALL.
			}else{//si el usuario no es administrador
		$cont=0;//iniciamos cont a 0
		$PERMISO = $USER->comprobarPermisos();//llamamos a esta función para comprobar los permisos del usuario
		while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se repite mientras haya permisos

			if($fila['IdFuncionalidad']=='1'){//miramos si este usuario tiene la funcionalidad de USU_GRUPO
				if($fila['IdAccion']=='6'){//miramos si el usuario tiene la acción para borrar
			    
			     $cont=$cont+1;//incrementamos la variable cont
				}
			   }
			}
			if($cont>=1){//miramos si cont es 1, por tanto si el usuario tiene el permiso de showall
		if ( !$_POST ) {//si no existe dolar POST
			$USU_GRUPO = new USU_GRUPO(  $_REQUEST['login'], '');//se crea una instancia de la clase USU_GRUPO con el valor del login
		} else {//si existe dolar POST
			$USU_GRUPO = new USU_GRUPO( $_REQUEST['login'], '');//se crea una instancia de la clase USU_GRUPO con el valor del login
		}
		$datos = $USU_GRUPO->SEARCH();//con el método SEARCH en este caso buscamos todos los valores que hay en la base de datos.
		$lista = array(  'login','NombreGrupo' );//metemos en un array los campos que queremos mostrar
		new USU_GRUPO_SHOWALL( $lista, $datos ,$_REQUEST['login']);// se muestra la vista SHOWALL.
}else{//si el usuario no tiene permiso showall se muestra una vista por defecto , que está vacía
			new USUARIO_DEFAULT();	//se muestra una vista por defecto que está vacía
			}
			}
}
?>