<?php

/*
 Función: modelo de datos definida en una clase que permite interactuar con la base de datos
 Fecha de creación:4/12/2017
*/
class NOTAS_MODEL{ //declaración de la clase

	var $IdTrabajo;//declaracion del atributo IdTrabajo
    var $login;//declaracion del atributo login
    var $NotaTrabajo;//declaracion del atributo NotaTrabajo
	var $mysqli; // declaración del atributo manejador de la bd
  
	//Constructor de la clase

	function __construct($IdTrabajo,$login,$NotaTrabajo) {
        //asignación de valores de parámetro a los atributos de la clase
        $this->IdTrabajo = $IdTrabajo;
		$this->login = $login;
        $this->NotaTrabajo = $NotaTrabajo;
		
        
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
                        login,
                        NotaTrabajo
       			from NOTA_TRABAJO
    			where 
    				(
					(BINARY IdTrabajo LIKE '%$this->IdTrabajo%') &&
                    (BINARY login LIKE '%$this->login%') &&
	 				(BINARY NotaTrabajo LIKE '%$this->NotaTrabajo%')
    				)";
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
	} // fin metodo SEARCH
    
    function RellenaDatosShowCurrent() { // se construye la sentencia de busqueda de la tupla

		$sql = "SELECT E.IdTrabajo,IdHistoria,CorrectoP,ComentIncorrectoP,OK FROM EVALUACION E,ENTREGA ET WHERE 
        ( E.IdTrabajo = ET.IdTrabajo && E.IdTrabajo = '$this->IdTrabajo' && Alias = AliasEvaluado && login='$this->login')";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si existe se devuelve la tupla resultado
            
            
			return $resultado;
		}
	} // fin del metodo RellenaDatosShowCurrent()
    
     function RellenaDatosShowCurrent2() { // se construye la sentencia de busqueda de la tupla

		$sql = "SELECT E.IdTrabajo,IdHistoria,CorrectoA,ComenIncorrectoA,CorrectoP,ComentIncorrectoP,OK FROM EVALUACION E,ENTREGA ET WHERE 
        ( E.IdTrabajo = ET.IdTrabajo && E.IdTrabajo = '$this->IdTrabajo' && LoginEvaluador='$this->login')";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si existe se devuelve la tupla resultado
            
            
			return $resultado;
		}
	} // fin del metodo RellenaDatos()
    
    


	//Metodo ADD()
	//Inserta en la tabla  de la bd  los valores
	// de los atributos del objeto. Comprueba si la clave/s esta vacia y si 
	//existe ya en la tabla
	function ADD() {
		if ( ( $this->IdTrabajo <> '' && $this->login <> '' ) ) { // si el atributo clave de la entidad no esta vacio
            
			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM NOTA_TRABAJO WHERE (  login = '$this->login'  && IdTrabajo = '$this->IdTrabajo')";

			if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} else { // si la ejecución de la query no da error

				 if($result->num_rows ==1){
                     return "ya está almacenada esta nota";
                 }
                    else{
							$sql = "INSERT INTO NOTA_TRABAJO (
							     login,
                                 IdTrabajo,
							     NotaTrabajo
					               ) 
								VALUES(
								'$this->login',
								'$this->IdTrabajo',
								'$this->NotaTrabajo'
								)";
							
                        
                    }
						}

					
					if ( !$this->mysqli->query( $sql )) { // si da error en la ejecución del insert devolvemos mensaje
						return 'Error en la inserción';
					} else { //si no da error en la insercion devolvemos mensaje de exito
						return 'Inserción realizada con éxito'; //operacion de insertado correcta
					}
			
		} else { // si el atributo clave de la bd es vacio solicitamos un valor en un mensaje
			return 'Introduzca un valor'; // introduzca un valor para el usuario
		}
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
		$sql = "SELECT * FROM NOTA_TRABAJO WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si existe una tupla con ese valor de clave

		if ( $result->num_rows == 1 ) {
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM NOTA_TRABAJO WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo' )";
			
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

		$sql = "SELECT * FROM NOTA_TRABAJO WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo')";
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
		$sql = "SELECT * FROM NOTA_TRABAJO WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) {
			     //modificamos los atributos de la tabla USUARIO
				$sql = "UPDATE NOTA_TRABAJO SET 
					login = '$this->login',
                    IdTrabajo='$this->IdTrabajo',
					NotaTrabajo = '$this->NotaTrabajo'
				WHERE ( login = '$this->login' AND IdTrabajo = '$this->IdTrabajo'
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
    
} //fin de clase

?>