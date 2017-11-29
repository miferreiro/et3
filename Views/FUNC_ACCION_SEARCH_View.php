<?php
/*  Archivo php
	Nombre: FUNC_ACCION_SEARCH_View.php
	Fecha de creación: 26/11/2017 
	Función: vista de el formulario de búsqueda(search) realizada con una clase donde se muestran todos los campos a rellenar para buscar a una accion de una funcionalidad de la base de datos
*/
class FUNC_ACCION_SEARCH {

	function __construct() {
		$this->render();
	}

	function render() {

		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de búsqueda'];?>
			</h2>
			<form id="SEARCH" action="../Controllers/FUNC_ACCION_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarSearch()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdFuncionalidad'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdFuncionalidad" name="IdFuncionalidad" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="6" onBlur="comprobarLongitud(this,'6') && comprobarTexto(this,'6')"/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['IdAccion'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdAccion" name="IdAccion" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="6" onBlur="comprobarLongitud(this,'6') && comprobarTexto(this,'6')"/>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Buscar formulario']?>" /></button>
			</form>
						<form action='../Controllers/FUNC_ACCION_CONTROLLER.php' method="post" style="display:inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
						</td>
					</tr>
				</table>

		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>