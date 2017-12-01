<?php
/*
	Controlador que gestiona las entregas
    Fecha de creación:28/11/2017
*/
session_start(); //solicito trabajar con la session

include '../Models/ENTREGA_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Views/ENTREGA_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/ENTREGA_SEARCH_View.php'; //incluye la vista search
include '../Views/ENTREGA_ADD_View.php'; //incluye la vista add
include '../Views/ENTREGA_EDIT_View.php'; //incluye la vista edit
include '../Views/ENTREGA_DELETE_View.php'; //incluye la vista delete
include '../Views/ENTREGA_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje


function get_data_form() {

	$login = $_REQUEST['login'];
    $IdTrabajo = $_REQUEST['IdTrabajo'];
    $Alias = $_REQUEST['Alias'];
    $Horas = $_REQUEST['Horas'];
   // $Ruta= $_REQUEST['Ruta'];
    
    	if ( isset( $_FILES[ 'Ruta' ][ 'name' ] ) ) {
		$nombreRuta = $_FILES[ 'Ruta' ][ 'name' ];
	} else {
		$nombreRuta = null;
	}

	if ( isset( $_FILES[ 'Ruta' ][ 'tmp_name' ] ) ) {
		$nombreTempRuta = $_FILES[ 'Ruta' ][ 'tmp_name' ];
	} else {
		$nombreTempRuta = null;
	}


	if ( $nombreRuta != null ) {
		$dir_subida = '../Files/';
		$rutapersonal = $dir_subida . $nombreRuta;
		move_uploaded_file( $nombreTempRuta, $rutapersonal );
	}
   else{
    if(isset($_POST['ruta2'])){
                        $rutapersonal=$_POST['ruta2'];
                }else{

                    $rutapersonal=null;
                }
                }
    
    
    
    /*
   if(isset($_FILES['Ruta']['name'])){
                    $nombreRuta = $_FILES['Ruta']['name'];
        }else{
                    $nombreRuta = null;
        }
    if(isset($_FILES['Ruta']['type'])){
                    $tipoRuta = $_FILES['Ruta']['type'];
            }else{
                    $tipoRuta = null;
                }
     if(isset($_FILES['Ruta']['tmp_name'])){
                    $nombreTempRuta = $_FILES['Ruta']['tmp_name'];
                }else{
                    $nombreTempRuta = null;
                }
    if(isset($_FILES['Ruta']['size'])){
                    $tamanhoRuta = $_FILES['Ruta']['size']; 
                }else{
                    $tamanhoRuta = null;
                }
                        

    if($nombreRuta != null){

                    $ruta = '../Files/';
                    $extension = substr($tipoRuta, -3,3);
                    $rutapersonal = $ruta . $login . ".". $extension;
                   //NOTA CAMBIAR LOS PERMISOS A 777
                    move_uploaded_file($nombreTempRuta, $rutapersonal);
                    
    }else{
    if(isset($_POST['ruta2'])){
                        $rutapersonal=$_POST['ruta2'];
                }else{

                    $rutapersonal=null;
                }
                }
    */
    
   /* 
     $nombre =  $_FILES['Ruta']['name'];            //nombre con el que lo subió el usuario
            $tipo =  $_FILES['Ruta']['type'];            //tipo de archivo (jpg,gif,rar,txt,etc)
            $tamano = $_FILES['Ruta']['size'];            //tamaño del archivo en Kb; 1024Kb = 1Mb
            $error = $_FILES['Ruta']['error'];            //si apareció algún error en la subida
            $nombre_temporal = $_FILES['Ruta']['tmp_name'];    //Nombre temporal que se le asigna al archivo cuando sube a tu servidor
 
            $nuevo_nombre = 'EL Archivo';
                
                // $ruta = '../Files/';
                    //$extension = substr($tipoRuta, -3,3);
                   // $rutapersonal = $ruta . $login . ".". $extension;
 
//Reviso que el archivo sea del tipo ZIP o RAR; y que pese menos de 5Mb
                    if (!((strpos($tipo, "rar") || strpos($tipo, "zip")) && ($tamano< 5120))) { 
        echo "El tipo de archivo o el tamaño no es correcto.";
}else{ 
       //Verifico que pueda mover el archivo y cambiarle el nombre. El archivo se guardará donde esta la pagina
    if (move_uploaded_file(FILES['Ruta']['tmp_name'], $nuevo_nombre)){ 
           echo "El archivo subió!!."; 
       }else{ 
           echo "Error al subir el archivo. Inténtelo nuevamente."; 
       } 
} 

   */
    
	$action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action

	$ENTREGA = new ENTREGA_MODEL(
		$login,
        $IdTrabajo,
        $Alias,
        $Horas,
        $rutapersonal
	);
	//Devuelve el valor del objecto model creado
	return $ENTREGA;
}
//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
			new ENTREGA_ADD();
		} else {//Si recibe datos los recoge y mediante la clase ENTREGA_MODEL inserta los datos
			$ENTREGA = get_data_form();//Variable que almacena los datos recogidos
			$respuesta = $ENTREGA->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/ENTREGA_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			//Variable que recoge un objecto model.
			$ENTREGA = new ENTREGA_MODEL( $_REQUEST[ 'login' ], $_REQUEST[ 'IdTrabajo' ], '','', '');
			//Variable que almacena el relleno de los datos.
			$valores = $ENTREGA->RellenaDatos();
			//Crea una vista delete para ver la tupla
			new ENTREGA_DELETE( $valores );
			//Si recibe valores ejecuta el borrado
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$ENTREGA = get_data_form();
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $ENTREGA->DELETE();
			//crea una vista mensaje con la respuesta.
			new MESSAGE( $respuesta, '../Controllers/ENTREGA_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'EDIT'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			//Variable que almacena un objeto model 
			$ENTREGA = new ENTREGA_MODEL($_REQUEST[ 'login' ], $_REQUEST[ 'IdTrabajo' ],'', '', '');
			//Variable que almacena los datos de los atibutos rellenados 
			$valores = $ENTREGA->RellenaDatos();
			//Muestra la vista del formulario editar
			new ENTREGA_EDIT( $valores );
			//Si se reciben valores
		} else {
			//Variable que almacena los datos recogidos
			$ENTREGA = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $ENTREGA->EDIT();
			//crea una vista mensaje con la respuesta
			new MESSAGE( $respuesta, '../Controllers/ENTREGA_CONTROLLER.php' );
		}
		//Fin del bloque
		break;
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			new ENTREGA_SEARCH();
		//Si se reciben datos	
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$ENTREGA = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $ENTREGA->SEARCH();
			//Variable que almacena array con el CorrectoA de los atributos
			$lista = array('login','IdTrabajo','Alias','Horas','Ruta');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new ENTREGA_SHOWALL( $lista, $datos );
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		//Variable que almacena un objeto model
		$ENTREGA = new ENTREGA_MODEL( $_REQUEST[ 'login' ], $_REQUEST[ 'IdTrabajo' ], '', '','');
		//Variable que almacena los valores rellenados 
		$valores = $ENTREGA->RellenaDatos();
		//Creación de la vista showcurrent
		new ENTREGA_SHOWCURRENT( $valores );
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
		if ( !$_POST ) {//Si no se han recibido datos 
			$ENTREGA = new ENTREGA_MODEL( '','', '', '', '');
		//Si se reciben datos
		} else {
			$ENTREGA = get_data_form();
		}
		//Variable que almacena los datos de la busqueda
		$datos = $ENTREGA->SEARCH();
		//Variable que almacena array con el CorrectoA de los atributos
		$lista = array('login','IdTrabajo','Alias','Horas','Ruta');
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new ENTREGA_SHOWALL( $lista, $datos );
}

?>