<?php
/*  Archivo php
	Nombre: TRABAJO_ADD_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una acción a la base de datos
*/
class TRABAJO_ADD {

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
			<form name="ADD" action="../Controllers/TRABAJO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAdd()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ID Trabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="6" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Nombre Trabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreTrabajo" name="NombreTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="60" size="60" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'60') && comprobarTexto(this,'60') && comprobarAlfabetico(this,'60')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Fecha inicio trabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="FechaIniTrabajo" name="FechaIniTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="50" size="60" class="tcal tcalInput" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'50') && comprobarTexto(this,'50')"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['Fecha fin trabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="FechaFinTrabajo" name="FechaFinTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="50" size="60" class="tcal tcalInput" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'50') && comprobarTexto(this,'50')"/>
					</tr>
					
                      <tr>
						<th class="formThTd">
							<?php echo $strings['Porcentaje de Nota'];?>
						</th>
						<td class="formThTd"><input type="number" id="PorcentajeNota" name="PorcentajeNota" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="2" size="2" class="tcal tcalInput" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'2') && comprobarTexto(this,'2')"/>
					</tr>
                    
                    
                    
                    
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/TRABAJO_CONTROLLER.php' method="post" style="display: inline">
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