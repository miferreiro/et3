<?php
/*  Archivo php
	Nombre: GRUPO_DELETE_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los valores de un grupo y da la opción de borrarlos
*/
class GRUPO_DELETE {

	function __construct( $valores, $valores2 , $lista, $dependencias, $dependencias2) {
		$this->valores = $valores;
		$this->valores2 = $valores2;
		$this->lista = $lista;
		$this->dependencias = $dependencias;
		$this->dependencias2 = $dependencias2;
		$this->render( $this->valores, $this->valores2, $this->lista , $this->dependencias, $this->dependencias2 );
	}

	function render( $valores, $valores2, $lista, $dependencias, $dependencias2 ) {
		$this->valores = $valores;
		$this->valores2 = $valores2;
		$this->lista = $lista;
		$this->dependencias = $dependencias;
		$this->dependencias2 = $dependencias2;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de borrado'];?>
			</h2>
					
			<table>
				<tr>
					<th>
						<?php echo $strings['IdGrupo'];?>
					</th>
					<td>
						<?php echo $this->valores2['IdGrupo']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['NombreGrupo'];?>
					</th>
					<td>
						<?php echo $this->valores2['NombreGrupo']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['DescripGrupo'];?>
					</th>
					<td>
						<?php echo $this->valores2['DescripGrupo']?>
					</td>
				</tr>
	
			</table>
			<br>
			<br>
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
				while ( $fila = mysqli_fetch_array( $valores ) ) {
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
				
			</table>
            <br>
            
             <?php
            
            if($dependencias != null){
                ?>
            <br>
            <br>
                <p style="text-align:center;">
				<?php echo $strings['Debe borrar antes los permisos de este grupo'];?>
			</p>
            <?php
				while ( $fila = mysqli_fetch_array( $dependencias) ) {
            ?>
			<table>
            <tr>

				    <td>
                        <?php 
				        echo $fila['IdGrupo'];
                            
                        ?>
					</td>
                    <td>
                        <?php 
							
                        echo $fila['IdFuncionalidad'];

                        ?>
					</td>
                    <td>
                        <?php 
				        echo $fila['IdAccion'];
                            
                        ?>
					</td>
				</tr>
                </table>
                <br>
                <br>
                <?php
                    
				}
            }
        
                 
            else{

                ?>
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar este grupo de la tabla?'];?>
			</p>
			<form action="../Controllers/GRUPO_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="IdGrupo" value=<?php echo $valores2['IdGrupo'] ?> />
				<input type="hidden" name="NombreGrupo" value=<?php echo $valores2['NombreGrupo'] ?> />
				<input type="hidden" name="DescripGrupo" value=<?php echo $valores2['DescripGrupo'] ?> />
				<input id="DELETE" name="action" value="DELETE" type="image" src="../Views/icon/confirmar.png" width="32" height="32" alt="<?php echo $strings['Confirmar'] ?>">
			</form>
			<form action='../Controllers/GRUPO_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
            }
		include '../Views/Footer.php';
         
     }
	}

?>