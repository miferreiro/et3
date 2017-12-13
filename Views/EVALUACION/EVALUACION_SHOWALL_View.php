<?php
/*  Archivo php
	Nombre: EVALUACION_SHOWALL_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la acción que se desea realizar en la aplicación
*/
class EVALUACION_SHOWALL {

	function __construct( $lista, $datos) {
		$this->lista = $lista;
		$this->datos = $datos;
		$this->render($this->lista,$this->datos);
	}
	
	function render($lista,$datos){
		$this->lista = $lista;
		$this->datos = $datos;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
        include_once '../Functions/permisosAcc.php';

?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<caption style="margin-bottom:10px;">
					<form action='../Controllers/EVALUACION_CONTROLLER.php'>
<?php if(permisosAcc($_SESSION['login'],12,3)==true){ ?>
						<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>
<?php }
	  if(permisosAcc($_SESSION['login'],12,0)==true){ 
		?>
						<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="AÑADIR" /></button>
<?php } ?>
					</form>
				</caption>
				<tr>
<?php
					foreach ( $lista as $atributo ) {
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
<?php
					}
		if((permisosAcc($_SESSION['login'],12,1)==true)||(permisosAcc($_SESSION['login'],12,2)==true)||        (permisosAcc($_SESSION['login'],12,4)==true)){ 
?>
					<th colspan="3" >
						<?php echo $strings['Opciones']?>
					</th>
<?php } ?>
				</tr>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) {
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) {
?>
					<td>
<?php 
							echo $fila[ $atributo ];

?>
					</td>
<?php
					}
?>
					<td>
						<form action="../Controllers/EVALUACION_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
                            <input type="hidden" name="LoginEvaluador" value="<?php echo $fila['LoginEvaluador']; ?>">
                            <input type="hidden" name="AliasEvaluado" value="<?php echo $fila['AliasEvaluado']; ?>">
                            <input type="hidden" name="IdHistoria" value="<?php echo $fila['IdHistoria']; ?>">
<?php         if(permisosAcc($_SESSION['login'],12,2)==true){ ?>
								<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
<?php } ?>
					<td>
<?php         if(permisosAcc($_SESSION['login'],12,1)==true){ ?>
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
<?php } ?>
					<td>
<?php         if(permisosAcc($_SESSION['login'],12,4)==true){ ?>
								<button type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
<?php } ?>
						</form>

				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/EVALUACION_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>