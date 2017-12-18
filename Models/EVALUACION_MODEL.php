<?php

/*
 Función: modelo de datos definida en una clase que permite interactuar con la base de datos
 Fecha de creación:23/11/2017 Autor:Brais Rodríguez
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
    

	function DevolverCommentAlumno($log,$al,$id,$trabajo){
        
    
    $sql = "SELECT CorrectoA,ComenIncorrectoA 
    		FROM EVALUACION
    		WHERE LoginEvaluador = '$log' &&
    			  AliasEvaluado = '$al' && 
    			  IdHistoria = '$id' && 
    			  IdTrabajo = '$trabajo'";
          
    $resultado = $this->mysqli->query( $sql );
		if ( $resultado->num_rows == 0 ) { return null; }
		//Caragamos las tuplas resultado de la consulta en un array
		while($datos = mysqli_fetch_row ($resultado)){
			//Variable que almacena el array de las tuplas resultado de la query
			$miarray[] = $datos;
		}
		return $miarray;	
        
    }

	function EvaluacionesQa($alias){
        
    
    $sql = "SELECT E.IdHistoria,CorrectoA,ComenIncorrectoA,CorrectoP,ComentIncorrectoP,OK,TextoHistoria,LoginEvaluador,AliasEvaluado,E.IdTrabajo,CorrectoA,ComenIncorrectoA
			FROM EVALUACION E,HISTORIA H
			WHERE AliasEvaluado = '$alias' &&
				  E.IdHistoria = H.IdHistoria &&
				  SUBSTRING(E.IdTrabajo,3) = SUBSTRING(H.IdTrabajo,3)
			ORDER BY E.IdHistoria";
          
    $resultado = $this->mysqli->query( $sql );
		if ( $resultado->num_rows == 0 ) { return null; }
		//Caragamos las tuplas resultado de la consulta en un array
		while($datos = mysqli_fetch_row ($resultado)){
			//Variable que almacena el array de las tuplas resultado de la query
			$miarray[] = $datos;
		}
		return $miarray;	
        
    }
    
     //Esta función nos devuelve el IdTrabajo y login donde el IdTrabajo sea una QA
    function cogerDatosQA($trabajo){
         $sql = "SELECT IdTrabajo,LoginEvaluador FROM EVALUACION WHERE IdTrabajo LIKE '%qa%' AND IdTrabajo='$trabajo'";
            if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {//ejecutamos la query
			         return 'Error en la consulta sobre la base de datos';
		  } else { // si existe se devuelve la tupla resultado
           
            return $resultado;
		}
    }

 /*****************************************************************************************************/
    //PARA CORRECCION DE QAS Y ENTREGAS
     
function mostrarEntregas($nombre){
        
    
    $sql = "SELECT DISTINCT login,E.IdTrabajo,ET.IdTrabajo AS Entrega FROM ENTREGA ET,EVALUACION E WHERE  ET.Alias=E.AliasEvaluado AND login='$nombre'";
          
    if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si existe se devuelve la tupla resultado
            
           
			return $resultado;
		}
        
    }
    
   function mostrarQAS($nombre){
        
    
    $sql = "SELECT  DISTINCT LoginEvaluador,IdTrabajo FROM EVALUACION  WHERE LoginEvaluador='$nombre'";
          
    if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si existe se devuelve la tupla resultado
            
           
			return $resultado;
		}
        
    }
    
    
    function mostrarCorrecion($IdTrabajo,$nombre){
        
        
       
        $sql = "SELECT DISTINCT LoginEvaluador,ET.login,E.IdTrabajo FROM EVALUACION E,ENTREGA ET WHERE 
        ( Alias = AliasEvaluado && login='$nombre' && E.IdTrabajo='$IdTrabajo')";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		
    if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si existe se devuelve la tupla resultado
            
         
			return $resultado;
		}
    }

  function mostrarCorrecion1($IdTrabajo,$nombre){
        
        
       
        $sql ="SELECT DISTINCT E.IdTrabajo,LoginEvaluador,IdHistoria,CorrectoP,ComentIncorrectoP FROM EVALUACION E,ENTREGA ET WHERE 
        ( E.IdTrabajo = '$IdTrabajo' && Alias = AliasEvaluado && login='$nombre') GROUP BY IdHistoria";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		
    if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si existe se devuelve la tupla resultado
      
           
            
			return $resultado;
		}
    }
    

  
        function mostrarCorrecion2($IdTrabajo,$nombre){
        $sql = "SELECT DISTINCT LoginEvaluador,AliasEvaluado,IdTrabajo FROM EVALUACION  WHERE 
        ( IdTrabajo = '$IdTrabajo' && LoginEvaluador='$nombre')";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si existe se devuelve la tupla resultado
            
            
			return $resultado;
		}
}
    
 function mostrarCorrecion3($IdTrabajo,$nombre,$alias){
        
        
       
       $sql = "SELECT DISTINCT LoginEvaluador,AliasEvaluado,IdTrabajo,IdHistoria,CorrectoP,ComentIncorrectoP,CorrectoA,ComenIncorrectoA,OK FROM EVALUACION   WHERE 
        (IdTrabajo = '$IdTrabajo' && AliasEvaluado='$alias' && LoginEvaluador='$nombre')";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si existe se devuelve la tupla resultado
            
            
			return $resultado;
		}
}
    
    
/**************************************************************************************************************************/    
    
 
    

	//funcion SEARCH: hace una búsqueda en la tabla con 
	//los datos proporcionados. Si van vacios devuelve todos
	function SEARCH() {
		// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
		$sql = "select  E.IdTrabajo,
					T.NombreTrabajo,
                    LoginEvaluador,
                    AliasEvaluado,
					E.IdHistoria,
					CorrectoA,
					ComenIncorrectoA,
                    CorrectoP,
                    ComentIncorrectoP,
					OK,
					TextoHistoria
       			from EVALUACION E,HISTORIA H,TRABAJO T
    			where 
    				(
    				H.IdHistoria = E.IdHistoria &&
					E.IdTrabajo = T.IdTrabajo &&
    				SUBSTRING(E.IdTrabajo,3) = SUBSTRING(H.IdTrabajo,3) &&
					(BINARY E.IdTrabajo LIKE '%$this->IdTrabajo%') &&
					(BINARY LoginEvaluador LIKE '%$this->LoginEvaluador%') &&
                    (BINARY AliasEvaluado LIKE '%$this->AliasEvaluado%') &&
    				(BINARY E.IdHistoria LIKE '%$this->IdHistoria%') &&
					(BINARY CorrectoA LIKE '%$this->CorrectoA%') &&
	 				(BINARY ComenIncorrectoA LIKE '%$this->ComenIncorrectoA%') &&
                    (BINARY CorrectoP LIKE '%$this->CorrectoP%') &&
                    (BINARY ComentIncorrectoP LIKE '%$this->ComentIncorrectoP%') &&
	 				(BINARY OK LIKE '%$this->OK%')
    				)
    			ORDER BY AliasEvaluado,E.IdHistoria	";
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
                          
                        return 'no puedes insertar un id de trabajo, debes insertar previamente un trabajo.';
                    }
            }
            
              $al="SELECT * FROM ENTREGA WHERE (Alias = '$this->AliasEvaluado')";
            
                   $result=$this->mysqli->query($al);
                if(!$result){
                    return "No se ha podido conectar a la base de datos";
                }
                else{
                    if($result->num_rows == 0){
                        return "No puedes insertar una evaluacion debido a que este alias no existe";
                    }
                }   


			// construimos el sql para buscar esa clave en la tabla
			$sql = "SELECT * FROM EVALUACION WHERE (  IdTrabajo = '$this->IdTrabajo' && LoginEvaluador = '$this->LoginEvaluador' && AliasEvaluado = '$this->AliasEvaluado' && IdHistoria = '$this->IdHistoria')";

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
                    
                   include_once '../Models/NOTAS_MODEL.php';//incluimos el modelo USU_GRUPO
							$NOTA = new NOTAS_MODEL($this->IdTrabajo,$this->LoginEvaluador,'');//instanciamos un objeto del modelo USU_GRUPO donde metemos un  usuario en el grupo alumnos
							$mensaje = $NOTA->ADD();//insertamos el login en el grupo alumnos
                    
                }
                    else{
                        return 'Ya existe la acción introducida en la base de datos'; // ya existe
                    }
					}
					if ( !$this->mysqli->query( $sql ) ) { // si da error en la ejecución del insert devolvemos mensaje
						return 'Error en la inserción';
					} 
                   
            
                    else { //si no da error en la insercion devolvemos mensaje de exito
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
		$sql = "SELECT * FROM EVALUACION WHERE (IdTrabajo = '$this->IdTrabajo' && LoginEvaluador = '$this->LoginEvaluador' && AliasEvaluado = '$this->AliasEvaluado' && IdHistoria = '$this->IdHistoria')";
		// se ejecuta la query
		$result = $this->mysqli->query( $sql );
		// si existe una tupla con ese valor de clave

		if ( $result->num_rows == 1 ) {
			// se construye la sentencia sql de borrado
			$sql = "DELETE FROM EVALUACION WHERE (IdTrabajo = '$this->IdTrabajo' && LoginEvaluador = '$this->LoginEvaluador' && AliasEvaluado = '$this->AliasEvaluado' && IdHistoria = '$this->IdHistoria')";
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

		$sql = "SELECT * FROM EVALUACION WHERE (IdTrabajo = '$this->IdTrabajo' && LoginEvaluador = '$this->LoginEvaluador' && AliasEvaluado = '$this->AliasEvaluado' && IdHistoria = '$this->IdHistoria')";
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
		$sql = "SELECT * FROM EVALUACION WHERE (IdTrabajo = '$this->IdTrabajo' && LoginEvaluador = '$this->LoginEvaluador' && AliasEvaluado = '$this->AliasEvaluado' && IdHistoria = '$this->IdHistoria')";
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
                    ComentIncorrectoP ='$this->ComentIncorrectoP',
					OK = '$this->OK'
				WHERE ( IdTrabajo = '$this->IdTrabajo' && LoginEvaluador = '$this->LoginEvaluador' && AliasEvaluado = '$this->AliasEvaluado' && 
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

	function EDITAR_EVALUACION_ADMIN() {
		// se construye la sentencia de busqueda de la tupla en la bd
		$sql = "SELECT * FROM EVALUACION WHERE (IdTrabajo = '$this->IdTrabajo' && LoginEvaluador = '$this->LoginEvaluador' && AliasEvaluado = '$this->AliasEvaluado' && IdHistoria = '$this->IdHistoria')";
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
                    CorrectoP = '$this->CorrectoP',
                    ComentIncorrectoP ='$this->ComentIncorrectoP',
					OK = '$this->OK'
				WHERE ( IdTrabajo = '$this->IdTrabajo' && LoginEvaluador = '$this->LoginEvaluador' && AliasEvaluado = '$this->AliasEvaluado' && 
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

	function DevolverEntregas(){
		$sql = "SELECT DISTINCT login,Alias,E.IdTrabajo,Ruta,Horas,T.NombreTrabajo
				FROM ENTREGA EN,EVALUACION E,TRABAJO T
				WHERE Alias = AliasEvaluado && SUBSTRING(E.IdTrabajo,3) = SUBSTRING(EN.IdTrabajo,3)
				&& E.IdTrabajo=T.IdTrabajo
				ORDER BY E.Idtrabajo,AliasEvaluado,E.IdHistoria";
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
	}



	function entregasUsu($nombre){
        
        $sql = "SELECT DISTINCT login,Alias,E.IdTrabajo,Ruta,Horas,T.NombreTrabajo
				FROM ENTREGA EN,EVALUACION E,TRABAJO T
				WHERE Alias = AliasEvaluado &&
					  LoginEvaluador = '$nombre' &&
					  E.IdTrabajo=T.IdTrabajo  
				ORDER BY AliasEvaluado,E.IdHistoria";
        if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'Error en la consulta sobre la base de datos';
		} else { // si la busqueda es correcta devolvemos el recordset resultado

			return $resultado;
		}
        
    }

} //fin de clase

?>