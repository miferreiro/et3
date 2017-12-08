<?php
/* 
	Fecha de creación: 4/12/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar mostrar los permisos que existen
*/
class PERMISO_ASSIGN {

	function __construct( $lista, $datos, $DatosGrupo) {
		$this->lista = $lista;
		$this->datos = $datos;
		$this->render($this->lista,$this->datos,$DatosGrupo);
	}
	
	function render($lista,$datos,$DatosGrupo){
		$this->lista = $lista;
		$this->datos = $datos;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Gestión de permisos'];?>
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
						<form action="../Controllers/PERMISO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdGrupo" value="<?php echo $fila['IdGrupo']; ?>">
							<input type="hidden" name="IdFuncionalidad" value="<?php echo $fila['IdFuncionalidad']; ?>">
							<input type="hidden" name="IdAccion" value="<?php echo $fila['IdAccion']; ?>">
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
						</form>
				</tr>
<?php
				}
?>
			<caption style="margin-bottom:10px;">
					<form action='../Controllers/PERMISO_CONTROLLER.php'>
						<input type="hidden" name="IdGrupo" value="<?php echo $DatosGrupo[0][0]?>">
						<input type="hidden" name="NombreGrupo" value="<?php echo $DatosGrupo[0][1]?>">
						<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="BUSCAR" /></button>
					</form>
				</caption>
			</table>
			<form action='../Controllers/GRUPO_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>