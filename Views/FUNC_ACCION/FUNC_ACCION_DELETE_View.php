<?php
/*  Archivo php
	Nombre: FUNC_ACCION_DELETE_View.php
	Fecha de creación: 26/11/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de una accion de una Funcionalidad y da la opción de borrarlos
*/
class FUNC_ACCION_DELETE {

	function __construct( $valores, $dependencias ) {
		$this->valores = $valores;
		$this->dependencias = $dependencias;
		$this->render( $this->valores, $this->dependencias );
	}

	function render( $valores, $dependencias ) {
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
						<?php echo $strings['NombreFuncionalidad'];?>
					</th>
					<td>
						<?php echo $this->valores['NombreFuncionalidad']?>
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['NombreAccion'];?>
					</th>
					<td>
						<?php echo $this->valores['NombreAccion']?>
					</td>
				</tr>
				
			</table>
            
            <?php
            
            if($dependencias != null){
            
				while ( $fila = mysqli_fetch_array( $dependencias ) ) {
            ?>
			<table>
            <tr>

				    <td>
                        <?php 
				        echo $fila['IdFuncionalidad'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['IdAccion'];

                        ?>
					</td>

				</tr>
                </table>
                <?php
				}
            }
        
            else{
                
           
              ?>  
            
            
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?']; ?>
			</p>
			<form action="../Controllers/FUNC_ACCION_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="IdFuncionalidad" value=<?php echo $this->valores['IdFuncionalidad'] ?> />
				<input type="hidden" name="IdAccion" value=<?php echo $this->valores['IdAccion'] ?> />
				
				<button type="submit" name="action" value="DELETE" width="32" height="32"><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/FUNC_ACCION_CONTROLLER.php' method="post" style="display: inline">
				<input type="hidden" name="IdFuncionalidad" value=<?php echo $this->valores['IdFuncionalidad'] ?> />
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
            }
		include '../Views/Footer.php';
            
	}
}

?>