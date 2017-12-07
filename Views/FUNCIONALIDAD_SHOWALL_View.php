<?php
/*  Archivo php
	Nombre: FUNCIONALIDAD_SHOWALL_View.php
	Fecha de creación: 26/11/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la funcionalidad que se desea realizar en la aplicación
*/
class FUNCIONALIDAD_SHOWALL {

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
					<form action='../Controllers/FUNCIONALIDAD_CONTROLLER.php'>
						<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>
						<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="AÑADIR" /></button>
					</form>
				</caption>
				<tr>
<?php
					foreach ( $lista as $atributo ) {
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
<?php
					}
?>
					<th colspan="4" >
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
							echo $fila[ $atributo ];

?>
					</td>
<?php
					}
?>
					<td>
						<form action="../Controllers/FUNCIONALIDAD_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdFuncionalidad" value="<?php echo $fila['IdFuncionalidad']; ?>">
								<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
					<td>
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
					<td>
								<button type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
						</form>

						<form action="../Controllers/FUNC_ACCION_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdFuncionalidad" value="<?php echo $fila['IdFuncionalidad']; ?>">
								<button type="submit" name="action" value="SHOWALL" ><img src="../Views/icon/accion.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20" /></button>
						</form>

				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/FUNCIONALIDAD_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>