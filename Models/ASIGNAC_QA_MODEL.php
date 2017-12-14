<?php

/*
 Función: modelo de datos definida en una clase que permite interactuar con la base de datos
 Fecha de creación:23/11/2017
*/
class ASIGNAC_QA_MODEL{ //declaración de la clase

    var $IdTrabajo; //declaración de idtrabajo
	var $LoginEvaluador; // declaración del atributo LoginEvaluador
    var $LoginEvaluado; // declaración del atributo LoginEvaluado
    var $AliasEvaluado;//declaración del atributo AliasEvaluado
	var $mysqli; // declaración del atributo manejador de la bd
	var $dependencias; // declaración de las dependencias
	var $dependencias2; // declaración de las dependencias

	//Constructor de la clase

	function __construct($IdTrabajo,$LoginEvaluador,$LoginEvaluado,$AliasEvaluado) {
		//asignación de valores de parámetro a los atributos de la clase
		$this->IdTrabajo = $IdTrabajo;
		$this->LoginEvaluador = $LoginEvaluador;
        $this->LoginEvaluado = $LoginEvaluado;
        $this->AliasEvaluado = $AliasEvaluado;
		
		// incluimos la funcion de acceso a la bd
		include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		$this->mysqli = ConectarBD();

	} // fin del constructor

	function DevolverQAs(){
		//Consulta que recupera la tabla ASIGNAC_QA
		$sql = "select IdTrabajo,
					   LoginEvaluador,
					   AliasEvaluado
					   from ASIGNAC_QA
					   where IdTrabajo = '$this->IdTrabajo'";
		$resultado = $this->mysqli->query( $sql );
		if ( $resultado->num_rows == 0 ) { return null; }
		//Caragamos las tuplas resultado de la consulta en un array
		while($datos = mysqli_fetch_row ($resultado)){
			//Variable que almacena el array de las tuplas resultado de la query
			$miarray[] = $datos;
		}
		return $miarray;		
	}

	

	
	function ADD(){
        $usuario = "SELECT login FROM USUARIO WHERE (login = '$this->LoginEvaluador')";
        
               $result=$this->mysqli->query($usuario);
                if(!$result){
                    return "No se ha podido conectar a la base de datos";
                }
                else{
                    if($result->num_rows == 0){
                        return "No puedes asignar una qa debido a que no se añadiu este usuario con este login";
                    }
                }
        
          $trabajo="SELECT * FROM TRABAJO WHERE (IdTrabajo = '$this->IdTrabajo')";
            
                   $result=$this->mysqli->query($trabajo);
                if(!$result){
                    return "No se ha podido conectar a la base de datos";
                }
                else{
                    if($result->num_rows == 0){
                        return "No puedes asignar una qa debido a que no se añadio un trabajo";
                    }
                }
        
        
           $al="SELECT * FROM ENTREGA WHERE (Alias = '$this->AliasEvaluado')";
            
                   $result=$this->mysqli->query($al);
                if(!$result){
                    return "No se ha podido conectar a la base de datos";
                }
                else{
                    if($result->num_rows == 0){
                        return "No puedes asignar una qa debido a que este alias no existe";
                    }
                }
        
        
			//Variable que almacena sentencia sql
			$sql = "INSERT INTO ASIGNAC_QA (
									  IdTrabajo,
									  LoginEvaluador,
									  LoginEvaluado,
									  AliasEvaluado)					           
									 VALUES(
									 '$this->IdTrabajo',
                                	 '$this->LoginEvaluador',
									 '$this->LoginEvaluado',
									 '$this->AliasEvaluado'
									 )";

			//ejecutamos la consulta
			$this->mysqli->query( $sql );
			return "Asignacion generada con exito";
	}
	
	function DELETE() {
		// se construye la sentencia sql de busqueda con los atributos de la clase
		$sql = "SELECT * FROM ASIGNAC_QA
						 WHERE (
						 		IdTrabajo = '$this->IdTrabajo' &&
						 		LoginEvaluador = '$this->LoginEvaluador' &&
						 		AliasEvaluado = '$this->AliasEvaluado'
								)";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si existe una tupla con ese valor de clave

		if ( $result->num_rows == 1 ) {
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM ASIGNAC_QA
							 WHERE (
							 		IdTrabajo = '$this->IdTrabajo' &&
							 		LoginEvaluador = '$this->LoginEvaluador' &&
							 		AliasEvaluado = '$this->AliasEvaluado'
									)";
			// se ejecuta la query
			$this->mysqli->query( $sql );
			// se devuelve el mensaje de borrado correcto
			return "Borrado correctamente";
		} // si no existe el login a borrar se devuelve el mensaje de que no existe
		else
			return "No existe";
	} // fin metodo DELETE
  
        // funcion RellenaDatos()
        // Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
	   // en el atributo de la clase
	function RellenaDatos() { // se construye la sentencia de busqueda de la tupla

		// se construye la sentencia sql de busqueda con los atributos de la clase
		$sql = "SELECT * FROM ASIGNAC_QA
						 WHERE (
						 		IdTrabajo = '$this->IdTrabajo' &&
						 		LoginEvaluador = '$this->LoginEvaluador' &&
						 		AliasEvaluado = '$this->AliasEvaluado'
								)";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
			$result = $resultado->fetch_array();
			return $result;
		}
	} // fin del metodo RellenaDatos()
    
    function dependencias() { // se construye la sentencia de busqueda de la tupla

		$dependencias = null;

		$sql = "SELECT E.IdTrabajo, E.LoginEvaluador, E.AliasEvaluado, IdHistoria, CorrectoA, ComenIncorrectoA, CorrectoP, ComentIncorrectoP, OK FROM EVALUACION E, ASIGNAC_QA QA WHERE E.LoginEvaluador = '$this->LoginEvaluador' AND E.LoginEvaluador = QA.LoginEvaluador";
		$resultado = $this->mysqli->query( $sql );
		if ( $resultado->num_rows >= 1 ) {
			$dependencias = $resultado;
		}

		return $dependencias;
	} // fin del metodo RellenaDatos()
    
    function dependencias2() { // se construye la sentencia de busqueda de la tupla

		$dependencias2= null;

		$sql = "SELECT E.IdTrabajo, E.LoginEvaluador, E.AliasEvaluado, IdHistoria, CorrectoA, ComenIncorrectoA, CorrectoP, ComentIncorrectoP, OK FROM EVALUACION E, ASIGNAC_QA QA WHERE QA.LoginEvaluado = '$this->LoginEvaluado' AND E.AliasEvaluado = QA.AliasEvaluado";
		$resultado = $this->mysqli->query( $sql );
		if ( $resultado->num_rows >= 1 ) {
			$dependencias2 = $resultado;
		}

		return $dependencias2;
	} // fin del metodo RellenaDatos()
    
    
        //funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		// se construye la sentencia sql de busqueda con los atributos de la clase
		$sql = "SELECT * FROM ASIGNAC_QA
						 WHERE (
						 		(BINARY IdTrabajo LIKE '%$this->IdTrabajo%') &&
                    			(BINARY LoginEvaluador LIKE '%$this->LoginEvaluador%') &&
                    			(BINARY AliasEvaluado LIKE '%$this->AliasEvaluado%')
								)";
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
	} // fin metodo SEARCH
        
        
        // funcion EDIT()
	   // Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
	  // si existe se modifica
	function EDIT() {
		// se construye la sentencia de busqueda de la tupla en la bd
		$sql = "SELECT * FROM ASIGNAC_QA
						 WHERE (
						 		IdTrabajo = '$this->IdTrabajo' &&
						 		LoginEvaluador = '$this->LoginEvaluador' &&
						 		AliasEvaluado = '$this->AliasEvaluado'
								)";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) { // se construye la sentencia de modificacion en base a los atributos de la clase
			
				$sql = "UPDATE ASIGNAC_QA SET 
					 IdTrabajo = '$this->IdTrabajo',
					 LoginEvaluador = '$this->LoginEvaluador',
                     LoginEvaluado = '$this->LoginEvaluado',
                     AliasEvaluado = '$this->AliasEvaluado'
				WHERE (
						 IdTrabajo  = '$this->IdTrabajo' &&
						 LoginEvaluador = '$this->LoginEvaluador' &&
						 AliasEvaluado = '$this->AliasEvaluado'
					  )";
            
			// si hay un problema con la query se envia un mensaje de error en la modificacion
			if ( !( $result = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			} else { // si no hay problemas con la modificación se indica que se ha modificado
				return 'Modificado correctamente';
			}

		} else // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
			return 'No existe en la base de datos';
	} // fin del metodo EDIT

} //fin de clase

?>