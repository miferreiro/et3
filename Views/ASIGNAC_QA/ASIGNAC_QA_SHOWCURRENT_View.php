<?php
/*  Archivo php
	Nombre: ASIGNAC_QA_SHOWCURRENT_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de un usuario y da la opción de borrarlos
*/



      class ASIGNAC_QA_SHOWCURRENT{
        
        
        function __construct($valores){
            
            $this->mostrar($valores);
            
            
        }
        
        public function mostrar($valores){
            $this->valores = $valores;
		    include '../Locales/Strings_' . $_SESSION[ 'idioma' ] . '.php';
		    include '../Views/Header.php';
                
        ?>
    <div class="seccion">
			<h2>
				<?php echo $strings['Vista detallada'];?>
			</h2>
			<table>
				<tr>
					<th>
						<?php echo $strings['IdTrabajo'];?><!--se muestra el campo login -->
					</th>
					<td>
						<?php echo $this->valores['IdTrabajo']?><!--se muestran  el valor del campo login -->
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['LoginEvaluador'];?><!--se muestra el campo IdTrabajo -->
					</th>
					<td>
						<?php echo $this->valores['LoginEvaluador']?><!--se muestra elvalor del campo idTrabajo -->
					</td>
				</tr>
				
				<tr>
					<th>
						<?php echo $strings['LoginEvaluado'];?><!--se muestra el campo Alias -->
					</th>
					<td>
						<?php echo $this->valores['LoginEvaluado']?><!--se muestra el valor del campo Alias -->
					</td>
                    
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['AliasEvaluado'];?><!--se muestra el campo Horas -->
					</th>
					<td>
						<?php echo $this->valores['AliasEvaluado']?><!--se muestra el valor del campo Horas -->
					</td>
				</tr>
                	
			</table>
			<form action='../Controllers/ASIGNAC_QA_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>"/></button><!--con este boton se vuelve atras -->
			</form>
		</div>
<?php
		include '../Views/Footer.php';
	}
}

?>