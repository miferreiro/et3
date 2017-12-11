<?php

/*
 Función: modelo de datos definida en una clase que permite interactuar con la base de datos
 Fecha de creación:23/11/2017
*/
class USUARIO_MODEL{ //declaración de la clase

	var $login; // declaración del atributo login
    var $password;//declaración del atributo password
	var $DNI; // declaración del atributo DNI
	var $Nombre; // declaración del atributo Nombre
	var $Apellidos; // declaración del atributo Apellidos
    var $Correo; // declaración del atributo Correo
    var $Direccion;//declaración del atributo Direccion
	var $Telefono; // declaración del atributo Telefono
	var $mysqli; // declaración del atributo manejador de la bd
    var $dependencias;//declaración del atributo dependencias
    var $dependencias2;//declaración del atributo dependencias
    var $dependencias3;//declaración del atributo dependencias
    var $dependencias4;//declaración del atributo dependencias
    var $dependencias5;//declaración del atributo dependencias
    var $dependencias6;//declaración del atributo dependencias
	//Constructor de la clase

	function __construct($login,$password,$DNI,$Nombre,$Apellidos,$Correo,$Direccion,$Telefono) {
		//asignación de valores de parámetro a los atributos de la clase
		$this->login = $login;
        $this->password=$password;
		$this->DNI = $DNI;
		$this->Nombre = $Nombre;
		$this->Apellidos = $Apellidos;
        $this->Correo = $Correo;
        $this->Direccion=$Direccion;
		$this->Telefono = $Telefono;	
		
        
		// incluimos la funcion de acceso a la bd
		include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		$this->mysqli = ConectarBD();

	} // fin del constructor

	//funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select  login,
                    password,
					DNI,
					Nombre,
					Apellidos,
                    Correo,
                    Direccion,
					Telefono
       			from USUARIO 
    			where 
    				(
					(BINARY login LIKE '%$this->login%') &&
                    (BINARY password LIKE '%$this->password%') &&
    				(BINARY DNI LIKE '%$this->DNI%') &&
					(BINARY Nombre LIKE '%$this->Nombre%') &&
	 				(BINARY Apellidos LIKE '%$this->Apellidos%') &&
                    (BINARY Correo LIKE '%$this->Correo%') &&
                    (BINARY Direccion LIKE '%$this->Direccion%') &&
	 				(BINARY Telefono LIKE '%$this->Telefono%')
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
	// de los atributos del objeto. Comprueba si la clave/s esta vacia y si 
	//existe ya en la tabla
	function ADD() {
		if ( ( $this->login <> '' ) ) { // si el atributo clave de la entidad no esta vacio
            
			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM USUARIO WHERE (  login = '$this->login')";

			if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} else { // si la ejecución de la query no da error

				if ( $result->num_rows == 0 ) { // miramos si el resultado de la consulta es vacio (no existe el login)
					// construimos el sql para buscar esa clave candidata en la tabla
					$sql = "SELECT * FROM USUARIO WHERE (DNI = '$this->DNI')";
					
					if ( $result->num_rows != 0 ) {// miramos si el resultado de la consulta no es vacio ( existe el dni)
						// si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
						return 'Ya existe un usuario con el DNI introducido en la base de datos';// ya existe
						
					} else {
						// construimos el sql para buscar esa clave candidata en la tabla
						$sql = "SELECT * FROM USUARIO WHERE  (Correo = '$this->Correo')";

						if ( $result->num_rows != 0 ) {// miramos si el resultado de la consulta no es vacio ( existe el Correo)
							// si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
							return 'Ya existe un usuario con el Correo introducido en la base de datos';// ya existe
							
						} else { //si ninguna de las claves candidatas son iguales, insertamos el usuario
                            //insertamos un usuario
							$sql = "INSERT INTO USUARIO (
							     login,
                                 password,
							     DNI,
					             Nombre,
					             Apellidos,
                                 Correo,
                                 Direccion,
					             Telefono) 
								VALUES(
								'$this->login',
                                '$this->password',
								'$this->DNI',
								'$this->Nombre',
								'$this->Apellidos',
								'$this->Correo',
								'$this->Direccion',
								'$this->Telefono'
								)";
							$sql2 = "INSERT INTO USU_GRUPO
										(login,IdGrupo)
										VALUES
										('$this->login',
										 '00001A'
										)";
						}

					}
					if ( !$this->mysqli->query( $sql ) || !$this->mysqli->query( $sql2 ) ) { // si da error en la ejecución del insert devolvemos mensaje
						return 'Error en la inserción';
					} else { //si no da error en la insercion devolvemos mensaje de exito
						return 'Inserción realizada con éxito'; //operacion de insertado correcta
					}

				} else // si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
					return 'Ya existe el usuario introducido en la base de datos'; // ya existe
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
		$sql = "SELECT * FROM USUARIO WHERE (login = '$this->login')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si existe una tupla con ese valor de clave

		if ( $result->num_rows == 1 ) {
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM USUARIO WHERE (login = '$this->login' )";
			$sql2 = "DELETE FROM USU_GRUPO WHERE (login = '$this->login' )";
			// se ejecuta la query
			$this->mysqli->query( $sql );
			$this->mysqli->query( $sql2 );
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

		$sql = "SELECT * FROM USUARIO WHERE (login = '$this->login')";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
			$result = $resultado->fetch_array();
			return $result;
		}
	} // fin del metodo RellenaDatos()
    
    // funcion RellenaDatos()
	// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
	// en el atributo de la clase
	function dependencias() { // se construye la sentencia de busqueda de la tupla
        
        $dependencias = null;

		$sql = "SELECT * FROM USU_GRUPO WHERE (login = '$this->login')";
        $resultado = $this->mysqli->query( $sql );
        if ( $resultado->num_rows >= 1 ) {
            $dependencias = $resultado;
        }
        
        return $dependencias;
	} // fin del metodo RellenaDatos()
    
    function dependencias2() { // se construye la sentencia de busqueda de la tupla
        
        $dependencias2 = null;

        
        $sql = "SELECT * FROM ENTREGA WHERE (login = '$this->login')";
        $resultado = $this->mysqli->query( $sql );
        if ( $resultado->num_rows == 1 ) {
            
            $dependencias2 = $resultado;
        }
        
        return $dependencias2;
	} // fin del metodo RellenaDatos()
    
    function dependencias3() { // se construye la sentencia de busqueda de la tupla
        
        $dependencias3 = null;
        
        $sql = "SELECT * FROM ASIGNAC_QA WHERE (LoginEvaluador = '$this->login')";
        $resultado = $this->mysqli->query( $sql );
        if ( $resultado->num_rows == 1 ) { 
            $dependencias3 = $resultado;
        }
        
        return $dependencias3;
	} // fin del metodo RellenaDatos()
    
    function dependencias4() { // se construye la sentencia de busqueda de la tupla
        
        $dependencias4 = null;
        
		
        $sql = "SELECT * FROM ASIGNAC_QA WHERE (LoginEvaluado = '$this->login')";
        $resultado = $this->mysqli->query( $sql );
        if ( $resultado->num_rows == 1 ) {
            $dependencias4 = $resultado;
        }
        
        return $dependencias4;
	} // fin del metodo RellenaDatos()
    
    function dependencias5() { // se construye la sentencia de busqueda de la tupla
        
        $dependencias5 = null;
        
        $sql = "SELECT * FROM NOTA_TRABAJO WHERE (login = '$this->login')";
        $resultado = $this->mysqli->query( $sql );
        if ( $resultado->num_rows == 1 ) {
            $dependencias5 = $resultado;
        }
        
        return $dependencias5;
	} // fin del metodo RellenaDatos()

    function dependencias6() { // se construye la sentencia de busqueda de la tupla
        
        $dependencias6 = null;
        
        $sql = "SELECT * FROM EVALUACION WHERE (LoginEvaluador = '$this->login')";
        $resultado = $this->mysqli->query( $sql );
        if ( $resultado->num_rows == 1 ) {
            $dependencias6 = $resultado;
        }
        
        return $dependencias6;
	} // fin del metodo RellenaDatos()


	// funcion EDIT()
	// Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
	// si existe se modifica
	function EDIT() {
		// se construye la sentencia de busqueda de la tupla en la bd
		$sql = "SELECT * FROM USUARIO WHERE (login = '$this->login')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si el numero de filas es igual a uno es que lo encuentra
		if ( $result->num_rows == 1 ) {
			// se construye la sentencia de modificacion en base a los atributos de la clase
			//if ( count($Grup) == 0){
			//modificamos los atributos de la tabla USUARIO
			$sql = "UPDATE USUARIO SET 
					login = '$this->login',
                    password='$this->password',
					DNI = '$this->DNI',
					Nombre = '$this->Nombre',
					Apellidos = '$this->Apellidos',
                    Correo = '$this->Correo',
                    Direccion ='$this->Direccion',
					Telefono = '$this->Telefono'
				WHERE ( login = '$this->login'
				)";
			// si hay un problema con la query se envia un mensaje de error en la modificacion
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
				return 'Error en la modificación';
			} else { // si no hay problemas con la modificación se indica que se ha modificado
				return 'Modificado correctamente';
			}

		} // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
		else {
			return 'No existe en la base de datos';
		}
	} // fin del metodo EDIT



	//Con esta función vemos si ya está registrado el usuario, sino lo registramos
	function Register() {
        
		$sql = "select * from USUARIO where login = '" . $this->login . "'";//miramos los usuarios cuyo login es igual al que nos pasan

		$result = $this->mysqli->query( $sql ); //hacemos la consulta en la base de datos.
		if ( $result->num_rows == 1 ) { // existe el usuario
			return 'El usuario ya existe';
		} else {
			$sql = "SELECT * FROM USUARIO WHERE (DNI = '$this->DNI')";//miramos si el DNI ya está insertado
					
				if ( $result->num_rows != 0 ) {// miramos si el resultado de la consulta no es vacio ( existe el dni)
					// si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
					return 'Ya existe un usuario con el DNI introducido en la base de datos';// ya existe
					
				} else {
					// construimos el sql para buscar esa clave candidata en la tabla
					$sql = "SELECT * FROM USUARIO WHERE  (Correo = '$this->Correo')";//miramos si el Correo está insertado

					if ( $result->num_rows != 0 ) {// miramos si el resultado de la consulta no es vacio ( existe el Correo)
						// si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
						return 'Ya existe un usuario con el Correo introducido en la base de datos';// ya existe
						
					}else{
								return true; //no existe el usuario
					}
				}
		}

	} //fin del método Register
        
        // funcion login: realiza la comprobación de si existe el usuario en la bd y despues si la pass
	   // es correcta para ese usuario. Si es asi devuelve true, en cualquier otro caso devuelve el 
	   // error correspondiente
	function login() {
        //hacemos la consulta para saber que usuario tiene dicho login
		$sql = "SELECT *
			FROM USUARIO
			WHERE (
				(login = '$this->login') 
			)";
		$resultado = $this->mysqli->query( $sql );//hacemos la consulta en la base de datos
		if ( $resultado->num_rows == 0 ) {//miramos si el numero de filas es 0
			return 'El usuario no existe';
		} else {//si no es 0, el usuario existe
			$tupla = $resultado->fetch_array();//devolvemos la tupla
			if ( $tupla[ 'password' ] == $this->password ) {//si la contraseña es correcta entra en la página
				return true;
			} else {//en caso contrario no entra
				return 'La password para este usuario no es correcta';
			}
		}
	} //fin metodo login
	
/*	//Comprueba que la Bd esté vacia, es decir sin grupos.
	function comprobarBdIncial(){
		
		$sql = "SELECT * FROM GRUPO U";
		
		$resultado = $this->mysqli->query($sql); //hacemos la consulta en la base de datos
		
		if($resultado->num_rows == 0){//miramos si el numero de filas es 0
			return true;
		}else{
			return false;
		}
	
	}
	
	
	function primerUsuario(){
		$sqlInicial = "INSERT INTO GRUPO (IdGrupo,NombreGrupo,DescripGrupo) VALUES ('00000A','Administracion','Grupo que tendra todos los permisos')";

		
		if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
			return 'No se ha podido conectar con la base de datos';
		}

        $sqlInicial = "INSERT INTO GRUPO  (IdGrupo,NombreGrupo,DescripGrupo) VALUES ('00001A','ALUMNOS','Grupo que tendra todos los permisos de alumnos')";

		
		if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
			return 'No se ha podido conectar con la base de datos';
		}

		$sqlInicial = "INSERT INTO FUNCIONALIDAD (IdFuncionalidad,NombreFuncionalidad,DescripFuncionalidad) VALUES('1','GestionUsuarios','GestionUsuarios')";
		if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
			return 'No se ha podido conectar con la base de datos';
		}

		$sqlInicial = "INSERT INTO FUNCIONALIDAD (IdFuncionalidad,NombreFuncionalidad,DescripFuncionalidad) VALUES('2','GestionGrupos','GestionGrupos')";
		if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
			return 'No se ha podido conectar con la base de datos';
		}

		$sqlInicial = "INSERT INTO FUNCIONALIDAD (IdFuncionalidad,NombreFuncionalidad,DescripFuncionalidad) VALUES('3','GestionFuncionalidades','GestionFuncionalidades')";
		if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
			return 'No se ha podido conectar con la base de datos';
		}

		$sqlInicial = "INSERT INTO FUNCIONALIDAD (IdFuncionalidad,NombreFuncionalidad,DescripFuncionalidad) VALUES('4','GestionAccion','GestionAccion')";
		if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
			return 'No se ha podido conectar con la base de datos';
		}
		$sqlInicial = "INSERT INTO FUNCIONALIDAD (IdFuncionalidad,NombreFuncionalidad,DescripFuncionalidad) VALUES('5','GestionPermisos','GestionPermisos')";
		if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
			return 'No se ha podido conectar con la base de datos';
		}

		$sqlInicial = "INSERT INTO ACCION (IdAccion,NombreAccion,DescripAccion) VALUES('0','ADD','ADD')";
		if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
			return 'No se ha podido conectar con la base de datos';
		}
		
		$sqlInicial = "INSERT INTO ACCION (IdAccion,NombreAccion,DescripAccion) VALUES('1','DELETE','DELETE')";
		if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
			return 'No se ha podido conectar con la base de datos';
		}
		
		$sqlInicial = "INSERT INTO ACCION (IdAccion,NombreAccion,DescripAccion) VALUES('2','EDIT','EDIT')";
		if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
			return 'No se ha podido conectar con la base de datos';
		}

		$sqlInicial = "INSERT INTO ACCION (IdAccion,NombreAccion,DescripAccion) VALUES('3','SEARCH','SEARCH')";
		if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
			return 'No se ha podido conectar con la base de datos';
		}
	
		$sqlInicial = "INSERT INTO ACCION (IdAccion,NombreAccion,DescripAccion) VALUES('4','SHOWCURRENT','SHOWCURRENT')";
		if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
			return 'No se ha podido conectar con la base de datos';
		}

		$sqlInicial = "INSERT INTO ACCION (IdAccion,NombreAccion,DescripAccion) VALUES('5','SHOWALL','SHOWALL')";
		if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
			return 'No se ha podido conectar con la base de datos';
		}

		$sqlInicial = "INSERT INTO ACCION (IdAccion,NombreAccion,DescripAccion) VALUES('6','ASIGN','ASIGN')";
		if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
			return 'No se ha podido conectar con la base de datos';
		}
		
		$sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('1','0')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('1','1')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('1','2')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('1','3')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('1','4')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('1','5')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('1','6')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }		
		
        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('2','0')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('2','1')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('2','2')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('2','3')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('2','4')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('2','5')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('2','6')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }		

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('3','0')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('3','1')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('3','2')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('3','3')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('3','4')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('3','5')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

		$sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('3','6')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }		
		
        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('4','0')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('4','1')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('4','2')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('4','3')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('4','4')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('4','5')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

	    $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('4','6')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }		


        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('5','3')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }

        $sqlInicial = "INSERT INTO FUNC_ACCION (IdFuncionalidad,IdAccion) VALUES('5','5')";
        if ( !$result = $this->mysqli->query( $sqlInicial ) ) {
            return 'No se ha podido conectar con la base de datos';
        }
	
		
		if ( ( $this->login <> '' ) ) { // si el atributo clave de la entidad no esta vacio
            
			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM USUARIO WHERE (  login = '$this->login')";

			if ( !$result = $this->mysqli->query( $sql ) ) { // si da error la ejecución de la query
				return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
			} else { // si la ejecución de la query no da error

				if ( $result->num_rows == 0 ) { // miramos si el resultado de la consulta es vacio (no existe el login)
					// construimos el sql para buscar esa clave candidata en la tabla
					$sql = "SELECT * FROM USUARIO WHERE (DNI = '$this->DNI')";
					
					if ( $result->num_rows != 0 ) {// miramos si el resultado de la consulta no es vacio ( existe el dni)
						// si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
						return 'Ya existe un usuario con el DNI introducido en la base de datos';// ya existe
						
					} else {
						// construimos el sql para buscar esa clave candidata en la tabla
						$sql = "SELECT * FROM USUARIO WHERE  (Correo = '$this->Correo')";

						if ( $result->num_rows != 0 ) {// miramos si el resultado de la consulta no es vacio ( existe el Correo)
							// si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
							return 'Ya existe un usuario con el Correo introducido en la base de datos';// ya existe
							
						} else { //si ninguna de las claves candidatas son iguales, insertamos el usuario
                            //insertamos un usuario
							$sql = "INSERT INTO USUARIO (
							     login,
                                 password,
							     DNI,
					             Nombre,
					             Apellidos,
                                 Correo,
                                 Direccion,
					             Telefono) 
								VALUES(
								'$this->login',
                                '$this->password',
								'$this->DNI',
								'$this->Nombre',
								'$this->Apellidos',
								'$this->Correo',
								'$this->Direccion',
								'$this->Telefono'
								)";
							$sql2 = "INSERT INTO USU_GRUPO
										(login,IdGrupo)
										VALUES
										('$this->login',
										 '00000A'
										)";
						}

					}
					if ( !$this->mysqli->query( $sql ) || !$this->mysqli->query( $sql2 ) ) { // si da error en la ejecución del insert devolvemos mensaje
						return 'Error en la inserción';
					} else { //si no da error en la insercion devolvemos mensaje de exito
						return 'Inserción realizada con éxito'; //operacion de insertado correcta
					}

				} else // si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
					return 'Ya existe el usuario introducido en la base de datos'; // ya existe
			}
		} else { // si el atributo clave de la bd es vacio solicitamos un valor en un mensaje
			return 'Introduzca un valor'; // introduzca un valor para el usuario
		}
	}

	    */
    

} //fin de clase

?>