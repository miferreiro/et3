<?php
/*  Archivo php
	Nombre: PERMISOS_ADD_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una acción a la base de datos
*/
class PERMISO_ADD {

	function __construct($Grupo,$Funcionalidades) {
		$this->render($Grupo,$Funcionalidades);
	}

	function render($Grupo,$Funcionalidades) {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form name="ADD_PERMISOS" action="../Controllers/PERMISO_CONTROLLER.php" method="post" enctype="multipart/form-data" >
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreGrupo'];?>
						</th>
						<td class="formThTd">
							<input type="text" id="NombreGrupo" name="NombreGrupo" maxlength="60" size="60" required value="<?php echo $Grupo[0][1] ?>" onBlur="comprobarVacio(this) && comprobarLongitud(this,'60') && comprobarTexto(this,'60') " readonly />	
							<input type="hidden" id="IdGrupo" name="IdGrupo" value="<?php echo $Grupo[0][0]; ?>" maxlength="2" size="2" required readonly />				
				    </tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreFuncionalidad'];?>
						</th>
						<td class="formThTd">
							<select name="IdFuncionalidad">

						<?php
							if($Funcionalidades == null){

						?>
							<input type="hidden" id='IdFuncionalidad' name='IdFuncionalidad' value="" maxlength="2" size="2" readonly />
						<?php
							}
							for ($i=0; $i < count($Funcionalidades); $i++) {
						?>
								<option value="<?php echo $Funcionalidades[$i][0] . "," . $Funcionalidades[$i][2]; ?>"><?php echo $Funcionalidades[$i][1]; ?></option>
						<?php
							}
						?>    
						</select>
						<input type="hidden" id='IdAccion' name='IdAccion' value="" maxlength="2" size="2" readonly />
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" />
							</button>
			</form>
						<form action='../Controllers/GRUPO_CONTROLLER.php' method="post" style="display: inline">
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