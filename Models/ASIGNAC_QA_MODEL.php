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

	//Constructor de la clase

	function __construct($IdTrabajo,$LoginEvaluador,$LoginEvaluado,$AliasEvaluado) {
		//asignación de valores de parámetro a los atributos de la clase
		$this->IdTrabajo = $IdTrabajo;
		$this->LoginEvaluador = $LoginEvaluador;
        $this->LoginEvaluado = $LoginEvaluado;
        $this->AliasEvaluado=$AliasEvaluado;
		
		// incluimos la funcion de acceso a la bd
		include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		$this->mysqli = ConectarBD();

	} // fin del constructor

	function DevolverArray($Entrega){
		//Consulta que recupera la tabla trabajo
			$sql = "select ENTREGA.IdTrabajo,
						   login,
						   Alias
						   from ENTREGA,TRABAJO
						   where ENTREGA.IdTrabajo = TRABAJO.IdTrabajo
						   AND (BINARY NombreTrabajo LIKE '$Entrega%')
						   order by login";
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
	}
	

} //fin de clase

?>