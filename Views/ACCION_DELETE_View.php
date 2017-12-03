<?php
/*  Archivo php
	Nombre: ACCION_DELETE_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de una acción y da la opción de borrarlos
*/
class ACCION_DELETE {

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
						<?php echo $strings['IdAccion'];?>
					</th>
					<td>
						<?php echo $this->valores['IdAccion']?>
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
				
				<tr>
					<th>
						<?php echo $strings['DescripAccion'];?>
					</th>
					<td>
						<?php echo $this->valores['DescripAccion']?>
					</td>
				</tr>
				
			</table>
            
            <?php
            
            if($dependencias != null){
                if(array_key_exists('FUNC_ACCION', $dependencias)){
            ?>
                    <td>FUNC_ACCION</td>
                    <td><?php echo $dependencias['FUNC_ACCION']['IdFuncionalidad'] ?></td>
				    <td><?php echo $dependencias['FUNC_ACCION']['IdAccion'] ?></td>
            <?php
                }
                  if(array_key_exists('FUNC_ACCION', $dependencias)){
            ?>
                    <td>FUNC_ACCION</td>
                    <td><?php echo $dependencias['PERMISO']['IdFuncionalidad'] ?></td>
				    <td><?php echo $dependencias['PERMISO']['IdAccion'] ?></td>
            <?php
                }

                }
            else{
              ?>  
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/ACCION_CONTROLLER.php" method="POST" style="display: inline">
				<input type="hidden" name="IdAccion" value="<?php echo $this->valores['IdAccion'] ?>" />
				<input type="hidden" name="NombreAccion" value="<?php echo $this->valores['NombreAccion'] ?>" />
				<input type="hidden" name="DescripAccion" value="<?php echo $this->valores['DescripAccion'] ?>" />
				
				<button type="submit" id="DELETE" name="action" value="DELETE"><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/ACCION_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
            }
		include '../Views/Footer.php';
	}
}

?>