<?php
/*  Archivo php
	Nombre: EVALUACION_SHOWALL_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la acción que se desea realizar en la aplicación
*/
class EVALUACION_USUARIO_EVALUAR {

	function __construct( $lista, $datos) {
		$this->lista = $lista;
		$this->datos = $datos;
		$this->render($this->lista,$this->datos);
	}
	
	function render($lista,$datos){
		$this->lista = $lista;
		$this->datos = $datos;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include_once '../Functions/permisosAcc.php';
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
		if(permisosAcc($_SESSION['login'],12,12)==true){
?>
					<th colspan="3" >
						<?php echo $strings['Opciones']?>
					</th>
<?php } ?>
				</tr>
				<tr><td></td></tr>
				<tr></tr>
<?php
				$his = -100000;
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				<tr>
<?php
					if ($fila['IdHistoria'] != $his) {
?>
						<td bgcolor="#b59438" colspan="6"><?php echo $fila['IdHistoria'] . ". " . $fila['TextoHistoria']; ?></td>
						<tr></tr>
<?php
					}
					$his = $fila['IdHistoria'];
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
						<form action="../Controllers/EVALUACION_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
                            <input type="hidden" name="LoginEvaluador" value="<?php echo $fila['LoginEvaluador']; ?>">
                            <input type="hidden" name="AliasEvaluado" value="<?php echo $fila['AliasEvaluado']; ?>">
                            <input type="hidden" name="IdHistoria" value="<?php echo $fila['IdHistoria']; ?>">
                            <td>
							<?php if(permisosAcc($_SESSION['login'],12,12)==true){ ?>
								<button type="submit" name="action" value="EDITUSU" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
			                <?php } ?>
				            </td>
						</form>

				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/EVALUACION_CONTROLLER.php' method="get">
				<button type="submit" name="action" value="EVALUACION_HISTORIAS_ASIGNADAS"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>