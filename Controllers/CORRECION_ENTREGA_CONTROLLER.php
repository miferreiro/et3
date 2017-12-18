

<?php
session_start();//solicito trabajar con la sesión

include '../Models/EVALUACION_MODEL.php';//incluye el contendio del modelo EVALUACION
include '../Functions/permisosAcc.php';//incluye el contendio de la función permisosAcc
include '../Views/CORRECION/CORRECION_ENTREGA_View.php';//incluye el contendio de la vista CORRECION_ENTREGA
include '../Views/CORRECION/CORRECION_ENTREGA_RESULTADO_View.php';//incluye el contendio de la vista CORRECION_ENTREGA_RESULTADO
include '../Views/CORRECION/CORRECION_ENTREGAS_View.php';//incluye el contendio de la vista CORRECION_ENTREGAS
include '../Views/DEFAULT_View.php';//incluye una vista por defecto que no tiene nada


if(!isset($_REQUEST['action'])){//Si la variable action no tiene contenido le asignamos ''
    
    $_REQUEST['action'] = '';
}

if(permisosAcc($_SESSION['login'],13,7)==true){//miramos si este usuario tiene permiso para ver la correcion de sus entregas
switch($_REQUEST['action']){//Estructura de control, que realiza un determinado caso dependiendo del valor action
        
        
    case 'RESULTADOS'://caso donde se muestran todas las correciones por parte del alumno y profesor
        $CORRECION = new EVALUACION('','','','','','','','','');//se crea un objeto de tipo EVALUACION
        $lista=array('IdTrabajo','IdHistoria','CorrectoP','ComentIncorrectoP','CorrectoA','ComenIncorrectoA');//se crea un arrray con los atributos que queremos mostrar
        $datos =$CORRECION->mostrarCorrecion1($_REQUEST['IdTrabajo'],$_REQUEST['LoginEvaluador']);//llamamos  a esta fución para que nos muestre todas las correciones de nuestras ETs por parte de alumnos y profesor
        
        new CORRECION_ENTREGA_RESULTADO($lista,$datos);//se nos muestra la vista con las correciones de nuestras ETs
        break;
    
    case 'RESULTADO'://caso donde se muestran cuantos te corrigieron tus ETs
        //  $sql = "SELECT DISTINCT LoginEvaluador,E.IdTrabajo FROM EVALUACION E,ENTREGA ET WHERE 
        //( E.IdTrabajo = '$IdTrabajo' && Alias = AliasEvaluado && login='$nombre')";
        $CORRECION = new EVALUACION('','','','','','','','','');//se crea un objeto de tipo EVALUACION
        $lista=array('LoginEvaluador','login','IdTrabajo');//se crea un arrray con los atributos que queremos mostrar
        $datos =$CORRECION->mostrarCorrecion($_REQUEST['IdTrabajo'],$_SESSION['login']);//llamamos a esta donde se muestran el numero de personas que nos corrigieron(aparecerá el usario tantas tuplas como usuarios nos corrigen)
        new CORRECION_ENTREGAS($lista,$datos);//se nos muestra la vista
        break;
    default://caso por defecto con vista SHOWALL
        $CORRECION = new EVALUACION('','','','','','','','','');//se crea un objeto de tipo EVALUACION
        $lista = array('login','IdTrabajo','Entrega');//se crea un arrray con los atributos que queremos mostrar
        $datos =$CORRECION->mostrarEntregas($_SESSION['login']);//llamamos a esta función para mostrar todas las entregas que realizó dicho usuario

        new CORRECION_ENTREGA($lista,$datos);//se nos muestra la vista 
        
        
}
}else{
	new USUARIO_DEFAULT();
}     
    
?>