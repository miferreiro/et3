<?php
/* 
	Fecha de creación: 2/12/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los valores de una historia y da la opción de borrarlos
*/
class HISTORIA_DELETE {

	function __construct( $valores, $dependencias) {
		$this->valores = $valores;
		$this->dependencias = $dependencias;
		
		$this->render( $this->valores, $this->dependencias);
	}

	function render( $valores, $dependencias) {
		$this->valores = $valores;
		$this->dependencias = $dependencias;
		
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
						<?php echo $strings['IdHistoria'];?>
					</th>
					<td>
						<?php echo $this->valores['IdHistoria']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['TextoHistoria'];?>
					</th>
					<td>
						<?php echo $this->valores['TextoHistoria']?>
					</td>
				</tr>
	
			</table>
			<br>
			<br>
            
            <?php
       
            
            if($dependencias != null){
            
            
            echo $strings['Debe eliminar antes todas las dependencias para poder borrar este dato.'];
                ?>
                <br>
                <br>
            
            
            <table>
                    <th>
                        EVALUACIÓN
                    </th>
            <?php
				while ( $fila = mysqli_fetch_array( $dependencias ) ) {
            ?>
			
            <tr>

				    <td>
                        <?php 
				        echo $fila['IdTrabajo'];
                            
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
            
         
                ?>
           
            
            <form action='../Controllers/HISTORIA_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
            <?php
    }
        
                
               else{
                    
              ?>  


			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/HISTORIA_CONTROLLER.php"  method="post" style="display: inline">
				<input type="hidden" name="IdTrabajo" value="<?php echo $valores['IdTrabajo'] ?>" />
				<input type="hidden" name="IdHistoria" value="<?php echo $valores['IdHistoria'] ?>" />
				<input type="hidden" name="TextoHistoria" value="<?php echo $valores['TextoHistoria'] ?>" />
				<input id="DELETE" name="action" value="DELETE" type="image" src="../Views/icon/confirmar.png" width="32" height="32" alt="<?php echo $strings['Confirmar'] ?>">
			</form>
			<form action='../Controllers/HISTORIA_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
               }
		include '../Views/Footer.php';
            
	}
}

?>