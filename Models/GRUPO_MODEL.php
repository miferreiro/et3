<?php

//modelo de datos definida con una clase que interactúa con el controlador que gestiona el grupo.
//Fecha de creación:23/11/2017
    class GRUPO{
        
        //Se definen las vaiables que se utilizarán en esta clase
        var $IdGrupo; //es la clave de la tabla GRUPO.
        var $NombreGrupo;//Declaracion de la variable NombreGrupo
        var $DescripGrupo;//Declaracion de la variable DescripGrupo
        var $dependencias;
            
        function __construct($IdGrupo,$NombreGrupo,$DescripGrupo){
            //Asignamos valores a los atributos de la clase
            $this->IdGrupo=$IdGrupo;
            $this->NombreGrupo=$NombreGrupo;
            $this->DescripGrupo=$DescripGrupo;
            
            // incluimos la funcion de acceso a la bd
		      include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		      $this->mysqli = ConectarBD();
        }//fin del constructor
        
    //Devuelve el número de tuplas que hay el la tabla grupo
    function NumRows(){
    	//Variable que almacena una sentencia sql
    	$sql = "SELECT * FROM GRUPO";
    	//Variable que almacena el resultado de una query sql
        $resultado = $this->mysqli->query( $sql );
			$cont = 0;//Variable que almacena un contador de tuplas
			//Caragamos las tuplas resultado de la consulta en un array
			while($datos = mysqli_fetch_row ($resultado)){
				//Incrementa contador de vueltas
				$cont++;
			}
			//Devuelve el número de tuplas
			return $cont;
    }   
	//funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select IdGrupo,
                        NombreGrupo,
                        DescripGrupo
       			from GRUPO
    			where 
    				(
					(BINARY IdGrupo LIKE '%$this->IdGrupo%') &&
                    (BINARY NombreGrupo LIKE '%$this->NombreGrupo%') &&
                    (BINARY DescripGrupo LIKE '%$this->DescripGrupo%')
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
		if ( ( $this->IdGrupo <> '' ) ) { // si el atributo clave de la entidad no esta vacio

			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM GRUPO WHERE (  IdGrupo = '$this->IdGrupo')";

			if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} else { // si la ejecución de la query no da error
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio
                    //hacemos la inserción en la base de datos
					$sql = "INSERT INTO GRUPO (
							    IdGrupo,
                                NombreGrupo,
                                DescripGrupo) 
								VALUES(
								'$this->IdGrupo',
								'$this->NombreGrupo',
								'$this->DescripGrupo'
								)";
                }
                    else{
                        return 'Ya existe el grupo introducido en la base de datos'; // ya existe
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
		$sql = "SELECT * FROM GRUPO WHERE (IdGrupo = '$this->IdGrupo' && (IdGrupo <> '00000A' && IdGrupo <> '00001A'))";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si existe una tupla con ese valor de clave

		if ( $result->num_rows == 1 ) {
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM GRUPO WHERE (IdGrupo = '$this->IdGrupo' )";
			$sql2 = "DELETE FROM USU_GRUPO WHERE (IdGrupo = '$this->IdGrupo' )";
			$sql3 = "DELETE FROM PERMISO WHERE (IdGrupo = '$this->IdGrupo' )";
			
			// se ejecuta la query
			$this->mysqli->query( $sql );
			$this->mysqli->query( $sql2 );
			$this->mysqli->query( $sql3 );
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

		$sql = "SELECT * FROM GRUPO WHERE (IdGrupo = '$this->IdGrupo')";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
			$resultado = $resultado->fetch_array();
			return $resultado;
		}
	} // fin del metodo RellenaDatos()
	// funcion RellenaDatos()
	// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
	// en el atributo de la clase
	function RellenaSelect() { // se construye la sentencia de busqueda de la tupla

		$sql = "SELECT A.IdAccion,A.NombreAccion,F.IdFuncionalidad,F.NombreFuncionalidad FROM FUNC_ACCION FA, FUNCIONALIDAD F, ACCION A, GRUPO G, PERMISO P WHERE(FA.IdFuncionalidad = F.IdFuncionalidad && FA.IdAccion = A.IdAccion && P.IdFuncionalidad = FA.IdFuncionalidad && P.IdAccion = FA.IdAccion && P.IdGrupo = '$this->IdGrupo') ";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
			$result = $resultado->fetch_array();
			return $result;
		}
	} // fin del metodo RellenaDatos()
	// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
	// en el atributo de la clase
	function dependencias() { // se construye la sentencia de busqueda de la tupla
        
        $dependencias = null;

		$sql = "SELECT * FROM USU_GRUPO WHERE (IdGrupo= '$this->IdGrupo')";
        $resultado = $this->mysqli->query( $sql );
        if ( $resultado->num_rows != 0 ) {
            $result = $resultado->fetch_array();
            $keys = array('USU_GRUPO');
            $dependencias = array_fill_keys($keys , $result);
        }
        
        $sql = "SELECT * FROM PERMISO WHERE (IdGrupo= '$this->IdGrupo')";
        $resultado = $this->mysqli->query( $sql );
        if ( $resultado->num_rows != 0 ) {
            $result = $resultado->fetch_array();
            $keys = array('PERMISO');
            $dependencias = array_fill_keys($keys , $result);
        }
        
        return $dependencias;
	} // fin del metodo RellenaDatos()

		
        // funcion RellenaShowCurrent()
        // Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
	   // en el atributo de la clase
	function RellenaShowCurrent() { // se construye la sentencia de busqueda de la tupla

		$sql = "SELECT * FROM USU_GRUPO WHERE (IdGrupo = '$this->IdGrupo')";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
			return $resultado;
		}
	} // fin del metodo RellenaShowCurrent()		
		
        // funcion EDIT()
	   // Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
	  // si existe se modifica
function EDIT() {
		// se construye la sentencia de busqueda de la tupla en la bd
		$sql = "SELECT * FROM GRUPO WHERE (IdGrupo = '$this->IdGrupo')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) {
			// se construye la sentencia de modificacion en base a los atributos de la clase
		
			     //modificamos los atributos de la tabla USUARIO
				$sql = "UPDATE GRUPO SET 
					IdGrupo= '$this->IdGrupo',
                    NombreGrupo='$this->NombreGrupo',
					DescripGrupo = '$this->DescripGrupo'
				WHERE ( IdGrupo = '$this->IdGrupo'
				)";
			// si hay un problema con la query se envia un mensaje de error en la modificacion
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			} else { // si no hay problemas con la modificación se indica que se ha modificado
				return 'Modificado correctamente';
			}

	
		
			
		} // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
		            else
				return 'No existe en la base de datos';		
	} // fin del metodo EDIT
             
    }
?>