<?php
//Esta función es la vista que sirve para editar una entrega.
//Fecha de creación:27/11/2017

class ENTREGA_EDIT {

	function __construct($valores) {
		$this->render($valores);
	}

	function render($valores) {
        $this->valores=$valores;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Formulario de modificación'];?>
			</h2>
			<form name="ADD" action="../Controllers/ENTREGA_CONTROLLER.php" method="post"  enctype="multipart/form-data"  onsubmit="return comprobarEditEntrega()">
				<table>
				<tr>
						<th class="formThTd">
							<?php echo $strings['login'];?><!--se muestra el campo login sin poder modififcarlo-->
						</th>
						<td class="formThTd"><input type="text" id="login" name="login" value="<?php echo $this->valores['login']?>" placeholder="<?php echo $strings['Escriba aqui...']?>"  maxlength="9" size="9"  onBlur="comprobarVacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9')" readonly/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?><!--se muestra el campo IdTrabajo sin poder modificarlo-->
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['IdTrabajo']?>"  maxlength="6" size="6" onBlur="comprobarVacio(this) && comprobarLongitud(this,'6') && comprobarTexto(this,'6')" readonly/>
					</tr>
					<tr>
						<th class="formThTd">
							<?php echo $strings['Alias'];?><!--se muestra el campo Alias-->
						</th>
						<td class="formThTd"><input type="text" id="Alias" name="Alias" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Alias']?>"  maxlength="9" size="9" readonly onBlur="comprobarVacio(this) && comprobarLongitud(this,'9') && comprobarTexto(this,'9')"/>
					</tr>
                    
                    <tr>
						<th class="formThTd">
							<?php echo $strings['Horas'];?><!--se muestra el campo Horas-->
						</th>
						<td class="formThTd"><input type="text" id="Horas" name="Horas" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php echo $this->valores['Horas']?>"  maxlength="2" size="2" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'2') && comprobarTexto(this,'2') && comprobarEntero(this,0,99)"/>
					</tr>
                    
                  <!--  <tr>
						<th class="formThTd">
							<?php //echo $strings['Ruta'];?>
						</th>
						<td class="formThTd"><input type="file" id="Ruta" name="Ruta" placeholder="<?php echo $strings['Escriba aqui...']?>" value="<?php //echo $this->valores['Ruta']?>"  maxlength="60" size="60" required onBlur="comprobarVacio(this) && comprobarLongitud(this,'60') && comprobarTexto(this,'60')"/>
					</tr>
					<input type="hidden" id="ruta2" name="ruta2" value="<?php echo $this->valores['Ruta']?>"/>
					<tr>-->
                <tr>
                    <th class="formThTd">
							<?php echo $strings['Ruta'];?>
						</th>
						<td class="formThTd">
							<a href="<?php echo $this->valores['Ruta']?>" alt="<?php echo $strings['Ruta'];?>">
								<?php echo $this->valores['Ruta']?></a>
							<p style="font-size: 12px"><?php echo $strings['Seleccione un nuevo archivo si desea cambiarlo, en caso contrario, no es necesario seleccionarlo de nuevo.'];?></p>
					
							<input type="file" id="Ruta" name="Ruta" value="<?php echo $this->valores['Ruta']?>"   />
                            
                </tr>
                    <input type="hidden" id="ruta2" name="ruta2" value="<?php echo $this->valores['Ruta']?>"/>
                    
						<td colspan="2">
							<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button><!--boton para confirmar borrado-->
			</form>
						<form action='../Controllers/ENTREGA_CONTROLLER.php' method="post" style="display: inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
                            <!--boton para volver atras-->
						</form>
					</tr>
				</table>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>