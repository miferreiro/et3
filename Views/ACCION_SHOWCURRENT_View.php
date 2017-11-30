<?php
/*  Archivo php
	Nombre: ACCION_SHOWCURRENT_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de vista en detalle(showcurrent) realizada con una clase donde se muestran todos los datos de una acción
*/
class ACCION_SHOWCURRENT {

	function __construct( $lista ) {
		$this->lista = $lista;
		$this->render( $this->lista );
	}

	function render( $lista ) {
		$this->lista = $lista;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<h2>
			<?php echo $strings['Vista detallada'];?>
		</h2>
		<table class="tablaDatos">
			<tr>
				<th>
					<?php echo $strings['IdAccion'];?>
				</th>
				<td>
					<?php echo $this->lista['IdAccion'] ?>
				</td>
			</tr>
	
			<tr>
				<th>
					<?php echo $strings['NombreAccion'];?>
				</th>
				<td>
					<?php echo $this->lista['NombreAccion'] ?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['DescripAccion'];?>
				</th>
				<td>
					<?php echo $this->lista['DescripAccion'] ?>
				</td>
			</tr>
			
			<caption style="margin-top:10px;" align="bottom">
				<form action='../Controllers/ACCION_CONTROLLER.php' method="post">
					<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			</caption>
		</table>

<?php
		include '../Views/Footer.php';
	}
}
?>