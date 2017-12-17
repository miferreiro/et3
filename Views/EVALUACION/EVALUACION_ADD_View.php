<?php
/*  Archivo php
	Nombre: EVALUACION_ADD_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una acción a la base de datos
*/
class EVALUACION_ADD {

	function __construct($id,$alias) {
		$this->render($id,$alias);
	}

	function render($id,$alias) {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
		?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form name="ADD" action="../Controllers/EVALUACION_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAddEvaluacion()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" value="<?php echo $id ?>" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="6" size="6" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6')" readonly />
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['LoginEvaluador'];?>
						</th>
						<td class="formThTd"><input type="text" id="LoginEvaluador" name="LoginEvaluador" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="9" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9') && comprobarAlfabetico(this,'9')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['AliasEvaluado'];?>
						</th>
						<td class="formThTd"><input type="text" id="AliasEvaluado" name="AliasEvaluado" value="<?php echo $alias ?>" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="9" size="9" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9')" readonly />
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['IdHistoria'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdHistoria" name="IdHistoria" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="2" size="2" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'2') && comprobarTexto(this,'2') comprobarEntero(this,'2','0','99')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['CorrectoA'];?>
						</th>
						<td class="formThTd"><input type="text" id="CorrectoA" name="CorrectoA" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="1" size="1" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'1') && comprobarTexto(this,'1')  && comprobarEntero(this,0,1)"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ComenIncorrectoA'];?>
						</th>
						<td class="formThTd"><textarea id="ComenIncorrectoA" name="ComenIncorrectoA" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="300" cols="50" rows="7" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'300') && comprobarTexto(this,'300')"></textarea>

					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['CorrectoP'];?>
						</th>
						<td class="formThTd"><input type="text" id="CorrectoP" name="CorrectoP" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="1" size="1" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'1') && comprobarTexto(this,'1')  && comprobarEntero(this,0,1)"/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['ComentIncorrectoP'];?>
						</th>
						<td class="formThTd"><textarea id="ComentIncorrectoP" name="ComentIncorrectoP" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="300" cols="50" rows="7" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'300') && comprobarTexto(this,'300')"></textarea>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['OK'];?>
						</th>
						<td class="formThTd"><input type="text" id="OK" name="OK" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="1" size="1" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'1') && comprobarTexto(this,'1')  && comprobarEntero(this,0,1)"/>
					</tr>


					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
			<form action='../Controllers/EVALUACION_CONTROLLER.php' method="get" style="display: inline">
				<input type="hidden" name="IdTrabajo" value="<?php echo $id ?>">
				<input type="hidden" name="AliasEvaluado" value="<?php echo $alias ?>">
				<button type="submit" name="action" value="MOSTRAR_USER"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			</tr>
			</table>
		</div>
		<?php
		include '../Views/Footer.php';
		}
		}
		?>