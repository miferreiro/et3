<?php
/*
	Archivo php
	Nombre: Register_Controller.php
	Autor: fta875
	Fecha de creación: 23/10/2017 
	Función: controlador que realiza las operaciones necesarias para realizar un registro correcto de un nuevo usuario
*/
session_start();
include_once '../Locales/Strings_'.$_SESSION['idioma'].'.php';

if(!isset($_POST['login'])){
	include '../Views/Register_View.php';
	$register = new Register();
}
else{
		
	include '../Models/USUARIO_MODEL.php';
	//Variable que almacena un objecto de usuarios model
	$usuario = new USUARIO_MODEL($_REQUEST['login'],$_REQUEST['password'],$_REQUEST['DNI'],$_REQUEST['Nombre'],$_REQUEST['Apellidos'],$_REQUEST['Correo'],$_REQUEST['Direccion'],$_REQUEST['Telefono']);
	//Almacena la respuesta de si esta existe el login o no para poder registrarse
	$respuesta = $usuario->Register();

	//Si no existe el login en la base de datos
	if ($respuesta == 'true'){
		$respuesta = $usuario->ADD();
		//Incluye la vista mensaje
		include '../Views/MESSAGE_View.php';
		new MESSAGE($respuesta, './Login_Controller.php');
	}
	//Si existe en la base de datos
	else{
		//Incluye la vista mensaje
		include '../Views/MESSAGE_View.php';
		new MESSAGE($respuesta, './Login_Controller.php');
	}

}

?>

