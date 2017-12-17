<?php
/*  Archivo php
	Nombre: TRABAJO_DELETE_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de una acción y da la opción de borrarlos
*/
class TRABAJO_DELETE {

	function __construct( $valores, $dependencias,  $dependencias2,  $dependencias3,  $dependencias4,  $dependencias5 ) {
		$this->valores = $valores;
		$this->dependencias = $dependencias;
		$this->dependencias2 = $dependencias2;
		$this->dependencias3 = $dependencias3;
		$this->dependencias4 = $dependencias4;
		$this->dependencias5 = $dependencias5;
		
		$this->render( $this->valores, $this->dependencias, $this->dependencias2, $this->dependencias3, $this->dependencias4, $this->dependencias5);
	}

	function render( $valores, $dependencias,  $dependencias2,  $dependencias3,  $dependencias4,  $dependencias5 ) {
		$this->valores = $valores;
		$this->dependencias = $dependencias;
		$this->dependencias2 = $dependencias2;
		$this->dependencias3 = $dependencias3;
		$this->dependencias4 = $dependencias4;
		$this->dependencias5 = $dependencias5;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de borrado'];?>
			</h2>
			<table>
				<tr>
					<th>
						<?php echo $strings['IdTrabajo'];?>
					</th>
					<td>
						<?php echo $this->valores['IdTrabajo']?>
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['NombreTrabajo'];?>
					</th>
					<td>
						<?php echo $this->valores['NombreTrabajo']?>
					</td>
				</tr>
				
				<tr>
					<th>
						<?php echo $strings['FechaIniTrabajo'];?>
					</th>
					<td>
						<?php echo $this->valores['FechaIniTrabajo']?>
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['FechaFinTrabajo'];?>
					</th>
					<td>
						<?php echo $this->valores['FechaFinTrabajo']?>
					</td>
				</tr>
                
                
                   <tr>
					<th>
						<?php echo $strings['PorcentajeNota'];?>
					</th>
					<td>
						<?php echo $this->valores['PorcentajeNota']?>
					</td>
				</tr>
				
			</table>
            <br>
            <br>
            
            <?php
            if($dependencias != null || $dependencias2 != null || $dependencias3 != null || $dependencias4 != null || $dependencias5 != null ){
                
                 echo $strings['Debe eliminar antes todas las dependencias para poder borrar este dato.'];
                 ?>
                <br>
                <br>
            <?php
            
            if($dependencias != null){
            ?>
            
            <table>
                 <th>
                        <?php echo $strings['NombreTrabajo'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['LoginEvaluador'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['AliasEvaluado'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['IdHistoria'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['CorrectoA'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['ComenIncorrectoA'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['CorrectoP'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['ComentIncorrectoP'];?>
                    </th>
                
                     <th>
                        <?php echo $strings['OK'];?>
                    </th>
            <?php
				while ( $fila = mysqli_fetch_array( $dependencias ) ) {
            ?>
			
            <tr>

				    <td>
                        <?php 
				        echo $fila['NombreTrabajo'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['LoginEvaluador'];

                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['AliasEvaluado'];

                        ?>
					</td>
                
                    <td>
                        <?php 
				        echo $fila['IdHistoria'];
                            
                        ?>
					</td>
                
                    <td>
                        <?php 
				        echo $fila['CorrectoA'];
                            
                        ?>
					</td>
                
                    <td>
                        <?php 
				        echo $fila['ComenIncorrectoA'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
				        echo $fila['CorrectoP'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
				        echo $fila['ComentIncorrectoP'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
				        echo $fila['OK'];
                            
                        ?>
					</td>

				</tr>
                
                <?php
				}
                ?>
                </table>
            <?php
            }
                
            
            if($dependencias2 != null){
            ?>
            <table>
                 <th>
                        <?php echo $strings['NombreTrabajo'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['IdHistoria'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['TextoHistoria'];?>
                    </th>
                
                    
            <?php
				while ( $fila = mysqli_fetch_array( $dependencias2 ) ) {
            ?>
			
            <tr>

				    <td>
                        <?php 
				        echo $fila['NombreTrabajo'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['IdHistoria'];

                        ?>
					</td>
                    <td>
                        <?php 
				        echo $fila['TextoHistoria'];
                            
                        ?>
                    </td>


				</tr>
                
                <?php
				}
                ?>
                </table>
            
            <?php
            }
                
            
            if($dependencias3 != null){
            ?>
            
            <table>
                    <th>
                        <?php echo $strings['login'];?>
                    </th>
                    <th>
                        <?php echo $strings['NombreTrabajo'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['NotaTrabajo'];?>
                    </th>
                
            <?php
				while ( $fila = mysqli_fetch_array( $dependencias3 ) ) {
            ?>
			
            <tr>

				    <td>
                        <?php 
				        echo $fila['login'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['NombreTrabajo'];

                        ?>
					</td>
                    <td>
                        <?php 
				        echo $fila['NotaTrabajo'];
                            
                        ?>
					</td>
				</tr>
                
                <?php
				}
                ?>
                </table>
            <?php
                    
            }
                
            
            if($dependencias4 != null){
            ?>
            
            <table>
                    <th>
                        <?php echo $strings['NombreTrabajo'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['LoginEvaluador'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['LoginEvaluado'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['AliasEvaluado'];?>
                    </th>
                
            <?php
				while ( $fila = mysqli_fetch_array( $dependencias4 ) ) {
            ?>
			
            <tr>

				    <td>
                        <?php 
				        echo $fila['NombreTrabajo'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['LoginEvaluador'];

                        ?>
					</td>
                    <td>
                        <?php 
				        echo $fila['LoginEvaluado'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['AliasEvaluado'];

                        ?>
					</td>

				</tr>
                
                <?php
				}
                ?>
                </table>
            <?php
            }
                
            
            if($dependencias5 != null){
            ?>
            
            <table>
                    <th>
                        <?php echo $strings['USUARIO_ENTREGA'];?>
                    </th>
                    <th>
                        <?php echo $strings['NombreTrabajo'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['ALIAS'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['HORAS'];?>
                    </th>
                
                    <th>
                        <?php echo $strings['RUTA'];?>
                    </th>
                
            <?php
				while ( $fila = mysqli_fetch_array( $dependencias5 ) ) {
            ?>
			
           <tr>

				    <td>
                        <?php 
				        echo $fila['login'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['NombreTrabajo'];

                        ?>
					</td>
                    <td>
                        <?php 
				        echo $fila['Alias'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['Horas'];

                        ?>
					</td>
                
                    <td>
                        <?php 
							
                        echo $fila['Ruta'];

                        ?>
					</td>


				</tr>
                
                <?php
				}
                ?>
                </table>
                <?php
            }
                ?>
            <form action='../Controllers/TRABAJO_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
            
            <?php
            }
                
                
               if($dependencias == null && $dependencias2 == null && $dependencias3 == null && $dependencias4 == null && $dependencias5 == null ){
                    
              ?>  
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/TRABAJO_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="IdTrabajo" value="<?php echo $this->valores['IdTrabajo'] ?>" />
				<input type="hidden" name="NombreTrabajo" value="<?php echo $this->valores['NombreTrabajo'] ?>" />
				<input type="hidden" name="FechaIniTrabajo" value="<?php echo $this->valores['FechaIniTrabajo'] ?>" />
				<input type="hidden" name="FechaFinTrabajo" value="<?php echo $this->valores['FechaFinTrabajo'] ?>" />
                <input type="hidden" name="PorcentajeNota" value="<?php echo $this->valores['PorcentajeNota'] ?>" />
				<!--<input id="DELETE" name="action" value="DELETE" type="image" src="../Views/icon/confirmar.png" width="32" height="32" alt="<?php //echo $strings['Confirmar'] ?>">-->
                <button type="submit" id="DELETE" name="action" value="DELETE" ><img src="../Views/icon/confirmar.png" width="32" height="32" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/TRABAJO_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
               }
		include '../Views/Footer.php';
               
	}
}

?>