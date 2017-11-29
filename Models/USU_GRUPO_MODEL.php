<!--Modelo que contiene un constructor de usuarios de grupo y las funciones de la base de datos como insertar, buscar, etc-->
<!--Fecha: 23-11-2017 Autor: fwnbmw Dedicados: 20 minutos-->

<?php
 include '../Functions/BdAdmin.php';

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
        
        $usuario="SELECT * FROM USUARIO WHERE (login = '$this->login')";
        
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
    $sql = "select login,
                    IdGrupo
       			from USU_GRUPO
    			where 
    				(
    				(login LIKE '%$this->login%') &&
                    (IdGrupo LIKE '%$this->IdGrupo%')
    				)";
    // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
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
    $sql = "SELECT * FROM USU_GRUPO WHERE (login = '$this->login' && IdGrupo = '$this->IdGrupo')";
    // se ejecuta la query
    $result = $this->mysqli->query($sql);
    // si el numero de filas es igual a uno es que lo encuentra
    if ($result->num_rows == 1)
    {	// se construye la sentencia de modificacion en base a los atributos de la clase
		$sql = "UPDATE USU_GRUPO SET 
                    login = '$this->login',
                    IdGrupo = '$this->IdGrupo'
				WHERE ( login = '$this->login' && IdGrupo = '$this->IdGrupo'
				)";
		// si hay un problema con la query se envia un mensaje de error en la modificacion
        if (!($resultado = $this->mysqli->query($sql))){
			return 'Error en la modificación, login ya en uso'; 
		}
		else{ // si no hay problemas con la modificación se indica que se ha modificado
			return 'Modificado correctamente';
		}
    }
    else // si no se encuentra la tupla se manda el mensaje de que no existe la tupla
    	return 'No existe en la base de datos';
} // fin del metodo EDIT

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
    $sql = "SELECT * FROM USU_GRUPO WHERE (login = '$this->login' && IdGrupo = '$this->IdGrupo')";
    // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
    if (!($resultado = $this->mysqli->query($sql))){
		return 'No existe en la base de datos'; // 
	}
    else{ // si existe se devuelve la tupla resultado
		$result = $resultado->fetch_array();
		return $result;
	}
} // fin del metodo RellenaDatos()
        
    }
?>