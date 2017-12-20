<?php
/*  Archivo php
	Nombre: EVALUACION_ADD_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una acción a la base de datos
*/
class EVALUACION_ADD {

	function __construct($datos,$trabajos,$trabajos2,$hists) {
		$this->datos = $datos;
		$this->trabajos = $trabajos;
		$this->trabajos2 = $trabajos2;
		$this->hists= $hists;
		$this->render($this->datos,$this->trabajos,$this->trabajos2,$this->hists);

	}

	function render($datos,$trabajos,$trabajos2,$hists) {
		$this->datos = $datos;
		$this->trabajos = $trabajos;
		$this->trabajos2 = $trabajos2;
		$this->hists= $hists;
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
							<?php echo $strings['NombreTrabajo'];?>
						</th>
                  <td class="formThTd">
                   <select id="IdTrabajo" name="IdTrabajo" required>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				<option value="<?php echo $fila[ 'IdTrabajo' ]?>">

<?php 
			//echo $fila[ 'NombreGrupo' ].'_'.$fila['IdGrupo'];
					echo $fila['NombreTrabajo'];
?>		
               							

               </option>
	
<?php } ?>					
					</select>
				</td>
					</tr>
					
					
					
				<tr>
						<th class="formThTd">
							<?php echo $strings['LoginEvaluador'];?>
						</th>
                  <td class="formThTd">
                   <select id="LoginEvaluador" name="LoginEvaluador" required>
<?php
				while ( $fila = mysqli_fetch_array( $this->trabajos) ) {
?>
				<option value="<?php echo $fila[ 'login' ]?>">

<?php 
			//echo $fila[ 'NombreGrupo' ].'_'.$fila['IdGrupo'];
					echo $fila['login'];
?>		
               							

               </option>
	
<?php } ?>					
					</select>
				</td>
					</tr>

			
				<tr>
						<th class="formThTd">
							<?php echo $strings['AliasEvaluado'];?>
						</th>
                  <td class="formThTd">
                   <select id="AliasEvaluado" name="AliasEvaluado" required>
<?php
				while ( $fila = mysqli_fetch_array( $this->trabajos2) ) {
?>
				<option value="<?php echo $fila[ 'Alias' ]?>">

<?php 
			//echo $fila[ 'NombreGrupo' ].'_'.$fila['IdGrupo'];
					echo $fila['Alias'];
?>		
               							

               </option>
	
<?php } ?>					
					</select>
				</td>
					</tr>
			
				<tr>
						<th class="formThTd">
							<?php echo $strings['TextoHistoria'];?>
						</th>
                  <td class="formThTd">
                   <select id="IdHistoria" name="IdHistoria" required>
<?php
				while ( $fila = mysqli_fetch_array( $this->hists) ) {
?>
				<option value="<?php echo $fila[ 'IdHistoria' ]?>">

<?php 
			//echo $fila[ 'NombreGrupo' ].'_'.$fila['IdGrupo'];
					echo $fila['TextoHistoria'];
?>		
               							

               </option>
	
<?php } ?>					
					</select>
				</td>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['CorrectoA'];?>
						</th>
						<td class="formThTd"><input type="text" id="CorrectoA" name="CorrectoA" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="1" size="1" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'1') && comprobarTexto(this,'1')  && comprobarEntero(this,0,2)"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ComenIncorrectoA'];?>
						</th>
						<td class="formThTd"><textarea id="ComenIncorrectoA" name="ComenIncorrectoA" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="300" cols="32" rows="8"  onBlur="comprobarLongitud(this,'300') && comprobarTexto(this,'300')"></textarea>

					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['CorrectoP'];?>
						</th>
						<td class="formThTd"><input type="text" id="CorrectoP" name="CorrectoP" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="1" size="1" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'1') && comprobarTexto(this,'1')  && comprobarEntero(this,0,2)"/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['ComentIncorrectoP'];?>
						</th>
						<td class="formThTd"><textarea id="ComentIncorrectoP" name="ComentIncorrectoP" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="300" cols="32" rows="8"  onBlur=" comprobarLongitud(this,'300') && comprobarTexto(this,'300')"></textarea>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['OK'];?>
						</th>
						<td class="formThTd"><input type="text" id="OK" name="OK" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="1" size="1" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'1') && comprobarTexto(this,'1')  && comprobarEntero(this,0,2)"/>
					</tr>


					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
			<form action='../Controllers/EVALUACION_CONTROLLER.php' method="get" style="display: inline">
				<button type="submit" name="action" value=""><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			</tr>
			</table>
		</div>
		<?php
		include '../Views/Footer.php';
		}
		}
		?>