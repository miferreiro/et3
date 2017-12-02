<?php
/* 
	Fecha de creación: 2/12/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los valores de una historia y da la opción de borrarlos
*/
class HISTORIA_DELETE {

	function __construct( $valores) {
		$this->valores = $valores;
		
		$this->render( $this->valores);
	}

	function render( $valores) {
		$this->valores = $valores;
		
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de borrado'];?>
			</h2>
					
			<table>
				<tr>
					<th>
						<?php echo $strings['IdTrabajo'];?>
					</th>
					<td>
						<?php echo $this->valores['IdTrabajo']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['IdHistoria'];?>
					</th>
					<td>
						<?php echo $this->valores['IdHistoria']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['TextoHistoria'];?>
					</th>
					<td>
						<?php echo $this->valores['TextoHistoria']?>
					</td>
				</tr>
	
			</table>
			<br>
			<br>


			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/HISTORIA_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="IdTrabajo" value="<?php echo $valores['IdTrabajo'] ?>" />
				<input type="hidden" name="IdHistoria" value="<?php echo $valores['IdHistoria'] ?>" />
				<input type="hidden" name="TextoHistoria" value="<?php echo $valores['TextoHistoria'] ?>" />
				<input id="DELETE" name="action" value="DELETE" type="image" src="../Views/icon/confirmar.png" width="32" height="32" alt="<?php echo $strings['Confirmar'] ?>">
			</form>
			<form action='../Controllers/HISTORIA_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
            
		include '../Views/Footer.php';
            
	}
}

?>