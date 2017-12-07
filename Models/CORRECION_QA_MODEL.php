<?php
   
    
   
class CORRECION_QA_MODEL{
    
    
    var $mysqli; 


        function __construct(){
            include_once '../Functions/BdAdmin.php';
            $this->mysqli = ConectarBD();
            
        }

     
    function mostrarEntregas($nombre){
        
    
    $sql = "SELECT DISTINCT login,E.IdTrabajo FROM ENTREGA ET,EVALUACION E WHERE  ET.Alias=E.AliasEvaluado AND login='$nombre'";
          
    if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si existe se devuelve la tupla resultado
            
           
			return $resultado;
		}
        
    }

    function mostrarCorrecion($IdTrabajo,$nombre){
        
        
       
       $sql = "SELECT DISTINCT LoginEvaluador,AliasEvaluado,E.IdTrabajo,IdHistoria,OK FROM EVALUACION E,ENTREGA ET WHERE 
        ( E.IdTrabajo = ET.IdTrabajo && E.IdTrabajo = '$IdTrabajo' && LoginEvaluador='$nombre')";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si existe se devuelve la tupla resultado
            
            
			return $resultado;
		}
    


}
}

?>