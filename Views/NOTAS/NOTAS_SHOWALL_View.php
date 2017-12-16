<?php
/* 
	Fecha de creación: 4/12/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la acción que se desea realizar en la aplicación
*/
class NOTAS_SHOWALL {
        
	function __construct( $lista, $datos, $notas,$bol) {
		$this->lista = $lista;
		$this->datos = $datos;
		$this->notas = $notas;
        $this->bol=$bol;
		$this->render($this->lista,$this->datos, $this->notas,$this->bol);
	}
	
	function render($lista,$datos, $notas,$bol){
		$this->lista = $lista;
		$this->datos = $datos;
		$this->notas = $notas;
        $this->bol=$bol;
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
					<form action='../Controllers/NOTAS_CONTROLLER.php'>
<?php if(permisosAcc($_SESSION['login'],7,3)==true){ ?>
						<button type="submit" name="action" value="SEARCH"><img src="../Views/icon/buscar.png" alt="BUSCAR" /></button>
<?php }
	  if(permisosAcc($_SESSION['login'],7,0)==true){ 
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
                ?>
                    <th>NotaET</th>
                    <?php
		if((permisosAcc($_SESSION['login'],7,1)==true)||(permisosAcc($_SESSION['login'],7,2)==true)||        (permisosAcc($_SESSION['login'],7,4)==true)){ 
?>
					<th colspan="3" >
						<?php echo $strings['Opciones']?>
					</th>
<?php } ?>
				</tr>
<?php           $i=0;
                $suma=0;
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
                    <?php

                
                echo $notas[$i];
                $suma=$suma+$notas[$i];
                    $i++;
            
                ?>
                    </td>
                    

					<td>
						<form action="../Controllers/NOTAS_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="login" value="<?php echo $fila['login']; ?>">
                            <input type="hidden" name=IdTrabajo value="<?php echo $fila['IdTrabajo']; ?>">
<?php         if(permisosAcc($_SESSION['login'],7,2)==true){ ?>
								<button type="submit" name="action" value="EDIT" ><img src="../Views/icon/modificar.png" alt="<?php echo $strings['Modificar']?>" width="20" height="20" /></button>
<?php } ?>
					<td>
<?php         if(permisosAcc($_SESSION['login'],7,1)==true){ ?>
								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
<?php } ?>
					<td>
<?php         if(permisosAcc($_SESSION['login'],7,4)==true){ ?>
								<button type="submit" name="action" value="SHOWCURRENT" ><img src="../Views/icon/verDetalles.png" alt="<?php echo $strings['Ver en detalle']?>" width="20" height="20"/></button>
<?php } ?>
						</form>

				
<?php
				}
        ?>
                
                
                    </tr>
			</table>

<?php
        echo '<br>';
        
                if($this->bol ==true){
                    echo "Nota final:".$suma;
                }
        
?>
            
            
			<form action='../Controllers/NOTAS_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>