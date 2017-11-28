<?php
/*  Archivo php
	Nombre: PERMISOS_SEARCH_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de búsqueda(search) realizada con una clase donde se muestran todos los campos a rellenar para buscar a una acción de la base de datos
*/
class PERMISO_SEARCH {

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
			<form id="SEARCH" action="../Controllers/PERMISO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdGrupo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdGrupo" name="IdGrupo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="2" size="2" onBlur="comprobarEntero(this,0,99)"/>					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdFuncionalidad'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdFuncionalidad" name="IdFuncionalidad" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="2" size="2" onBlur="comprobarEntero(this,0,99)"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdAccion'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdAccion" name="IdAccion" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="2" size="2" onBlur="comprobarEntero(this,0,99)"/>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" />
							</button>
			</form>
						<form action='../Controllers/PERMISO_CONTROLLER.php' method="post" style="display:inline">
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