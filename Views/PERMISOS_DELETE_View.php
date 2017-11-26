<?php
/*  Archivo php
	Nombre: PERMISOS_DELETE_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de una acción y da la opción de borrarlos
*/
class PERMISOS_DELETE {

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
						<?php echo $strings['ID Grupo'];?>
					</th>
					<td>
						<?php echo $this->valores['idGrupo']?>
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['ID Funcionalidad'];?>
					</th>
					<td>
						<?php echo $this->valores['idFuncionalidad']?>
					</td>
				</tr>
				
				<tr>
					<th>
						<?php echo $strings['ID Accion'];?>
					</th>
					<td>
						<?php echo $this->valores['idAccion']?>
					</td>
				</tr>
				
			</table>
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/PERMISOS_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="idGrupo" value=<?php echo $this->valores['idGrupo'] ?> />
				<input type="hidden" name="idFuncionalidad" value=<?php echo $this->valores['idFuncionalidad'] ?> />
				<input type="hidden" name="idAccion" value=<?php echo $this->valores['idAccion'] ?> />
				<input id="DELETE" name="action" value="DELETE" type="image" src="../Views/icon/confirmar.png" width="32" height="32" alt="<?php echo $strings['Confirmar'] ?>">
			</form>
			<form action='../Controllers/PERMISOS_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
	}
}

?>