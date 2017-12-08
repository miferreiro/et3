<?php
	/*
	Archivo php
	Nombre: USU_GRUPO_CONTROLLER.php
	Autor: 	miferreiro
	Fecha de creación: 9/10/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/
session_start();//solicito trabajar con la session
//incluimos las vistas asociadas para este controlador y el modelo adecuado
include '../Models/USU_GRUPO_MODEL.php';
include '../Views/USU_GRUPO_SHOWALL_View.php';
include '../Views/USU_GRUPO_SEARCH_View.php';
include '../Views/USU_GRUPO_ADD_View.php';
include '../Views/USU_GRUPO_DELETE_View.php';
include '../Views/USU_GRUPO_SHOWCURRENT_View.php';
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php';

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

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD': //se hace este case en el caso de que queramos insertar
		if ( !$_POST ) { // si no existe dolar POST  se muestra la vista ADD de USU_GRUPO
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
				$USU_GRUPO = new USU_GRUPO( $_REQUEST['login'], '');
			    $grupos= $USU_GRUPO->RellenaShowCurrent();
				new USU_GRUPO_ADD($_REQUEST['login'],$grupos);
			}else{
            $cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='1'){
				if($fila['IdAccion']=='6'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   } 
			}
			if($cont==1){
				$USU_GRUPO = new USU_GRUPO( $_REQUEST['login'], '');
			    $grupos= $USU_GRUPO->RellenaShowCurrent();
				new USU_GRUPO_ADD($_REQUEST['login'],$grupos);
			}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
			}
		} else { // si existe dolar POST
			$USU_GRUPO = get_data_form();// se pasa a la variable USU_GRUPO un objeto del modelo USU_GRUPO
			$respuesta = $USU_GRUPO->ADD();//obtenemos la respuesta que viene del método ADD() de la clase USU_GRUPO
			new MESSAGE( $respuesta, '../Controllers/USUARIO_CONTROLLER.php' );//mostramos en pantalla un mensaje con la respuesta y un enlace para volver al principio.
		}
		break;
	case 'DELETE': //se hace este case en el caso de que queramos eliminar
		if ( !$_POST ) { // si no existe dolar POST  se muestra la vista DELETE  de USU_GRUPO con todos sus valores.
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $USUARIO->comprobarAdmin();
			if($ADMIN == true){
			$USU_GRUPO = new USU_GRUPO( $_REQUEST[ 'login' ], $_REQUEST[ 'IdGrupo' ] ); //en $USU se le pasará un login y un IdGrupo elegido en la vista de SHOWALL.
			$valores = $USU_GRUPO->RellenaDatos( $_REQUEST[ 'login' ], $_REQUEST[ 'IdGrupo' ]);//con el método RellenaDatos pasaremos el valor de login y de IdGrupo
			new USU_GRUPO_DELETE( $valores ); //se muestra la vista DELETE con el login y el IdGrupo.
			}else{
            $cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='1'){
				if($fila['IdAccion']=='6'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   } 
			}
			if($cont==1){
			$USU_GRUPO = new USU_GRUPO( $_REQUEST[ 'login' ], $_REQUEST[ 'IdGrupo' ] ); //en $USU se le pasará un login y un IdGrupo elegido en la vista de SHOWALL.
			$valores = $USU_GRUPO->RellenaDatos( $_REQUEST[ 'login' ], $_REQUEST[ 'IdGrupo' ]);//con el método RellenaDatos pasaremos el valor de login y de IdGrupo
			new USU_GRUPO_DELETE( $valores ); //se muestra la vista DELETE con el login y el IdGrupo.
			}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
			}			

		} else {//si existe dolar POST
			$USU_GRUPO = get_data_form(); // se le pasa a la variable $USU el login y IdGrupo a eliminar
			$respuesta = $USU_GRUPO->DELETE(); // con el método DELETE de USU_GRUPO se elimna ese login y IdGrupo de la base de datos.
			new MESSAGE( $respuesta, '../Controllers/USUARIO_CONTROLLER.php' );// se muestar en una vista un mensaje después del borrado.
		}
		break;
	default: // por defecto aparecerá la vista SHOWALL.
		$USER = new USU_GRUPO(  $_SESSION[ 'login' ],'');
		$ADMIN = $USER->comprobarAdmin();
		if($ADMIN == true){
        if ( !$_POST ) {//si ni existe deolar POST
			$USU_GRUPO = new USU_GRUPO(  $_REQUEST['login'], '');//se crea una instancia de la clase USU_GRUPO con parametros vacíos para que nos coga todas las tuplas de la base de datos.
		} else {//si existe dolar POST
			$USU_GRUPO = new USU_GRUPO( $_REQUEST['login'], '');;//a la variable USU_GRUPO se le pasa el login y IdGrupo vacío.
		}
		$datos = $USU_GRUPO->SEARCH();//con el método SEARCH en este caso buscamos todos los valores que hay en la base de datos.
		$lista = array(  'login','IdGrupo' );
		new USU_GRUPO_SHOWALL( $lista, $datos ,$_REQUEST['login']);// se muestra la vista SHOWALL.
			}else{
		$cont=0;
		$PERMISO = $USER->comprobarPermisos();
		while ( $fila = mysqli_fetch_array( $PERMISO ) ) {

			if($fila['IdFuncionalidad']=='1'){
				if($fila['IdAccion']=='6'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont>=1){
		if ( !$_POST ) {//si ni existe deolar POST
			$USU_GRUPO = new USU_GRUPO(  $_REQUEST['login'], '');//se crea una instancia de la clase USU_GRUPO con parametros vacíos para que nos coga todas las tuplas de la base de datos.
		} else {//si existe dolar POST
			$USU_GRUPO = new USU_GRUPO( $_REQUEST['login'], '');;//a la variable USU_GRUPO se le pasa el login y IdGrupo vacío.
		}
		$datos = $USU_GRUPO->SEARCH();//con el método SEARCH en este caso buscamos todos los valores que hay en la base de datos.
		$lista = array(  'login','IdGrupo' );
		new USU_GRUPO_SHOWALL( $lista, $datos ,$_REQUEST['login']);// se muestra la vista SHOWALL.
}else{
			new USUARIO_DEFAULT();	
			}
			}
}
?>