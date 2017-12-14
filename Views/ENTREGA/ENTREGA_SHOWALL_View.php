<?php
/*  Archivo php
	Nombre: USUARIOS_SHOWALL_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la acción que se desea realizar en la aplicación
*/
class ENTREGA_SHOWALL {

	function __construct( $lista, $datos/*, $PERMISO, $admin*/) {
		$this->lista = $lista;
		$this->datos = $datos;
		/*$this->PERMISO = $PERMISO;
		$this->admin = $admin;*/
		$this->render($this->lista,$this->datos/*,$this->PERMISO,$this->admin*/);
	}
	
	function render($lista,$datos/*,$PERMISO,$admin*/){
		$this->lista = $lista;
		$this->datos = $datos;
		/*$this->PERMISO = $PERMISO;
		$this->admin = $admin;*/
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
        include_once '../Functions/permisosAcc.php';
/*$ADD=false;	
$EDIT=true;	
$SEARCH=false;	
$DELETE=false;	
$SHOW=false;
$ASIGN=false;
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
			    $ADD=true;	
			    $DELETE=true;				   
			    $EDIT=true;	
			    $SEARCH=true;	
			    $SHOW=true;	
			    $ASIGN=true;	
	}	
	while ( $fila = mysqli_fetch_array( $PERMISO ) ) {

	 if($fila['IdFuncionalidad']=='1'){
				$GESTUSU=true;
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
		 if($fila['IdAccion']=='6'){
			    $ASIGN=true;	
			   }
			   }
	 if($fila['IdFuncionalidad']=='2'){
				$GESTGRUP=true;
			   }
	 if($fila['IdFuncionalidad']=='5'){
				$GESTPERM=true;
			   }
	 if($fila['IdFuncionalidad']=='3'){
				$GESTFUNC=true;
			   }
	 if($fila['IdFuncionalidad']=='4'){
				$GESTACC=true;
			   }

			}*/
	include '../Views/Header.php';			
?>

		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<caption style="margin-bottom:10px;">
					<form action='../Controllers/ENTREGA_CONTROLLER.php'>

<?php if(permisosAcc($_SESSION['login'],8,3)==true){ ?>
						<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>	
<?php }
	  if(permisosAcc($_SESSION['login'],8,0)==true){ 
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
		if((permisosAcc($_SESSION['login'],8,1)==true)||(permisosAcc($_SESSION['login'],8,2)==true)||        (permisosAcc($_SESSION['login'],8,4)==true)){ 
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
						  if($atributo == 'Ruta'){
                                ?>
                        
                                <a href="<?php echo $fila[$atributo] ?>"><?php echo $fila[$atributo] ?></a>
                        
                                <?php
                            }
                        else
							echo $fila[ $atributo ];//se muestra el valor de todos los campos

?>
					</td>
<?php
					}
?>
					<td>
						<form action="../Controllers/ENTREGA_CONTROLLER.php" method="get" style="display:inline" >
				            <input type="hidden" name="login" value="<?php echo $fila['login']; ?>">
                            <input type="hidden" name="IdTrabajo" value="<?php echo $fila['IdTrabajo']; ?>">
                            
<?php         if(permisosAcc($_SESSION['login'],8,2)==true){ ?>
								<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button><!--con este boton pulsas para ver la vista EDIT-->
<?php } ?>
					<td>
<?php         if(permisosAcc($_SESSION['login'],8,1)==true){ ?>
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
                                <!--si pulsas este boton ves la vista DELETE-->
<?php } ?>
					<td>
<?php         if(permisosAcc($_SESSION['login'],8,4)==true){ ?>
									<button type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
                                <!--si pulsas este boton ves la vista SHOWCURRENT-->
<?php } ?>
						</form>
				    <td>
							
				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/ENTREGA_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>























