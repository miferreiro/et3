<?php
/*  Archivo php
	Nombre: EVALUACION_ADMIN_EVALUAR_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la acción que se desea realizar en la aplicación
*/
class EVALUACION_ADMIN_EVALUAR {

	function __construct( $datos) {
		$this->datos = $datos;
		$this->render($this->datos);
	}
	
	function render($datos){
		$this->datos = $datos;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<form name="EVALUAR" action="../Controllers/EVALUACION_CONTROLLER.php" method="post"  enctype="multipart/form-data">
			<table>

<?php
				$num = 0;
				$i = 0;
				$his = $datos[$i][0];
				while($his == $datos[$i][0]){
					$his = $datos[$i][0];
					$num++;
					$i++;
				}
				$comentario = array();
				$cont = 0;
				$his = -10000;
				$total = 0;
				for ($i=0; $i < count($datos); $i++) {
				$cont++;

				//$contenido = array(); 
?>				
				
<?php
					if ($his != $datos[$i][0]) {
?>
					<tr>
						<td bgcolor="#b59438"  colspan="15"><?php echo $datos[$i][6]; ?></td>
						<tr></tr>
<?php
					}
					$his = $datos[$i][0];
?>
<?php
					if ($datos[$i][1] == 1) {
?>
							<td bgcolor="#4e8726">
<?php
					} else {
?>		
							<td bgcolor="#ff3700">					
<?php
					}
?>
						<?php echo $datos[$i][1]; ?>
					</td>
<?php
					if ($datos[$i][3] == 1) {
?>
						<td bgcolor="#4e8726">
<?php
					} else {
?>
						<td bgcolor="#ff3700">
<?php

					}
?>
						<?php echo $datos[$i][3]; ?>

					</td>
					<td>
<?php
					if ($datos[$i][3] == 1) {

?>			
						<select name="<?php echo $datos[$i][7] . $datos[$i][0] ?>" required>						        	
								<option selected="selected" value="1">1</option>
						        <option value="0">0</option>
						</select>
<?php
					} else {
?>
						<select name="<?php echo $datos[$i][7] . $datos[$i][0] ?>"required>						        	
						        <option value="1">1</option>
						        <option selected="selected" value="0">0</option>
						</select>
<?php
					}
?>
					</td>
				
<?php
				
				$contenido[$total][0] = $datos[$i][0];
				$contenido[$total][1] = $datos[$i][7];
				$contenido[$total][2] = $datos[$i][8];


				$total++;
				if(strlen($datos[$i][2]) > 0){$comentario[] = $datos[$i][2];}
				if ($cont >= $num) {
?>
				<tr></tr>
<?php
				for ($j=0; $j < count($comentario); $j++) { 
?>
					<tr>
						<td bgcolor="" colspan="15"><?php echo $comentario[$j]; ?></td>
					</tr>
<?php
				} 
?>
				<tr></tr>
				<td colspan="15">
					<textarea id="TextoHistoria" name="<?php echo $datos[$i][0] . $datos[$i][8] ?>" placeholder="<?php echo $strings['Escriba aqui...']?>" maxlength="300" cols="50" rows="7"   onBlur="validarComentIncorrectoP(this,'300')" ><?php echo $datos[$i][4]?></textarea>
<?php
				if ($datos[$i][5] == 1) {
?>
					<td bgcolor="#4e8726">
<?php
				} else {
?>
					<td bgcolor="#ff3700">
<?php
				}
?>

					<?php echo $datos[$i][5] ?>
				<td>
<?php
					if ($datos[$i][5] == 1) {
?>
						<select name="<?php echo $datos[$i][0] ?>" required>						        	
								<option selected="selected" value="1">1</option>
						        <option value="0">0</option>
						</select>
						
<?php
					} else {
?>
						<select name="<?php echo $datos[$i][0] ?>" required>						        	
						        <option value="1">1</option>
						        <option selected="selected" value="0">0</option>
						</select>
						
<?php
					}
?>
				</td>
				</td>
				</td>
				</tr>
<?php
					$comentario = array();
					$cont = 0;
				}
				}
				$_SESSION['contenido'] = $contenido;
?>
				
				</table>
				<table>
				<input type="hidden" name="IdTrabajo" value="<?php echo $datos[0][9] ?>">
				<button type="submit" name="action" value="EVALUAR"><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			<form action='../Controllers/EVALUACION_CONTROLLER.php' method="get">
				<button type="submit" name="action" value="SELECT_QA"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
			</table>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>