<?php
/* 
	Fecha de creación: 7/12/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la acción que se desea realizar en la aplicación
*/
class CORRECION_ENTREGA {

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
				<?php echo $strings['Ver los resultados de las entregas'];?>
			</h2>
			<table>
				<tr>
<?php
					
?>
					<th>
						<?php echo $strings['login']?>
					</th>
                    
					<th>
						<?php echo $strings['IdTrabajo']?>
					</th>
<?php
					
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
			
?>
                    
				    <td><?php echo $fila[0] ?></td>
                    <td><?php echo $fila[2] ?></td>
                    
						<form action="../Controllers/CORRECION_ENTREGA_CONTROLLER.php" method="get" style="display:inline" >
                            <input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
                              <input type="hidden" name="Entrega" value="<?php echo $fila[0]; ?>">
                            <input type="hidden" name="login" value="<?php echo $fila['login']; ?>">
							<td>
                                <button type="submit" name="action" value="RESULTADOS" ><img src="../Views/icon/flecha.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
                            </td>
						</form>

				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/CORRECION_ENTREGA_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>