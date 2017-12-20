<?php
/* 
	Fecha de creación: 4/12/2017 
	Función: vista de la tabla de vista en detalle(showcurrent) realizada con una clase donde se muestran todos los datos de  la nota de un trabajo
*/
class NOTA_TRABAJO_SHOWCURRENT {

	function __construct( $lista ) {
		$this->lista = $lista;
		$this->render( $this->lista );
	}

	function render( $lista ) {
		$this->lista = $lista;
		include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		include '../Views/Header.php';
?>
		<h2>
			<?php echo $strings['Vista detallada'];?>
		</h2>
		<table class="tablaDatos">
			<tr>
				<th>
					<?php echo $strings['Usuario'];?>
				</th>
				<td>
					<?php echo $this->lista['login'] ?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['IdTrabajo'];?>
				</th>
				<td>
					<?php echo $this->lista['IdTrabajo'] ?>
				</td>
			</tr>

			<tr>
				<th>
					<?php echo $strings['Nota del Trabajo'];?>
				</th>
				<td>
					<?php echo $this->lista['NotaTrabajo'] ?>
				</td>
			</tr>
			

			<caption style="margin-top:10px;" align="bottom">
				<form action='../Controllers/NOTA_TRABAJO_CONTROLLER.php' method="post">
					<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			</caption>
		</table>

<?php
		include '../Views/Footer.php';
	}
}
?>