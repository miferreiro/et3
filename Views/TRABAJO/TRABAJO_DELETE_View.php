<?php
/*  Archivo php
	Nombre: TRABAJO_DELETE_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de una acción y da la opción de borrarlos
*/
class TRABAJO_DELETE {

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
						<?php echo $strings['IdTrabajo'];?>
					</th>
					<td>
						<?php echo $this->valores['IdTrabajo']?>
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['NombreTrabajo'];?>
					</th>
					<td>
						<?php echo $this->valores['NombreTrabajo']?>
					</td>
				</tr>
				
				<tr>
					<th>
						<?php echo $strings['FechaIniTrabajo'];?>
					</th>
					<td>
						<?php echo $this->valores['FechaIniTrabajo']?>
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['FechaFinTrabajo'];?>
					</th>
					<td>
						<?php echo $this->valores['FechaFinTrabajo']?>
					</td>
				</tr>
                
                
                   <tr>
					<th>
						<?php echo $strings['PorcentajeNota'];?>
					</th>
					<td>
						<?php echo $this->valores['PorcentajeNota']?>
					</td>
				</tr>
				
			</table>
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/TRABAJO_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="IdTrabajo" value="<?php echo $this->valores['IdTrabajo'] ?>" />
				<input type="hidden" name="NombreTrabajo" value="<?php echo $this->valores['NombreTrabajo'] ?>" />
				<input type="hidden" name="FechaIniTrabajo" value="<?php echo $this->valores['FechaIniTrabajo'] ?>" />
				<input type="hidden" name="FechaFinTrabajo" value="<?php echo $this->valores['FechaFinTrabajo'] ?>" />
                <input type="hidden" name="PorcentajeNota" value="<?php echo $this->valores['PorcentajeNota'] ?>" />
				<!--<input id="DELETE" name="action" value="DELETE" type="image" src="../Views/icon/confirmar.png" width="32" height="32" alt="<?php //echo $strings['Confirmar'] ?>">-->
                <button type="submit" id="DELETE" name="action" value="DELETE" ><img src="../Views/icon/confirmar.png" width="32" height="32" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/TRABAJO_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
	}
}

?>