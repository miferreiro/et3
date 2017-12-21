<?php
/*  Archivo php
	Nombre: ACCION_SHOWALL_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la acción que se desea realizar en la aplicación
*/
class CORRECION_QA_RESULTADO {

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
				<?php echo $strings['Ver los resultados de las QAs'];?>
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

?>
					</td>
<?php
					}
?>
					<td>
						<form action="../Controllers/EVALUACION_CONTROLLER.php" method="get" style="display:inline" >
                             <input type="hidden" name="LoginEvaluador" value="<?php echo $fila['LoginEvaluador']; ?>">
                             <input type="hidden" name="AliasEvaluado" value="<?php echo $fila['AliasEvaluado']; ?>">
                             <input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
                            
							<td>
                                <button type="submit" name="action" value="RESULTADOS_QAS" ><img src="../Views/icon/flecha.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
                            </td>
						</form>

				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/EVALUACION_CONTROLLER?action=MOSTRAR_CORRECCION_QA' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>