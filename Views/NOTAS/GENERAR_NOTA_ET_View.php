<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_GENERAR_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de el formulario de añadir(add) realizada con una clase donde se muestran todos los campos a rellenar para añadir una acción a la base de datos
*/
class GENERAR_NOTA_ET {

	function __construct() {
		$this->render();
	}

	function render() {
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['GENERACIÓN NOTAS ENTREGA'];?>
			</h2>
			<form name="NOTA_ET" value="NOTA_ET" action="../Controllers/NOTAS_CONTROLLER.php" method="post" enctype="multipart/form-data">
				<table>
					<tr>
						<th class="formThTd">
							<?php echo $strings['IdTrabajo'];?><!--se muestra el campo Horas-->
						</th>
						<td class="formThTd"><input type="text" id="IdTrabajo" name="IdTrabajo" placeholder="<?php echo $strings['Escriba aqui...']?>" value="" maxlength="10" size="10" required/>
					</tr>
					

					<tr>
						
                            
                    
							<button type="submit" name="action" value="NOTA_ENTREGA"><img src="../Views/icon/generar.png" alt="<?php echo $strings['Confirmar formulario']?>" width="32" height="32" /></button>
                   
			
						<form action='../Controllers/NOTAS_CONTROLLER.php' method="post" style="display: inline">
							<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
						</form>
					</tr>
				</table>
                </form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>