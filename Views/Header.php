<?php
/*
	Archivo php
	Nombre: Header.php
	Autor: 	fta875
	Fecha de creación: 23/10/2017 
	Función: contiene todas las características del header
*/
	include_once '../Functions/Authentication.php';
    include_once '../Functions/AuthenticationAdmin.php';
	if (!isset($_SESSION['idioma'])) {
		$_SESSION['idioma'] = 'SPANISH';

	}
	include '../Locales/Strings_' . $_SESSION['idioma'] . '.php';
?>
<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<script type="text/javascript" src="../Views/js/md5.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="../Views/css/estilos.css" hreflang="es">
	<link rel="stylesheet" type="text/css" media="screen" href="../Views/tcal/tcal.css" hreflang="es">
	<script language="JavaScript" type="text/javascript" src="../Views/tcal/tcal.js"></script>
	<?php include '../Views/js/validaciones.js' ?>
	<title>ET3</title>
</head>
<body>
 <header>
	<p style="text-align:center">
		<h1>
<?php
			echo $strings['Portal de Gestión'];
?>
		</h1>
	</p>
<?php	
	if (IsAuthenticated()){
?>
		<p style="font-size:20px; ">
<?php
			echo $strings['Usuario'] . ' : ' . $_SESSION['login'] . '<br>';
		    echo $GESTUSU;
?>	
			<a href="../Functions/Desconectar.php" style="text-decoration:none"> <img src="../Views/icon/desconexion.png" width="32" height="32" alt="<?php echo $strings['Desconectarse']?>" style="float:right;"></a>
	
		</p>
<?php
	} else {
		
			echo $strings['Usuario no identificado'];
?> 
		<a href = '../Controllers/Registro_Controller.php' ><img src="../Views/icon/registrarse.png" alt="<?php echo $strings['Registrar']?>" /></a>
<?php		
	}
?>
		
	<form name='idiomform' action="../Functions/CambioIdioma.php" method="post">
		<?php echo $strings['idioma']; ?>
		<button type="submit"  name="idioma" value="SPANISH" ><img src="../Views/icon/banderaEspaña.jpg" alt="<?php echo $strings['Cambiar idioma a español']?>" width="32" height="20" style="display: block;"/></button>
		<button type="submit"  name="idioma" value="ENGLISH" ><img src="../Views/icon/banderaReinoUnido.png" alt="<?php echo $strings['Cambiar idioma a inglés']?>" width="32" height="20" style="display: block;"/></button>
		<button type="submit"  name="idioma" value="GALLEGO" ><img src="../Views/icon/banderaGalicia.png" alt="<?php echo $strings['Cambiar idioma a gallego']?>" width="32" height="20" style="display: block;"/></button>
	</form>	
</header>
<div id = 'main'>   
<?php
if (IsAuthenticated()){
		include '../Views/admin_menuLateral.php';

}
?>  
<article>

     