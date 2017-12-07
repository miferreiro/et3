<?php
session_start();//solicito trabajar con la sesión
include '../Models/CORRECION_QA_MODEL.php';
include '../Views/CORRECION_QA_View.php'; 
include '../Views/CORRECION_QA_RESULTADO_View.php'; 

if(!isset($_REQUEST['action'])){
    
    $_REQUEST['action'] = '';
}

switch($_REQUEST['action']){
        
        
    case 'RESULTADO':
        $CORRECION = new CORRECION_QA_MODEL();
        $lista=array('LoginEvaluador','AliasEvaluado','IdTrabajo','IdHistoria','OK');
        $datos =$CORRECION->mostrarCorrecion($_REQUEST['IdTrabajo'],$_SESSION['login']);
        new CORRECION_QA_RESULTADO($lista,$datos);
        break;
        
        
    default:
        $CORRECION = new CORRECION_QA_MODEL();
        $lista = array('login','IdTrabajo');
        $datos =$CORRECION->mostrarEntregas($_SESSION['login']);

        new CORRECION_QA($lista,$datos);
        
        
}
    
    
?>