<?php
/* 
	Fecha de creación: 4/12/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una nota de trabajo a la base de datos
*/
class NOTAS_ADD {
	function __construct($datos,$trabajos) {
		$this->datos = $datos;
		$this->trabajos = $trabajos;
		$this->render($this->datos,$this->trabajos);

	}

	function render($datos,$trabajos) {
		$this->datos = $datos;
		$this->trabajos = $trabajos;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de inserción'];?>
			</h2>
			<form name="ADD" action="../Controllers/NOTAS_CONTROLLER.php" method="post" enctype="multipart/form-data" onsubmit="return comprobarAddNotas()">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['login'];?>
						</th>
                  <td class="formThTd">
                   <select id="login" name="login">
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
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
							<?php echo $strings['NombreTrabajo'];?>
						</th>
                  <td class="formThTd">
                   <select id="IdTrabajo" name="IdTrabajo">
<?php
				while ( $fila = mysqli_fetch_array( $this->trabajos ) ) {
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
							<?php echo $strings['Nota del Trabajo'];?>
						</th>
						<td class="formThTd"><input type="text" id="NotaTrabajo" name="NotaTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="4" size="4" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'4') && comprobarReal(this,4,0,10)"/>
					</tr>
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>
			</form>
						<form action='../Controllers/NOTAS_CONTROLLER.php' method="post" style="display: inline">
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