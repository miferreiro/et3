<?php
/* 
	Fecha de creación: 4/12/2017 
	Función: vista de el formulario de editar(edit) realizada con una clase donde se muestran todos los campos posibles a modificar para cambiar la nota del trabajo
*/
class NOTAS_EDIT {

	function __construct($valores) {
		$this->valores = $valores;
		$this->render($this->valores);
	}

	function render($valores) {
 		$this->valores = $valores;
		
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
		?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de modificación'];?>
			</h2>
			<form name="EDIT" action="../Controllers/NOTAS_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarEditNotas()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Usuario'];?>
						</th>
						<td class="formThTd"><input type="text" id="login" name="login" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['login']?>" maxlength="9" size="9"  readonly onBlur="comprobarVacio(this)  && comprobarLongitud(this,'9') && comprobarTexto(this,'9')" required/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['IdTrabajo']?>" maxlength="6" size="6" onBlur="comprobarVacio(this) &&  comprobarLongitud(this,6) && comprobarTexto(this,6)" readonly required/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Nota del Trabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="NotaTrabajo" name="NotaTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['NotaTrabajo']?>" maxlength="4" size="4" onBlur="comprobarVacio(this) && comprobarLongitud(this,'4') && comprobarTexto(this,'4') && comprobarReal(this,4,0,10) " required/>
					</tr>
					
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="EDIT"><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
			<form action='../Controllers/NOTAS_CONTROLLER.php' style="display: inline">
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