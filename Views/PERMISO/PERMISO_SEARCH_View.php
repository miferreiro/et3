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
			<form id="SEARCH" name= "SEARCH" action="../Controllers/PERMISO_CONTROLLER.php" method="post" enctype="multipart/form-data" onSubmit="comprobarSearchPermisos()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreGrupo'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreGrupo" name="NombreGrupo" placeholder="<?php echo $strings['Escriba aqui...']?>" maxlength="60" size="61" onBlur="comprobarLongitud(this,'60') && comprobarTexto(this,'60') && comprobarAlfabetico(this,'60')"/>					
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreFuncionalidad'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreFuncionalidad" name="NombreFuncionalidad" placeholder="<?php echo $strings['Escriba aqui...']?>" maxlength="60" size="61" onBlur="comprobarLongitud(this,'60') && comprobarTexto(this,'60') && comprobarAlfabetico(this,'60')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreAccion'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreAccion" name="NombreAccion" placeholder="<?php echo $strings['Escriba aqui...']?>" maxlength="60" size="61" onBlur="comprobarLongitud(this,'60') && comprobarTexto(this,'60') && comprobarAlfabetico(this,'60')"/>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Confirmar formulario']?>" />
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