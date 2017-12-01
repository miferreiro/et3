<!--Creado el 8 de noviembre del 2017 por de3t7q/-->
<!--Contiene la vista del menu lateral-->
    <script type="text/javascript" src="../Views/js/desplegarMenu.js"></script> 
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
	<link rel="stylesheet"  type="text/css" href="../Views/css/estilos.css" />


<nav>
		<ul class ="menu">
			<li>
				<a href="#" class="primerNivel"><?php echo $strings['Gestion de usuarios']; ?></a> 
					<ul class="submenu">
						<li>
							<a href="../Controllers/USUARIO_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
						</li>
						<li>
							<a href="../Controllers/USUARIO_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
						</li>
					</ul>
			</li>
			<li>
				<a href="#" class="primerNivel"><?php echo $strings['Gestion de grupo']; ?></a> 
					<ul class="submenu">
						<li>
							<a href="../Controllers/GRUPO_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
						</li>
						<li>
							<a href="../Controllers/GRUPO_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
						</li>
					</ul>
			</li>
			<li>
				<a href="#" class="primerNivel"><?php echo $strings['Gestion de usuarios-grupo']; ?></a> 
					<ul class="submenu">
						<li>
							<a href="../Controllers/USU_GRUPO_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
						</li>
						<li>
							<a href="../Controllers/USU_GRUPO_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
						</li>
					</ul>
			</li>
			<li>
				<a href="#" class="primerNivel"><?php echo $strings['Gestion de funcionalidades/acciones']; ?></a> 
					<ul class="submenu">
						<li>
							<a href="../Controllers/FUNC_ACCION_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
						</li>
						<li>
							<a href="../Controllers/FUNC_ACCION_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
						</li>
					</ul>
			</li>
			<li>
				<a href="#" class="primerNivel"><?php echo $strings['Gestion de funcionalidades']; ?></a> 
					<ul class="submenu">
						<li>
							<a href="../Controllers/FUNCIONALIDAD_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
						</li>
						<li>
							<a href="../Controllers/FUNCIONALIDAD_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
						</li>
					</ul>
			</li>
			<li>
				<a href="#" class="primerNivel"><?php echo $strings['Gestion de acciones']; ?></a> 
					<ul class="submenu">
						<li>
							<a href="../Controllers/ACCION_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
						</li>
						<li>
							<a href="../Controllers/ACCION_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
						</li>
					</ul>
			</li>
			<li>
				<a href="#" class="primerNivel"><?php echo $strings['Gestión de permisos']; ?></a> 
					<ul class="submenu">
						<li>
							<a href="../Controllers/PERMISO_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
						</li>
						<li>
							<a href="../Controllers/PERMISO_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
						</li>
					</ul>
			</li>
			<li>
				<a href="#" class="primerNivel"><?php echo $strings['Gestión de QAs']; ?></a> 
					<ul class="submenu">
						<li>
							<a href="../Controllers/ASIGNAC_QA_CONTROLLER.php" class="segundoNivel"><?php echo $strings['ASIGNACIÓN DE QAs']; ?></a>
						</li>
					</ul>
			</li>
		</ul>
	</nav>