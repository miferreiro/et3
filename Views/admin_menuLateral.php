<!--
	Archivo php
	Nombre: users_menuLateral.php
	Autor: 	fta875
	Fecha de creación: 23/10/2017 
	Función: contiene todas las características del menú lateral
-->
<nav>
	<ul class="menu">
				<ul class ="menu">
	<?php //if($GESTUSU==true){ ?>
			<li>
				<a href="../Controllers/USUARIO_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de usuarios']; ?></a> 
			</li>
<?php //} ?>
			<li>
				<a href="../Controllers/GRUPO_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de grupo']; ?></a> 
			</li>
			<li>
				<a href="../Controllers/FUNCIONALIDAD_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de funcionalidades']; ?></a> 
			</li>
			<li>
				<a href="../Controllers/ACCION_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de acciones']; ?></a> 
			</li>
			<li>
				<a href="../Controllers/PERMISO_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestión de permisos']; ?></a> 
			</li>
			<li>
				<a href="../Controllers/ASIGNAC_QA_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestión de QAs']; ?></a> 
					<ul class="submenu">
						<li>
							<a href="../Controllers/ASIGNAC_QA_CONTROLLER.php?action=GENERAR" class="segundoNivel"><?php echo $strings['GENERACIÓN DE QAs']; ?></a>
						</li>
						<li>
							<a href="../Controllers/ASIGNAC_QA_CONTROLLER.php?action=HISTORIAS" class="segundoNivel"><?php echo $strings['GENERACIÓN DE HISTORIAS EVALUACIÓN']; ?></a>
						</li>
					</ul>
			</li>
			<li>
				<a href="../Controllers/ENTREGA_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de entregas']; ?></a> 
			</li>
			<li>
				<a href="../Controllers/HISTORIA_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de historias']; ?></a> 
			</li>
			<li>
				<a href="../Controllers/TRABAJO_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de trabajos']; ?></a> 
			</li>
			<li>
				<a href="../Controllers/EVALUACION_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de evaluaciones']; ?></a> 
			</li>
		</ul>
	</ul>
</nav>