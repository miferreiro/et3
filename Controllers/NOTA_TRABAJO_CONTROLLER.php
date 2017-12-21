<?php
/*
	Fecha de creación: 4/12/2017 
    Autor:Brais Rodriguez
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas en la tabla NOTA_TRABAJO
*/
session_start(); //solicito trabajar con la session
include '../Functions/Authentication.php'; //incluye el contenido de la función de autentificación
//Si no esta autenticado se redirecciona al index
if (!IsAuthenticated()){
	//Redireción al index
 	header('Location:../index.php');
}

include '../Models/NOTA_TRABAJO_MODEL.php'; //incluye el contendio del modelo NOTA_TRABAJO
include '../Models/ENTREGA_MODEL.php'; //incluye el contendio del modelo ENTREGA
include '../Models/EVALUACION_MODEL.php'; //incluye el contendio del modelo EVALUACION
include '../Models/USU_GRUPO_MODEL.php'; //incluye el contendio del modelo USU_GRUPO
include '../Models/TRABAJO_MODEL.php'; //incluye el contendio del modelo TRABAJO
include_once '../Models/USUARIO_MODEL.php'; //incluye el contendio del modelo USUARIO
include '../Functions/permisosAcc.php';//incluye el contenido del fichero permisosAcc.php
include '../Functions/comprobarAdministrador.php';//incluye el contenido del fichero comprobarAministrador.php
include '../Views/NOTA_TRABAJO/NOTA_TRABAJO_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/NOTA_TRABAJO/NOTA_TRABAJO_GENERAR_NOTA_ENTREGA_View.php'; //incluye la vista del fichero NOTA_TRABAJO_GENERAR_NOTA_ENTREGA_View.php
include '../Views/NOTA_TRABAJO/NOTA_TRABAJO_GENERAR_NOTA_QA_View.php'; //incluye la vista del fichero NOTA_TRABAJO_GENERAR_NOTA_QA_View.php
include '../Views/NOTA_TRABAJO/NOTA_TRABAJO_SEARCH_View.php'; //incluye la vista search
include '../Views/NOTA_TRABAJO/NOTA_TRABAJO_ADD_View.php'; //incluye la vista add
include '../Views/NOTA_TRABAJO/NOTA_TRABAJO_EDIT_View.php'; //incluye la vista edit
include '../Views/NOTA_TRABAJO/NOTA_TRABAJO_DELETE_View.php'; //incluye la vista delete
include '../Views/NOTA_TRABAJO/NOTA_TRABAJO_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/DEFAULT_View.php';//incluye una vista por defecto
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje

//Esta función crea un objeto tipo NOTA_TRABAJO_MODEL con los valores que se le pasan con $_REQUEST
function get_data_form() {


	$IdTrabajo = $_REQUEST['IdTrabajo'];//Variable que almacena el valor de IdTrabajo
    $login = $_REQUEST['login'];//Variable que almacena el valor de login
    $NotaTrabajo = $_REQUEST['NotaTrabajo'];//Variable que almacena el valor de NotaTrabajo
    $action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action
	$NOTAS = new NOTA_TRABAJO_MODEL(
		$IdTrabajo,
        $login,
        $NotaTrabajo
	);
	//Devuelve el valor del objecto model creado
	return $NOTAS;
}



//Si la variable action no tiene contenido le asignamos ''
if ( !isset( $_REQUEST[ 'action' ] ) ) {
	$_REQUEST[ 'action' ] = '';
	
}
//Estructura de control, que realiza un determinado caso dependiendo del valor action
switch ( $_REQUEST[ 'action' ] ) {
	case 'ADD'://Caso añadir
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario ADD
			if(permisosAcc($_SESSION['login'],7,0)==true){//miramos si el usuario tiene permiso para añadir
			$USUARIO= new USUARIO_MODEL('','','','','','','','');//creamos un objeto de tipo USUARIO_MODEL
			$USUARIOS=$USUARIO->SEARCH();//llamamos al método SEARCH para obtener todos los usuarios			
			$TRABAJO= new TRABAJO('','','','','');//creamos un objeto de tipo TRABAJO
			$TRABAJOS=$TRABAJO->SEARCH2();//llamamos al método SEARCH2 para obtener todos los trabajos
			//Crea una vista add para ver la tupla
			new NOTA_TRABAJO_ADD($USUARIOS,$TRABAJOS);
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );
			}
		} else {//Si recibe datos los recoge y mediante las funcionalidad de NOTA_TRABAJO_MODEL inserta los datos
			$NOTAS = get_data_form();//Variable que almacena los datos recogidos
			$respuesta = $NOTAS->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			if(permisosAcc($_SESSION['login'],7,1)==true){
			//Variable que recoge un objecto model
			$NOTAS = new NOTA_TRABAJO_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'login' ],'');
			//Variable que almacena el relleno de los datos
			$valores = $NOTAS->RellenaDatos();
            //Crea una vista delete para ver la tupla
			new NOTA_TRABAJO_DELETE($valores);
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );
			}
			//Si recibe valores ejecuta el borrado
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$NOTAS = get_data_form();
           
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $NOTAS->DELETE();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'EDIT'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			if(permisosAcc($_SESSION['login'],7,2)==true){
			//Variable que almacena un objeto model
			$NOTAS = new NOTA_TRABAJO_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'login' ],'');
			//Variable que almacena los datos de los atibutos rellenados a traves de login
			$valores = $NOTAS->RellenaDatos();
			new NOTA_TRABAJO_EDIT($valores);
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );
			}
			//Si se reciben valores
		} else {
			//Variable que almacena los datos recogidos
			$NOTAS = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $NOTAS->EDIT();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );
		}
		//Fin del bloque
		break;
        
    case 'GENERAR_NOTA_ENTREGA':
             $USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
             $ADMIN = $USUARIO->comprobarAdmin();
             
        
           if(!$_POST){
                 if(permisosAcc($_SESSION['login'],7,13)==true){
                 $TRABAJOS= new TRABAJO('','','','','');
			     $datos=$TRABAJOS->SEARCH2();
                 new GENERAR_NOTA_ET($datos);
                
            }
            else{  
                new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );
            }
        }
        
      else{
                 $ENTREGA = new ENTREGA_MODEL('','','','','');
                 $dat=$ENTREGA->cogerDatos($_REQUEST['IdTrabajo']);
                 $NOTAS = new NOTA_TRABAJO_MODEL('','','','','');
                 
                 while($fila = mysqli_fetch_array($dat)){
                     $existe=$NOTAS->siExiste($fila['login'],$fila['IdTrabajo']);
                     
                     if($existe == false){
                         $NOTAS = new NOTA_TRABAJO_MODEL($fila['IdTrabajo'],$fila['login'], '');
                         $NOTAS->ADD();
                         
                            
                     $nota = $NOTAS->calcularNota($fila['login'],$fila['IdTrabajo']);
                  
                     $porcentaje = $NOTAS->notasUsuario($fila['IdTrabajo']);
                     
                     $notaET = $nota * ($porcentaje[0]/100);
                    
                     $NOTAS->actualizar($fila['login'],$fila['IdTrabajo'],$notaET);
                     $respuesta="Notas generadas correctamente";
                     new MESSAGE($respuesta,'../Controllers/NOTA_TRABAJO_CONTROLLER.php');
                         
                     }
                    else{
                         
                     $nota = $NOTAS->calcularNota($fila['login'],$fila['IdTrabajo']);
                     $porcentaje = $NOTAS->notasUsuario($fila['IdTrabajo']);
                     $notaET = $nota * ($porcentaje[0]/100);
                      
                     $NOTAS->actualizar($fila['login'],$fila['IdTrabajo'],$notaET);
                     $respuesta="Notas generadas correctamente";
                      new MESSAGE($respuesta,'../Controllers/NOTA_TRABAJO_CONTROLLER.php');
                    }
                     
                     
                  
                 }
                    $respuesta="Las notas no se pudieron generar";
                    new MESSAGE($respuesta,'../Controllers/NOTA_TRABAJO_CONTROLLER.php');

      }
        
    break;    
        
    case 'GENERAR_NOTA_QA':
        
         $USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
         $ADMIN = $USUARIO->comprobarAdmin();
        
        if(!$_POST){
        
           if(permisosAcc($_SESSION['login'],7,8)==true){
               $TRABAJOS= new TRABAJO('','','','','');
			   $datos=$TRABAJOS->SEARCH3();
               new GENERAR_NOTA_QA($datos);  
               
            }
            else{
                
                new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );
            }
        }
            
        
         else{
            
                 $EVALUACION = new EVALUACION('','','','','','','','','');
                 $dat=$EVALUACION->cogerDatosQA($_REQUEST['IdTrabajo']);
                 $NOTAS = new NOTA_TRABAJO_MODEL('','','','','');
                // $notas=array();
                 
                 while($fila = mysqli_fetch_array($dat)){
                     
                     $existe=$NOTAS->siExiste($fila['LoginEvaluador'],$fila['IdTrabajo']);
                     
                     if($existe == false){
                         $NOTAS = new NOTA_TRABAJO_MODEL($fila['IdTrabajo'],$fila['LoginEvaluador'], '');
                         $NOTAS->ADD();
                         
                     $nota = $NOTAS->calcularNotaQA($fila['LoginEvaluador'],$fila['IdTrabajo']);
                     $porcentaje = $NOTAS->notasUsuario($fila['IdTrabajo']);
                     $notaET = $nota * ($porcentaje[0]/100);
                     //$notas[$fila['LoginEvaluador'].$fila['IdTrabajo']] = $notaET;
                     $NOTAS->actualizar($fila['LoginEvaluador'],$fila['IdTrabajo'],$notaET);
                     $respuesta="Notas generadas correctamente";
                     new MESSAGE($respuesta,'../Controllers/NOTA_TRABAJO_CONTROLLER.php');
                         
                     }
                    else{
                     $nota = $NOTAS->calcularNotaQA($fila['LoginEvaluador'],$fila['IdTrabajo']);
                     $porcentaje = $NOTAS->notasUsuario($fila['IdTrabajo']);
                     $notaET = $nota * ($porcentaje[0]/100);
                    // $notas[$fila['LoginEvaluador'].$fila['IdTrabajo']] = $notaET;
                     $NOTAS->actualizar($fila['LoginEvaluador'],$fila['IdTrabajo'],$notaET);
                      $respuesta="Notas generadas correctamente";
                      new MESSAGE($respuesta,'../Controllers/NOTA_TRABAJO_CONTROLLER.php');
                    
                    }
        }
                    $respuesta="Las notas no se pudieron generar";
                    new MESSAGE($respuesta,'../Controllers/NOTA_TRABAJO_CONTROLLER.php');
        
         }
        break;
        
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			if(permisosAcc($_SESSION['login'],7,3)==true){
			new NOTA_TRABAJO_SEARCH();
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );
			}
		//Si se reciben datos	
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$NOTAS = get_data_form();
			//Variable que almacena el resultado de la busquedaS
			$datos = $NOTAS->SEARCH();
			//Variable que almacena array con el nombre de los atributos
			$lista = array('NombreTrabajo','login','NotaTrabajo');
			//Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
            if(comprobarAdministrador($_SESSION['login']) == true){
                new NOTA_TRABAJO_SHOWALL( $lista, $datos,false );
            }
            else
                 new NOTA_TRABAJO_SHOWALL( $lista, $datos,true );
			
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		if(permisosAcc($_SESSION['login'],7,4)==true){
		//Variable que almacena un objeto model con el login
		$NOTAS = new NOTA_TRABAJO_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST['login'],'');
		//Variable que almacena los valores rellenados a traves de login
		$valores = $NOTAS->RellenaDatos();
		//Creación de la vista showcurrent
		new NOTA_TRABAJO_SHOWCURRENT( $valores );
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTA_TRABAJO_CONTROLLER.php' );
		}
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
	
              $USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
              $ADMIN = $USUARIO->comprobarAdmin();
              $NOTAS=new NOTA_TRABAJO_MODEL('','','');        
        
             if($ADMIN == true){
                 
                $datos = $NOTAS->SEARCH();
		        //Variable que almacena array con el nombre de los atributos
		        $lista = array('login','NombreTrabajo','NotaTrabajo');
                
                new NOTA_TRABAJO_SHOWALL( $lista, $datos,false );
                  
            }
            else if(permisosAcc($_SESSION['login'],7,5)==true){
                
                      $NOTAS=new NOTA_TRABAJO_MODEL('',$_SESSION['login'],'');  
                 	  $datos = $NOTAS->SEARCH();
		              //Variable que almacena array con el nombre de los atributos
		              $lista = array('NombreTrabajo','login','NotaTrabajo');
		              //Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		              new NOTA_TRABAJO_SHOWALL( $lista, $datos,true );
            }else{
				new USUARIO_DEFAULT();				
			}
                               
	
	
}

?>