<?php
/*  Archivo php
	Nombre: EVALUACIONES_EDIT_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de editar(edit) realizada con una clase donde se muestran todos los campos posibles a modificar para cambiar los datos de una acción en la base de datos
*/
class EVALUACION_EDIT {

	function __construct( $valores ) {
		
		$this->render( $valores );
	}

	function render( $valores ) {
		$this->valores = $valores;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
		?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de modificación'];?>
			</h2>
			<form name="EDIT" action="../Controllers/EVALUACION_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarEdit()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['IdTrabajo']?>" maxlength="6" size="6"  readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6')" required/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['LoginEvaluador'];?>
						</th>
						<td class="formThTd"><input type="text" id="LoginEvaluador" name="LoginEvaluador" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['LoginEvaluador']?>" maxlength="9" size="9" readonly required onBlur="comprobarVacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9') && comprobarAlfabetico(this,'9')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['AliasEvaluado'];?>
						</th>
						<td class="formThTd"><input type="text" id="AliasEvaluado" name="AliasEvaluado" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['AliasEvaluado']?>" maxlength="9" size="9" required readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9') && comprobarAlfabetico(this,'9')"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['IdHistoria'];?>
						</th>
						<td class="formThTd"><input type="number" id="IdHistoria" name="IdHistoria" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['IdHistoria']?>" maxlength="2" size="2" required  readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'2') && comprobarInt(this,'2')"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['CorrectoA'];?>
						</th>
						<td class="formThTd"><input type="number" id="CorrectoA" name="CorrectoA" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['CorrectoA']?>" maxlength="1" size="1" onBlur="comprobarLongitud(this,'1') && comprobarTexto(this,'1')"/>
					</tr>
                
                    <tr>
						<th class="formThTd">
							<?php echo $strings['ComenIncorrectoA'];?>
						</th>
                        <td class="formThTd"><textarea type="text" id="ComenIncorrectoA" name="ComenIncorrectoA" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['ComenIncorrectoA']?>" required maxlength="300" size="300" onBlur="comprobarLongitud(this,'300') && comprobarTexto(this,'300')"></textarea>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['CorrectoP'];?>
						</th>
                        <td class="formThTd"><input type="number" id="CorrectoP" name="CorrectoP" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['CorrectoP']?>" maxlength="1" size="1" onBlur="comprobarLongitud(this,'1') && comprobarTexto(this,'1')" />
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['ComentIncorrectoP'];?>
						</th>
                        <td class="formThTd"><textarea type="text" id="ComentIncorrectoP" name="ComentIncorrectoP" placeholder="<?php echo $strings['Escriba aqui...']?>"  value="<?php echo $this->valores['ComentIncorrectoP']?>" maxlength="300" size="300" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'300') && comprobarTexto(this,'300')"></textarea>
					</tr>
                    
                     <tr>
						<th class="formThTd">
							<?php echo $strings['OK'];?>
						</th>
						<td class="formThTd"><input type="text" id="OK" name="OK" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['OK']?>" maxlength="50" size="60" required onBlur="comprobarLongitud(this,'50') && comprobarTexto(this,'50') && comprobarAlfabetico(this,'50')"/>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="EDIT"><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
			<form action='../Controllers/EVALUACION_CONTROLLER.php' style="display: inline">
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