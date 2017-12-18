<?php
/*  Archivo php
	Nombre: ACCION_SHOWALL_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la acción que se desea realizar en la aplicación
*/
class CORRECION_ENTREGA_RESULTADO {

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
			<table border>
				
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
				$cont=0;
		        $Id;
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				
                <tr>
                   
                    
<?php
					foreach ( $lista as $atributo ) {
?>
                    
<?php                    
                    if($atributo == 'ComentIncorrectoP'){
?>
            
                        <td><textarea maxlength="300" cols="20" rows="7" readonly>
<?php                    
                            
                           echo $fila[ $atributo ]; 
							if($cont==1){
							$Id= $fila[ 'IdTrabajo' ];
						}
?>                       
                        </textarea></td>
<?php                       
                    }
                        
                    else{
                        
                        
?>
                                
<?php
                                  
                     
?>                 
                  
                    
					<td>
<?php 
							echo $fila[ $atributo ];
						    if($cont==1){
							$Id= $fila[ 'IdTrabajo' ];
						}
                        
?>
					</td>
                    
<?php
                       
                        }
                        
					}
?>
					<td>

				</tr>
<?php
				$cont++;
				}
?>
			</table>
			<form action='../Controllers/CORRECION_ENTREGA_CONTROLLER.php' method="post">
			    <input type="hidden" name="IdTrabajo" value="<?php echo $Id; ?>">
				<button type="submit" name="action" value="RESULTADO"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>