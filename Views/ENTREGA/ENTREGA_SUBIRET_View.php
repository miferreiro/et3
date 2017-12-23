<?php
/*  Archivo php
	Autor: 	Brais Santos Negreira
	Fecha de creación: 24/11/2017 
	Función: vista que permite al usuario subir una entrega
*/
//Declaracion de la clase ENTREGA_SHOWET
class ENTREGA_SHOWET {
	//Constructor de la clase ENTREGA_SHOWET
	function __construct( $lista, $datos) {
		$this->lista = $lista;
		$this->datos = $datos;
		$this->render($this->lista,$this->datos);
	}
	//función que muestra la vista de subir una entrega
	function render($lista,$datos){
		$this->lista = $lista;//Tiene el nombre de atributos a mostrar en la tabla
		$this->datos = $datos;//Tiene el nombre de los valores de los atributos a mostrar
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Include del idioma a mostrar
		include '../Views/Header.php';//Include de la vista de la cabecera
        include_once '../Functions/permisosAcc.php';//Include que tiene la funcion para comprobar los permisos
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>

				<tr>
<?php				//Se recorre la lista de los nombres de atributos a mostrar
					foreach ( $lista as $atributo ) {
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
<?php
					}
		//Si tiene el permiso de subir entrega, muestra opciones
		if(permisosAcc($_SESSION['login'],8,2)==true){
?>
					<th>
						<?php echo $strings['Opciones']?>
					</th>
       <?php } ?>
				</tr>
<?php
				//Bucle que recorre el array de valores
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				<tr>
<?php				
					//Recorre el array que contiene el nombre de los atributos a mostrar
					foreach ( $lista as $atributo ) {
?>
					<td>
					
<?php 				
					//Si el atributo es fecha, se cambia el formato al formato europeo
					if ( $atributo == 'FechaIniTrabajo' ) {
						$fila[ $atributo ] = date( "d/m/Y", strtotime( $fila[ $atributo ] ) );
					} 
					//Si el atributo es fecha, se cambia el formato al formato europeo
													
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
                         

                                <?php
							//Si tiene los permisos para subir una entrega
	                       		if(permisosAcc($_SESSION['login'],8,2)==true){
									//Si la fecha de fin de trabajo es mayor que la fecha actual se permite subir la entrega
                                    if(date('d-m-Y')<$fila['FechaFinTrabajo']){
                                 ?>
                                
                                <button type="submit" name="action" value="SUBIR_ENTREGA" ><img src="../Views/icon/flecha.png"  width="20" height="20" /></button>
				                
                                <?php
                                    }
								}
                                ?>
                            
                       
						</form>
				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/ENTREGA_CONTROLLER.php?action=SUBIRET' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//Include del pie de página
		}
		}
?>