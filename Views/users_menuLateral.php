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
				<a href="../Controllers/ENTREGA_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de entregas']; ?></a> 
			</li>
			<li>
				<a href="../Controllers/EVALUACION_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de evaluaciones']; ?></a> 
			</li>
            <li>
                    
                    <a href="../Controllers/NOTAS_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de notas']; ?></a>     
            </li>
		</ul>
	</ul>
</nav>