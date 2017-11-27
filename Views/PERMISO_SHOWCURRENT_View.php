<?php
/*  Archivo php
	Nombre: PERMISOS_SHOWCURRENT_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de vista en detalle(showcurrent) realizada con una clase donde se muestran todos los datos de una acción
*/
class PERMISOS_SHOWCURRENT {

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
		<table>
				<tr>
					<th>
						<?php echo $strings['ID Grupo'];?>
					</th>
					<td>
						<?php echo $this->valores['IdGrupo']?>
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['ID Funcionalidad'];?>
					</th>
					<td>
						<?php echo $this->valores['IdFuncionalidad']?>
					</td>
				</tr>
				
				<tr>
					<th>
						<?php echo $strings['ID Accion'];?>
					</th>
					<td>
						<?php echo $this->valores['IdAccion']?>
					</td>
				</tr>
				
			</table>
			<form action='../Controllers/PERMISO_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
<?php
		include '../Views/Footer.php';
	}
}
?>