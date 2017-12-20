<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_GENERAR_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una acción a la base de datos
*/
class ASIGNAC_QA_GENERAR {

	function __construct($valores) {
		$this->render($valores);
	}

	function render($ET) {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['GENERACIÓN AUTOMÁTICA DE QAs'];?>
			</h2>
			<form name="ASIGNAC_QA" action="../Controllers/ASIGNAC_QA_CONTROLLER.php" method="post" enctype="multipart/form-data">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ET'];?>
						</th>
						<td class="formThTd">
							<select name="IdTrabajo">						        
								<?php
								//Bucle que recorre las posibles et para generer qas
								for ($i=0; $i < count($ET); $i++) { 
								?>
								<option value="<?php echo $ET[$i][0] ?>"><?php echo $ET[$i][1] ?></option>
						        <?php
						        }
						        ?>
							</select>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Número de QAs'];?>
						</th>
						<td class="formThTd">
						<input type="text" id="num" name="num" placeholder="<?php echo $strings['Escriba aqui...']?>" value="5" maxlength="3" size="3" required onBlur="comprobarVacio(this) && comprobarEntero(this, 0, 999) "/>
					</tr>

					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="GENERAR"><img src="../Views/icon/generar.png" alt="<?php echo $strings['Confirmar formulario']?>" width="32" height="32" /></button>
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