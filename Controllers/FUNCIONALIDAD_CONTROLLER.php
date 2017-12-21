<?php
/*
	Archivo php
	Nombre: FUNCIONALIDAD_CONTROLLER.php
	Autor: 	Miguel Ferreiro
	Fecha de creación: 27/11/2017 
	Función: controlador que realiza las FUNCIONALIDAD, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/

session_start(); //solicito trabajar con la sesión
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
//Si no esta autenticado se redirecciona al index
if (!IsAuthenticated()){
	//Redireción al index
 	header('Location:../index.php');
}

include '../Models/FUNCIONALIDAD_MODEL.php';//incluye el contendio del modelo del funcionalidad
include '../Models/USU_GRUPO_MODEL.php'; //incluye el contendio del modelo usuario grupo
include '../Views/FUNCIONALIDAD/FUNCIONALIDAD_SHOWALL_View.php';//incluye el contendio de la vista SHOWALL de funcionalidad
include '../Views/FUNCIONALIDAD/FUNCIONALIDAD_SEARCH_View.php';//incluye el contendio de la vista SEARCH de funcionalidad
include '../Views/FUNCIONALIDAD/FUNCIONALIDAD_ADD_View.php';//incluye el contendio de la vista ADD de funcionalidad
include '../Views/FUNCIONALIDAD/FUNCIONALIDAD_EDIT_View.php';//incluye el contendio de la vista EDIT de funcionalidad
include '../Views/FUNCIONALIDAD/FUNCIONALIDAD_DELETE_View.php';//incluye el contendio de la vista delete de funcionalidad
include '../Views/FUNCIONALIDAD/FUNCIONALIDAD_SHOWCURRENT_View.php';//incluye el contendio de la vista SHOWCURRENT de funcionalidad
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php';//incluye una vista que manda un mensaje de la base de datos


//Esta función crea un objeto tipo FUNCIONALIDAD_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form() {


	$IdFuncionalidad = $_REQUEST[ 'IdFuncionalidad' ];//Variable que almacena el valor de IdFuncionalidad
	$NombreFuncionalidad = $_REQUEST[ 'NombreFuncionalidad' ];//Variable que almacena el valor de NombreFuncionalidad
	$DescripFuncionalidad = $_REQUEST[ 'DescripFuncionalidad' ];//Variable que almacena el valor de DescripFuncionalidad
	$action = $_REQUEST[ 'action' ];//Variable que almacena el valor de la acción

	$FUNCIONALIDAD = new FUNCIONALIDAD(
		$IdFuncionalidad,
		$NombreFuncionalidad,
		$DescripFuncionalidad
	);//Devuelve el valor del objecto model creado

	return $FUNCIONALIDAD;
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {//Si la variable action no tiene contenido le asignamos ''
	$_REQUEST[ 'action' ] = '';
}

//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
			//Crea una nueva vista del formulario añadir
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ], '' );//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//miramos si este usuario es administrador
			if ( $ADMIN == true ) {//miramos si es administrador el usuario
				new FUNCIONALIDAD_ADD();//muestra la vista ADD de FUNCIONALIDAD
			} else {//si no es administrador
				$cont = 0;//inicializamos la variable cont a 0
				$PERMISO = $USUARIO->comprobarPermisos();//comprobamos los permisos que tiene el usuario
				while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos
					if ( $fila[ 'IdFuncionalidad' ] == '3' ) {//miramos si este usuario tiene la funcionalidad de Gestión de Funcionalidad
						if ( $fila[ 'IdAccion' ] == '0' ) {//miramos si este usuario tiene la funcionalidad de añadir
							//Crea una vista add para ver la tupla
							$cont = $cont + 1;//incrementamos la variable cont
						}
					}
				}
				if ( $cont == 1 ) {//si el usuario tiene dicho permiso
					new FUNCIONALIDAD_ADD();//mostramos el ADD de Funcionalidad
				} else {//si el usuario no tiene dicho permiso, se muestra un mensaje indicandolo
					new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
				}
			}
		} else { //Si recibe datos los recoge y mediante la funcionalidad de FUNCIONALIDAD_MODEL inserta los datos
			$FUNCIONALIDAD = get_data_form();//Variable que almacena los datos recogidos
			$respuesta = $FUNCIONALIDAD->ADD();//inserta la funcionalidad en la base de datos
			new MESSAGE( $respuesta, '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );//muestra un mensaje de la base de datos 
		}
		break;
	case 'DELETE'://caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			//Crea una nueva vista del formulario borrar
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ], '' );//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//miramos si este usuario es administrador
			if ( $ADMIN == true ) {//miramos si es administrador el usuario
				$FUNCIONALIDAD = new FUNCIONALIDAD( $_REQUEST[ 'IdFuncionalidad' ], '', '' );//creamos un objeto de tipo FUNCIONALIDAD pasandole el IdFuncionalidad
				$valores = $FUNCIONALIDAD->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ] );//llamamos al metodo RellenaDatos pasandole el IdFuncionalidad
				$dependencias = $FUNCIONALIDAD->dependencias( $_REQUEST[ 'IdFuncionalidad' ] );//pasamos a la variable $dependencias todas las depencias de FUNCIONALIDAD a la hora de borrar
				new FUNCIONALIDAD_DELETE( $valores, $dependencias );//mostramos la vista DELETE de FUNCIONALIDAD
			} else {//si el usuario no es administrador
				$cont = 0;//iniciamos la variable cont a 0
				$PERMISO = $USUARIO->comprobarPermisos();//comprobamos los permisos que tiene el usuario
				while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos
					if ( $fila[ 'IdFuncionalidad' ] == '3' ) {//miramos si este usuario tiene la funcionalidad de Gestión de Funcionalidad
						if ( $fila[ 'IdAccion' ] == '1' ) {//miramos si este usuario tiene la funcionalidad de borrar
							
							$cont = $cont + 1;//incrementamos la variable cont
						}
					}
				}
				if ( $cont == 1 ) {//si el usuario tiene el permiso de borrar
					$FUNCIONALIDAD = new FUNCIONALIDAD( $_REQUEST[ 'IdFuncionalidad' ], '', '' );//creamos un objeto de tipo FUNCIONALIDAD pasandole el IdFuncionalidad
					$valores = $FUNCIONALIDAD->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ] );//llamamos al metodo RellenaDatos pasandole el IdFuncionalidad
					$dependencias = $FUNCIONALIDAD->dependencias( $_REQUEST[ 'IdFuncionalidad' ] );//pasamos a la variable $dependencias todas las depencias de FUNCIONALIDAD a la hora de borrar
					new FUNCIONALIDAD_DELETE( $valores, $dependencias );//mostramos la vista DELETE de FUNCIONALIDAD
				} else {//si el usuario no tiene dicho permiso se le indica en un mensaje
					new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
				}
			}

		} else { //Si recibe datos los recoge y mediante la funcionalidad de FUNCIONALIDAD_MODEL borra los datos
			$FUNCIONALIDAD = get_data_form();//Variable que almacena los datos recogidos
			$respuesta = $FUNCIONALIDAD->DELETE();//borra la funcionalidad en la base de datos
			new MESSAGE( $respuesta, '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );//muestra un mensaje de la base de datos 
		}
		break;
	case 'EDIT'://caso editar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ], '' );//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$ADMIN = $USUARIO->comprobarAdmin();//miramos si este usuario es administrador
			if ( $ADMIN == true ) {//miramos si es administrador el usuario
				$FUNCIONALIDAD = new FUNCIONALIDAD( $_REQUEST[ 'IdFuncionalidad' ], '', '' );//creamos un objeto de tipo FUNCIONALIDAD pasandole el IdFuncionalidad
				$valores = $FUNCIONALIDAD->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ] );//llamamos al metodo RellenaDatos pasandole el IdFuncionalidad
				new FUNCIONALIDAD_EDIT( $valores );//mostramos la vista EDIT de FUNCIONALIDAD
			} else {//si el usuario no es administrador
				$cont = 0;//iniciamos la variable cont a 0
				$PERMISO = $USUARIO->comprobarPermisos();//comprobamos los permisos que tiene el usuario
				while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos
					if ( $fila[ 'IdFuncionalidad' ] == '3' ) {//miramos si este usuario tiene la funcionalidad de Gestión de Funcionalidad
						if ( $fila[ 'IdAccion' ] == '2' ) {//miramos si este usuario tiene la funcionalidad de editar
							
							$cont = $cont + 1;//incrementamos la variable cont
						}
					}
				}
				if ( $cont == 1 ) {//si el usuario tiene el permiso de editar
					$FUNCIONALIDAD = new FUNCIONALIDAD( $_REQUEST[ 'IdFuncionalidad' ], '', '' );//creamos un objeto de tipo FUNCIONALIDAD pasandole el IdFuncionalidad
					$valores = $FUNCIONALIDAD->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ] );//llamamos al metodo RellenaDatos pasandole el IdFuncionalidad
					new FUNCIONALIDAD_EDIT( $valores );//mostramos la vista EDIT de FUNCIONALIDAD
				} else {//si el usuario no tiene dicho permiso se le indica en un mensaje
					new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
				}
			}

		} else {//Si recibe datos los recoge y mediante la funcionalidad de FUNCIONALIDAD_MODEL edita los datos
			$FUNCIONALIDAD = get_data_form();//Variable que almacena los datos recogidos
			$respuesta = $FUNCIONALIDAD->EDIT();//edita la funcionalidad en la base de datos
			new MESSAGE( $respuesta, '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );//muestra un mensaje de la base de datos 
		}
		break;
	case 'SEARCH'://caso buscar
		$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ], '' );//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			$ADMIN = $USUARIO->comprobarAdmin();//miramos si este usuario es administrador
			if ( $ADMIN == true ) {//miramos si este usuario es administrador
				new FUNCIONALIDAD_SEARCH();//se muestra la vista SEARCH de FUNCIONALIDAD
			} else {//Si este usuario no es administrador
				$cont = 0;//iniciamos cont a 0
				$PERMISO = $USUARIO->comprobarPermisos();//comprobamos los permisos que tiene el usuario
				while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos
					if ( $fila[ 'IdFuncionalidad' ] == '3' ) {//miramos si este usuario tiene la funcionalidad de Gestión de Funcionalidad
						if ( $fila[ 'IdAccion' ] == '3' ) {//miramos si este usuario tiene la accion de buscar
							
							$cont = $cont + 1;//incrementamos la variable cont
						}
					}
				}
				if ( $cont == 1 ) {//miramos si el usuario tiene el permiso SEARCH
					new FUNCIONALIDAD_SEARCH();//mostramos la vista SEARCH de FUNCIONALIDAD
				} else {//si el usuario no tiene el permiso de buscar , se muestra un mensaje indicandolo
					new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
				}
			}
		} else {//Si recibe datos los recoge y mediante la funcionalidad de FUNCIONALIDAD_MODEL busca los datos
			$PERMISO = $USUARIO->comprobarPermisos();//comprobamos los permisos que tiene el usuario
			$FUNCIONALIDAD = get_data_form();//Variable que almacena los datos recogidos
			$datos = $FUNCIONALIDAD->SEARCH();//mostramos la vista SEARCH de FUNCIONALIDAD
			$lista = array( 'NombreFuncionalidad', 'DescripFuncionalidad' );//metemos en un array los campos que queremos mostrar
			new FUNCIONALIDAD_SHOWALL( $lista, $datos,$PERMISO,true);//mostramos la vista SHOWALL de FUNCIONALIDAD
		}
		break;

	case 'SHOWCURRENT'://caso ver en detalle
		$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ], '' );//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
		$ADMIN = $USUARIO->comprobarAdmin();//miramos si este usuario es administrador
		if ( $ADMIN == true ) {//miramos si este usuario es administrador
			$FUNCIONALIDAD = new FUNCIONALIDAD( $_REQUEST[ 'IdFuncionalidad' ], '', '' );//creamos un objeto de tipo FUNCIONALIDAD pasandole el IdFuncionalidad
			$valores = $FUNCIONALIDAD->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ] );//llamamos al metodo RellenaDatos pasandole el IdFuncionalidad
			new FUNCIONALIDAD_SHOWCURRENT( $valores );//mostramos la vista SHOWCURRENT de FUNCIONALIDAD
		} else {//Si el usuario no es administrador
			$cont = 0;//iniciamos la variable cont a 0
			$PERMISO = $USUARIO->comprobarPermisos();//comprobamos los permisos que tiene el usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos
				if ( $fila[ 'IdFuncionalidad' ] == '3' ) {//miramos si este usuario tiene la funcionalidad de Gestión de Funcionalidad
					if ( $fila[ 'IdAccion' ] == '4' ) {//miramos si este usuario tiene la accion de ver en detalle
						
						$cont = $cont + 1;//incrementamos la variable cont
					}
				}
			}
			if ( $cont == 1 ) {//si el usuario tiene permiso para ver en detalle
				$FUNCIONALIDAD = new FUNCIONALIDAD( $_REQUEST[ 'IdFuncionalidad' ], '', '' );//creamos un objeto de tipo FUNCIONALIDAD pasandole el IdFuncionalidad
				$valores = $FUNCIONALIDAD->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ] );//llamamos al metodo RellenaDatos pasandole el IdFuncionalidad
				new FUNCIONALIDAD_SHOWCURRENT( $valores );//mostramos la vista SHOWCURRENT de FUNCIONALIDAD
			} else {//si el usuario no tiene el permiso se dice en un mensaje
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
			}
		}
		break;
	default://caso por defecto
		$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ], '' );//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
		$ADMIN = $USUARIO->comprobarAdmin();//miramos si este usuario es administrador
		if ( $ADMIN == true ) {//miramos si este usuario es administrador
			if ( !$_POST ) { //Si no se han recibido datos 
				$FUNCIONALIDAD = new FUNCIONALIDAD( '', '', '' );//se crea un objeto de tipo FUNCIONALIDAD
				
			} else { //Si se reciben datos
				$FUNCIONALIDAD = get_data_form();//Variable que almacena los datos recogidos
			}
			//Variable que almacena los datos de la busqueda
			$datos = $FUNCIONALIDAD->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'NombreFuncionalidad', 'DescripFuncionalidad' );
			$PERMISO = $USUARIO->comprobarPermisos();//comprobamos los permisos que tiene el usuario
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new FUNCIONALIDAD_SHOWALL( $lista, $datos, $PERMISO, true );
		} else {//Si el usuario no es administrador
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ], '' );//creamos un objeto del modelo USU_GRUPO pasandole el usuario que está conectado
			$cont = 0;//iniciamos la variable cont a 0
			$PERMISO = $USUARIO->comprobarPermisos();//comprobamos los permisos que tiene el usuario
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va repetir mientras haya permisos
				if ( $fila[ 'IdFuncionalidad' ] == '3' ) {//miramos si este usuario tiene la funcionalidad de Gestión de Funcionalidad
					if ( $fila[ 'IdAccion' ] == '5' ) {//miramos si este usuario tiene la accion showall
						
						$cont = $cont + 1;//incrementamos el contador
					}
				}
			}
			if ( $cont == 1 ) {//sei el usuario tiene dicho permiso
				if ( !$_POST ) { //Si no se han recibido datos 
					$FUNCIONALIDAD = new FUNCIONALIDAD( '', '', '' );//se crea un objeto de tipo FUNCIONALIDAD
					//Si se reciben datos
				} else {
					$FUNCIONALIDAD = get_data_form();//Variable que almacena los datos recogidos
				}
				//Variable que almacena los datos de la busqueda
				$datos = $FUNCIONALIDAD->SEARCH();
				//Variable que almacena array con el nombre de los atributos
				$lista = array( 'NombreFuncionalidad', 'DescripFuncionalidad' );
				$PERMISO = $USUARIO->comprobarPermisos();//comprobamos los permisos que tiene el usuario
				//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
				new FUNCIONALIDAD_SHOWALL( $lista, $datos, $PERMISO, false );
			} else {//si el usuario no tiene dicho permiso muestra una vista sin nada
				new USUARIO_DEFAULT();
			}
		}
}

?>