<?php
session_start();//solicito trabajar con la sesión
include '../Models/EVALUACION_MODEL.php';//incluye el contendio del modelo EVALUACION
include '../Functions/permisosAcc.php';//incluye el contendio de la función permisosAcc
include '../Views/CORRECION/CORRECION_QA_View.php'; //incluye el contendio de la vista CORRECION_QA
include '../Views/CORRECION/CORRECION_QA_RESULTADO_View.php'; //incluye el contendio de la CORRECION_QA_RESULTADO
include '../Views/CORRECION/CORRECION_QA_RESULTADOS_View.php';//incluye el contendio de la CORRECION_QA_RESULTADOS
include '../Views/DEFAULT_View.php';//incluye el contendio de una vista por defecto vacia


if(!isset($_REQUEST['action'])){//Si la variable action no tiene contenido le asignamos ''
    
    $_REQUEST['action'] = '';
}

if(permisosAcc($_SESSION['login'],9,7)==true){//miramos si este usuario tiene permiso para ver la correcion de sus qas
switch($_REQUEST['action']){//Estructura de control, que realiza un determinado caso dependiendo del valor action
        
    case 'RESULTADOS'://caso donde nos aparecen los resultados de nuestras QAs
        $CORRECION = new EVALUACION('','','','','','','','','');//se crea un objeto de tipo EVALUACION
        $lista=array('LoginEvaluador','AliasEvaluado','IdTrabajo','IdHistoria','CorrectoP','ComentIncorrectoP','CorrectoA','ComenIncorrectoA','OK');//se crea un arrray con los atributos que queremos mostrar
        $datos =$CORRECION->mostrarCorrecion3($_REQUEST['IdTrabajo'],$_SESSION['login'],$_REQUEST['AliasEvaluado']);//llamamos a esta función para que nos muestren los resultados de nuestras QAs y se mete en la vista
        new CORRECION_QA_RESULTADOS($lista,$datos);
        break;
        
    case 'RESULTADO'://caso donde se muestran todas las QAs que corregimos
        $CORRECION = new EVALUACION('','','','','','','','','');//se crea un objeto de tipo EVALUACION
        $lista=array('LoginEvaluador','AliasEvaluado','IdTrabajo');//se crea un arrray con los atributos que queremos mostrar
        $datos =$CORRECION->mostrarCorrecion2($_REQUEST['IdTrabajo'],$_SESSION['login']);//llamamos a esta funcióm para que se nos muestren todas las Qas que tenemos que corregir
        new CORRECION_QA_RESULTADO($lista,$datos);
        break;
        
        
    default://caso por defecto con vista SHOWALL
        $CORRECION =new EVALUACION('','','','','','','','','');//se crea un objeto de tipo EVALUACION
        $lista = array('LoginEvaluador','IdTrabajo');//se crea un arrray con los atributos que queremos mostrar
        $datos =$CORRECION->mostrarQAS($_SESSION['login']);//llamamos a esta función para mostrar todas las entregas que realizó dicho usuario

        new CORRECION_QA($lista,$datos);//se nos muestra la vista 
      
        
}
}else{
	new USUARIO_DEFAULT();
}    
    
?>