<?php
/*  Archivo php
	Nombre: EVALUACION_SHOWCURRENT_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de vista en detalle(showcurrent) realizada con una clase donde se muestran todos los datos de una acción
*/
class EVALUACION_SHOWCURRENT {

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
						<?php echo $this->valores['IdTrabajo']?>
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['Login Evaluador'];?>
					</th>
					<td>
						<?php echo $this->valores['LoginEvaluador']?>
					</td>
				</tr>
				
				<tr>
					<th>
						<?php echo $strings['Alias Evaluado'];?>
					</th>
					<td>
						<?php echo $this->valores['AliasEvaluado']?>
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['ID Historia'];?>
					</th>
					<td>
						<?php echo $this->valores['IdHistoria']?>
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['CorrectoA'];?>
					</th>
					<td>
						<?php echo $this->valores['CorrectoA']?>
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['Comentario incorrecto A'];?>
					</th>
					<td>
						<?php echo $this->valores['ComenIncorrectoA']?>
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['CorrectoP'];?>
					</th>
					<td>
						<?php echo $this->valores['CorrectoP']?>
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['Comentario incorrecto P'];?>
					</th>
					<td>
						<?php echo $this->valores['ComentIncorrectoP']?>
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['OK'];?>
					</th>
					<td>
						<?php echo $this->valores['OK']?>
					</td>
				</tr>
			
			<caption style="margin-top:10px;" align="bottom">
				<form action='../Controllers/EVALUACION_CONTROLLER.php' method="post">
					<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>" /></button>
				</form>
			</caption>
		</table>

<?php
		include '../Views/Footer.php';
	}
}
?>