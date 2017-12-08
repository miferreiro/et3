<?php
/*  Archivo php
	Nombre: PERMISO_DELETE_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los valores de un grupo y da la opción de borrarlos
*/
class PERMISO_DELETE {

	function __construct( $valores , $lista ) {
		$this->valores = $valores;
		$this->render( $this->valores, $lista );
	}

	function render( $valores, $lista ) {
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
						<?php echo $strings['NombreGrupo'];?>
					</th>
					<td>
						<?php echo $this->valores['NombreGrupo']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['NombreFuncionalidad'];?>
					</th>
					<td>
						<?php echo $this->valores['NombreFuncionalidad']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['NombreAccion'];?>
					</th>
					<td>
						<?php echo $this->valores['NombreAccion']?>
					</td>
				</tr>
	
			</table>
   
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar este grupo de la tabla, así como sus permisos y desasignar sus usuarios?'];?>
			</p>
			<form action="../Controllers/PERMISO_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="IdGrupo" value=<?php echo $valores['IdGrupo'] ?> />
				<input type="hidden" name="IdFuncionalidad" value=<?php echo $valores['IdFuncionalidad'] ?> />
				<input type="hidden" name="IdAccion" value=<?php echo $valores['IdAccion'] ?> />
				
				<button type="submit" name="action" value="DELETE" width="32" height="32"><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
			<form action='../Controllers/PERMISO_CONTROLLER.php' method="post" style="display: inline">
				<input type="hidden" name="IdGrupo" value=<?php echo $valores['IdGrupo'] ?> />
				<input type="hidden" name="action" value="ASSIGN">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
            
		include '../Views/Footer.php';
         }   
	}

?>