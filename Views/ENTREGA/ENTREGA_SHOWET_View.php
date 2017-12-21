<?php
/*  Archivo php
	Nombre: TRABAJO_SHOWALL_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la acción que se desea realizar en la aplicación
*/
class ENTREGA_SHOWET {

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
        include_once '../Functions/permisosAcc.php';
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
		if(permisosAcc($_SESSION['login'],8,2)==true){
?>
					<th>
						<?php echo $strings['Opciones']?>
					</th>
       <?php } ?>
				</tr>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) {
?>
					<td>
<?php 				if ( $atributo == 'FechaIniTrabajo' ) {
						$fila[ $atributo ] = date( "d/m/Y", strtotime( $fila[ $atributo ] ) );
					} 
					if ( $atributo == 'FechaFinTrabajo' ) {
							$fila[ $atributo ] = date( "d/m/Y", strtotime( $fila[ $atributo ] ) );
					} 
					
						echo $fila[ $atributo ];
			
?>
					</td>

<?php
					}
?>
					<td>

						<form action="../Controllers/ENTREGA_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
                         
                            <td>
                                <?php
	                       		if(permisosAcc($_SESSION['login'],8,2)==true){
                                    if(date('d-m-Y')<$fila['FechaFinTrabajo']){
                                 ?>
                                
                                <button type="submit" name="action" value="SUBIR_ENTREGA" ><img src="../Views/icon/flecha.png"  width="20" height="20" /></button>
				                
                                <?php
                                    }
								}
                                ?>
                            
                            </td>
						</form>
				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/ENTREGA_CONTROLLER.php' method="post">
				<button type="submit" name="action" value="SUBIRETS" ><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>