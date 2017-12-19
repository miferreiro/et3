<?php
/*
	Fecha de creación: 4/12/2017 
	Función: controlador que realiza las acciones, recibidas de las vistas, necesarias para realizar altas, bajas, modificaciones y búsquedas.
*/
session_start(); //solicito trabajar con la session

include '../Models/NOTAS_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Models/ENTREGA_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Models/EVALUACION_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Models/USU_GRUPO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Models/TRABAJO_MODEL.php'; //incluye el contendio del modelo usuarios
include_once '../Models/USUARIO_MODEL.php'; //incluye el contendio del modelo usuarios
include '../Functions/permisosAcc.php';
include '../Views/NOTAS/NOTAS_SHOWALL_View.php'; //incluye la vista del showall
include '../Views/NOTAS/GENERAR_NOTA_ET_View.php'; //incluye la vista del showall
include '../Views/NOTAS/GENERAR_NOTA_QA_View.php'; //incluye la vista del showall
include '../Views/NOTAS/NOTAS_SHOWALL2_View.php'; //incluye la vista del showall para el caso de los usuarios
include '../Views/NOTAS/NOTAS_SEARCH_View.php'; //incluye la vista search
include '../Views/NOTAS/NOTAS_ADD_View.php'; //incluye la vista add
include '../Views/NOTAS/NOTAS_EDIT_View.php'; //incluye la vista edit
include '../Views/NOTAS/NOTAS_DELETE_View.php'; //incluye la vista delete
include '../Views/NOTAS/NOTAS_SHOWCURRENT_View.php'; //incluye la vista showcurrent
include '../Views/NOTAS/NOTAS_SHOWCURRENT2_View.php'; //incluye la vista showcurrent
include '../Views/DEFAULT_View.php';
include '../Views/MESSAGE_View.php'; //incluye la vista mensaje


function get_data_form() {


	$IdTrabajo = $_REQUEST['IdTrabajo'];
    $login = $_REQUEST['login'];
    $NotaTrabajo = $_REQUEST['NotaTrabajo'];
    $action = $_REQUEST[ 'action' ]; //Variable que almacena el valor de action
	$NOTAS = new NOTAS_MODEL(
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
			if(permisosAcc($_SESSION['login'],7,0)==true){
			$USUARIO= new USUARIO_MODEL('','','','','','','','');
			$USUARIOS=$USUARIO->SEARCH();				
			$TRABAJO= new TRABAJO('','','','','');
			$TRABAJOS=$TRABAJO->SEARCH2();
			//Crea una vista add para ver la tupla
			new NOTAS_ADD($USUARIOS,$TRABAJOS);
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTAS_CONTROLLER.php' );
			}
		} else {//Si recibe datos los recoge y mediante las funcionalidad de NOTAS_MODEL inserta los datos
			$NOTAS = get_data_form();//Variable que almacena los datos recogidos
			$respuesta = $NOTAS->ADD();//Variable que almacena la respuesta de la inserción
			//Crea la vista con la respuesta y la ruta para volver
			new MESSAGE( $respuesta, '../Controllers/NOTAS_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'DELETE'://Caso borrar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario DELETE
			if(permisosAcc($_SESSION['login'],7,1)==true){
			//Variable que recoge un objecto model
			$NOTAS = new NOTAS_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'login' ],'');
			//Variable que almacena el relleno de los datos
			$valores = $NOTAS->RellenaDatos();
            //Crea una vista delete para ver la tupla
			new NOTAS_DELETE($valores);
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTAS_CONTROLLER.php' );
			}
			//Si recibe valores ejecuta el borrado
		} else {
			//Variable que almacena los datos recogidos de los atributos
			$NOTAS = get_data_form();
           
			//Variable que almacena la respuesta de realizar el borrado
			$respuesta = $NOTAS->DELETE();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/NOTAS_CONTROLLER.php' );
		}
		//Finaliza el bloque
		break;
	case 'EDIT'://Caso editar	
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario EDIT
			if(permisosAcc($_SESSION['login'],7,2)==true){
			//Variable que almacena un objeto model
			$NOTAS = new NOTAS_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST[ 'login' ],'');
			//Variable que almacena los datos de los atibutos rellenados a traves de login
			$valores = $NOTAS->RellenaDatos();
			new NOTAS_EDIT($valores);
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTAS_CONTROLLER.php' );
			}
			//Si se reciben valores
		} else {
			//Variable que almacena los datos recogidos
			$NOTAS = get_data_form();
			//Variable que almacena la respuesta de la edición de los datos
			$respuesta = $NOTAS->EDIT();
			//crea una vista mensaje con la respuesta y la dirección de vuelta
			new MESSAGE( $respuesta, '../Controllers/NOTAS_CONTROLLER.php' );
		}
		//Fin del bloque
		break;
        
    case 'NOTA_ENTREGA':
             $USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
             $ADMIN = $USUARIO->comprobarAdmin();
             
        
           if(!$_POST){
                 if(permisosAcc($_SESSION['login'],7,13)==true){
                
                    new GENERAR_NOTA_ET();
                
            }
            else{  
                new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTAS_CONTROLLER.php' );
            }
        }
        
      else{
                 $ENTREGA = new ENTREGA_MODEL('','','','','');
                 $dat=$ENTREGA->cogerDatos($_REQUEST['IdTrabajo']);
                 $NOTAS = new NOTAS_MODEL('','','','','');
                 
                 while($fila = mysqli_fetch_array($dat)){
                     $existe=$NOTAS->siExiste($fila['login'],$fila['IdTrabajo']);
                     
                     if($existe == false){
                         $NOTAS = new NOTAS_MODEL($fila['IdTrabajo'],$fila['login'], '');
                         $NOTAS->ADD();
                         
                            
                     $nota = $NOTAS->calcularNota($fila['login'],$fila['IdTrabajo']);
                  
                     $porcentaje = $NOTAS->notasUsuario($fila['IdTrabajo']);
                     
                     $notaET = $nota * ($porcentaje[0]/100);
                    
                     $NOTAS->actualizar($fila['login'],$fila['IdTrabajo'],$notaET);
                     $respuesta="Notas generadas correctamente";
                     new MESSAGE($respuesta,'../Controllers/NOTAS_CONTROLLER.php');
                         
                     }
                    else{
                         
                     $nota = $NOTAS->calcularNota($fila['login'],$fila['IdTrabajo']);
                     $porcentaje = $NOTAS->notasUsuario($fila['IdTrabajo']);
                     $notaET = $nota * ($porcentaje[0]/100);
                      
                     $NOTAS->actualizar($fila['login'],$fila['IdTrabajo'],$notaET);
                     $respuesta="Notas generadas correctamente";
                      new MESSAGE($respuesta,'../Controllers/NOTAS_CONTROLLER.php');
                    }
                     
                     
                  
                 }
                    $respuesta="Las notas no se pudieron generar";
                    new MESSAGE($respuesta,'../Controllers/NOTAS_CONTROLLER.php');

      }
        
    break;    
        
    case 'NOTA_QA':
        
         $USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
         $ADMIN = $USUARIO->comprobarAdmin();
        
        if(!$_POST){
        
           if(permisosAcc($_SESSION['login'],7,8)==true){
               
               new GENERAR_NOTA_QA();  
               
            }
            else{
                
                new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTAS_CONTROLLER.php' );
            }
        }
            
        
         else{
            
                 $EVALUACION = new EVALUACION('','','','','','','','','');
                 $dat=$EVALUACION->cogerDatosQA($_REQUEST['IdTrabajo']);
                 $NOTAS = new NOTAS_MODEL('','','','','');
                // $notas=array();
                 
                 while($fila = mysqli_fetch_array($dat)){
                     
                     $existe=$NOTAS->siExiste($fila['LoginEvaluador'],$fila['IdTrabajo']);
                     
                     if($existe == false){
                         $NOTAS = new NOTAS_MODEL($fila['IdTrabajo'],$fila['LoginEvaluador'], '');
                         $NOTAS->ADD();
                         
                     $nota = $NOTAS->calcularNotaQA($fila['LoginEvaluador'],$fila['IdTrabajo']);
                     $porcentaje = $NOTAS->notasUsuario($fila['IdTrabajo']);
                     $notaET = $nota * ($porcentaje[0]/100);
                     //$notas[$fila['LoginEvaluador'].$fila['IdTrabajo']] = $notaET;
                     $NOTAS->actualizar($fila['LoginEvaluador'],$fila['IdTrabajo'],$notaET);
                     $respuesta="Notas generadas correctamente";
                     new MESSAGE($respuesta,'../Controllers/NOTAS_CONTROLLER.php');
                         
                     }
                    else{
                     $nota = $NOTAS->calcularNotaQA($fila['LoginEvaluador'],$fila['IdTrabajo']);
                     $porcentaje = $NOTAS->notasUsuario($fila['IdTrabajo']);
                     $notaET = $nota * ($porcentaje[0]/100);
                    // $notas[$fila['LoginEvaluador'].$fila['IdTrabajo']] = $notaET;
                     $NOTAS->actualizar($fila['LoginEvaluador'],$fila['IdTrabajo'],$notaET);
                      $respuesta="Notas generadas correctamente";
                      new MESSAGE($respuesta,'../Controllers/NOTAS_CONTROLLER.php');
                    
                    }
        }
                    $respuesta="Las notas no se pudieron generar";
                    new MESSAGE($respuesta,'../Controllers/NOTAS_CONTROLLER.php');
        
         }
        break;
        
	case 'SEARCH'://Caso buscar
		if ( !$_POST ) {//Si no se han recibido datos se envia a la vista del formulario SEARCH
			if(permisosAcc($_SESSION['login'],7,3)==true){
			new NOTAS_SEARCH();
			}else{
				new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTAS_CONTROLLER.php' );
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
            if($ADMIN == true){
                new NOTAS_SHOWALL( $lista, $datos,$notas,false );
            }
            else
                 new NOTAS_SHOWALL( $lista, $datos,$notas,true );
			
		}
		//Final del bloque
		break;
	case 'SHOWCURRENT'://Caso showcurrent
		if(permisosAcc($_SESSION['login'],7,4)==true){
		//Variable que almacena un objeto model con el login
		$NOTAS = new NOTAS_MODEL( $_REQUEST[ 'IdTrabajo' ],$_REQUEST['login'],'');
		//Variable que almacena los valores rellenados a traves de login
		$valores = $NOTAS->RellenaDatos();
		//Creación de la vista showcurrent
		new NOTAS_SHOWCURRENT( $valores );
		}else{
			new MESSAGE( 'El usuario no tiene los permisos necesarios', '../Controllers/NOTAS_CONTROLLER.php' );
		}
		//Final del bloque
		break;
	default: //Caso que se ejecuta por defecto
	
              $USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
              $ADMIN = $USUARIO->comprobarAdmin();
              $NOTAS=new NOTAS_MODEL('','','');        
        
             if($ADMIN == true){
                 
                $datos = $NOTAS->SEARCH();
		        //Variable que almacena array con el nombre de los atributos
		        $lista = array('NombreTrabajo','login','NotaTrabajo');
                
                new NOTAS_SHOWALL( $lista, $datos,false );
                  
            }
            else if(permisosAcc($_SESSION['login'],7,5)==true){
                
                      $NOTAS=new NOTAS_MODEL('',$_SESSION['login'],'');  
                 	  $datos = $NOTAS->SEARCH();
		              //Variable que almacena array con el nombre de los atributos
		              $lista = array('NombreTrabajo','login','NotaTrabajo');
		              //Creacion de la vista showall con el array $lista, los datos y la ruta de vuelta
		              new NOTAS_SHOWALL( $lista, $datos,true );
            }else{
				new USUARIO_DEFAULT();				
			}
                               
	
	
}

?>