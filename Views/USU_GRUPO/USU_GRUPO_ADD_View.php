<?php
/*  Archivo php
	Nombre: USUARIOS_ADD_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir un usuario a la base de datos
*/
class USU_GRUPO_ADD {

	function __construct($login,$grupos) {
		$this->grupos = $grupos;
		$this->login = $login;
		$this->render($this->grupos,$this->login);
	}

	function render($grupos,$login) { 
		$this->grupos = $grupos;
		$this->login = $login;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>

			<form action='../Controllers/USU_GRUPO_CONTROLLER.php' method="post" style="display: inline">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Login'];?>
						</th>
						<td class="formThTd"><input type="text" id="login" name="login" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->login ?>" maxlength="9" size="11" required readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9')"/>
					</tr>

					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreGrupo'];?>
						</th>
                  <td>
                   <select id="IdGrupo" name="IdGrupo">
<?php
				while ( $fila = mysqli_fetch_array( $this->grupos ) ) {
?>
				<option value="<?php echo $fila[ 'IdGrupo' ]?>">

<?php 
			//echo $fila[ 'NombreGrupo' ].'_'.$fila['IdGrupo'];
					echo $fila['NombreGrupo'];
?>		
               							

               </option>
	
<?php } ?>					
					</select>
				</td>
					</tr>
					<tr>
					<td colspan="2">

						
						<!--	<input type="hidden" name="login" value="<?php echo $this->login  ?>">-->
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
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