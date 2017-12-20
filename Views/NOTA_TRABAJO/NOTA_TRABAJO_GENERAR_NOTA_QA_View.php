<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_GENERAR_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una acción a la base de datos
*/
class GENERAR_NOTA_QA {

	function __construct($datos) {
		$this->datos = $datos;
		$this->render($this->datos);

	}

	function render($datos) {
		$this->datos = $datos;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['GENERACIÓN NOTAS QA'];?>
			</h2>
			<form name="GENERAR_NOTA_QA" value="GENERAR_NOTA_QA" action="../Controllers/NOTA_TRABAJO_CONTROLLER.php" method="post" enctype="multipart/form-data">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreTrabajo'];?>
						</th>
                  <td class="formThTd">
                   <select id="IdTrabajo" name="IdTrabajo" required>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				<option value="<?php echo $fila[ 'IdTrabajo' ]?>">

<?php 
			//echo $fila[ 'NombreGrupo' ].'_'.$fila['IdGrupo'];
					echo $fila['NombreTrabajo'];
?>		
               							

               </option>
	
<?php } ?>					
					</select>
				</td>
					</tr>					
				</table>
						

							<button type="submit" name="action" value="GENERAR_NOTA_QA"><img src="../Views/icon/generar.png" alt="<?php echo $strings['Confirmar formulario']?>" width="32" height="32" /></button>
                   
			
						<form action='../Controllers/NOTA_TRABAJO_CONTROLLER.php' method="post" style="display: inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
					
				
               </form>   
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>