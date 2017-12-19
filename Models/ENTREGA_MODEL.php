<?php

//modelo de datos definida con una clase que interactúa con el controlador que gestiona las entregas.
//Fecha de creación:28/11/2017 Autor:Brais Santos
    class ENTREGA_MODEL{
        
        //Se definen las vaiables que se utilizarán en esta clase
        var $login; //es la clave de la tabla ENTREGA
        var $IdTrabajo;// es la clave de la tabla ENTREGA
        var $Alias;//Declaracion de la variable Alias
        var $Horas; //Declaracion de la variable Horas
        var $Ruta; //Declaracion de la variable Ruta
        var $dependencias; //Declaracion de la variable dependencias
        var $dependencias2; //Declaracion de la variable dependencias2
        function __construct($login,$IdTrabajo,$Alias,$Horas,$Ruta){
            //Asignamos valores a los atributos de la clase
            $this->login=$login;//le asignamos  a login un valor
            $this->IdTrabajo=$IdTrabajo;//le asignamos a IdTrabajo un valor
            $this->Alias=$Alias;//se le asigna un valor al alias
            $this->Horas=$Horas;//se le asigna un valor a horas
            $this->Ruta=$Ruta;//se le asigna un valor a la ruta
            
            // incluimos la funcion de acceso a la bd
		      include_once '../Functions/BdAdmin.php';
		// conectamos con la bd y guardamos el manejador en un atributo de la clase
		      $this->mysqli = ConectarBD();
        }//fin del constructor
        
    //Esta funcion coge el login y Idtrabajo de todas las entregas
    function cogerDatos($trabajo){
        $sql = "SELECT IdTrabajo,login FROM ENTREGA WHERE IdTrabajo LIKE '%et%' AND IdTrabajo='$trabajo'";//Se construye la sentencia sql
            if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {//ejecutamos la query
			         return 'Error en la consulta sobre la base de datos';
		  } else { // si existe se devuelve la tupla resultado
           
            return $resultado;
		}
    }
	//funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select login,
                        E.IdTrabajo,
						T.NombreTrabajo,
                        Alias,
                        Horas,
                        Ruta
       			from ENTREGA E, TRABAJO T
    			where 
    				(
					(BINARY login LIKE '%$this->login%') &&
                    (BINARY E.IdTrabajo LIKE '%$this->IdTrabajo%') &&
                    (BINARY Alias LIKE '%$this->Alias%') &&
                    (BINARY Horas LIKE '%$this->Horas%') &&
                    (BINARY Ruta LIKE '%$this->Ruta%') &&
					(E.IdTrabajo = T.IdTrabajo)
    				)";// se construye la sentencia sql
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
	} // fin metodo SEARCH
        
    //funcion SEARCH: hace una búsqueda en la tabla con
	//los datos proporcionados. Si van vacios devuelve todos
    //Se utiliza en case SUBIR_ENTREGA de ENTREGA_CONTROLLER cuando queramos buscar todas las tuplas
	function SEARCH2() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select login,
                        E.IdTrabajo,
						T.NombreTrabajo,
                        Alias,
                        Horas,
                        Ruta
       			from ENTREGA E, TRABAJO T
    			where 
    				(
					(BINARY login = '$this->login') &&
                    (BINARY E.IdTrabajo LIKE '%$this->IdTrabajo%') &&
                    (BINARY Alias LIKE '%$this->Alias%') &&
                    (BINARY Horas LIKE '%$this->Horas%') &&
                    (BINARY Ruta LIKE '%$this->Ruta%')&&
					(E.IdTrabajo = T.IdTrabajo)
    				)";//se construye la sentencia sql
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
	}//fin de la funcion SEARCH2
        
    //esta función sirve para generar las QAs generando una palabra aleatoria
    function aleatorio(){
        $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
        $numerodeletras=10; //numero de letras para generar el texto
        $cadena = ""; //variable para almacenar la cadena generada
        for($i=0;$i<$numerodeletras;$i++)//se genera una palabra de 10 caracteres
        {       
            $cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres 
                entre el rango 0 a Numero de letras que tiene la cadena */
        }
        return $cadena;
        
        
    }//fin de método aleatorio.
        
    //Esta función sirve para buscar un alias y servirá para comprobar que un alias no se repita    
     function buscarAlias($Alias_Usuario){
        $sql = "select Alias
       			from ENTREGA
    			where 
    				(Alias = '$Alias_Usuario')";//Se construye la sentencia sql
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			if($resultado->num_rows == 1){//miramos si el número de filas es igual a uno y si es devolvemos true
                return true;
            }
            else// si no es devolvemos false
                return false;
		}
         return false;
    }
				
        function obtenerUsuarios(){
        $sql = "select login
       			from ENTREGA";//Se construye la sentencia sql
		// si se produce un error en la busqueda mandamos el mensaje de error en la consulta
			if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
    }    
          function obtenerAlias($LOG){
        $sql = "select Alias
       			from ENTREGA WHERE login=='$LOG'";//Se construye la sentencia sql
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
              
        
        /*  $trabajo = "SELECT * FROM TRABAJO WHERE ( IdTrabajo='$this->IdTrabajo')";
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
                */
            
			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM ENTREGA WHERE (  login = '$this->login' && IdTrabajo = '$this->IdTrabajo')";
            $vacio='';//inicializamos la variable vacío
            
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
								)";//se contruye la sentencia sql para insertar la entrega
                    
                 /*  include_once '../Models/NOTAS_MODEL.php';//incluimos el modelo USU_GRUPO
							$NOTA = new NOTAS_MODEL($this->IdTrabajo,$this->login,'');//instanciamos un objeto del modelo USU_GRUPO donde metemos un  usuario en el grupo alumnos
							$mensaje = $NOTA->ADD();//insertamos el login en el grupo alumnos
                       */  
                    
                   
                }
                    else{//si el número de tuplas no es 0
                        return 'Ya existe la entrega introducida en la base de datos'; // ya existe
                    }
                }
					if ( !$this->mysqli->query( $sql )) { // si da error en la ejecución del insert devolvemos mensaje
						return "Error en la inserción";
					}
                 
                    
                    else { //si no da error en la insercion devolvemos mensaje de exito
						return 'Inserción realizada con éxito'; //operacion de insertado correcta
					}

				} else // si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
					return 'Inserta un valor'; // ya existe
    
	} // fin del metodo ADD
    
    //esta función la utiliaremos para comprobar si un usuario ya tiene una entrega ó no
    function comprobarCreacion(){
        $sql = "SELECT * FROM ENTREGA WHERE login='$this->login' AND IdTrabajo='$this->IdTrabajo'";//se contruye la sentencia sql
        
         if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {//se ejecuta la query y miramos si da error
			return 'Error en la consulta sobre la base de datos';
		}
            else{// si no error
                if($resultado->num_rows == 1){//miramos si el número de tuplas es 1
                    return true;
                }
                else{//si el número de tuplas mo es uno 
                    return false;
                }
            }
        
        
        
    }

         // funcion DELETE()
	    // comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
	    // se manda un mensaje de que ese valor de clave no existe
	function DELETE() {
		// se construye la sentencia sql de busqueda con los atributos de la clase
		$sql = "SELECT * FROM ENTREGA WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si existe una tupla con ese valor de clave

		if ( $result->num_rows == 1 ) {//miramos si el número de tuplas es uno
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM ENTREGA WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo' )";//se construye la sentencia sql
			// se ejecuta la query
			$this->mysqli->query( $sql );
			// se devuelve el mensaje de borrado correcto
			return "Borrado correctamente";
		} // si no existe el login a borrar se devuelve el mensaje de que no existe
		else//si el número de tuplas no es 0
			return "No existe";
	} // fin metodo DELETE
  
        // funcion RellenaDatos()
        // Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
	   // en el atributo de la clase
	function RellenaDatos() { // se construye la sentencia de busqueda de la tupla

		$sql = "SELECT * FROM ENTREGA WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo')";//se construye la sentencia sql
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
			$result = $resultado->fetch_array();
			return $result;
		}
	} // fin del metodo RellenaDatos()
        
        function dependencias() { // se construye la sentencia de busqueda de la tupla
        
        $dependencias = null;//inicializamos la variable a null

		$sql = "SELECT NombreTrabajo, QA.LoginEvaluador, LoginEvaluado, AliasEvaluado FROM ASIGNAC_QA QA, ENTREGA E, TRABAJO T WHERE QA.LoginEvaluador = '$this->login' AND QA.LoginEvaluador = E.login AND QA.IdTrabajo = T.IdTrabajo";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//se ejecuta la query
        if ( $resultado->num_rows >= 1 ) {//miramos si el número de tuplas es mayor o igual que uno
            $dependencias = $resultado;//le pasamos a la variable dependencias todas las tablas de las que depende
        }
        
        return $dependencias;
	} // fin del metodo RellenaDatos()
        
        function dependencias2() { // se construye la sentencia de busqueda de la tupla
        
        $dependencias2 = null;//inicializamos la variable a null

		$sql = "SELECT NombreTrabajo, QA.LoginEvaluador, LoginEvaluado, AliasEvaluado FROM ASIGNAC_QA QA, ENTREGA E, TRABAJO T WHERE QA.LoginEvaluado = '$this->login' AND QA.LoginEvaluado = E.login AND QA.IdTrabajo = T.IdTrabajo";//se construye la sentencia sql
        $resultado = $this->mysqli->query( $sql );//se ejecuta la query
        if ( $resultado->num_rows >= 1 ) {//miramos si el número de tuplas es mayor o igual que uno
            $dependencias2 = $resultado;//le pasamos a la variable dependencias2 todas las tablas de las que depende
        }
        
        return $dependencias2;
	} // fin del metodo RellenaDatos()
        
        
        // funcion EDIT()
	   // Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
	  // si existe se modifica
	function EDIT() {
		// se construye la sentencia de busqueda de la tupla en la bd
		$sql = "SELECT * FROM ENTREGA WHERE (login = '$this->login' AND IdTrabajo = '$this->IdTrabajo')";
        
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
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
				)";//se construye la sentencia sql de modificacion

            }
            else{
                $sql = "UPDATE ENTREGA SET 
					login = '$this->login',
					 IdTrabajo='$this->IdTrabajo',
                     Alias='$this->Alias',
                     Horas='$this->Horas'
				WHERE ( login = '$this->login' AND IdTrabajo = '$this->IdTrabajo'
				)";//se construye la sentencia sql de modificacion
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