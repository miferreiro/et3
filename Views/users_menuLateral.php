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
			<li>
				<a href="#" class="primerNivel"><?php echo $strings['Gestion de entregas']; ?></a> 
					<ul class="submenu">
						<li>
							<a href="../Controllers/ENTREGA_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
						</li>
						<li>
							<a href="../Controllers/ENTREGA_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
						</li>
					</ul>
			</li>
			<li>
				<a href="#" class="primerNivel"><?php echo $strings['Gestion de evaluaciones']; ?></a> 
					<ul class="submenu">
						<li>
							<a href="../Controllers/EVALUACION_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
						</li>
						<li>
							<a href="../Controllers/EVALUACION_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
						</li>
					</ul>
			</li>
		</ul>
	</ul>
</nav>