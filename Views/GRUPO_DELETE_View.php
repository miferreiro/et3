<?php
/*  Archivo php
	Nombre: GRUPO_DELETE_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los valores de un grupo y da la opción de borrarlos
*/
class GRUPO_DELETE {

	function __construct( $valores , $lista, $dependencias) {
		$this->valores = $valores;
		$this->lista = $lista;
		$this->dependencias = $dependencias;
		$this->render( $this->valores, $this->lista , $this->dependencias );
	}

	function render( $valores, $lista, $dependencias ) {
		$this->valores = $valores;
		$this->lista = $lista;
		$this->dependencias = $dependencias;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de borrado'];?>
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
						</form>

				</tr>
<?php
				}
?>
				
			</table>
            <?php
            
            if($dependencias != null){
                
                if(array_key_exists('USU_GRUPO', $dependencias)){
            ?>
                <h3>Para borrar este grupo tendrá que eliminar a sus integrantes del grupo.</h3>
                }
            <?php
                if(array_key_exists('PERMISO', $dependencias)){
            ?>
                    <td>PERMISO</td>
                    <td><?php echo $dependencias['PERMISO']['IdGrupo'] ?></td>
				    <td><?php echo $dependencias['PERMISO']['IdFuncionalidad'] ?></td>
				    <td><?php echo $dependencias['PERMISO']['IdAccion'] ?></td>
            <?php
                }
            }
            else{
                ?>
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/GRUPO_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="login" value=<?php echo $this->valores['login'] ?> />
				<input type="hidden" name="IdGrupo" value=<?php echo $this->valores['IdGrupo'] ?> />
				<input type="hidden" name="NombreGrupo" value=<?php echo $this->valores['NombreGrupo'] ?> />
				<input type="hidden" name="DescripGrupo" value=<?php echo $this->valores['DescripGrupo'] ?> />
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