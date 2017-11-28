<?php
/*  Archivo php
	Nombre: GRUPO_EDIT_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de editar(edit) realizada con una clase donde se muestran todos los campos posibles a modificar para cambiar los datos de un grupo en la base de datos
*/
class GRUPO_EDIT {

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
			<form name="EDIT" action="../Controllers/GRUPO_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdGrupo'];?>
						</th>
						<td class="formThTd"><input type="text" id="IdGrupo" name="IdGrupo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $valores['IdGrupo'] ?>" maxlength="15" size="20"  readonly onBlur="" required/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreGrupo'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreGrupo" name="NombreGrupo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['NombreGrupo'] ?>" maxlength="30" size="34" required onBlur=""/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['DescripGrupo'];?>
						</th>
						<td class="formThTd"><input type="text" id="DescripGrupo" name="DescripGrupo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['DescripGrupo'] ?>" maxlength="50" size="60" required onBlur=""/>
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="EDIT"><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
			<form action='../Controllers/GRUPO_CONTROLLER.php' style="display: inline">
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