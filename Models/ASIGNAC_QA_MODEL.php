<?php

/*
 Función: modelo de datos definida en una clase que permite interactuar con la base de datos
 Fecha de creación:23/11/2017 Autor:Jonatan Couto
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
		$this->IdTrabajo = $IdTrabajo;//se le asigna un valor a IdTrabajo
		$this->LoginEvaluador = $LoginEvaluador;//se le asigan un valor a LoginEvaluador
        $this->LoginEvaluado = $LoginEvaluado;//se le asigna un valor a LoginEvaluado 
        $this->AliasEvaluado = $AliasEvaluado;//se le asigna un valor a AliasEvaluado
		
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
					   where IdTrabajo = '$this->IdTrabajo'";//se construye la sentencia sql
        //se ejecuta la query
		$resultado = $this->mysqli->query( $sql );
		if ( $resultado->num_rows == 0 ) { return null; }//miramos si el número de filas es 0.
		//Caragamos las tuplas resultado de la consulta en un array
		while($datos = mysqli_fetch_row ($resultado)){
			//Variable que almacena el array de las tuplas resultado de la query
			$miarray[] = $datos;
		}
		return $miarray;		
	}

	

	//función que sirve para insertar una QA
	function ADD(){
       
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
	} //fin del método ADD
	
    //función que borra una tupla de una QA
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
		

		if ( $result->num_rows == 1 ) {// si existe una tupla con ese valor de clave
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
    
    //Esta función mira si tiene dependencias a la hora de borrar.
    function dependencias() { // se construye la sentencia de busqueda de la tupla

		$dependencias = null; //inicializamos la variable dependencias a null

		$sql = "SELECT NombreTrabajo, E.LoginEvaluador, E.AliasEvaluado, IdHistoria, CorrectoA, ComenIncorrectoA, CorrectoP, ComentIncorrectoP, OK FROM EVALUACION E, ASIGNAC_QA QA, TRABAJO T WHERE E.LoginEvaluador = '$this->LoginEvaluador' AND E.LoginEvaluador = QA.LoginEvaluador AND QA.IdTrabajo = T.IdTrabajo";//se construye la sentencia sql
		$resultado = $this->mysqli->query( $sql );//se ejecuta la query
		if ( $resultado->num_rows >= 1 ) {//mira si el número de filas es mayor ó igual a uno
			$dependencias = $resultado;//le asignamos a la variable dependencias las tablas de las que depende
		}

		return $dependencias;
	} // fin del metodo RellenaDatos()
    
    //Esta función mira si tiene dependencias a la hora de borrar.
    function dependencias2() { // se construye la sentencia de busqueda de la tupla
     
	 $dependencias2= null;//inicializamos la variable dependencias2 a null

		$sql = "SELECT NombreTrabajo, E.LoginEvaluador, E.AliasEvaluado, IdHistoria, CorrectoA, ComenIncorrectoA, CorrectoP, ComentIncorrectoP, OK FROM EVALUACION E, ASIGNAC_QA QA, TRABAJO T WHERE QA.LoginEvaluado = '$this->LoginEvaluado' AND E.AliasEvaluado = QA.AliasEvaluado AND QA.IdTrabajo = T.IdTrabajo";//se construye la sentencia sql
     
		$resultado = $this->mysqli->query( $sql );  //se ejecuta la query
		if ( $resultado->num_rows >= 1 ) {//miramos si el número de filas es mayor o igual que uno
			$dependencias2 = $resultado; //le asignamos a la variable dependencias2 las tablas de las que depende
		}

		return $dependencias2;
	} // fin del metodo RellenaDatos()
    
    
        //funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		// se construye la sentencia sql de busqueda con los atributos de la clase
		$sql = "SELECT * FROM ASIGNAC_QA A,TRABAJO T
						 WHERE (
						 		(BINARY A.IdTrabajo LIKE '%$this->IdTrabajo%') &&
                                (A.IdTrabajo = T.IdTrabajo) &&
                    			(BINARY LoginEvaluador LIKE '%$this->LoginEvaluador%') &&
                    			(BINARY AliasEvaluado LIKE '%$this->AliasEvaluado%')
								)";//se construye la sentencia sql
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
								)";//se constrye la sentencia sql
		
		$result = $this->mysqli->query( $sql );// se ejecuta la query
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
					  )";//se construye la sentencia sql
            
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