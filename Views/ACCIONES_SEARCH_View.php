<?php
/*  Archivo php
	Nombre: ACCION_SEARCH_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de búsqueda(search) realizada con una clase donde se muestran todos los campos a rellenar para buscar a una acción de la base de datos
*/
class USUARIOS_SEARCH {

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
			<form id="SEARCH" action="../Controllers/USUARIOS_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarSearch()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ID Acción'];?>
						</th>
						<td class="formThTd"><input type="text" id="idaccion" name="idaccion" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="15" size="20" onBlur="comprobarLongitud(this,'15') && comprobarTexto(this,'15')"/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['Nombre Acción'];?>
						</th>
						<td class="formThTd"><input type="text" id="nombreAc" name="nombreAc" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="30" size="34" onBlur="comprobarLongitud(this,'30') && comprobarTexto(this,'30') && comprobarAlfabetico(this,'30')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Descripción Acción'];?>
						</th>
						<td class="formThTd"><input type="text" id="descripAc" name="descripAc" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="50" size="60" onBlur="comprobarLongitud(this,'50') && comprobarTexto(this,'50') && comprobarAlfabetico(this,'50')"/>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Buscar formulario']?>" /></button>
			</form>
						<form action='../Controllers/USUARIOS_CONTROLLER.php' method="post" style="display:inline">
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