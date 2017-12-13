<?php
session_start();//solicito trabajar con la sesión
include '../Models/EVALUACION_MODEL.php';
include '../Functions/permisosAcc.php';
include '../Views/CORRECION/CORRECION_QA_View.php'; 
include '../Views/CORRECION/CORRECION_QA_RESULTADO_View.php'; 
include '../Views/CORRECION/CORRECION_QA_RESULTADOS_View.php'; 
include '../Views/DEFAULT_View.php';

if(!isset($_REQUEST['action'])){
    
    $_REQUEST['action'] = '';
}

if(permisosAcc($_SESSION['login'],9,7)==true){
switch($_REQUEST['action']){
        
    case 'RESULTADOS':
        $CORRECION = new EVALUACION('','','','','','','','','');
        $lista=array('LoginEvaluador','AliasEvaluado','IdTrabajo','IdHistoria','CorrectoP','ComentIncorrectoP','CorrectoA','ComenIncorrectoA','OK');
        $datos =$CORRECION->mostrarCorrecion3($_REQUEST['IdTrabajo'],$_SESSION['login'],$_REQUEST['AliasEvaluado']);
        new CORRECION_QA_RESULTADOS($lista,$datos);
        break;
        
    case 'RESULTADO':
        $CORRECION = new EVALUACION('','','','','','','','','');
        $lista=array('LoginEvaluador','AliasEvaluado','IdTrabajo');
        $datos =$CORRECION->mostrarCorrecion2($_REQUEST['IdTrabajo'],$_SESSION['login']);
        new CORRECION_QA_RESULTADO($lista,$datos);
        break;
        
        
    default:
        $CORRECION =new EVALUACION('','','','','','','','','');
        $lista = array('LoginEvaluador','IdTrabajo');
        $datos =$CORRECION->mostrarQAS($_SESSION['login']);

        new CORRECION_QA($lista,$datos);
        
        
}
}else{
	new USUARIO_DEFAULT();
}    
    
?>