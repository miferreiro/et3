<?php
/*  Archivo php
	Nombre: FUNCIONALIDADES_EDIT_View.php
	Fecha de creación: 26/11/2017 
	Función: vista de el formulario de editar(edit) realizada con una clase donde se muestran todos los campos posibles a modificar para cambiar los datos de una Funcionalidad en la base de datos
*/
class FUNCIONALIDADES_EDIT {

	function __construct( $valores ) {
		$this->valores = $valores;
		$this->render( $this->valores );
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
			<form name="EDIT" action="../Controllers/FUNCIONALIDADES_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarEdit()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ID Funcionalidad'];?>
						</th>
						<td class="formThTd"><input type="text" id="idFunc" name="idFunc" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['idFunc']?>" maxlength="15" size="20"  readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'15') && comprobarTexto(this,'15')" required/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['Nombre Funcionalidad'];?>
						</th>
						<td class="formThTd"><input type="text" id="nombreFunc" name="nombreFunc" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['nombreFunc']?>" maxlength="30" size="34" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'30') && comprobarTexto(this,'30') && comprobarAlfabetico(this,'30')"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Descripción Funcionalidad'];?>
						</th>
						<td class="formThTd"><input type="text" id="descripFunc" name="descripFunc" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['descripFunc']?>" maxlength="50" size="60" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'50') && comprobarTexto(this,'50') && comprobarAlfabetico(this,'50')"/>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="EDIT"><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
			<form action='../Controllers/FUNCIONALIDADES_CONTROLLER.php' style="display: inline">
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