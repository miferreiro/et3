<?php
/*  Archivo php
	Nombre: PERMISOS_SEARCH_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de búsqueda(search) realizada con una clase donde se muestran todos los campos a rellenar para buscar a una acción de la base de datos
*/
class PERMISOS_SEARCH {

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
			<form id="SEARCH" action="../Controllers/PERMISOS_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarSearch()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ID Grupo'];?>
						</th>
						<td class="formThTd"><input type="text" id="idGrupo" name="idGrupo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="2" size="2" required onBlur="comprobarEntero(this,0,99)"/>					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ID Funcionalidad'];?>
						</th>
						<td class="formThTd"><input type="text" id="idFuncionalidad" name="idFuncionalidad" placeholder="<?php echo $strings['Escriba aqui...']?>" value="2" maxlength="2" size="2" required onBlur="comprobarEntero(this,0,99)"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ID Accion'];?>
						</th>
						<td class="formThTd"><input type="text" id="idAccion" name="idAccion" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="2" size="2" required onBlur="comprobarEntero(this,0,99)"/>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" />
							</button>
			</form>
						<form action='../Controllers/PERMISOS_CONTROLLER.php' method="post" style="display:inline">
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