<?php
//Esta función es la vista que sirve para añadir una entrega.
//Fecha de creación:27/11/2017
class ENTREGA_ADD {

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
			<form id="ADD" name="ADD" action="../Controllers/ENTREGA_CONTROLLER.php" method="post"  enctype="multipart/form-data"  onsubmit="return comprobarAddEntrega()"><!--Formulario para añadir una entrega -->
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
							<?php echo $strings['Horas'];?><!--se muestra el campo Horas-->
						</th>
						<td class="formThTd"><input type="text" id="Horas" name="Horas" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="2" size="2" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'2') && comprobarTexto(this,'2') && comprobarEntero(this,0,99)"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['Ruta'];?><!--se muestra el campo Ruta-->
						</th>
						<td class="formThTd"><input type="file" id="Ruta" name="Ruta" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="60" size="60" required  />
					</tr>
					
					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="ADD" onfocus="comprobarVacio(document.forms['ADD'].elements[3])"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button><!--boton para confirmar el añadido de la entrega -->
			</form>
						<form action='../Controllers/ENTREGA_CONTROLLER.php' method="post" style="display: inline"><!--formulario para volver atra-->
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
                            <!--boton para volver atras -->
						</form>
					</tr>
				</table>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>