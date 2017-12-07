<?php
/*  Archivo php
	Nombre: FUNC_ACCION_ADD_View.php
	Fecha de creación: 26/11/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una accion de una funcionalidad a la base de datos
*/
class FUNC_ACCION_ADD {

	function __construct($valores,$acciones) {
		$this->render($valores,$acciones);
	}

	function render($valores,$acciones) {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form name="ADD" action="../Controllers/FUNC_ACCION_CONTROLLER.php" method="post" enctype="multipart/form-data" >
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreFuncionalidad'];?>
						</th>
						<td class="formThTd"><input type="text" id="NombreFuncionalidad" name="NombreFuncionalidad" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $valores[0][1]?>" maxlength="60" size="60" onBlur="comprobarVacio(this) && comprobarLongitud(this,'60') && comprobarTexto(this,'6')" readonly/>
						<input type="hidden" name="IdFuncionalidad" value="<?php echo $valores[0][0];?>">
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreAccion'];?>
						</th>
						<td class="formThTd">
							<select name="IdAccion">						        
								<?php
								//Bucle que recorre las posibles et para generer qas
								for ($i=0; $i < count($acciones); $i++) { 
								?>
								<option value="<?php echo $acciones[$i][0] ?>"><?php echo $acciones[$i][1] ?></option>
						        <?php
						        }
						        ?>
							</select>
					</tr>
					<input type="hidden" name="IdFuncionalidad" value="<?php echo $valores[0][0];?>">
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/FUNC_ACCION_CONTROLLER.php' method="post" style="display: inline">
							<input type="hidden" name="IdFuncionalidad" value="<?php echo $valores[0][0];?>">
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