<?php
/*  Archivo php
	Nombre: GRUPO_ADD_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir un grupo a la base de datos
*/
class GRUPO_ADD {

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
			<form name="ADD" action="../Controllers/USUARIOS_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAdd()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ID Grupo'];?>
						</th>
						<td class="formThTd"><input type="text" id="idgroup" name="idgroup" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="15" size="20" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'15') && comprobarTexto(this,'15')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Nombre Grupo'];?>
						</th>
						<td class="formThTd"><input type="text" id="nombreG" name="nombreG" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="30" size="34" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'30') && comprobarTexto(this,'30') && comprobarAlfabetico(this,'30')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Descripción Grupo'];?>
						</th>
						<td class="formThTd"><input type="text" id="descrip" name="descrip" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="50" size="60" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'50') && comprobarTexto(this,'50')"/>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/USUARIOS_CONTROLLER.php' method="post" style="display: inline">
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