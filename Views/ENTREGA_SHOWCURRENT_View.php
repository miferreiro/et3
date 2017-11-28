<?php
//Esta clase sirve para mostrar una tupla del SHOWALL en detalle con todos los atributos
//Fecha de creación:28/11/2017



      class ENTREGA_SHOWCURRENT{
        
        
        function __construct($valores){
            
            $this->mostrar($valores);
            
            
        }
        
        public function mostrar(){
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
						<?php echo $strings['login'];?>
					</th>
					<td>
						<?php echo $this->valores['login']?>
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['IdTrabajo'];?>
					</th>
					<td>
						<?php echo $this->valores['IdTrabajo']?>
					</td>
				</tr>
				
				<tr>
					<th>
						<?php echo $strings['Alias'];?>
					</th>
					<td>
						<?php echo $this->valores['Alias']?>
					</td>
                    
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['Horas'];?>
					</th>
					<td>
						<?php echo $this->valores['Horas']?>
					</td>
				</tr>
                
                <tr>
					<th>
						<?php echo $strings['Ruta'];?>
					</th>
					<td>
						<?php echo $this->valores['Ruta']?>
					</td>
				</tr>
                
                
				
			</table>
			<form action='../Controllers/ENTREGA_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/atras.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
	}
}

?>