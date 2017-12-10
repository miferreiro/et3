<?php
/*  Archivo php
	Nombre: FUNC_ACCION_SHOWALL_View.php
	Fecha de creación: 26/11/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la accion de una funcionalidad que se desea realizar en la aplicación
*/
class FUNC_ACCION_SHOWALL {

	function __construct( $lista, $datos, $name) {
		$this->lista = $lista;
		$this->datos = $datos;
		$this->render($this->lista,$this->datos,$name);
	}
	
	function render($lista,$datos,$name){
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
							echo $fila[ $atributo ];
							$log=$fila['IdFuncionalidad'];
							
?>						
					</td>
<?php
					}
?>
					<td>
						<form action="../Controllers/FUNC_ACCION_CONTROLLER.php" method="get" style="display:inline" >
						    <input type="hidden" name="IdFuncionalidad" value="<?php echo $fila['IdFuncionalidad']; ?>">
							<input type="hidden" name="IdAccion" value="<?php echo $fila['IdAccion']; ?>">
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
					
						</form>

				</tr>
<?php
				}
?>
			<caption style="margin-bottom:10px;">
					<form action='../Controllers/FUNC_ACCION_CONTROLLER.php'>
						<input type="hidden" name="IdFuncionalidad" value="<?php echo $name[0][0];?>">
						<input type="hidden" name="NombreFuncionalidad" value="<?php echo $name[0][1];?>">
						<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="AÑADIR" /></button>
					</form>
				</caption>
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