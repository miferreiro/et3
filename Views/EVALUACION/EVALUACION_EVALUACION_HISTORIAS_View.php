<?php
    //Se muestra una tabla SHOWALL conto todas las entregas y iconos para añadir,insertar,borrar,buscar y buscar en detalle.
    //Fecha de creación:28/11/2017

class EVALUACION_SELECT_ALL_QA {

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
		include_once '../Functions/comprobarAdministrador.php';
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
						<?php echo $strings[$atributo]?><!--se muestra todos los campos-->
					</th>
<?php
					}
?>
					<th colspan="2" >
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
                            if($atributo == 'Ruta'){
                                ?>
                        
                                <a href="<?php echo $fila[$atributo] ?>"><?php echo $fila[$atributo] ?></a>
                        
                                <?php
                            }
                        else
							echo $fila[ $atributo ];//se muestra el valor de todos los campos
?>                      
					</td>
<?php
					}
?>
					<td>
						<form action="../Controllers/EVALUACION_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="LoginEvaluado" value="<?php echo $fila['login']; ?>">
                            <input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
                            <input type="hidden" name="AliasEvaluado" value="<?php echo $fila['Alias']; ?>">
                        <td>
								<button type="submit" name="action" value="EVALUARADMIN" ><img src="../Views/icon/evaluar.png" alt="<?php echo $strings['Ver en detalle']?>" width="32" height="32"/></button>                             
                                <!--si pulsas este boton ves la vista SHOWCURRENT-->
                        </td>
                            
						</form>

				</tr>
<?php
				}
?>
			</table>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>

    
