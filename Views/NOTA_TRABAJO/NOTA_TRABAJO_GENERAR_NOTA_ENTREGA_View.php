<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_GENERAR_View.php
	Autor: 	Alejandro Vila
    Fecha de creación: 12/12/2017 
	Función: se encarga de generar las notas d elas entregas
*/

 //esta clase es la encargada de generar las notas de las entregas
class GENERAR_NOTA_ET {
//es el constructor de la clase  GENERAR_NOTA_ET
	function __construct($datos) { 
		$this->datos = $datos;//pasamos todos los Idtrabajo que en este caso serán entregas
		$this->render($this->datos);//funcion que mostrará la vista para generar la nota de las entregas

	}
//funcion que mostrará la vista para generar la nota de las entregas
	function render($datos) {
		$this->datos = $datos;//pasamos todos los Idtrabajo que en este caso serán entregas
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['GENERACIÓN NOTAS ENTREGA'];?>
			</h2>
			<form name="GENERAR_NOTA_ENTREGA" value="GENERAR_NOTA_ENTREGA" action="../Controllers/NOTA_TRABAJO_CONTROLLER.php" method="post" enctype="multipart/form-data">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['NombreTrabajo'];?>
						</th>
                  <td class="formThTd">
                   <select id="IdTrabajo" name="IdTrabajo" required>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) { //este bucle se va a repetir hasta que no se recorran todos los trabajos que sean ET
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
                            
                    
							<button type="submit" name="action" value="GENERAR_NOTA_ENTREGA"><img src="../Views/icon/generar.png" alt="<?php echo $strings['Confirmar formulario']?>" width="32" height="32" /></button>
                   
			
						<form action='../Controllers/NOTA_TRABAJO_CONTROLLER.php' method="post" style="display: inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
					</tr>

                </form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la página
		}
		}
?>