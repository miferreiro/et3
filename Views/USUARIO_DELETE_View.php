<?php
/*  Archivo php
	Nombre: USUARIOS_DELETE_View.php
	Autor: 	fta875
	Fecha de creación: 9/10/2017 
	Función: vista de la tabla de borrado(delete) realizada con una clase donde se muestran todos los datos de un usuario y da la opción de borrarlos
*/
class USUARIO_DELETE {

	function __construct( $valores, $dependencias ) {
		$this->valores = $valores;
		$this->dependencias = $dependencias;
		$this->render( $this->valores, $this->dependencias);
	}

	function render( $valores, $dependencias ) {
		$this->valores = $valores;
		$this->dependencias = $dependencias;
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
						<?php echo $this->valores['Nombre']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Apellidos'];?>
					</th>
					<td>
						<?php echo $this->valores['Apellidos']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Teléfono'];?>
					</th>
					<td>
						<?php echo $this->valores['Telefono']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Correo electrónico'];?>
					</th>
					<td>
						<?php echo $this->valores['Correo']?>
					</td>
				</tr>
				<tr>
					<th>
						<?php echo $strings['Direccion'];?>
					</th>
					<td>
						<?php echo $this->valores['Direccion']?>
					</td>
				</tr>
			</table>
            
            <?php
            
            if($dependencias != null){
                if(array_key_exists('USU_GRUPO', $dependencias)){
            ?>
                    <td>USU_GRUPO</td>
                    <td><?php echo $dependencias['USU_GRUPO']['login'] ?></td>
				    <td><?php echo $dependencias['USU_GRUPO']['IdGrupo'] ?></td>
            <?php
                }
                if(array_key_exists('ENTREGA', $dependencias)){
            ?>
                    <td>ENTREGA</td>
                    <td><?php echo $dependencias['ENTREGA']['login'] ?></td>
				    <td><?php echo $dependencias['ENTREGA']['IdTrabajo'] ?></td>
				    <td><?php echo $dependencias['ENTREGA']['Alias'] ?></td>
				    <td><?php echo $dependencias['ENTREGA']['Horas'] ?></td>
				    <td><?php echo $dependencias['ENTREGA']['Ruta'] ?></td>
            <?php
                }
                if(array_key_exists('ASIGNAC_QA', $dependencias)){
            ?>
                    <td>ASIGNAC_QA</td>
                    <td><?php echo $dependencias['ASIGNAC_QA']['IdTrabajo'] ?></td>
				    <td><?php echo $dependencias['ASIGNAC_QA']['LoginEvaluador'] ?></td>
				    <td><?php echo $dependencias['ASIGNAC_QA']['LoginEvaluado'] ?></td>
				    <td><?php echo $dependencias['ASIGNAC_QA']['AliasEvaluado'] ?></td>
            <?php
                }
                if(array_key_exists('ASIGNAC_QA2', $dependencias)){
            ?>
                    <td>ASIGNAC_QA</td>
                    <td><?php echo $dependencias['ASIGNAC_QA']['IdTrabajo'] ?></td>
				    <td><?php echo $dependencias['ASIGNAC_QA']['LoginEvaluador'] ?></td>
				    <td><?php echo $dependencias['ASIGNAC_QA']['LoginEvaluado'] ?></td>
				    <td><?php echo $dependencias['ASIGNAC_QA']['AliasEvaluado'] ?></td>
            <?php
                }
                if(array_key_exists('NOTA_TRABAJO', $dependencias)){
            ?>
                    <td>NOTA_TRABAJO</td>
                    <td><?php echo $dependencias['NOTA_TRABAJO']['login'] ?></td>
				    <td><?php echo $dependencias['NOTA_TRABAJO']['IdTrabajo'] ?></td>
				    <td><?php echo $dependencias['NOTA_TRABAJO']['NotaTrabajo'] ?></td>
            <?php
                }
                if(array_key_exists('EVALUACION', $dependencias)){
            ?>
                    <td>EVALUACIÓN</td>
                    <td><?php echo $dependencias['EVALUACION']['IdTrabajo'] ?></td>
				    <td><?php echo $dependencias['EVALUACION']['LoginEvaluador'] ?></td>
				    <td><?php echo $dependencias['EVALUACION']['AliasEvaluado'] ?></td>
				    <td><?php echo $dependencias['EVALUACION']['IdHistoria'] ?></td>
				    <td><?php echo $dependencias['EVALUACION']['CorrectoA'] ?></td>
				    <td><?php echo $dependencias['EVALUACION']['CorrectoP'] ?></td>
				    <td><?php echo $dependencias['EVALUACION']['OK'] ?></td>

            <?php
                }
            
                
                }
            else{
              ?>  
            
			<p style="text-align:center;">
				<?php echo $strings['¿Está seguro de que quiere borrar esta tupla de la tabla?'];?>
			</p>
			<form action="../Controllers/USUARIO_CONTROLLER.php" method="post" style="display: inline">
				<input type="hidden" name="login" value=<?php echo $this->valores['login'] ?> />
				<input type="hidden" name="password" value=<?php echo $this->valores['password'] ?> />
				<input type="hidden" name="DNI" value=<?php echo $this->valores['DNI'] ?> />
				<input type="hidden" name="nombre" value=<?php echo $this->valores['Nombre'] ?> />
				<input type="hidden" name="apellidos" value=<?php echo $this->valores['Apellidos'] ?> />
				<input type="hidden" name="telefono" value=<?php echo $this->valores['Telefono'] ?> />
				<input type="hidden" name="email" value=<?php echo $this->valores['Correo'] ?> />
				<input type="hidden" name="direc" value=<?php echo $this->valores['Direccion'] ?> />
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
        
	}


?>