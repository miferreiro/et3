<?php
    //vista que muestra una tabla con todos los atributos de la clase NOTA_TRABAJO a borrar.
    //Fecha de creación:28/11/2017
    class NOTAS_DELETE{
        
        
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
				<?php echo $strings['Tabla de borrado'];?>
			</h2>
			<table>
				<tr>
					<th>
						<?php echo $strings['login'];?><!--se muestra el campo login-->
					</th>
					<td>
						<?php echo $this->valores['login']?><!--se muestra el valor del campo login-->
					</td>
				</tr>

				<tr>
					<th>
						<?php echo $strings['IdTrabajo'];?><!--se muestra el campo IdTrabajo-->
					</th>
					<td>
						<?php echo $this->valores['IdTrabajo']?><!--se muestra el valor del campo IdTrabajo-->
					</td>
				</tr>
				
				<tr>
					<th>
						<?php echo $strings['NotaTrabajo'];?><!--se muestra el campo Alias-->
					</th>
					<td>
						<?php echo $this->valores['NotaTrabajo']?><!--se muestra el valor del campo Alias-->
					</td>
                    
				</tr>
        
                
				
			</table>
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/NOTAS_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="login" value="<?php echo $this->valores['login'] ?>" />
                
                <input type="hidden" name="IdTrabajo" value="<?php echo $this->valores['IdTrabajo'] ?>" />
                <input type="hidden" name="NotaTrabajo" value="<?php echo $this->valores['NotaTrabajo'] ?>" />
                
                <button type="submit" name="action" value="DELETE" ><img src="../Views/icon/confirmar.png" alt="<?php echo $strings['Confirmar'] ?>"/></button>
			</form>
			<form action='../Controllers/NOTAS_CONTROLLER.php' method="post" style="display: inline">
				<button type="submit"><img src="../Views/icon/cancelar.png" alt="<?php echo $strings['Atras'] ?>"/></button>
			</form>
		</div>
<?php
		include '../Views/Footer.php';
	}
}

?>