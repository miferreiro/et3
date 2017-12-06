<!--Modelo que contiene un constructor permisos y las funciones de la base de datos como insertar, buscar, etc-->
<!--Fecha: 24-11-2017 Autor: fwnbmw Dedicados: 25 minutos-->

<?php
    class PERMISO_MODEL{
        var $IdFuncionalidad;
        var $IdAccion;
        var $IdGrupo;
        
        var $NombreGrupo;
        var $NombreFuncionalidad;
        var $NombreAccion;

        var $mysqli;
        function __construct($IdGrupo, $IdFuncionalidad, $IdAccion, $NombreGrupo, $NombreFuncionalidad, $NombreAccion){
            $this->IdFuncionalidad = $IdFuncionalidad;
            $this->IdAccion = $IdAccion;
            $this->IdGrupo = $IdGrupo;
           
            $this->NombreGrupo = $NombreGrupo;
            $this->NombreFuncionalidad = $NombreFuncionalidad;
            $this->NombreAccion = $NombreAccion;
            
            include_once '../Functions/BdAdmin.php';  
            $this->mysqli=ConectarBD();
        }
   
    //Metodo ADD()
//Inserta en la tabla  de la bd  los valores
// de los atributos del objeto. Comprueba si la clave/s esta vacia y si 
//existe ya en la tabla


 //funcion SEARCH: hace una búsqueda en la tabla con
//los datos proporcionados. Si van vacios devuelve todos
function SEARCH()
{ 	// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
     $sql = "SELECT P.IdGrupo,G.NombreGrupo,P.IdFuncionalidad,F.NombreFuncionalidad,P.IdAccion,A.NombreAccion
                     FROM PERMISO P,GRUPO G,FUNCIONALIDAD F,FUNC_ACCION FA,ACCION A 
                     WHERE (
                            G.IdGrupo = P.IdGrupo &&
                            F.IdFuncionalidad = P.IdFuncionalidad &&
                            A.IdAccion = P.IdAccion &&
                            F.IdFuncionalidad = FA.IdFuncionalidad &&
                            A.IdAccion = FA.IdAccion &&
                            P.IdFuncionalidad LIKE '%$this->IdFuncionalidad%' &&
                            P.IdAccion LIKE '%$this->IdAccion%' &&
                            P.IdGrupo LIKE '%$this->IdGrupo%'
                           )";

    // si se produce un error en la busqueda m&&amos el mensaje de error en la consulta
    if (!($resultado = $this->mysqli->query($sql))){
		return 'Error en la consulta sobre la base de datos, revise los campos introducidos';
	}
    else{ // si la busqueda es correcta devolvemos el recordset resultado
		return $resultado;
	}
} // fin metodo SEARCH

function SEARCH2()
{   // construimos la sentencia de busqueda con LIKE y los atributos de la entidad
     $sql = "SELECT P.IdGrupo,G.NombreGrupo,P.IdFuncionalidad,F.NombreFuncionalidad,P.IdAccion,A.NombreAccion
                     FROM PERMISO P,GRUPO G,FUNCIONALIDAD F,FUNC_ACCION FA,ACCION A 
                     WHERE (
                            G.IdGrupo = P.IdGrupo &&
                            F.IdFuncionalidad = P.IdFuncionalidad &&
                            A.IdAccion = P.IdAccion &&
                            F.IdFuncionalidad = FA.IdFuncionalidad &&
                            A.IdAccion = FA.IdAccion &&
                            F.NombreFuncionalidad LIKE '%$this->NombreFuncionalidad%' &&
                            A.NombreAccion LIKE '%$this->NombreAccion%' &&
                            G.NombreGrupo LIKE '%$this->NombreGrupo%'
                           )";

    // si se produce un error en la busqueda m&&amos el mensaje de error en la consulta
    if (!($resultado = $this->mysqli->query($sql))){
        return 'Error en la consulta sobre la base de datos, revise los campos introducidos';
    }
    else{ // si la busqueda es correcta devolvemos el recordset resultado
        return $resultado;
    }
} // fin metodo SEARCH

// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
// se m&&a un mensaje de que ese valor de clave no existe
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