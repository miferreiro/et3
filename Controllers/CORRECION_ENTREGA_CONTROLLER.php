
<?php
session_start();//solicito trabajar con la sesión

include '../Models/EVALUACION_MODEL.php';
include '../Functions/permisosAcc.php';
include '../Views/CORRECION/CORRECION_ENTREGA_View.php'; 
include '../Views/CORRECION/CORRECION_ENTREGA_RESULTADO_View.php'; 
include '../Views/CORRECION/CORRECION_ENTREGAS_View.php'; 
include '../Views/DEFAULT_View.php';


if(!isset($_REQUEST['action'])){
    
    $_REQUEST['action'] = '';
}

if(permisosAcc($_SESSION['login'],13,7)==true){
switch($_REQUEST['action']){
        
        
    case 'RESULTADOS':
        $CORRECION = new EVALUACION('','','','','','','','','');
        $lista=array('IdTrabajo','IdHistoria','CorrectoP','ComentIncorrectoP','CorrectoA','ComenIncorrectoA');
        $datos =$CORRECION->mostrarCorrecion1($_REQUEST['IdTrabajo'],$_REQUEST['LoginEvaluador']);
        new CORRECION_ENTREGA_RESULTADO($lista,$datos);
        break;
    
    case 'RESULTADO':
        //  $sql = "SELECT DISTINCT LoginEvaluador,E.IdTrabajo FROM EVALUACION E,ENTREGA ET WHERE 
        //( E.IdTrabajo = '$IdTrabajo' && Alias = AliasEvaluado && login='$nombre')";
        $CORRECION = new EVALUACION('','','','','','','','','');
        $lista=array('LoginEvaluador','IdTrabajo','login');
        $datos =$CORRECION->mostrarCorrecion($_REQUEST['IdTrabajo'],$_SESSION['login']);
        new CORRECION_ENTREGAS($lista,$datos);
        
    default:
        $CORRECION = new EVALUACION('','','','','','','','','');
        $lista = array('login','IdTrabajo');
        $datos =$CORRECION->mostrarEntregas($_SESSION['login']);

        new CORRECION_ENTREGA($lista,$datos);
        
        
}
}else{
	new USUARIO_DEFAULT();
}     
    
?>