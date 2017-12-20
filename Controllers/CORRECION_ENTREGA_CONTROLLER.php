

<?php
session_start();//solicito trabajar con la sesión

include '../Models/EVALUACION_MODEL.php';//incluye el contendio del modelo EVALUACION
include '../Functions/permisosAcc.php';//incluye el contendio de la función permisosAcc
include '../Views/CORRECION/CORRECION_ENTREGA_View.php';//incluye el contendio de la vista CORRECION_ENTREGA
include '../Views/CORRECION/CORRECION_ENTREGA_RESULTADO_View.php';//incluye el contendio de la vista CORRECION_ENTREGA_RESULTADO

include '../Views/DEFAULT_View.php';//incluye una vista por defecto que no tiene nada


if(!isset($_REQUEST['action'])){//Si la variable action no tiene contenido le asignamos ''
    
    $_REQUEST['action'] = '';
}

if(permisosAcc($_SESSION['login'],13,7)==true){//miramos si este usuario tiene permiso para ver la correcion de sus entregas
switch($_REQUEST['action']){//Estructura de control, que realiza un determinado caso dependiendo del valor action
        
        
    case 'RESULTADOS_ENTREGAS'://caso donde se muestran todas las correciones por parte del alumno y profesor
        $CORRECION = new EVALUACION('','','','','','','','','');//se crea un objeto de tipo EVALUACION
        $lista=array('NombreTrabajo','NombreTrabajo','CorrectoP','ComentIncorrectoP');//se crea un arrray con los atributos que queremos mostrar
        
        $datos =$CORRECION->mostrarCorrecion1($_REQUEST['IdTrabajo'],$_REQUEST['login'],$_REQUEST['Entrega']);//llamamos  a esta fución para que nos muestre todas las correciones de nuestras ETs por parte de alumnos y profesor
        
        new CORRECION_ENTREGA_RESULTADO($lista,$datos);//se nos muestra la vista con las correciones de nuestras ETs
        break;
    
   
    case 'MOSTAR_CORRECCION_ET'://caso por defecto con vista SHOWALL
        $CORRECION = new EVALUACION('','','','','','','','','');//se crea un objeto de tipo EVALUACION
        $lista = array('login','IdTrabajo','Entrega');//se crea un arrray con los atributos que queremos mostrar
        $datos =$CORRECION->mostrarEntregas($_SESSION['login']);//llamamos a esta función para mostrar todas las entregas que realizó dicho usuario

        new CORRECION_ENTREGA($lista,$datos);//se nos muestra la vista 
        break;
    /*
            SELECT DISTINCT E.IdTrabajo,LoginEvaluador,IdHistoria,CorrectoP,ComentIncorrectoP FROM EVALUACION E,ENTREGA ET WHERE 
        ( E.IdTrabajo = 'QA2' && Alias = AliasEvaluado && login='a') GROUP BY IdHistoria;
    
    
    
    */
        
        
        
}
}else{
	new USUARIO_DEFAULT();
}     
    
?>