<?php
/* 
	Fecha de creación: 4/12/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar mostrar los permisos que existen
*/
class PERMISO_SHOWALL {

	function __construct( $lista, $datos/*, $DatosGrupo*/,$PERMISO,$admin) {
		$this->lista = $lista;
		$this->datos = $datos;
		$this->PERMISO = $PERMISO;
		$this->admin = $admin;
	/*	$this->DatosGrupo = $DatosGrupo;*/
		$this->render($this->lista,$this->datos/*,$this->DatosGrupo*/,$this->PERMISO,$this->admin);
	}
	
	function render($lista,$datos/*,$DatosGrupo*/,$PERMISO,$admin){
		$this->lista = $lista;
		$this->datos = $datos;
		/*$this->DatosGrupo = $DatosGrupo;*/
		$this->PERMISO = $PERMISO;
		$this->admin = $admin;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';

	
$SEARCH=false;	
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
		
	if($admin==true){

			    $SEARCH=true;			
	}	
	while ( $fila = mysqli_fetch_array( $PERMISO ) ) {

	 if($fila['IdFuncionalidad']=='1'){
				$GESTUSU=true;
			   }
	 if($fila['IdFuncionalidad']=='2'){
				$GESTGRUP=true;
			   }
	 if($fila['IdFuncionalidad']=='5'){
				$GESTPERM=true;

		 if($fila['IdAccion']=='3'){
			    $SEARCH=true;	
			   }

			   }
	 if($fila['IdFuncionalidad']=='3'){
				$GESTFUNC=true;
			   }
	 if($fila['IdFuncionalidad']=='4'){
				$GESTACC=true;
			   }

			}
	include '../Views/Header.php';			
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Gestión de permisos'];?>
			</h2>
			<table>
				<tr>
<?php
					foreach ( $lista as $atributo ) {
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
<?php
					}
?>
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
				</tr>
<?php
				}
?>
			<caption style="margin-bottom:10px;">
					<form action='../Controllers/PERMISO_CONTROLLER.php'>
<?php if($SEARCH==true){  ?>
						<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>	
<?php } ?>
					</form>
				</caption>
			</table>
			<form action='../Controllers/PERMISO_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>