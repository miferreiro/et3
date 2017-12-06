<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_HISTORIAS_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una acción a la base de datos
*/
class ASIGNAC_QA_HISTORIAS {

	function __construct() {
		$this->render();
	}

	function render() {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['GENERACIÓN AUTOMÁTICA DE HISTORIAS'];?>
			</h2>
			<form name="ASIGNAC_QA" action="../Controllers/ASIGNAC_QA_CONTROLLER.php" method="post" enctype="multipart/form-data">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ET'];?>
						</th>
						<td class="formThTd">
							<select name="IdTrabajo">						        
								<option value="ET1">1</option>
						        <option value="ET2">2</option>
						        <option value="ET3">3</option>
						        <option value="ET4">4</option>
						        <option value="ET5">5</option>
							</select>
					</tr>

					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="HISTORIAS"><img src="../Views/icon/historias.png" alt="<?php echo $strings['Confirmar formulario']?>" width="32" height="32" /></button>
			</form>
						<form action='../Controllers/ASIGNAC_QA_CONTROLLER.php' method="post" style="display: inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
					</tr>
				</table>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>