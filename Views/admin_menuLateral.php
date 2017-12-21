<!--
Archivo php
Nombre: users_menuLateral . php
Autor: fta875
Fecha de creación: 23 / 10 / 2017
Función: contiene todas las características del menú lateral
	-->
	<?php
include_once '../Functions/permisosAcc.php';
include_once '../Functions/comprobarAdministrador.php';

?>
<nav>
	<ul class="menu">
		<!-- Si hay un usuario logeado (Variable de sesion login con valor) ejecuta el código dento del if
que comprueba permisos para cada una de las acciones -->
		<?php if (isset($_SESSION['login'])) { ?>

		<?php if((permisosAcc($_SESSION['login'],1,5)==true)){ ?>
		<li>
			<a href="../Controllers/USUARIO_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de usuarios']; ?></a>
		</li>

		<?php }
	if((permisosAcc($_SESSION['login'],2,5)==true)){ ?>
		<li>
			<a href="../Controllers/GRUPO_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de grupo']; ?></a>
		</li>
		<?php }
	if((permisosAcc($_SESSION['login'],5,5)==true)){ ?>
		<li>
			<a href="../Controllers/PERMISO_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestión de permisos']; ?></a>
		</li>
		<?php }
	if((permisosAcc($_SESSION['login'],3,5)==true)){ ?>
		<li>
			<a href="../Controllers/FUNCIONALIDAD_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de funcionalidades']; ?></a>
		</li>
		<?php }
	if((permisosAcc($_SESSION['login'],4,5)==true)){ ?>
		<li>
			<a href="../Controllers/ACCION_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de acciones']; ?></a>
		</li>
		<?php }
	if((permisosAcc($_SESSION['login'],11,5)==true)){ ?>
		<li>
			<a href="../Controllers/TRABAJO_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de trabajos']; ?></a>
		</li>
		<?php }
	if((permisosAcc($_SESSION['login'],10,5)==true)){ ?>
		<li>
			<a href="../Controllers/HISTORIA_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de historias']; ?></a>

		</li>
		<?php }
	if((permisosAcc($_SESSION['login'],6,5)==true)){ ?>
		<li>
			<a href="../Controllers/ASIGNAC_QA_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestión de QAs']; ?></a>
		</li>
		<?php }
		 if(comprobarAdministrador($_SESSION['login']== true) || (permisosAcc($_SESSION['login'],8,10)==true)){?>

		<?php if(comprobarAdministrador($_SESSION['login'])==true){ ?>
		<li>
			<a href="../Controllers/ENTREGA_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de entregas']; ?></a>
		</li>
		<?php }else
		                       if((permisosAcc($_SESSION['login'],8,10)==true)){ ?>
		<li>
			<a href="../Controllers/TRABAJO_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de entregas']; ?></a>
		</li>
		<?php } ?>
		<?php }
		 if((permisosAcc($_SESSION['login'],7,5)==true)){?>
		<li>
			<a href="../Controllers/NOTA_TRABAJO_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de notas']; ?></a>

		</li>

		<?php }
	if((permisosAcc($_SESSION['login'],12,5)==true)){ ?>
		<li>
			<a href="../Controllers/EVALUACION_CONTROLLER.php" class="primerNivel"><?php echo $strings['Gestion de evaluaciones']; ?></a>
		</li>
		<?php }
	if((permisosAcc($_SESSION['login'],12,10)==true)){ ?>
		<li>
			<a href="../Controllers/EVALUACION_CONTROLLER.php?action=EVALUACION_HISTORIAS_ASIGNADAS" class="primerNivel"><?php echo $strings['Evaluar Historias QA']; ?></a>
		</li>
		<?php }
	if((permisosAcc($_SESSION['login'],12,11)==true)){ ?>
		<li>
			<a href="../Controllers/EVALUACION_CONTROLLER.php?action=EVALUACION_HISTORIAS" class="primerNivel"><?php echo $strings['Evaluar Historias']; ?></a>
		</li>
		<?php }

		 if((permisosAcc($_SESSION['login'],9,7)==true)){?>
		<li>
			<a href="../Controllers/EVALUACION_CONTROLLER.php?action=MOSTRAR_CORRECCION_QA" class="primerNivel"><?php echo $strings['Consulta de correciones']; ?></a>
		</li>
		<?php }
		if(permisosAcc($_SESSION['login'],13,7)==true){ ?>
		<li>
			<a href="../Controllers/EVALUACION_CONTROLLER.php?action=MOSTRAR_CORRECCION_ET" class="primerNivel"><?php echo $strings['Correción entregas']; ?></a>
		</li>

		<?php }
	if((permisosAcc($_SESSION['login'],6,8)==true)){ ?>
		<li>
			<a href="../Controllers/ASIGNAC_QA_CONTROLLER.php?action=GENERAR" class="primerNivel"><?php echo $strings['GENERACIÓN DE QAs']; ?></a>
		</li>
		<?php }
	if((permisosAcc($_SESSION['login'],6,9)==true)){ ?>
		<li>
			<a href="../Controllers/ASIGNAC_QA_CONTROLLER.php?action=HISTORIAS" class="primerNivel"><?php echo $strings['GENERACIÓN DE HISTORIAS EVALUACIÓN']; ?></a>
		</li>
		<?php }
	if((permisosAcc($_SESSION['login'],7,13)==true)){ ?>
		<li>
			<a href="../Controllers/NOTA_TRABAJO_CONTROLLER.php?action=GENERAR_NOTA_ENTREGA" class="primerNivel"><?php echo $strings['GENERACIÓN NOTAS ENTREGA']; ?></a>
		</li>
		<?php }
	if((permisosAcc($_SESSION['login'],7,8)==true)){ ?>
		<li>
			<a href="../Controllers/NOTA_TRABAJO_CONTROLLER.php?action=GENERAR_NOTA_QA" class="primerNivel"><?php echo $strings['GENERACIÓN NOTAS QA']; ?></a>
		</li>
		<?php } ?>

		<?php } ?>
	</ul>
</nav>