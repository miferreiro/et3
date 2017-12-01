<?php
/*  Archivo php
	Nombre: EVALUACION_SEARCH_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de búsqueda(search) realizada con una clase donde se muestran todos los campos a rellenar para buscar a una acción de la base de datos
*/
class EVALUACION_SEARCH {

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
			<form id="SEARCH" action="../Controllers/EVALUACION_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarSearch()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ID Trabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="6" onBlur="comprobarLongitud(this,'6') && comprobarTexto(this,'6')"/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['Login evaluador'];?>
						</th>
						<td class="formThTd"><input type="text" id="LoginEvaluador" name="LoginEvaluador" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="34" onBlur="comprobarLongitud(this,'9') && comprobarTexto(this,'9') && comprobarAlfabetico(this,'9')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Alias evaluado'];?>
						</th>
						<td class="formThTd"><input type="text" id="AliasEvaluado" name="AliasEvaluado" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="9" onBlur="comprobarLongitud(this,'9') && comprobarTexto(this,'9') && comprobarAlfabetico(this,'9')"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['ID Historia'];?>
						</th>
						<td class="formThTd"><input type="number" id="IdHistoria" name="IdHistoria" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="2" size="2" onBlur="comprobarLongitud(this,'2') && comprobarTexto(this,'2')"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['CorrectoA'];?>
						</th>
						<td class="formThTd"><input type="number" id="CorrectoA" name="CorrectoA" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="1" size="1" onBlur="comprobarLongitud(this,'1') && comprobarTexto(this,'1')"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['Comentario incorrecto A'];?>
						</th>
                        <td class="formThTd"><texarea type="text" id="ComenIncorrectoA" name="ComenIncorrectoA" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="300" size="300" onBlur="comprobarLongitud(this,'300') && comprobarTexto(this,'300') && comprobarAlfabetico(this,'300')"></texarea>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['CorrectoP'];?>
						</th>
						<td class="formThTd"><input type="number" id="CorrectoP" name="CorrectoP" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="1" size="1" onBlur="comprobarLongitud(this,'1') && comprobarTexto(this,'1')"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['Comentario incorrecto P'];?>
						</th>
                        <td class="formThTd"><textarea type="text" id="ComentIncorrectoP" name="ComentIncorrectoP" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="300" size="300" onBlur="comprobarLongitud(this,'300') && comprobarTexto(this,'300') && comprobarAlfabetico(this,'300')"></textarea>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['OK'];?>
						</th>
						<td class="formThTd"><input type="number" id="OK" name="OK" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="1" size="1" onBlur="comprobarLongitud(this,'1') && comprobarTexto(this,'1')"/>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="<?php echo $strings['Buscar formulario']?>" /></button>
			</form>
						<form action='../Controllers/EVALUACION_CONTROLLER.php' method="post" style="display:inline">
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