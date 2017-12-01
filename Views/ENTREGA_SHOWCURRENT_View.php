<?php
//Esta clase sirve para mostrar una tupla del SHOWALL en detalle con todos los atributos
//Fecha de creación:28/11/2017



      class ENTREGA_SHOWCURRENT{
        
        
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
				<?php echo $strings['Tabla SHOWCURRENT'];?>
			</h2>
			<table>
				<tr>
					<th>
						<?php echo $strings['login'];?><!--se muestra el campo login -->
					</th>
					<td>
						<?php echo $this->valores['login']?><!--se muestran  el valor del campo login -->
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['IdTrabajo'];?><!--se muestra el campo IdTrabajo -->
					</th>
					<td>
						<?php echo $this->valores['IdTrabajo']?><!--se muestra elvalor del campo idTrabajo -->
					</td>
				</tr>
				
				<tr>
					<th>
						<?php echo $strings['Alias'];?><!--se muestra el campo Alias -->
					</th>
					<td>
						<?php echo $this->valores['Alias']?><!--se muestra el valor del campo Alias -->
					</td>
                    
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['Horas'];?><!--se muestra el campo Horas -->
					</th>
					<td>
						<?php echo $this->valores['Horas']?><!--se muestra el valor del campo Horas -->
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['Ruta'];?><!--se muestra el campo Ruta -->
					</th>
					<td>
						<a href="<?php echo $this->valores['Ruta']?>"><?php echo $this->valores['Ruta']?></a><!--se muestra el valor del campo Ruta -->
					</td>
				</tr>
                
                
				
			</table>
			<form action='../Controllers/ENTREGA_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>"/></button><!--con este boton se vuelve atras -->
			</form>
		</div>
<?php
		include '../Views/Footer.php';
	}
}

?>