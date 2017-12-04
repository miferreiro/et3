<?php

//modelo de datos definida con una clase que interactúa con el controlador que gestiona las entregas.
//Fecha de creación:28/11/2017
    class ENTREGA_MODEL{
        
        //Se definen las vaiables que se utilizarán en esta clase
        var $login; //es la clave de la tabla ENTREGA
        var $IdTrabajo;// es la clave de la tabla ENTREGA
        var $Alias;//Declaracion de la variable Alias
        var $Horas; //Declaracion de la variable Horas
        var $Ruta; //Declaracion de la variable Ruta
        function __construct($login,$IdTrabajo,$Alias,$Horas,$Ruta){
            //Asignamos valores a los atributos de la clase
            $this->login=$login;
            $this->IdTrabajo=$IdTrabajo;
            $this->Alias=$Alias;
            $this->Horas=$Horas;
            $this->Ruta=$Ruta;
            
            // incluimos la funcion de acceso a la bd
		      include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		      $this->mysqli = ConectarBD();
        }//fin del constructor
        
        
        
	//funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select login,
                        IdTrabajo,
                        Alias,
                        Horas,
                        Ruta
       			from ENTREGA
    			where 
    				(
					(BINARY login LIKE '%$this->login%') &&
                    (BINARY IdTrabajo LIKE '%$this->IdTrabajo%') &&
                    (BINARY Alias LIKE '%$this->Alias%') &&
                    (BINARY Horas LIKE '%$this->Horas%') &&
                    (BINARY Ruta LIKE '%$this->Ruta%')
    				)";
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
	} // fin metodo SEARCH
        
    function buscarAlias(){
        $sql = "select Alias
       			from ENTREGA
    			where 
    				(Alias = '$this->Alias')";
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
    }
        
        
    //Metodo ADD()
	//Inserta en la tabla  de la bd  los valores
	// de los atributos del objeto. Comprueba si la clave esta vacia y si 
	//existe ya en la tabla
	function ADD() {
		if ( ( $this->login <> '' && $this->IdTrabajo <> '' ) ) { // si el atributo clave de la entidad no esta vacio
            
            
            
        
          $trabajo = "SELECT * FROM TRABAJO WHERE ( IdTrabajo='$this->IdTrabajo')";
                    $result=$this->mysqli->query($trabajo);
                if(!$result){
                    return "No se ha podido conectar a la base de datos";
                }
                else{
                    if($result->num_rows == 0){
                        return "No puedes añadir la entrega debido a que no se añadio un trabajo";
                    }
                }
                
            
                $usuario = "SELECT * FROM USUARIO WHERE (login= '$this->login')";
            
                 $result=$this->mysqli->query($usuario);
            
                if(!$result){
                    
                      return "No se ha podido conectar a la base de datos";
                }
            
                else{
                    if($result->num_rows == 0){
                        return "No puedes añadir la entrega debido a que no se añadio un usuario";
                    }
                }
                
            
            
            $usuario = "SELECT * FROM ENTREGA WHERE (login= '$this->login')";
            
                 $result=$this->mysqli->query($usuario);
            
                if(!$result){
                    
                      return "No se ha podido conectar a la base de datos";
                }
            
                else{
                    if($result->num_rows == 1){
                        return "No puedes añadir la entrega debido a que añadiste una, modificala o borrala";
                    }
                }
            
            
			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM ENTREGA WHERE (  login = '$this->login' && IdTrabajo = '$this->IdTrabajo')";
            $vacio='';
			if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} else { // si la ejecución de la query no da error
                if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio
                    //hacemos la inserción en la base de datos
					$sql = "INSERT INTO ENTREGA (
							    login,
                                IdTrabajo,
                                Alias,
                                Horas,
                                Ruta) 
								VALUES(
								'$this->login',
								'$this->IdTrabajo',
								'$this->Alias',
                                '$this->Horas',
                                '$this->Ruta'
								)";
                    
                    $sql2= "INSERT INTO NOTA_TRABAJO (
							    login,
                                IdTrabajo,
                                NotaTrabajo) 
								VALUES(
								'$this->login',
								'$this->IdTrabajo',
                                '$vacio'
								)";
                }
                    else{
                        return 'Ya existe la entrega introducida en la base de datos'; // ya existe
                    }
                }
					if ( !$this->mysqli->query( $sql )) { // si da error en la ejecución del insert devolvemos mensaje
						return "Error en la inserción";
					}
            
                    if(!$this->mysqli->query( $sql2 ) ){
                        return "Error en la inserción";
                    }
            
                    else { //si no da error en la insercion devolvemos mensaje de exito
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
		$sql = "SELECT * FROM ENTREGA WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si existe una tupla con ese valor de clave

		if ( $result->num_rows == 1 ) {
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM ENTREGA WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo' )";
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

		$sql = "SELECT * FROM ENTREGA WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo')";
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
		$sql = "SELECT * FROM ENTREGA WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo')";
        $sql2="SELECT * FROM NOTA_TRABAJO WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
        $result2 = $this->mysqli->query( $sql2 );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) { // se construye la sentencia de modificacion en base a los atributos de la clase
			
            if($this->Ruta <> null){
				$sql = "UPDATE ENTREGA SET 
					login = '$this->login',
					 IdTrabajo='$this->IdTrabajo',
                     Alias='$this->Alias',
                     Horas='$this->Horas',
                     Ruta='$this->Ruta'
				WHERE ( login = '$this->login' AND IdTrabajo = '$this->IdTrabajo'
				)";
                
                if($result2->num_rows == 1){
                    $sql2 = "UPDATE ENTREGA SET 
				     login = '$this->login',
					 IdTrabajo='$this->IdTrabajo',
                     NotaTrabajo=''
				WHERE ( login = '$this->login' AND IdTrabajo = '$this->IdTrabajo'
				)";
                    
                }
                else{
                     $sql2= "INSERT INTO NOTA_TRABAJO (
							    login,
                                IdTrabajo,
                                NotaTrabajo) 
								VALUES(
								'$this->login',
								'$this->IdTrabajo',
                                ''
								)";
                }
                

            }
            else{
                $sql = "UPDATE ENTREGA SET 
					login = '$this->login',
					 IdTrabajo='$this->IdTrabajo',
                     Alias='$this->Alias',
                     Horas='$this->Horas'
				WHERE ( login = '$this->login' AND IdTrabajo = '$this->IdTrabajo'
				)";
                
                 if($result2->num_rows == 1){
                    $sql2 = "UPDATE ENTREGA SET 
				     login = '$this->login',
					 IdTrabajo='$this->IdTrabajo',
                     NotaTrabajo=''
				WHERE ( login = '$this->login' AND IdTrabajo = '$this->IdTrabajo'
				)";
                    
                }
                //else{
                   /*  $sql2= "INSERT INTO NOTA_TRABAJO (
							    login,
                                IdTrabajo,
                                NotaTrabajo) 
								VALUES(
								'$this->login',
								'$this->IdTrabajo',
                                ''
								)";
                }
                */
           // }
            }
			// si hay un problema con la query se envia un mensaje de error en la modificacion
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			}
           
          /*  if(!$this->mysqli->query( $sql2 ) ){
                return "Error en la inserción";
            }*/
            else { // si no hay problemas con la modificación se indica que se ha modificado
				return 'Modificado correctamente';
			}

		} else // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
			return 'No existe en la base de datos';
	} // fin del metodo EDIT

            
    }



?>