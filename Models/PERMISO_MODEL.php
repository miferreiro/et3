<!--Modelo que contiene un constructor permisos y las funciones de la base de datos como insertar, buscar, etc-->
<!--Fecha: 24-11-2017 Autor: fwnbmw Dedicados: 25 minutos-->

<?php
 include '../Functions/BdAdmin.php';

    class PERMISO_MODEL{
        var $IdFuncionalidad;
        var $IdAccion;
        var $IdGrupo;
        
        var $mysqli;
        public function __construct($IdGrupo, $IdFuncionalidad, $IdAccion){
            $this->IdFuncionalidad = $IdFuncionalidad;
            $this->IdAccion = $IdAccion;
            $this->IdGrupo = $IdGrupo;
           
            
            $this->mysqli=ConectarBD();
        }
   
    //Metodo ADD()
//Inserta en la tabla  de la bd  los valores
// de los atributos del objeto. Comprueba si la clave/s esta vacia y si 
//existe ya en la tabla
function ADD()
{
    if (($this->IdFuncionalidad <> '' && $this->IdAccion <> '' && $this->IdGrupo <> '')){ // si los atributos clave de la entidad no estan vacíos'
		
        $grupo = "SELECT * FROM GRUPO WHERE (IdGrupo = '$this->IdGrupo')";
        
        $result=$this->mysqli->query($grupo);
        
        if(!$result){
           return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
        }
        else{
            if($result->num_rows == 0){
                 return "No puedes insertar este grupo debido a que no existe, debes insertar previamente un grupo";
            }
            
        }
        
        $accion = "SELECT * FROM ACCION WHERE (IdAccion = '$this->IdAccion')";
        $result=$this->mysqli->query($accion);
        
          if(!$result){
           return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
        }
        
        else{
              if($result->num_rows == 0){
                 return "No puedes insertar este id de accion debido a que no existe, debes insertar previamente una accion";
            }
        }
        
        $funcionalidad = "SELECT * FROM FUNCIONALIDAD WHERE (IdFuncionalidad = '$this->IdFuncionalidad')";
        $result=$this->mysqli->query($funcionalidad);
        
          if(!$result){
           return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
        }
        else{
             if($result->num_rows == 0){
                 return "No puedes insertar este id de funcionalidad debido a que no existe, debes insertar previamente una funcionalidad";
            }
        }
        
        
        
        
		// construimos el sql para buscar esa clave en la tabla
        $sql = "SELECT * FROM PERMISO WHERE (IdFuncionalidad = '$this->IdFuncionalidad' && IdAccion = '$this->IdAccion' && IdGrupo = '$this->IdGrupo')";

		if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
			return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
		}
		else { // si la ejecución de la query no da error
			if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio (no existe el IdFuncionalidad)
				//construimos la sentencia sql de inserción en la bd
				$sql = "INSERT INTO PERMISO (
                    IdFuncionalidad,
                    IdAccion,
                    IdGrupo
					) 
						VALUES (
                    '$this->IdFuncionalidad',
                    '$this->IdAccion',
                    '$this->IdGrupo')";
				
				if (!$this->mysqli->query($sql)) { // si da error en la ejecución del insert devolvemos mensaje
					return 'Error en la inserción, IdFuncionalidad ya en uso';
				}
				else{ //si no da error en la insercion devolvemos mensaje de exito
					 return 'Inserción realizada con éxito'; //operacion de insertado correcta
				}
				
			}
			else // si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
				return 'Ya existe en la base de datos'; // ya existe
		}
    }
    else{ // si el atributo clave de la bd es vacio solicitamos un valor en un mensaje
            return 'Introduzca un valor'; // introduzca un valor para el usuario
	}
} // fin del metodo ADD

 //funcion SEARCH: hace una búsqueda en la tabla con
//los datos proporcionados. Si van vacios devuelve todos
function SEARCH()
{ 	// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
    $sql = "select IdFuncionalidad,
                    IdAccion,
                    IdGrupo
       			from PERMISO
    			where 
    				(
    				(IdFuncionalidad LIKE '%$this->IdFuncionalidad%') &&
                    (IdAccion LIKE '%$this->IdAccion%') &&
                    (IdGrupo LIKE '%$this->IdGrupo%')
    				)";
    // si se produce un error en la busqueda m&&amos el mensaje de error en la consulta
    if (!($resultado = $this->mysqli->query($sql))){
		return 'Error en la consulta sobre la base de datos, revise los campos introducidos';
	}
    else{ // si la busqueda es correcta devolvemos el recordset resultado
		return $resultado;
	}
} // fin metodo SEARCH

    // funcion EDIT()
// Se comprueba que la tupla a modificar exista en base al valor de su clave primaria
// si existe se modifica
function EDIT()
{
	// se construye la sentencia de busqueda de la tupla en la bd
    $sql = "SELECT * FROM PERMISO WHERE (IdFuncionalidad = '$this->IdFuncionalidad' && IdAccion = '$this->IdAccion' && IdGrupo = '$this->IdGrupo')";
    // se ejecuta la query
    $result = $this->mysqli->query($sql);
    // si el numero de filas es igual a uno es que lo encuentra
    if ($result->num_rows == 1)
    {	// se construye la sentencia de modificacion en base a los atributos de la clase
		$sql = "UPDATE PERMISO SET 
                    IdFuncionalidad = '$this->IdFuncionalidad',
                    IdAccion = '$this->IdAccion',
                    IdGrupo = '$this->IdGrupo'
				WHERE ( IdFuncionalidad = '$this->IdFuncionalidad' && IdAccion = '$this->IdAccion' && IdGrupo = '$this->IdGrupo')";
        
		// si hay un problema con la query se envia un mensaje de error en la modificacion
        if (!($resultado = $this->mysqli->query($sql))){
			return 'Error en la modificación, IdFuncionalidad ya en uso'; 
		}
		else{ // si no hay problemas con la modificación se indica que se ha modificado
			return 'Modificado correctamente';
		}
    }
    else // si no se encuentra la tupla se m&&a el mensaje de que no existe la tupla
    	return 'No existe en la base de datos';
} // fin del metodo EDIT

    // funcion DELETE()
// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
// se m&&a un mensaje de que ese valor de clave no existe
function DELETE()
{	// se construye la sentencia sql de busqueda con los atributos de la clase
    $sql = "SELECT * FROM PERMISO WHERE (IdFuncionalidad = '$this->IdFuncionalidad' && IdAccion = '$this->IdAccion' && IdGrupo = '$this->IdGrupo')";
    // se ejecuta la query
    $result = $this->mysqli->query($sql);
    // si existe una tupla con ese valor de clave
    if ($result->num_rows == 1)
    {
    	// se construye la sentencia sql de borrado
        $sql = "DELETE FROM PERMISO WHERE (IdFuncionalidad = '$this->IdFuncionalidad' && IdAccion = '$this->IdAccion' && IdGrupo = '$this->IdGrupo')";
        // se ejecuta la query
        $this->mysqli->query($sql);
        // se devuelve el mensaje de borrado correcto
    	return "Borrado correctamente";
    } // si no existe el IdFuncionalidad a borrar se devuelve el mensaje de que no existe
    else
        return "No existe";
} // fin metodo DELETE
    
// funcion RellenaDatos()
// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
// en el atributo de la clase
function RellenaDatos($IdGrupo, $IdFuncionalidad, $IdAccion)
{	// se construye la sentencia de busqueda de la tupla
    $sql = "SELECT * FROM PERMISO WHERE (IdFuncionalidad = '$this->IdFuncionalidad' && IdAccion = '$this->IdAccion' && IdGrupo = '$this->IdGrupo')";
    // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
    if (!($resultado = $this->mysqli->query($sql))){
		return 'No existe en la base de datos'; // 
	}
    else{ // si existe se devuelve la tupla resultado
		$result = $resultado->fetch_array();
		return $result;
	}
} // fin del metodo RellenaDatos()

//Recupera todas funcionalidades que hay en la base de datos
function recuperarFuncionalidades(){
    //Variable que almacena la query
    $sql = "SELECT F.IdFuncionalidad,NombreFuncionalidad,A.IdAccion,NombreAccion 
            FROM FUNCIONALIDAD F,ACCION A,FUNC_ACCION FA
            WHERE F.IdFuncionalidad = FA.IdFuncionalidad &&
                  A.IdAccion = FA.IdAccion";
    //Variable que almacena el resultado de la query
    $resultado = $this->mysqli->query( $sql );
    //Si no hay tuplas devuelve null
    if ( $resultado->num_rows == 0 ) { return null; }
    //Caragamos las tuplas resultado de la consulta en un array
    while($datos = mysqli_fetch_row ($resultado)){
    //Variable que almacena el array de las tuplas resultado de la query
        $miarray[] = $datos;
    }
    //retorna un array con las funcionalidades
    return $miarray;
}//Fin de recuperarFuncionalidades

//Recupera los datos de grupo
function recuperarGrupo($id){
    //Variable que almacena la query
    $sql = "SELECT GRUPO.IdGrupo,NombreGrupo 
            FROM GRUPO
            WHERE IdGrupo = '$id'";
    //Variable que almacena el resultado de la query
    $resultado = $this->mysqli->query( $sql );
    if ( $resultado->num_rows == 0 ) { return null; }
    //Caragamos las tuplas resultado de la consulta en un array
    while($datos = mysqli_fetch_row ($resultado)){
    //Variable que almacena el array de las tuplas resultado de la query
        $miarray[] = $datos;
    }
    //Devuelve el array con el grupo
    return $miarray;
}
    }
?>