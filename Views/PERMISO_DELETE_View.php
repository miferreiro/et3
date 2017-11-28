<?php
/*  Archivo php
	Nombre: PERMISOS_DELETE_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de una acción y da la opción de borrarlos
*/
class PERMISO_DELETE {

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
						<?php echo $strings['IdGrupo'];?>
					</th>
					<td>
						<?php echo $this->valores['IdGrupo']?>
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['IdFuncionalidad'];?>
					</th>
					<td>
						<?php echo $this->valores['IdFuncionalidad']?>
					</td>
				</tr>
				
				<tr>
					<th>
						<?php echo $strings['IdAccion'];?>
					</th>
					<td>
						<?php echo $this->valores['IdAccion']?>
					</td>
				</tr>
				
			</table>
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/PERMISO_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="IdGrupo" value=<?php echo $this->valores['IdGrupo'] ?> />
				<input type="hidden" name="IdFuncionalidad" value=<?php echo $this->valores['IdFuncionalidad'] ?> />
				<input type="hidden" name="IdAccion" value=<?php echo $this->valores['IdAccion'] ?> />
				<input id="DELETE" name="action" value="DELETE" type="image" src="../Views/icon/confirmar.png" width="32" height="32" alt="<?php echo $strings['Confirmar'] ?>">
			</form>
			<form action='../Controllers/PERMISO_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
	}
}

?>