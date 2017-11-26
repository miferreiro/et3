<?php
        //esta clase  es un modelo que interactúa con la base de datos y el controlador FUNC_ACCION
        //Fecha de creación:26/11/2017

    class  FUNC_ACCION_MODEL{
     

        var $IdFuncionalidad; //declaración de la variable IdFuncionalidad, forma parte de la clave
        var $IdAccion;//Declaración de la variable IdAccion, forma parte de la clave.
        
        
        
            function __construct($IdFuncionalidad,$IdAccion){
                //Asignamos valores a las variables.
                $this->IdFuncionalidad=$IdFuncionalidad;
                $this->IdAccion=$IdAccion;
                
                  // incluimos la funcion de acceso a la bd
		              include_once '../Functions/BdAdmin.php';
		        // conectamos con la bd y guardamos el manejador en un atributo de la clase
		              $this->mysqli = ConectarBD();
                
            }//fin del constructor.
            
        
           //funcion SEARCH: hace una búsqueda en la tabla con
        //los datos proporcionados. Si van vacios devuelve todos
	   function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select IdFuncionalidad,
                        IdAccion
       			from FUNC_ACCION
    			where 
    				(
					(BINARY IdFuncionalidad LIKE '%$this->IdFuncionalidad%') &&
                    (BINARY IdAccion LIKE '%$this->IdAccion%')
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
		if ( ( $this->IdFuncionalidad <> '' && $this->IdAccion <> '' ) ) { // si el atributo clave de la entidad no esta vacio

			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM FUNC_ACCION WHERE (  IdFuncionalidad COLLATE utf8_bin = '$this->IdFuncionalidad' AND  IdAccion COLLATE utf8_bin = '$this->IdAccion' )";

			if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} else { // si la ejecución de la query no da error
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio
                    //hacemos la inserción en la base de datos
					$sql = "INSERT INTO FUNC_ACCION (
							    IdFuncionalidad,
                                IdAccion) 
								VALUES(
								'$this->IdFuncionalidad',
								'$this->IdAccion'
								)";
                }
                else{
                     return 'Ya existe esa funcionalidad  en la base de datos'; // ya existe
                    }
                }
					if ( !$this->mysqli->query( $sql ) ) { // si da error en la ejecución del insert devolvemos mensaje
						return 'Error en la inserción';
					} else { //si no da error en la insercion devolvemos mensaje de exito
						return 'Inserción realizada con éxito'; //operacion de insertado correcta
					}

				} else // si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
					return 'Inserta un valor'; // ya existe
    
	} // fin del metodo ADD  
        
           // funcion DELETE()
	       // comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
	       // se manda un mensaje de que ese valor de clave no existe
	function DELETE() {
		// se construye la sentencia sql de busqueda con los atributos de la clase
		$sql = "SELECT * FROM FUNC_ACCION WHERE (IdFuncionalidad COLLATE utf8_bin = '$this->IdFuncionalidad' AND IdAccion COLLATE utf8_bin = '$this->IdAccion' )";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si existe una tupla con ese valor de clave

		if ( $result->num_rows == 1 ) {
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM FUNC_ACCION WHERE (IdFuncionalidad COLLATE utf8_bin = '$this->IdFuncionalidad' AND IdAccion COLLATE utf8_bin = '$this->IdAccion' )";
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

		$sql = "SELECT * FROM FUNC_ACCION WHERE (IdFuncionalidad COLLATE utf8_bin = '$this->IdFuncionalidad' AND IdAccion COLLATE utf8_bin = '$this->IdAccion')";
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
		$sql = "SELECT * FROM FUNC_ACCION WHERE (IdFuncionalidad COLLATE utf8_bin = '$this->IdFuncionalidad' AND IdAccion COLLATE utf8_bin = '$this->IdAccion')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) { // se construye la sentencia de modificacion en base a los atributos de la clase
			
				$sql = "UPDATE FUNC_ACCION SET 
					IdFuncionalidad = '$this->IdFuncionalidad',
                      IdAccion='$this->IdAccion'
				WHERE ( IdFuncionalidad COLLATE utf8_bin = '$this->IdFuncionalidad'  AND IdAccion COLLATE utf8_bin = '$this->IdAccion'
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
         
        
    }
        

?>