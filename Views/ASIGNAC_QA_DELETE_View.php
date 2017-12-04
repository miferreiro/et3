<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_DELETE_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de un usuario y da la opción de borrarlos
*/
class ASIGNAC_QA_DELETE {

	function __construct( $valores ) {
		$this->valores = $valores;
		$this->render( $this->valores );
	}

	function render( $valores ) {
		$this->valores = $valores;
		
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
						<?php echo $strings['LoginEvaluador'];?>
					</th>
					<td>
						<?php echo $this->valores['LoginEvaluador']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['LoginEvaluado'];?>
					</th>
					<td>
						<?php echo $this->valores['LoginEvaluado']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['AliasEvaluado'];?>
					</th>
					<td>
						<?php echo $this->valores['AliasEvaluado']?>
					</td>
				</tr>
			</table>
            
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/ASIGNAC_QA_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="IdTrabajo" value=<?php echo $this->valores['IdTrabajo'] ?> />
				<input type="hidden" name="LoginEvaluador" value=<?php echo $this->valores['LoginEvaluador'] ?> />
				<input type="hidden" name="LoginEvaluado" value=<?php echo $this->valores['LoginEvaluado'] ?> />
				<input type="hidden" name="AliasEvaluado" value=<?php echo $this->valores['AliasEvaluado'] ?> />
				
				<button type="submit" name="action" value="DELETE"><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>

			</form>
			<form action='../Controllers/ASIGNAC_QA_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
            
		include '../Views/Footer.php';
                
            }
        
	}


?>