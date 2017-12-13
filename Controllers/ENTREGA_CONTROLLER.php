<?php
/*
	Controlador que gestiona las entregas
    Fecha de creación:28/11/2017
*/
session_start(); //solicito trabajar con la session

include '../Models/ENTREGA_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Models/TRABAJO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Functions/permisosAcc.php';
include '../Views/ENTREGA/ENTREGA_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/ENTREGA/ENTREGA_USU_SHOWALL.php'; //incluye la vista del showall
include '../Views/ENTREGA/ENTREGA_SUBIR_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/ENTREGA/ENTREGA_SEARCH_View.php'; //incluye la vista search
include '../Views/ENTREGA/ENTREGA_ADD_View.php'; //incluye la vista add
include '../Views/ENTREGA/ENTREGA_EDIT_View.php'; //incluye la vista edit
include '../Views/ENTREGA/ENTREGA_DELETE_View.php'; //incluye la vista delete
include '../Views/ENTREGA/ENTREGA_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje
include '../Views/DEFAULT_View.php'; //incluye la vista por defecto
include '../Models/USU_GRUPO_MODEL.php'; //incluye el contendio del modelo usuarios


function aleatorio(){
        $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
        $numerodeletras=10; //numero de letras para generar el texto
        $cadena = ""; //variable para almacenar la cadena generada
        for($i=0;$i<$numerodeletras;$i++)
        {       
            $cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres 
                entre el rango 0 a Numero de letras que tiene la cadena */
        }
        return $cadena;
        
        
    }

function get_data_form2() {
    
  
    
	$login = $_REQUEST['login'];
    $IdTrabajo = $_REQUEST['IdTrabajo'];
    
    $Alias = aleatorio();
  
    
    
    $Horas = $_REQUEST['Horas'];
  
    
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
   
    if (!file_exists("../Files/$login")){ 
              mkdir("../Files/$login", 0777);
   }
    
        
   /* }else{ 
    echo "El fichero no existe"; 
    } */
    

	if ( $nombreRuta != null ) {
		$dir_subida = '../Files/'.$login.'/';
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
    
    
	$action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action

	$ENTREGA = new ENTREGA_MODEL(
		$login,
        $IdTrabajo,
        $Alias,
        $Horas,
        $rutapersonal
	);
	//Devuelve el valor del objecto model creado
    
      $buscar=$ENTREGA->buscarAlias($Alias);
    
    
        while($Alias == $buscar){
            $Alias = aleatorio();
        }
    
    
   $ENTREGA = new ENTREGA_MODEL(
		$login,
        $IdTrabajo,
        $Alias,
        $Horas,
        $rutapersonal
	);
    
	return $ENTREGA;
}

function get_data_form() {
    
    
	$login = $_REQUEST['login'];
    $IdTrabajo = $_REQUEST['IdTrabajo'];
    $Alias = $_REQUEST['Alias'];
    $Horas = $_REQUEST['Horas'];
  
    
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

     if (!file_exists("../Files/$login")){ 
              mkdir('../Files/'.$login.'/', 0777);
    }

	if ( $nombreRuta != null ) {
		$dir_subida = '../Files/'.$login.'/';
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
            $ENTREGA = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $ENTREGA->comprobarAdmin();
			if($ADMIN == true){
				new ENTREGA_ADD();
			}else{
            $cont=0;
			$PERMISO = $ENTREGA->comprobarPermisos();
			while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='8'){
				if($fila['IdAccion']=='0'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   } 
			}
			if($cont==1){
			new USUARIO_ADD();
			}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ENTREGA_CONTROLLER.php' );
			}
			}
		} else {//Si recibe datos los recoge y mediante la clase ENTREGA_MODEL inserta los datos
			$ENTREGA = get_data_form2();//Variable que almacena los datos recogidos
			$respuesta = $ENTREGA->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/ENTREGA_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
            $ENTREGA = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $ENTREGA->comprobarAdmin();
			if($ADMIN == true){
			//Variable que recoge un objecto model.
			$ENTREGA = new ENTREGA_MODEL( $_REQUEST[ 'login' ], $_REQUEST[ 'IdTrabajo' ], '','', '');
			//Variable que almacena el relleno de los datos.
			$valores = $ENTREGA->RellenaDatos();
            //Crea una vista delete para ver la tupla
			new ENTREGA_DELETE($valores);
			}else{
			$cont=0;
			$PERMISO = $ENTREGA->comprobarPermisos();
						while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
			if($fila['IdFuncionalidad']=='8'){
				if($fila['IdAccion']=='1'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			  }
			}
			if($cont==1){
			//Variable que recoge un objecto model.
			$ENTREGA = new ENTREGA_MODEL( $_REQUEST[ 'login' ], $_REQUEST[ 'IdTrabajo' ], '','', '');
            //Variable que almacena el relleno de los datos.
			$valores = $ENTREGA->RellenaDatos();
			//Crea una vista delete para ver la tupla
			new ENTREGA_DELETE( $valores );
			//Si recibe valores ejecuta el borrado
			}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/ENTREGA_CONTROLLER.php' );
			}
			}
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
			if(permisosAcc($_SESSION['login'],8,2)==true){	            
            
			$ENTREGA = new ENTREGA_MODEL($_REQUEST[ 'login' ], $_REQUEST[ 'IdTrabajo' ],'', '', '');
			//Variable que almacena los datos de los atibutos rellenados 
			$valores = $ENTREGA->RellenaDatos();
			//Muestra la vista del formulario editar
			new ENTREGA_EDIT( $valores );
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/TRABAJO_CONTROLLER.php' );
			}
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
            $ENTREGA = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$ADMIN = $ENTREGA->comprobarAdmin();
			if($ADMIN == true){
				new ENTREGA_SEARCH();
			}else{
			$cont=0;
			$PERMISO = $ENTREGA->comprobarPermisos();
            while ( $fila = mysqli_fetch_array( $PERMISO ) ) {

			if($fila['IdFuncionalidad']=='8'){
				if($fila['IdAccion']=='3'){
			    //Crea una vista add para ver la tupla
			     $cont=$cont+1;
				}
			   }
			}
			if($cont>=1){
			new ENTREGA_SEARCH();
			}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/USUARIO_CONTROLLER.php' );
			}
			}
		//Si se reciben datos	
		} else {
            $ENTREGA = new USU_GRUPO( $_SESSION[ 'login' ],'');
			$PERMISO = $ENTREGA->comprobarPermisos();	
			$ADMIN = $ENTREGA->comprobarAdmin();
			//Variable que almacena los datos recogidos de los atributos
			$ENTREGA = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $ENTREGA->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array('login','IdTrabajo','Alias','Horas','Ruta');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			if($ADMIN == true){
				new ENTREGA_SHOWALL( $lista, $datos,$PERMISO,true );
			}else{
				new ENTREGA_SHOWALL( $lista, $datos,$PERMISO,false );
			}  
            /*
			//Variable que almacena los datos recogidos de los atributos
			$ENTREGA = get_data_form();
			//Variable que almacena el resultado de la busqueda
			$datos = $ENTREGA->SEARCH();
			//Variable que almacena array con el CorrectoA de los atributos
			$lista = array('login','IdTrabajo','Alias','Horas','Ruta');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
			new ENTREGA_SHOWALL( $lista, $datos );
            */
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
        $ENTREGA = new USU_GRUPO(  $_SESSION[ 'login' ],'');
			$ADMIN = $ENTREGA->comprobarAdmin();
			if($ADMIN == true){
					//Variable que almacena un objeto model
		          $ENTREGA = new ENTREGA_MODEL( $_REQUEST[ 'login' ], $_REQUEST[ 'IdTrabajo' ], '', '','');
		         //Variable que almacena los valores rellenados 
		          $valores = $ENTREGA->RellenaDatos();
                    //Creación de la vista showcurrent
		          new ENTREGA_SHOWCURRENT( $valores );
			}else{
			$cont=0;
			$PERMISO = $USUARIO->comprobarPermisos();
						while ( $fila = mysqli_fetch_array( $PERMISO ) ) {
	
			if($fila['IdFuncionalidad']=='8'){
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
		break;
        
    case 'SUBIR_ENTREGA':
           $USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
           $PERMISO = $USUARIO->comprobarPermisos();
        
          $ENTREGA = new ENTREGA_MODEL($_SESSION['login'],$_REQUEST['IdTrabajo'],'','','');
          $respuesta=$ENTREGA->comprobarCreacion();
        
        if($respuesta == false){
              $alias = aleatorio();
              $comprobar=$ENTREGA->buscarAlias($alias);
             
              while($comprobar == true){
                 $alias = aleatorio();
                $buscar=buscarAlias($Alias_Usuario);
            }
                  $ENTREGA = new ENTREGA_MODEL($_SESSION['login'],$_REQUEST['IdTrabajo'],$alias,'','');
                   $ENTREGA->ADD();
         }
          
                  
         $ENTREGA = new ENTREGA_MODEL($_SESSION['login'],$_REQUEST['IdTrabajo'],'','','');
         $datos=$ENTREGA->SEARCH();
       // var_dump($datos);
        //exit;
          $lista = array('login','IdTrabajo','Alias','Horas','Ruta');
          new ENTREGA_SHOWALL( $lista, $datos,$PERMISO,false );
        
        break;
        
	default: //Caso que se ejecuta por defecto
         $ENTREGA = new USU_GRUPO( $_SESSION[ 'login' ],'');
         $PERMISO = $ENTREGA->comprobarPermisos();
         $ADMIN = $ENTREGA->comprobarAdmin();
	if(permisosAcc($_SESSION['login'],8,5)==true){        
		if ( !$_POST ) {//Si no se han recibido datos 
          
              if($ADMIN == true){
                  $ENTREGA = new ENTREGA_MODEL( '','', '', '', '');
            }
            
               else{
                    $ENTREGA = new TRABAJO('','','','','');
                     $datos=$ENTREGA->SEARCH();
                     $lista = array('IdTrabajo','NombreTrabajo','FechaIniTrabajo','FechaFinTrabajo','PorcentajeNota');
		             new ENTREGA_USU_SHOWALL( $lista, $datos );
               }
		//Si se reciben datos
		} 
        else {
			$ENTREGA = get_data_form();
		}
		//Variable que almacena los datos de la busqueda
		$datos = $ENTREGA->SEARCH();
		//Variable que almacena array con el CorrectoA de los atributos
		$lista = array('login','IdTrabajo','Alias','Horas','Ruta');
		//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		new ENTREGA_SHOWALL( $lista, $datos,$PERMISO,true );
			}else{
				new USUARIO_DEFAULT();
			}
}

?>