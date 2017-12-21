<?php
/*  Archivo php
	Nombre: ACCION_SHOWALL_View.php
    Autor: Alejandro Vila
	Fecha de creación: 23/11/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la acción que se desea realizar en la aplicación
*/

//Es la clase SHOWALL de ACCION que nos permite mostrar todas las accion
class ACCION_SHOWALL {

	function __construct( $lista, $datos, $PERMISO,$admin) {//es el constructor de la clase ACCION_SHOWALL
		$this->lista = $lista;//pasamos una array con los campos a mostrar
		$this->datos = $datos;//pasamos el valor de los datos que queremos mostrar
		$this->PERMISO = $PERMISO;//pasamos los permisos
		$this->admin = $admin;//pasamos una variable booleana: true si es administrador y false si no es administrador
		$this->render($this->lista,$this->datos,$this->PERMISO,$this->admin);//llamamos a la función render donde se mostrará el formulario SHOWALL con los campos correspondientes
	}
	
	function render($lista,$datos,$PERMISO,$admin){//función render donde se mostrará el formulario SHOWALL con los campos correspondientes
		$this->lista = $lista;//pasamos una array con los campos a mostrar
		$this->datos = $datos;//pasamos el valor de los datos que queremos mostrar
		$this->PERMISO = $PERMISO;//pasamos los permisos
		$this->admin = $admin;//pasamos una variable booleana: true si es administrador y false si no es administrador
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';//incluimos los strings de idiomas, para que la página pueda estar en español,inglés y galego

//pasamos a todas las variables el valor false porque no tienen dicho permiso
$ADD=false;	
$EDIT=false;	
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
		
	if($admin==true){//si es administrador, tiene todos los permisos, por eso le pasamos el valor true a todas las variables
			    $ADD=true;	
			    $DELETE=true;				   
			    $EDIT=true;	
			    $SEARCH=true;	
			    $SHOW=true;	
			    $ASIGN=true;	
	}	
	while ( $fila = mysqli_fetch_array( $PERMISO ) ) {//este bucle se va a repetir mientras haya permisos

	 if($fila['IdFuncionalidad']=='1'){//si se tiene el permiso de gestión de usuario se pone la variable a true
				$GESTUSU=true;
			   }
	 if($fila['IdFuncionalidad']=='2'){//si se tiene el permiso de gestión de grupo se pone la variable a true
				$GESTGRUP=true;
			   }
	 if($fila['IdFuncionalidad']=='5'){//si se tiene el permiso de gestión de permisos se pone la variable a true
				$GESTPERM=true;
			   }
	 if($fila['IdFuncionalidad']=='3'){//si se tiene el permiso de gestión de funcionalidad se pone la variable a true
				$GESTFUNC=true;
			   }
	 if($fila['IdFuncionalidad']=='4'){//si se tiene el permiso de gestión de accion se pone la variable a true
				$GESTACC=true;
		 if($fila['IdAccion']=='0'){//si se tiene la acción de añadir se pone la variable a true
			    $ADD=true;	
			   }
		 if($fila['IdAccion']=='1'){//si se tiene la acción de borrar se pone la variable a true
			    $DELETE=true;	
			   }
		 if($fila['IdAccion']=='2'){//si se tiene la acción de editar se pone la variable a true
			    $EDIT=true;	
			   }
		 if($fila['IdAccion']=='3'){//si se tiene la acción de buscar se pone la variable a true
			    $SEARCH=true;	
			   }
		 if($fila['IdAccion']=='4'){//si se tiene la acción de showall se pone la variable a true
			    $SHOW=true;	
			   }
		 if($fila['IdAccion']=='6'){//si se tiene la acción de asignar se pone la variable a true
			    $ASIGN=true;	
			   }
			   }

			}		
		
		include '../Views/Header.php';//incluimos la cabecera
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
			</h2>
			<table>
				<caption style="margin-bottom:10px;">
					<form action='../Controllers/ACCION_CONTROLLER.php'>

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
					foreach ( $lista as $atributo ) { //este bucle se va a recorrer mientres queden campos por mostrar
?>
					<th>
						<?php echo $strings[$atributo]?>
					</th>
<?php
					}
   if($EDIT==true || $SHOW==true || $DELETE==true){ //miramos si tiene la accion de editar,borrar y showall
?>
					<th colspan="3" >
						<?php echo $strings['Opciones']?>
					</th>
<?php } ?>
				</tr>
<?php
				while ( $fila = mysqli_fetch_array( $this->datos ) ) { //este bucle se va a repetir mientras no se muestren todos los datos
?>
				<tr>
<?php
					foreach ( $lista as $atributo ) {//este bucle se va a repetir mientras se muestre todos los campos
?>
					<td>
<?php 
							echo $fila[ $atributo ];//se muestra el valor del campo

?>
					</td>
<?php
					}
?>
					<td>
						<form action="../Controllers/ACCION_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="IdAccion" value="<?php echo $fila['IdAccion']; ?>">
                            <?php if($EDIT==true){ //miramos si tiene la accion de editar ?>
								<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
						    <?php } ?>
					<td>
							<?php if($DELETE==true){ //miramos si tiene la accion de borrar ?>
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
							<?php } ?>
					<td>
							<?php if($SHOW==true){ //miramos si tiene la accion de añadir?>
								<button type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
							<?php } ?>
						</form>

				</tr>
<?php
				}
?>
			</table>
			<form action='../Controllers/ACCION_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';//incluimos el pie de la pagina
		}
		}
?>