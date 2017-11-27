<?php
/*  Archivo php
	Nombre: USUARIOS_DELETE_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de un usuario y da la opción de borrarlos
*/
class USUARIO_DELETE {

	function __construct( $valores ) {
		$this->valores = $valores;
		$this->render( $this->valores );
	}

	function render( $valores ) {
		$this->valores = $valores;
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
						<?php echo $strings['Usuario'];?>
					</th>
					<td>
						<?php echo $this->valores['login']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Contraseña'];?>
					</th>
					<td>
						<?php echo $this->valores['password']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['DNI'];?>
					</th>
					<td>
						<?php echo $this->valores['DNI']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Nombre'];?>
					</th>
					<td>
						<?php echo $this->valores['nombre']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Apellidos'];?>
					</th>
					<td>
						<?php echo $this->valores['apellidos']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Teléfono'];?>
					</th>
					<td>
						<?php echo $this->valores['telefono']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Correo electrónico'];?>
					</th>
					<td>
						<?php echo $this->valores['email']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Dirección'];?>
					</th>
					<td>
						<?php echo $this->valores['Dirección']?>
					</td>
				</tr>
			</table>
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/USUARIO_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="login" value=<?php echo $this->valores['login'] ?> />
				<input type="hidden" name="password" value=<?php echo $this->valores['password'] ?> />
				<input type="hidden" name="DNI" value=<?php echo $this->valores['DNI'] ?> />
				<input type="hidden" name="nombre" value=<?php echo $this->valores['nombre'] ?> />
				<input type="hidden" name="apellidos" value=<?php echo $this->valores['apellidos'] ?> />
				<input type="hidden" name="telefono" value=<?php echo $this->valores['telefono'] ?> />
				<input type="hidden" name="email" value=<?php echo $this->valores['email'] ?> />
				<input type="hidden" name="FechaNacimiento" value=<?php echo $this->valores['Dirección'] ?> />
				<input id="DELETE" name="action" value="DELETE" type="image" src="../Views/icon/confirmar.png" width="32" height="32" alt="<?php echo $strings['Confirmar'] ?>">
			</form>
			<form action='../Controllers/USUARIO_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
	}
}

?>