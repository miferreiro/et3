<?php
/*  Archivo php
	Nombre: USUARIOS_GRUPO_SHOWALL_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de tabla de datos(showall) realizada con una clase donde se muestran datos caracteristicos y permite seleccionar la acción que se desea realizar en la aplicación
*/
class USU_GRUPO_SHOWALL {

	function __construct( $lista, $datos,$login) {
		$this->lista = $lista;
		$this->datos = $datos;
		$this->login = $login;
		$this->render($this->lista,$this->datos,$this->login);
		
	}
	
	function render($lista,$datos,$login){
		$this->lista = $lista;
		$this->datos = $datos;
		$this->login = $login;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<div class="seccion">
			<h2>
				<?php echo $strings['Tabla de datos'];?>
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
					<th colspan="3" >
						<?php echo $strings['Opciones']?>
					</th>
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
						    //$log=$fila['login'];
?>
					</td>
<?php
					}
?>
					<td>
						<form action="../Controllers/USU_GRUPO_CONTROLLER.php" method="get" style="display:inline" >
							<input type="hidden" name="login" value="<?php echo $fila['login']; ?>">
							<input type="hidden" name="IdGrupo" value="<?php echo $fila['IdGrupo']; ?>">

								<button type="submit" name="action" value="DELETE" ><img src="../Views/icon/eliminar.png" alt="<?php echo $strings['Eliminar']?>" width="20" height="20" /></button>
	
						</form>

				</tr>
<?php
				}
?>
				<caption style="margin-bottom:10px;"><form action='../Controllers/USU_GRUPO_CONTROLLER.php' method="get">
				<input type="hidden" name="login" value="<?php echo $this->login;?>">
				<button type="submit" name="action" value="ADD"><img src="../Views/icon/añadir.png" alt="<?php echo $strings['Confirmar formulario']?>" /></button>				
				
			</form></table>
			
			<form action='../Controllers/USUARIO_CONTROLLER.php' method="post">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras']?>" /></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
		}
		}
?>