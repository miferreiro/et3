<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_HISTORIAS_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una acción a la base de datos
*/
//Clase Asignac_qa_historias que contiene la vista para poder generar las historias por cada qa	
class ASIGNAC_QA_HISTORIAS {

	function __construct($valores) {
		//$valores variable que almacena un array con la informacion de las qas existentes para asignar las historias
		$this->render($valores);
	}
	//Constructor de la clase
	function render($QA) {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//Incluye el contenido de los strings necesarios para el multiidioma
		include '../Views/Header.php';//Incluye el contenido del header
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['GENERACIÓN AUTOMÁTICA DE HISTORIAS'];?>
			</h2>
			<form name="ASIGNAC_QA" action="../Controllers/ASIGNAC_QA_CONTROLLER.php" method="post" enctype="multipart/form-data">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['QA'];?>
						</th>
						<td class="formThTd">
							<select name="IdTrabajo">						        
								<?php
								//Bucle que recorre el array las posibles QA para generer las historias
								for ($i=0; $i < count($QA); $i++) { 
								?>
								<option value="<?php echo $QA[$i][0] ?>"><?php echo $QA[$i][1] ?></option>
						        <?php
						        }
						        ?>
							</select>
					</tr>

					<tr>
						<td colspan="2">
							<button type="submit" name="action" value="HISTORIAS"><img src="../Views/icon/generar.png" alt="<?php echo $strings['Confirmar formulario']?>" width="32" height="32" /></button>
			</form>
						<form action='../Controllers/ASIGNAC_QA_CONTROLLER.php' method="post" style="display: inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
					</tr>
				</table>
		</div>
<?php
		include '../Views/Footer.php';//Incluye el contenido del pie
		}
		}
?>