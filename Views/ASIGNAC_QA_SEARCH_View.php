<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_SEARCH_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una acción a la base de datos
*/
class ASIGNAC_QA_SEARCH {

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
			<form name="SEARCH" action="../Controllers/ASIGNAC_QA_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="10" onBlur="comprobarLongitud(this,'6') && comprobarTexto(this,'6')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['LoginEvaluador'];?>
						</th>
						<td class="formThTd"><input type="text" id="LoginEvaluador" name="LoginEvaluador" placeholder="<?php echo $strings['Escriba aqui...']?>"  maxlength="9" size="10" onBlur="comprobarLongitud(this,'9') && comprobarTexto(this,'9') && comprobarAlfabetico(this,'9')"/>
					</tr>
				
					<tr>
						<th class="formThTd">
							<?php echo $strings['LoginEvaluado'];?>
						</th>
						<td class="formThTd"><input type="text" id="LoginEvaluado" name="LoginEvaluado" placeholder="<?php echo $strings['Escriba aqui...']?>"  maxlength="9" size="10" onBlur="comprobarLongitud(this,'9') && comprobarTexto(this,'9') && comprobarAlfabetico(this,'9')"/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['AliasEvaluado'];?>
						</th>
						<td class="formThTd"><input type="text" id="AliasEvaluado" name="AliasEvaluado" placeholder="<?php echo $strings['Escriba aqui...']?>"  maxlength="6" size="7" onBlur="ComprobarLongitud(this,'6') && comprobarTexto(this,'6') && comprobarAlfabetico(this,'6')"/>
					</tr>

					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
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