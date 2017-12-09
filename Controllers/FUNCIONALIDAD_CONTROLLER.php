<?php
/*
	Archivo php
	Nombre: FUNCIONALIDAD_CONTROLLER.php
	Autor: 	miferreiro
	Fecha de creación: 27/11/2017 
	Función: controlador que realiza las FUNCIONALIDAD, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/

session_start(); //solicito trabajar con la sesión

include '../Models/FUNCIONALIDAD_MODEL.php';
include '../Models/USU_GRUPO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Views/FUNCIONALIDAD_SHOWALL_View.php';
include '../Views/FUNCIONALIDAD_SEARCH_View.php';
include '../Views/FUNCIONALIDAD_ADD_View.php';
include '../Views/FUNCIONALIDAD_EDIT_View.php';
include '../Views/FUNCIONALIDAD_DELETE_View.php';
include '../Views/FUNCIONALIDAD_SHOWCURRENT_View.php';
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Views/MESSAGE_View.php';

function get_data_form() {


	$IdFuncionalidad = $_REQUEST[ 'IdFuncionalidad' ];
	$NombreFuncionalidad = $_REQUEST[ 'NombreFuncionalidad' ];
	$DescripFuncionalidad = $_REQUEST[ 'DescripFuncionalidad' ];
	$action = $_REQUEST[ 'action' ];

	$FUNCIONALIDAD = new FUNCIONALIDAD(
		$IdFuncionalidad,
		$NombreFuncionalidad,
		$DescripFuncionalidad
	);

	return $FUNCIONALIDAD;
}


if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}

switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD':
		if ( !$_POST ) {
			//Crea una nueva vista del formulario añadir
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ], '' );
			$ADMIN = $USUARIO->comprobarAdmin();
			if ( $ADMIN == true ) {
				new FUNCIONALIDAD_ADD();
			} else {
				$cont = 0;
				$PERMISO = $USUARIO->comprobarPermisos();
				while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
					if ( $fila[ 'IdFuncionalidad' ] == '4' ) {
						if ( $fila[ 'IdAccion' ] == '0' ) {
							//Crea una vista add para ver la tupla
							$cont = $cont + 1;
						}
					}
				}
				if ( $cont == 1 ) {
					new FUNCIONALIDAD_ADD();
				} else {
					new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
				}
			}
		} else {
			$FUNCIONALIDAD = get_data_form();
			$respuesta = $FUNCIONALIDAD->ADD();
			new MESSAGE( $respuesta, '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
		}
		break;
	case 'DELETE':
		if ( !$_POST ) {
			//Crea una nueva vista del formulario borrar
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ], '' );
			$ADMIN = $USUARIO->comprobarAdmin();
			if ( $ADMIN == true ) {
				$FUNCIONALIDAD = new FUNCIONALIDAD( $_REQUEST[ 'IdFuncionalidad' ], '', '' );
				$valores = $FUNCIONALIDAD->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ] );
				$dependencias = $FUNCIONALIDAD->dependencias( $_REQUEST[ 'IdFuncionalidad' ] );
				new FUNCIONALIDAD_DELETE( $valores, $dependencias );
			} else {
				$cont = 0;
				$PERMISO = $USUARIO->comprobarPermisos();
				while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
					if ( $fila[ 'IdFuncionalidad' ] == '4' ) {
						if ( $fila[ 'IdAccion' ] == '1' ) {
							//Crea una vista add para ver la tupla
							$cont = $cont + 1;
						}
					}
				}
				if ( $cont == 1 ) {
					$FUNCIONALIDAD = new FUNCIONALIDAD( $_REQUEST[ 'IdFuncionalidad' ], '', '' );
					$valores = $FUNCIONALIDAD->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ] );
					$dependencias = $FUNCIONALIDAD->dependencias( $_REQUEST[ 'IdFuncionalidad' ] );
					new FUNCIONALIDAD_DELETE( $valores, $dependencias );
				} else {
					new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
				}
			}

		} else {
			$FUNCIONALIDAD = get_data_form();
			$respuesta = $FUNCIONALIDAD->DELETE();
			new MESSAGE( $respuesta, '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
		}
		break;
	case 'EDIT':
		if ( !$_POST ) {
			//Crea una nueva vista del formulario editar
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ], '' );
			$ADMIN = $USUARIO->comprobarAdmin();
			if ( $ADMIN == true ) {
				$FUNCIONALIDAD = new FUNCIONALIDAD( $_REQUEST[ 'IdFuncionalidad' ], '', '' );
				$valores = $FUNCIONALIDAD->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ] );
				new FUNCIONALIDAD_EDIT( $valores );
			} else {
				$cont = 0;
				$PERMISO = $USUARIO->comprobarPermisos();
				while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
					if ( $fila[ 'IdFuncionalidad' ] == '4' ) {
						if ( $fila[ 'IdAccion' ] == '2' ) {
							//Crea una vista add para ver la tupla
							$cont = $cont + 1;
						}
					}
				}
				if ( $cont == 1 ) {
					$FUNCIONALIDAD = new FUNCIONALIDAD( $_REQUEST[ 'IdFuncionalidad' ], '', '' );
					$valores = $FUNCIONALIDAD->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ] );
					new FUNCIONALIDAD_EDIT( $valores );
				} else {
					new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
				}
			}

		} else {
			$FUNCIONALIDAD = get_data_form();
			$respuesta = $FUNCIONALIDAD->EDIT();
			new MESSAGE( $respuesta, '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
		}
		break;
	case 'SEARCH':
		$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ], '' );
		if ( !$_POST ) {
			$ADMIN = $USUARIO->comprobarAdmin();
			if ( $ADMIN == true ) {
				new FUNCIONALIDAD_SEARCH();
			} else {
				$cont = 0;
				$PERMISO = $USUARIO->comprobarPermisos();
				while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
					if ( $fila[ 'IdFuncionalidad' ] == '4' ) {
						if ( $fila[ 'IdAccion' ] == '3' ) {
							//Crea una vista add para ver la tupla
							$cont = $cont + 1;
						}
					}
				}
				if ( $cont == 1 ) {
					new FUNCIONALIDAD_SEARCH();
				} else {
					new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
				}
			}
		} else {
			$PERMISO = $USUARIO->comprobarPermisos();
			$FUNCIONALIDAD = get_data_form();
			$datos = $FUNCIONALIDAD->SEARCH();
			$lista = array( 'IdFuncionalidad', 'NombreFuncionalidad', 'DescripFuncionalidad' );
			new FUNCIONALIDAD_SHOWALL( $lista, $datos,$PERMISO,true);
		}
		break;

	case 'SHOWCURRENT':
		$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ], '' );
		$ADMIN = $USUARIO->comprobarAdmin();
		if ( $ADMIN == true ) {
			$FUNCIONALIDAD = new FUNCIONALIDAD( $_REQUEST[ 'IdFuncionalidad' ], '', '' );
			$valores = $FUNCIONALIDAD->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ] );
			new FUNCIONALIDAD_SHOWCURRENT( $valores );
		} else {
			$cont = 0;
			$PERMISO = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
				if ( $fila[ 'IdFuncionalidad' ] == '4' ) {
					if ( $fila[ 'IdAccion' ] == '4' ) {
						//Crea una vista add para ver la tupla
						$cont = $cont + 1;
					}
				}
			}
			if ( $cont == 1 ) {
				$FUNCIONALIDAD = new FUNCIONALIDAD( $_REQUEST[ 'IdFuncionalidad' ], '', '' );
				$valores = $FUNCIONALIDAD->RellenaDatos( $_REQUEST[ 'IdFuncionalidad' ] );
				new FUNCIONALIDAD_SHOWCURRENT( $valores );
			} else {
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/FUNCIONALIDAD_CONTROLLER.php' );
			}
		}
		break;
	default:
		$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ], '' );
		$ADMIN = $USUARIO->comprobarAdmin();
		if ( $ADMIN == true ) {
			if ( !$_POST ) { //Si no se han recibido datos 
				$FUNCIONALIDAD = new FUNCIONALIDAD( '', '', '' );
				//Si se reciben datos
			} else {
				$FUNCIONALIDAD = get_data_form();
			}
			//Variable que almacena los datos de la busqueda
			$datos = $FUNCIONALIDAD->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array( 'IdFuncionalidad', 'NombreFuncionalidad', 'DescripFuncionalidad' );
			$PERMISO = $USUARIO->comprobarPermisos();
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new FUNCIONALIDAD_SHOWALL( $lista, $datos, $PERMISO, true );
		} else {
			$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ], '' );
			$cont = 0;
			$PERMISO = $USUARIO->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
				if ( $fila[ 'IdFuncionalidad' ] == '3' ) {
					if ( $fila[ 'IdAccion' ] == '5' ) {
						//Crea una vista add para ver la tupla
						$cont = $cont + 1;
					}
				}
			}
			if ( $cont == 1 ) {
				if ( !$_POST ) { //Si no se han recibido datos 
					$FUNCIONALIDAD = new FUNCIONALIDAD( '', '', '' );
					//Si se reciben datos
				} else {
					$FUNCIONALIDAD = get_data_form();
				}
				//Variable que almacena los datos de la busqueda
				$datos = $FUNCIONALIDAD->SEARCH();
				//Variable que almacena array con el nombre de los atributos
				$lista = array( 'IdFuncionalidad', 'NombreFuncionalidad', 'DescripFuncionalidad' );
				$PERMISO = $USUARIO->comprobarPermisos();
				//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
				new FUNCIONALIDAD_SHOWALL( $lista, $datos, $PERMISO, false );
			} else {
				new USUARIO_DEFAULT();
			}
		}
}

?>