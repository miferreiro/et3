<?php
    //vista que muestra una tabla con todos los atributos de la clase ENTREGA a borrar.
    //Fecha de creación:28/11/2017
    class ENTREGA_DELETE{
        
        
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
				<?php echo $strings['Tabla de borrado'];?>
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
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/ENTREGA_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="" value="<?php echo $this->valores['login'] ?>" />
                
                <input type="hidden" name="" value="<?php echo $this->valores['IdTrabajo'] ?>" />
                
				<input id="DELETE" name="action" value="DELETE" type="image" src="../Views/icon/confirmar.png" width="32" height="32" alt="<?php echo $strings['Confirmar'] ?>">
			</form>
			<form action='../Controllers/ENTREGA_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
	}
}

?>