<?php
/*  Archivo php
	Nombre: PERMISOS_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de editar(edit) realizada con una clase donde se muestran todos los campos posibles a modificar para cambiar los datos de una acción en la base de datos
*/
class PERMISOS_EDIT {

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
			<form name="EDIT_PERMISOS" action="../Controllers/PERMISOS_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAdd()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ID Grupo'];?>
						</th>
						<td class="formThTd"><input type="text" id="idGrupo" name="idGrupo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['idGrupo']?>" maxlength="2" size="2" required onBlur="comprobarEntero(this,0,99)"/>					
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ID Funcionalidad'];?>
						</th>
						<td class="formThTd"><input type="text" id="idFuncionalidad" name="idFuncionalidad" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['idFuncionalidad']?>" maxlength="2" size="2" required onBlur="comprobarEntero(this,0,99)"/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['ID Accion'];?>
						</th>
						<td class="formThTd"><input type="text" id="idAccion" name="idAccion" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['idAccion']?>" maxlength="2" size="2" required onBlur="comprobarEntero(this,0,99)"/>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="EDIT"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" />
							</button>
			</form>
			<form action='../Controllers/PERMISOS_CONTROLLER.php' style="display: inline">
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