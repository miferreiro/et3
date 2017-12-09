<!--Modelo que contiene un constructor de usuarios de grupo y las funciones de la base de datos como insertar, buscar, etc-->
<!--Fecha: 23-11-2017 Autor: fwnbmw Dedicados: 20 minutos-->

<?php
 include_once '../Functions/BdAdmin.php';

    class USU_GRUPO{
        var $login;
        var $IdGrupo;
        
        var $mysqli;
        public function __construct($login, $IdGrupo){
            $this->login = $login;
            $this->IdGrupo = $IdGrupo;
           
            
            $this->mysqli=ConectarBD();
        }
   
    //Metodo ADD()
//Inserta en la tabla  de la bd  los valores
// de los atributos del objeto. Comprueba si la clave/s esta vacia y si 
//existe ya en la tabla
function ADD()
{
    if (($this->login <> '' && $this->IdGrupo <> '')){ // si el atributo clave de la entidad no esta vacío'
        
      /*  $usuario="SELECT * FROM USUARIO WHERE (login = '$this->login')";
        
        $result=$this->mysqli->query($usuario);
        
        if(!$result){
            return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
        }
        else{
            
            if($result->num_rows == 0){
                return "No puedes insertar este usuario debido a que no existe, debes insertar previamente un usuario";
            }
        }
        
        $grupo = "SELECT * FROM GRUPO WHERE (IdGrupo = '$this->IdGrupo')";
        
        $result = $this->mysqli->query($grupo);
        
        if(!$result){
             return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara 
        }
        
        else{
                if($result->num_rows == 0){
                    
                    return "No puedes insertar este grupo debido a que no existe, debes insertar previamente un grupo";
                }    
        
        }
        */
		
		// construimos el sql para buscar esa clave en la tabla
        $sql = "SELECT * FROM USU_GRUPO WHERE (login = '$this->login' && IdGrupo = '$this->IdGrupo')";

		if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
			return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
		}
		else { // si la ejecución de la query no da error
			if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio (no existe el login)
				//construimos la sentencia sql de inserción en la bd
				$sql = "INSERT INTO USU_GRUPO (
                    login,
                    IdGrupo
					) 
						VALUES (
                    '$this->login',
                    '$this->IdGrupo')";
				
				if (!$this->mysqli->query($sql)) { // si da error en la ejecución del insert devolvemos mensaje
					return 'Error en la inserción, login ya en uso';
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
    $sql = "select U.login,
                    U.IdGrupo,G.NombreGrupo
       			from USU_GRUPO U, GRUPO G
    			where 
    				(
    				U.login LIKE '$this->login' && G.IdGrupo LIKE U.IdGrupo
    				)";
    // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
    if (!($resultado = $this->mysqli->query($sql))){
		return 'Error en la consulta sobre la base de datos, revise los campos introducidos';
	}
    else{ // si la busqueda es correcta devolvemos el recordset resultado
		return $resultado;
	}
} // fin metodo SEARCH

    // funcion DELETE()
// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
// se manda un mensaje de que ese valor de clave no existe
function DELETE()
{	// se construye la sentencia sql de busqueda con los atributos de la clase
    $sql = "SELECT login,IdGrupo FROM USU_GRUPO WHERE (login = '$this->login' && IdGrupo = '$this->IdGrupo')";
    // se ejecuta la query
    $result = $this->mysqli->query($sql);
    // si existe una tupla con ese valor de clave
    if ($result->num_rows == 1)
    {
    	// se construye la sentencia sql de borrado
        $sql = "DELETE FROM USU_GRUPO WHERE (login = '$this->login' && IdGrupo = '$this->IdGrupo')";
        // se ejecuta la query
        $this->mysqli->query($sql);
        // se devuelve el mensaje de borrado correcto
    	return "Borrado correctamente";
    } // si no existe el login a borrar se devuelve el mensaje de que no existe
    else
        return "No existe";
} // fin metodo DELETE
    
// funcion RellenaDatos()
// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
// en el atributo de la clase
function RellenaDatos($login, $IdGrupo)
{	// se construye la sentencia de busqueda de la tupla
    $sql = "SELECT U.login,U.IdGrupo,G.NombreGrupo FROM USU_GRUPO U,GRUPO G WHERE (U.login = '$this->login' && U.IdGrupo = '$this->IdGrupo' && U.IdGrupo LIKE G.IdGrupo)";
    // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
    if (!($resultado = $this->mysqli->query($sql))){
		return 'No existe en la base de datos'; // 
	}
    else{ // si existe se devuelve la tupla resultado
		$result = $resultado->fetch_array();
		return $result;
	}
} // fin del metodo RellenaDatos()
    
		
   function comprobarPermisos(){
	   $sql = "SELECT DISTINCT P.IdGrupo, P.IdFuncionalidad, P.IdAccion FROM PERMISO P, USU_GRUPO U WHERE U.login = '$this->login' && (U.IdGrupo = P.IdGrupo || P.IdGrupo ='0000A')";
	   $resultado = $this->mysqli->query( $sql );//hacemos la consulta en la base de datos
       return $resultado;

   }
   function comprobarAdmin(){
		
		$sql = "SELECT * FROM USU_GRUPO WHERE login = '$this->login' && IdGrupo = '00000A'";
		
		$resultado = $this->mysqli->query($sql); //hacemos la consulta en la base de datos
		
		if($resultado->num_rows == 0){//miramos si el numero de filas es 0
			return false;
		}else{
			return true;
		}
	
   }
		
	function RellenaShowCurrent() { // se construye la sentencia de busqueda de la tupla

		$sql = "SELECT NombreGrupo,IdGrupo FROM GRUPO WHERE ( IdGrupo NOT IN (SELECT IdGrupo FROM USU_GRUPO WHERE login='$this->login'))";
		// Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		if ( !( $resultado = $this->mysqli->query( $sql ) ) ) {
			return 'No existe en la base de datos'; // 
		} else { // si existe se devuelve la tupla resultado
			return $resultado;
		}
	} // fin del metodo RellenaShowCurrent()
    }
?>