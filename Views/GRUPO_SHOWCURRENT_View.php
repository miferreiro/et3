<?php
/*  Archivo php
	Nombre: GRUPO_SHOWCURRENT_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de vista en detalle(showcurrent) realizada con una clase donde se muestran todos los datos de un grupo
*/
class GRUPO_SHOWCURRENT {


	function __construct($datos) {	
		$this->datos = $datos;
		$this->render($this->datos);
	}
	
	function render($datos){
		$this->datos = $datos;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<tr>
					<th>
						<?php echo $strings['IdGrupo'];?>
					</th>
					<td>
						<?php echo $this->datos['IdGrupo']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['NombreGrupo'];?>
					</th>
					<td>
						<?php echo $this->datos['NombreGrupo']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['DescripGrupo'];?>
					</th>
					<td>
						<?php echo $this->datos['DescripGrupo']?>
					</td>
				</tr>
	
			</table>
			<br>
			<br>
			
			
			<form action='../Controllers/GRUPO_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>