<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_HISTORIAS_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una acción a la base de datos
*/
class ASIGNAC_QA_HISTORIAS {

	function __construct($valores) {
		$this->render($valores);
	}

	function render($QA) {
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
							<?php echo $strings['QA'];?>
						</th>
						<td class="formThTd">
							<select name="IdTrabajo">						        
								<?php
								//Bucle que recorre las posibles et para generer qas
								for ($i=0; $i < count($QA); $i++) { 
								?>
								<option value="<?php echo $QA[$i][0] ?>"><?php echo $QA[$i][1] ?></option>
						        <?php
						        }
						        ?>
							</select>
					</tr>

					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="HISTORIAS"><img src="../Views/icon/generar.png" alt="<?php echo $strings['Confirmar formulario']?>" width="32" height="32" /></button>
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