<?php
/*
	Archivo php
	Nombre: Login_Controller.php
	Autor: zwos20
	Fecha 	fta875de creación: 23/10/2017 
	Función: controlador que realiza las operaciones necesarias para realizar un logeo correcto de un usuario
*/
session_start();
if(!isset($_REQUEST['login']) && !(isset($_REQUEST['password']))){
	//Incluye la vista login
	include '../Views/Login_View.php';
	//Variable que almacena un objecto de login
	$login = new Login();
}
else{
	//Incluye la función para conectarse a la base de datos
	include '../Functions/BdAdmin.php';

	//Incluye el acceso al modelo de datos
	include '../Models/USUARIO_MODEL.php';
	$usuario = new USUARIO_MODEL($_REQUEST['login'],$_REQUEST['password'], '', '', '', '', '', '','');
	$respuesta = $usuario->login();

	//Si existe el usuario se devuelve true y le asignamos a la variable de sesion el valor del login
	if ($respuesta == 'true'){
		session_start();
		$_SESSION['login'] = $_REQUEST['login'];
		header('Location:../Controllers/USUARIO_CONTROLLER.php');
	}
	//Si no esta en la base de datos, se muestra la respuesta en la vista mensaje
	else{
		//Incluye la vista de mensaje
		include '../Views/MESSAGE_View.php';
		//Vista de mensaje con la respuesta y ruta de vuelta atras
		new MESSAGE($respuesta, '../Controllers/Login_Controller.php');
	}

}

?>

