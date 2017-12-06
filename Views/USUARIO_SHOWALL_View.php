<?php
/*  Archivo php
	Nombre: USUARIOS_SHOWALL_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la acción que se desea realizar en la aplicación
*/
class USUARIO_SHOWALL {

	function __construct( $lista, $datos, $PERMISO) {
		$this->lista = $lista;
		$this->datos = $datos;
		$this->PERMISO = $PERMISO;
		$this->render($this->lista,$this->datos,$this->PERMISO);
	}
	
	function render($lista,$datos,$PERMISO){
		$this->lista = $lista;
		$this->datos = $datos;
		$this->PERMISO = $PERMISO;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';

$ADD=false;	
$EDIT=false;	
$SEARCH=false;	
$DELETE=false;	
$SHOW=false;
$GESTUSU=false;
$GESTGRUP=false;
$GESTFUNC=false;
$GESTACC=false;
$GESTPERM=false;		
$GESTQAS=false;		
$GESTENTR=false;		
$GESTHIST=false;
$GESTTRAB=false;		
$GESTEVAL=false;		
		
		
		while ( $fila = mysqli_fetch_array( $PERMISO ) ) {

		 if($fila['IdFuncionalidad']=='1'){
				$GESTUSU=true;
			   }
		 if($fila['IdFuncionalidad']=='2'){
				$GESTGRUP=true;
			   }
		 if($fila['IdFuncionalidad']=='3'){
				$GESTPERM=true;
			   }
		 if($fila['IdFuncionalidad']=='4'){
				$GESTFUNC=true;
			   }
		 if($fila['IdFuncionalidad']=='5'){
				$GESTACC=true;
			   }
		 if($fila['IdAccion']=='0'){
			    $ADD=true;	
			   }
		 if($fila['IdAccion']=='1'){
			    $DELETE=true;	
			   }
		 if($fila['IdAccion']=='2'){
			    $EDIT=true;	
			   }
		 if($fila['IdAccion']=='3'){
			    $SEARCH=true;	
			   }
		 if($fila['IdAccion']=='4'){
			    $SHOW=true;	
			   }
			}
	include '../Views/Header.php';			
?>

		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<caption style="margin-bottom:10px;">
					<form action='../Controllers/USUARIO_CONTROLLER.php'>

<?php if($SEARCH==true){  ?>
						<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>	
<?php }
		if($ADD==true){  ?>
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
		if($EDIT==true || $SHOW==true || $DELETE==true){
?>
					<th colspan="4" >
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
						<form action="../Controllers/USUARIO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="login" value="<?php echo $fila['login']; ?>">
							<?php if($EDIT==true){ ?>
								<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
						    <?php } ?>
					<td>
							<?php if($DELETE==true){ ?>
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
							<?php } ?>
					<td>
							<?php if($SHOW==true){ ?>
								<button type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
							<?php } ?>
						</form>
				    <td>
						<form action="../Controllers/USU_GRUPO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="login" value="<?php echo $fila['login']; ?>">
							<button type="submit" ><img src="../Views/icon/atras.png" width="20" height="20"/></button>
						</form>

				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/USUARIO_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>