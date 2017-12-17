<?php
/* 
	Fecha de creación: 4/12/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una nota de trabajo a la base de datos
*/
class NOTAS_ADD {

	function __construct() {
		$this->render();
	}

	function render() {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form id="ADD" name="ADD" action="../Controllers/NOTAS_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAddNotas()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Usuario'];?>
						</th>
						<td class="formThTd"><input type="text" id="login" name="login" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="9" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="6" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Nota del Trabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="NotaTrabajo" name="NotaTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="4" size="4" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'4') && comprobarReal(this,4,0,10)"/>
					</tr>
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/NOTAS_CONTROLLER.php' method="post" style="display: inline">
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