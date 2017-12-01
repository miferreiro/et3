<?php

/*
 Función: modelo de datos definida en una clase que permite interactuar con la base de datos
 Fecha de creación:23/11/2017
*/
class EVALUACION{ //declaración de la clase

    var $IdTrabajo; //declaración de idtrabajo
	var $LoginEvaluador; // declaración del atributo LoginEvaluador
    var $AliasEvaluado;//declaración del atributo AliasEvaluado
	var $IdHistoria; // declaración del atributo IdHistoria
	var $CorrectoA; // declaración del atributo CorrectoA
	var $ComenIncorrectoA; // declaración del atributo ComenIncorrectoA
    var $CorrectoP; // declaración del atributo CorrectoP
    var $ComentIncorrectoP;//declaración del atributo ComenIncorrectoP
	var $OK; // declaración del atributo OK
	var $mysqli; // declaración del atributo manejador de la bd

	//Constructor de la clase

	function __construct($IdTrabajo,$LoginEvaluador,$AliasEvaluado,$IdHistoria,$CorrectoA,$ComenIncorrectoA,$CorrectoP,$ComentIncorrectoP,$OK) {
		//asignación de valores de parámetro a los atributos de la clase
		$this->IdTrabajo = $IdTrabajo;
		$this->LoginEvaluador = $LoginEvaluador;
        $this->AliasEvaluado=$AliasEvaluado;
		$this->IdHistoria = $IdHistoria;
		$this->CorrectoA = $CorrectoA;
		$this->ComenIncorrectoA = $ComenIncorrectoA;
        $this->CorrectoP = $CorrectoP;
        $this->ComentIncorrectoP=$ComentIncorrectoP;
		$this->OK = $OK;
		
        
		// incluimos la funcion de acceso a la bd
		include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		$this->mysqli = ConectarBD();

	} // fin del constructor

	//funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select  IdTrabajo,
                    LoginEvaluador,
                    AliasEvaluado,
					IdHistoria,
					CorrectoA,
					ComenIncorrectoA,
                    CorrectoP,
                    ComentIncorrectoP,
					OK
       			from EVALUACION 
    			where 
    				(
					(BINARY IdTrabajo LIKE '%$this->IdTrabajo%') &&
					(BINARY LoginEvaluador LIKE '%$this->LoginEvaluador%') &&
                    (BINARY AliasEvaluado LIKE '%$this->AliasEvaluado%') &&
    				(BINARY IdHistoria LIKE '%$this->IdHistoria%') &&
					(BINARY CorrectoA LIKE '%$this->CorrectoA%') &&
	 				(BINARY ComenIncorrectoA LIKE '%$this->ComenIncorrectoA%') &&
                    (BINARY CorrectoP LIKE '%$this->CorrectoP%') &&
                    (BINARY ComentIncorrectoP LIKE '%$this->ComentIncorrectoP%') &&
	 				(BINARY OK LIKE '%$this->OK%')
    				)";
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
	} // fin metodo SEARCH


	//Metodo ADD()
	//Inserta en la tabla  de la bd  los valores
	// de los atributos del objeto. Comprueba si la clave esta vacia y si 
	//existe ya en la tabla
	function ADD() {
		if ( ( $this->IdTrabajo <> '' && $this->LoginEvaluador <> '' && $this->AliasEvaluado <> '' && $this->IdHistoria <> '' ) ) { // si el atributo clave de la entidad no esta vacio
            
           $usuarios="SELECT * FROM USUARIO WHERE (login ='$this->LoginEvaluador')";
            
            $result = $this->mysqli->query($usuarios);
            
            if(!$result){
              return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
                
            }
            else{
                    if($result->num_rows == 0){
                        return 'no puedes insertar un login evaluador, debes insertar previamente un usuario.';
                    }
                
            }
            
            $trabajo= "SELECT * FROM TRABAJO WHERE (IdTrabajo = '$this->IdTrabajo')";
            
            $result = $this->mysqli->query($trabajo);
            
             
            if(!$result){
              return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
                
            }
            
            
            else{
                      if($result->num_rows == 0){
                          
                        return 'no puedes insertar un id de trabajo, debes insertar previamente un trabajo.'
                    }
            }
            
                


			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM EVALUACION WHERE (  IdTrabajo = '$this->IdTrabajo' && IdAccion = '$this->LoginEvaluador' && IdAccion = '$this->AliasEvaluado' && IdHistoria = '$this->IdHistoria')";

			if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} else { // si la ejecución de la query no da error
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio
                    //hacemos la inserción en la base de datos
					$sql = "INSERT INTO EVALUACION (
							    IdTrabajo,
                                LoginEvaluador,
                                AliasEvaluado,
					            IdHistoria,
					            CorrectoA,
					            ComenIncorrectoA,
                                CorrectoP,
                                ComentIncorrectoP,
					            OK) 
								VALUES(
                                '$this->IdTrabajo',
                                '$this->LoginEvaluador',
                                '$this->AliasEvaluado',
		                        '$this->IdHistoria',
		                        '$this->CorrectoA',
		                        '$this->ComenIncorrectoA',
                                '$this->CorrectoP',
                                '$this->ComentIncorrectoP',
		                        '$this->OK'
								)";
                }
                    else{
                        return 'Ya existe la acción introducida en la base de datos'; // ya existe
                    }
					}
					if ( !$this->mysqli->query( $sql ) ) { // si da error en la ejecución del insert devolvemos mensaje
						return 'Error en la inserción';
					} else { //si no da error en la insercion devolvemos mensaje de exito
						return 'Inserción realizada con éxito'; //operacion de insertado correcta
					}

				} else // si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
					return 'Introduzca un valor'; // ya existe
    
	} // fin del metodo ADD

    
	//funcion de destrucción del objeto: se ejecuta automaticamente
	//al finalizar el script
	function __destruct() {

	} // fin del metodo destruct

	// funcion DELETE()
	// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
	// se manda un mensaje de que ese valor de clave no existe
	function DELETE() {
		// se construye la sentencia sql de busqueda con los atributos de la clase
		$sql = "SELECT * FROM EVALUACION WHERE (IdTrabajo = '$this->IdTrabajo' && IdAccion = '$this->LoginEvaluador' && IdAccion = '$this->AliasEvaluado' && IdHistoria = '$this->IdHistoria')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si existe una tupla con ese valor de clave

		if ( $result->num_rows == 1 ) {
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM EVALUACION WHERE (IdTrabajo = '$this->IdTrabajo' && IdAccion = '$this->LoginEvaluador' && IdAccion = '$this->AliasEvaluado' && IdHistoria = '$this->IdHistoria')";
			// se ejecuta la query
			$this->mysqli->query( $sql );
			// se devuelve el mensaje de borrado correcto
			return "Borrado correctamente";
		} // si no existe el LoginEvaluador a borrar se devuelve el mensaje de que no existe
		else
			return "No existe";
	} // fin metodo DELETE

	// funcion RellenaDatos()
	// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
	// en el atributo de la clase
	function RellenaDatos() { // se construye la sentencia de busqueda de la tupla

		$sql = "SELECT * FROM EVALUACION WHERE (IdTrabajo = '$this->IdTrabajo' && IdAccion = '$this->LoginEvaluador' && IdAccion = '$this->AliasEvaluado' && IdHistoria = '$this->IdHistoria')";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
			$result = $resultado->fetch_array();
			return $result;
		}
	} // fin del metodo RellenaDatos()

	// funcion EDIT()
	// Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
	// si existe se modifica
	function EDIT() {
		// se construye la sentencia de busqueda de la tupla en la bd
		$sql = "SELECT * FROM EVALUACION WHERE (IdTrabajo = '$this->IdTrabajo' && IdAccion = '$this->LoginEvaluador' && IdAccion = '$this->AliasEvaluado' && IdHistoria = '$this->IdHistoria')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) { // se construye la sentencia de modificacion en base a los atributos de la clase
			     //modificamos los atributos de la tabla EVALUACION
				$sql = "UPDATE EVALUACION SET 
					IdTrabajo = '$this->IdTrabajo',
					LoginEvaluador = '$this->LoginEvaluador',
                    AliasEvaluado='$this->AliasEvaluado',
					IdHistoria = '$this->IdHistoria',
					CorrectoA = '$this->CorrectoA',
					ComenIncorrectoA = '$this->ComenIncorrectoA',
                    CorrectoP = '$this->CorrectoP',
                    ComentIncorrectoP ='$this->ComenIncorrectoP',
					OK = '$this->OK'
				WHERE ( IdTrabajo = '$this->IdTrabajo' && IdAccion = '$this->LoginEvaluador' && IdAccion = '$this->AliasEvaluado' && 
                IdHistoria = '$this->IdHistoria'
				)";
            
			// si hay un problema con la query se envia un mensaje de error en la modificacion
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			} else { // si no hay problemas con la modificación se indica que se ha modificado
				return 'Modificado correctamente';
			}

		} else // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
			return 'No existe en la base de datos';
	} // fin del metodo EDIT

} //fin de clase

?>