
<?php
session_start();//solicito trabajar con la sesión
include '../Models/CORRECION_ENTREGA_MODEL.php';
include '../Views/CORRECION_ENTREGA_View.php'; 
include '../Views/CORRECION_ENTREGA_RESULTADO_View.php'; 

if(!isset($_REQUEST['action'])){
    
    $_REQUEST['action'] = '';
}

switch($_REQUEST['action']){
        
        
    case 'RESULTADO':
        $CORRECION = new CORRECION_ENTREGA_MODEL();
        $lista=array('IdTrabajo','IdHistoria','CorrectoP','ComentIncorrectoP');
        $datos =$CORRECION->mostrarCorrecion($_REQUEST['IdTrabajo'],$_SESSION['login']);
        new CORRECION_ENTREGA_RESULTADO($lista,$datos);
        break;
        
        
    default:
        $CORRECION = new CORRECION_ENTREGA_MODEL();
        $lista = array('login','IdTrabajo');
        $datos =$CORRECION->mostrarEntregas($_SESSION['login']);

        new CORRECION_ENTREGA($lista,$datos);
        
        
}
    
    
?>