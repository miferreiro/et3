<?php
/*  Archivo php
	Nombre: TRABAJO_SHOWCURRENT_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de vista en detalle(showcurrent) realizada con una clase donde se muestran todos los datos de una acción
*/
class TRABAJO_SHOWCURRENT {

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
					<?php echo $strings['ID Trabajo'];?>
				</th>
				<td>
					<?php echo $this->lista['IdTrabajo'] ?>
				</td>
			</tr>
	
			<tr>
				<th>
					<?php echo $strings['Nombre Trabajo'];?>
				</th>
				<td>
					<?php echo $this->lista['NombreTrabajo'] ?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $strings['Fecha inicio trabajo'];?>
				</th>
				<td>
					<?php echo $this->lista['FechaIniTrabajo'] ?>
				</td>
			</tr>
            
            <tr>
				<th>
					<?php echo $strings['Fecha fin trabajo'];?>
				</th>
				<td>
					<?php echo $this->lista['FechaFinTrabajo'] ?>
				</td>
			</tr>
            
            
             <tr>
				<th>
					<?php echo $strings['Porcentaje Nota'];?>
				</th>
				<td>
					<?php echo $this->lista['PorcentajeNota'] ?>
				</td>
			</tr>
			
			<caption style="margin-top:10px;" align="bottom">
				<form action='../Controllers/TRABAJO_CONTROLLER.php' method="post">
					<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			</caption>
		</table>

<?php
		include '../Views/Footer.php';
	}
}
?>