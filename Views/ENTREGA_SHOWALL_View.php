<?php
    //Se muestra una tabla SHOWALL conto todas las entregas y iconos para añadir,insertar,borrar,buscar y buscar en detalle.
    //Fecha de creación:28/11/2017

class USU_GRUPO_SHOWALL {

	function __construct( $lista, $datos) {
		$this->lista = $lista;
		$this->datos = $datos;
		$this->render($this->lista,$this->datos);
	}
	
	function render($lista,$datos){
		$this->lista = $lista;
		$this->datos = $datos;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<caption style="margin-bottom:10px;">
					<form action='../Controllers/ENTREGA_CONTROLLER.php'>
						<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>
                        <!--este boton te envía al formualrio SEARCH-->
						<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="AÑADIR" /></button>
                        <!--este boton te envia al formualrio ADD-->
					</form>
				</caption>
				<tr>
<?php
					foreach ( $lista as $atributo ) {
?>
					<th>
						<?php echo $strings[$atributo]?><!--se muestra todos los campos-->
					</th>
<?php
					}
?>
					<th colspan="3" >
						<?php echo $strings['Opciones']?>
					</th>
				</tr>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) {
?>
					<td>
<?php 

							echo $fila[ $atributo ];//se muestra el valor de todos los campos
?>
					</td>
<?php
					}
?>
					<td>
						<form action="../Controllers/ENTREGA_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="login" value="<?php echo $fila['login']; ?>">
                            <input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
								<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button><!--con este boton pulsas para ver la vista EDIT-->
					<td>
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
                                <!--si pulsas este boton ves la vista DELETE-->
					<td>
								<button type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
                                <!--si pulsas este boton ves la vista SHOWCURRENT-->
						</form>

				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/ENTREGA_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
                <!--si pulsas este boton vas atras -->
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>

    






















