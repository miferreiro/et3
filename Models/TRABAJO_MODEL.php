<?php
//modelo que interactuará con el controlador y llevará datos a la base de datos ó recogerá valores de la base de datos.
//Fecha de creación:23/11/2017
class TRABAJO{

    var $IdTrabajo;//clave de la tabla de TRABAJO
    var $NombreTrabajo;//declaración de la variable NombreTrabajo
    var $FechaIniTrabajo;//declaracion de la variable FechaIniTrabajo
    var $FechaFinTrabajo;//declaracion de la variable FechaFinTrabajo
    var $PorcentajeNota; //declaracion de la variable PorcentajeNota
    var $dependencias;
    var $dependencias2;
    var $dependencias3;
    var $dependencias4;
    var $dependencias5;
    //constructor de la clase
    function __construct($IdTrabajo,$NombreTrabajo,$FechaIniTrabajo,$FechaFinTrabajo,$PorcentajeNota){
        //Asignamos valores a los atributos de la clase
        $this->IdTrabajo=$IdTrabajo;
        $this->NombreTrabajo=$NombreTrabajo;
        $this->FechaIniTrabajo=$FechaIniTrabajo;
        $this->FechaFinTrabajo=$FechaFinTrabajo;
        $this->PorcentajeNota=$PorcentajeNota;
        
          // incluimos la funcion de acceso a la bd
		      include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		      $this->mysqli = ConectarBD();
        
    }//fin del constructor

        

    //funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select IdTrabajo,
                        NombreTrabajo,
                        FechaIniTrabajo,
                        FechaFinTrabajo,
                        PorcentajeNota
       			from TRABAJO
    			where 
    				(
					(BINARY IdTrabajo LIKE '%$this->IdTrabajo%') &&
                    (BINARY NombreTrabajo LIKE '%$this->NombreTrabajo%') &&
                    (BINARY DATE_FORMAT(FechaIniTrabajo,'%d/%m/%Y') LIKE '%$this->FechaIniTrabajo%') &&
                    (BINARY DATE_FORMAT(FechaFinTrabajo,'%d/%m/%Y') LIKE '%$this->FechaFinTrabajo%') &&
                    (BINARY PorcentajeNota LIKE '%$this->PorcentajeNota%')
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
		if ( ( $this->IdTrabajo <> '' ) ) { // si el atributo clave de la entidad no esta vacio

			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM TRABAJO WHERE (  IdTrabajo  = '$this->IdTrabajo')";

			if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} else { // si la ejecución de la query no da error
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio
                    //hacemos la inserción en la base de datos
					$sql = "INSERT INTO TRABAJO (
							    IdTrabajo,
                                NombreTrabajo,
                                FechaIniTrabajo, 
                                FechaFinTrabajo,
                                PorcentajeNota) 
								VALUES(
								'$this->IdTrabajo',
								'$this->NombreTrabajo',
								STR_TO_DATE(REPLACE('$this->FechaIniTrabajo','/','.') ,GET_FORMAT(date,'EUR')),
								STR_TO_DATE(REPLACE('$this->FechaFinTrabajo','/','.') ,GET_FORMAT(date,'EUR')),
                                '$this->PorcentajeNota'
								)";
                }
                    else{
                        return 'Ya existe el trabajo introducido en la base de datos'; // ya existe
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

         // funcion DELETE()
	    // comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
	    // se manda un mensaje de que ese valor de clave no existe
	function DELETE() {
		// se construye la sentencia sql de busqueda con los atributos de la clase
		$sql = "SELECT * FROM TRABAJO WHERE (IdTrabajo  = '$this->IdTrabajo')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si existe una tupla con ese valor de clave

		if ( $result->num_rows == 1 ) {
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM TRABAJO WHERE (IdTrabajo  = '$this->IdTrabajo' )";
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

		$sql = "SELECT * FROM TRABAJO WHERE (IdTrabajo  = '$this->IdTrabajo')";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
			$result = $resultado->fetch_array();
			$result[ 'FechaIniTrabajo' ] = date( "d/m/Y", strtotime( $result[ 'FechaIniTrabajo' ] ) );
			$result[ 'FechaFinTrabajo' ] = date( "d/m/Y", strtotime( $result[ 'FechaFinTrabajo' ] ) );
			return $result;
		}
	} // fin del metodo RellenaDatos()
    
    
    function dependencias() { // se construye la sentencia de busqueda de la tupla
        
        $dependencias = null;

		$sql = "SELECT E.IdTrabajo, LoginEvaluador, AliasEvaluado, IdHistoria, CorrectoA, ComenIncorrectoA, CorrectoP, ComentIncorrectoP, OK FROM EVALUACION E, TRABAJO T WHERE E.IdTrabajo = '$this->IdTrabajo' AND E.IdTrabajo = T.IdTrabajo";
        $resultado = $this->mysqli->query( $sql );
        if ( $resultado->num_rows >= 1 ) {
            $dependencias = $resultado;
        }
        
        return $dependencias;
	} // fin del metodo RellenaDatos()
    
    function dependencias2() { // se construye la sentencia de busqueda de la tupla
        
        $dependencias2 = null;

		$sql = "SELECT H.IdTrabajo, IdHistoria, TextoHistoria FROM HISTORIA H, TRABAJO T WHERE H.IdTrabajo = '$this->IdTrabajo' AND H.IdTrabajo = T.IdTrabajo";
        $resultado = $this->mysqli->query( $sql );
        if ( $resultado->num_rows >= 1 ) {
            $dependencias2 = $resultado;
        }
        
        return $dependencias2;
	} // fin del metodo RellenaDatos()
    
    function dependencias3() { // se construye la sentencia de busqueda de la tupla
        
        $dependencias3 = null;

		$sql = "SELECT login, NT.IdTrabajo, NotaTrabajo FROM NOTA_TRABAJO NT, TRABAJO T WHERE NT.IdTrabajo = '$this->IdTrabajo' AND NT.IdTrabajo = T.IdTrabajo";
        $resultado = $this->mysqli->query( $sql );
        if ( $resultado->num_rows >= 1 ) {
            $dependencias3 = $resultado;
        }
        
        return $dependencias3;
	} // fin del metodo RellenaDatos()
    
    function dependencias4() { // se construye la sentencia de busqueda de la tupla
        
        $dependencias4 = null;

		$sql = "SELECT QA.IdTrabajo, LoginEvaluador, LoginEvaluado, AliasEvaluado FROM ASIGNAC_QA QA, TRABAJO T WHERE QA.IdTrabajo = '$this->IdTrabajo' AND QA.IdTrabajo = T.IdTrabajo";
        $resultado = $this->mysqli->query( $sql );
        if ( $resultado->num_rows >= 1 ) {
            $dependencias4 = $resultado;
        }
        
        return $dependencias4;
	} // fin del metodo RellenaDatos()

    function dependencias5() { // se construye la sentencia de busqueda de la tupla
        
        $dependencias5 = null;

		$sql = "SELECT login, E.IdTrabajo, Alias, Horas, Ruta FROM ENTREGA E, TRABAJO T WHERE E.IdTrabajo = '$this->IdTrabajo' AND E.IdTrabajo=T.IdTrabajo";
        $resultado = $this->mysqli->query( $sql );
        if ( $resultado->num_rows >= 1 ) {
            $dependencias5 = $resultado;
        }
        
        return $dependencias5;
	} // fin del metodo RellenaDatos()
        
        
        // funcion EDIT()
	   // Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
	  // si existe se modifica
	function EDIT() {
		// se construye la sentencia de busqueda de la tupla en la bd
		$sql = "SELECT * FROM TRABAJO WHERE (IdTrabajo  = '$this->IdTrabajo')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) { // se construye la sentencia de modificacion en base a los atributos de la clase
			
				$sql = "UPDATE TRABAJO SET 
					IdTrabajo = '$this->IdTrabajo',
					 NombreTrabajo='$this->NombreTrabajo',
					 FechaIniTrabajo = STR_TO_DATE(REPLACE('$this->FechaIniTrabajo','/','.') ,GET_FORMAT(date,'EUR')),
					 FechaFinTrabajo = STR_TO_DATE(REPLACE('$this->FechaFinTrabajo','/','.') ,GET_FORMAT(date,'EUR')),
                     PorcentajeNota='$this->PorcentajeNota'
				WHERE ( IdTrabajo  = '$this->IdTrabajo'
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

    //Función de devuelve el array con todas las entregas pertenecientes al trabajo que se pasa como parametro
	function DevolverArray($Entrega){
		//Consulta que recupera la tabla trabajo
			$sql = "select ENTREGA.IdTrabajo,
						   login,
						   Alias
						   from ENTREGA,TRABAJO
						   where ENTREGA.IdTrabajo = TRABAJO.IdTrabajo
						   AND ENTREGA.IdTrabajo = '$Entrega'
						   AND Ruta != ''
						   order by login";
			//variable que almacena el resultado de la query
			$resultado = $this->mysqli->query( $sql );
			if ( $resultado->num_rows == 0 ) { return null; }
			
			//Caragamos las tuplas resultado de la consulta en un array
			while($datos = mysqli_fetch_row ($resultado)){
				//Variable que almacena el array de las tuplas resultado de la query
				$miarray[] = $datos;
			}
			//devuelve el array
			return $miarray;
	}

	function DevolverET(){
		$sql = "SELECT IdTrabajo,NombreTrabajo FROM `TRABAJO` WHERE (BINARY IdTrabajo LIKE 'ET%')"; 
		//variable que almacena el resultado de la query
			$resultado = $this->mysqli->query( $sql );
			if ( $resultado->num_rows == 0 ) { return null; }
			
			//Caragamos las tuplas resultado de la consulta en un array
			while($datos = mysqli_fetch_row ($resultado)){
				//Variable que almacena el array de las tuplas resultado de la query
				$miarray[] = $datos;
			}
			//devuelve el array
			return $miarray;
	}

	function DevolverQA(){
		$sql = "SELECT IdTrabajo,NombreTrabajo FROM `TRABAJO` WHERE (BINARY IdTrabajo LIKE 'QA%')"; 
		//variable que almacena el resultado de la query
			$resultado = $this->mysqli->query( $sql );
			if ( $resultado->num_rows == 0 ) { return null; }
			
			//Caragamos las tuplas resultado de la consulta en un array
			while($datos = mysqli_fetch_row ($resultado)){
				//Variable que almacena el array de las tuplas resultado de la query
				$miarray[] = $datos;
			}
			//devuelve el array
			return $miarray;
	}


          
    }


?>