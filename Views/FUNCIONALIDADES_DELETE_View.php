<?php
/*  Archivo php
	Nombre: FUNCIONALIDADES_DELETE_View.php
	Fecha de creación: 26/11/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de una Funcionalidad y da la opción de borrarlos
*/
class FUNCIONALIDADES_DELETE {

	function __construct( $valores ) {
		$this->valores = $valores;
		$this->render( $this->valores );
	}

	function render( $valores ) {
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
						<?php echo $strings['ID Funcionalidad'];?>
					</th>
					<td>
						<?php echo $this->valores['idFunc']?>
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['Nombre Funcionalidad'];?>
					</th>
					<td>
						<?php echo $this->valores['nombreFunc']?>
					</td>
				</tr>
				
				<tr>
					<th>
						<?php echo $strings['Descripción Funcionalidad'];?>
					</th>
					<td>
						<?php echo $this->valores['descripFunc']?>
					</td>
				</tr>
				
			</table>
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/FUNCIONALIDADES_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="idFunc" value=<?php echo $this->valores['idFunc'] ?> />
				<input type="hidden" name="nombreFunc" value=<?php echo $this->valores['nombreFunc'] ?> />
				<input type="hidden" name="descripFunc" value=<?php echo $this->valores['descripFunc'] ?> />
				<input id="DELETE" name="action" value="DELETE" type="image" src="../Views/icon/confirmar.png" width="32" height="32" alt="<?php echo $strings['Confirmar'] ?>">
			</form>
			<form action='../Controllers/FUNCIONALIDADES_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
	}
}

?>