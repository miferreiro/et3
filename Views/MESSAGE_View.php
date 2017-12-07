<?php

/*  Archivo php
	Nombre: mensaje.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de un mensaje(message) realizada con una clase donde se muestra el mensaje deseado
*/
class MESSAGE { // declaración de la función

	function __construct( $text, $ruta ) {
		$this->text = $text;
		$this->ruta = $ruta;
		$this->render();
	}

	function render() {

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<br>
		<br>
		<br>
		<?php
			echo $strings[$this->text]; // se muestra por pantalla el texto
		?>
		<br>
		<br>
		<br>
		
		<form action='<?php echo $this->ruta?>' method="post">
			<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>"/></button>
		</form>


<?php
	include '../Views/Footer.php';
	}
}
?>