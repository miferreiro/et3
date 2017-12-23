<?php
/*  Archivo php
	Nombre: EVALUACIONES_EDIT_View.php
	Autor: 	Alejandro Vila
	Fecha de creación: 28/11/2017 
	Función: vista de el formulario de editar(edit) realizada con una clase donde se muestran todos los campos posibles a modificar para cambiar los datos de una evaluacion en la base de datos
*/


//es la clase EDIT de EVALUACION que nos permite editar una evaluacion
class EVALUACION_EDIT {
//es el constructor de la clase EVALUACION_EDIT
	function __construct( $valores ) { 
		//$valores es una variable que almacena el recordset de la base de datos
		$this->render( $valores );//llamamos a la función render donde se mostrará el formulario EDIT con los campos correspondientes
	}
//funcion que mostrará el formulario EDIT con los campos correspondientes
	function render( $valores ) {
		$this->valores = $valores;//es una variable que almacena el recordset de la base de datos
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
		?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de modificación'];?>
			</h2>
			<form name="EDIT" action="../Controllers/EVALUACION_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarEditEvaluacion()">
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
						<td class="formThTd"><input type="text" id="LoginEvaluador" name="LoginEvaluador" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['LoginEvaluador']?>" maxlength="9" size="9" readonly required onBlur="comprobarVacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9') "/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['AliasEvaluado'];?>
						</th>
						<td class="formThTd"><input type="text" id="AliasEvaluado" name="AliasEvaluado" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['AliasEvaluado']?>" maxlength="6" size="6" required readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6') "/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['IdHistoria'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdHistoria" name="IdHistoria" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['IdHistoria']?>" maxlength="2" size="2" required  readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'2') && comprobarEntero(this,0,99)"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['CorrectoA'];?>
						</th>
						<td class="formThTd"><input type="text" id="CorrectoA" name="CorrectoA" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['CorrectoA']?>" maxlength="1" size="1" onBlur="comprobarLongitud(this,'1') && comprobarTexto(this,'1') && comprobarEntero(this,0,2)"/>
					</tr>
                
                    <tr>
						<th class="formThTd">
							<?php echo $strings['ComenIncorrectoA'];?>
						</th>
                        <td class="formThTd"><textarea type="text" id="ComenIncorrectoA" name="ComenIncorrectoA" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="300" cols="32" rows="8" onBlur=" comprobarLongitud(this,'300') && comprobarTexto(this,'300')"><?php echo $this->valores['ComenIncorrectoA']?></textarea>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['CorrectoP'];?>
						</th>
                        <td class="formThTd"><input type="text" id="CorrectoP" name="CorrectoP" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['CorrectoP']?>" maxlength="1" size="1" onBlur=" comprobarVacio(this) && comprobarLongitud(this,'1') && comprobarTexto(this,'1')  && comprobarEntero(this,0,2)" />
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['ComentIncorrectoP'];?>
						</th>
                        <td class="formThTd"><textarea id="ComentIncorrectoP" name="ComentIncorrectoP" placeholder="<?php echo $strings['Escriba aqui...']?>"  value="" maxlength="300" cols="32" rows="8"  onBlur=" comprobarLongitud(this,'300') && comprobarTexto(this,'300')"><?php echo $this->valores['ComentIncorrectoP']?></textarea>
					</tr>
                    
                     <tr>
						<th class="formThTd">
							<?php echo $strings['OK'];?>
						</th>
						<td class="formThTd"><input type="text" id="OK" name="OK" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['OK']?>" maxlength="1" size="1" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'1') && comprobarTexto(this,'1')  && comprobarEntero(this,0,2)"/>
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
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
		?>