<?php
/*  Archivo php
	Nombre: FUNCIONALIDADES_ACCION_ADD_View.php
	Fecha de creación: 26/11/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una accion de una funcionalidad a la base de datos
*/
class FUNCIONALIDADES_ACCION_ADD {

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
			<form name="ADD" action="../Controllers/FUNCIONALIDADES_ACCION_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAdd()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ID Funcionalidad'];?>
						</th>
						<td class="formThTd"><input type="text" id="idFuncionalidad" name="idFuncionalidad" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="15" size="20" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'15') && comprobarTexto(this,'15')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ID Acción'];?>
						</th>
						<td class="formThTd"><input type="text" id="idAccion" name="idAccion" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="30" size="34" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'30') && comprobarTexto(this,'30') && comprobarAlfabetico(this,'30')"/>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/FUNCIONALIDADES_ACCION_CONTROLLER.php' method="post" style="display: inline">
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