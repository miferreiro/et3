<!--
	Archivo php
	Nombre: users_menuLateral.php
	Autor: 	fta875
	Fecha de creación: 23/10/2017 
	Función: contiene todas las características del menú lateral
-->
<?php 
include_once '../Functions/permisosAcc.php';
include_once '../Functions/comprobarAdministrador.php';
 /*include_once '../Models/USU_GRUPO_MODEL.php'; 
$USUARIO = new USU_GRUPO( $_SESSION[ 'login' ],'');
$admin = $USUARIO->comprobarAdmin();
$ADD=false;	
$EDIT=false;	
$SEARCH=false;	
$DELETE=false;	
$SHOW=false;
$ASIGN=false;
$GESTUSU=false;
$GESTGRUP=false;
$GESTFUNC=false;
$GESTACC=false;
$GESTPERM=false;		
$GESTQAS=false;		
$GESTENTR=false;
$GESTNOTAS=false;
$GESTCORREC=false;
$GESTHIST=false;
$GESTTRAB=false;		
$GESTEVAL=false;
			
$PERMISO = $USUARIO->comprobarPermisos();

	if($admin==true){
			    $ADD=true;	
			    $DELETE=true;				   
			    $EDIT=true;	
			    $SEARCH=true;	
			    $SHOW=true;	
			    $ASIGN=true;
		        $GESTUSU=true;
		        $GESTGRUP=true;
				$GESTFUNC=true;
				$GESTACC=true;
				$GESTPERM=true;		
				$GESTQAS=true;		
				$GESTENTR=true;		
				$GESTHIST=true;
				$GESTTRAB=true;		
				$GESTEVAL=true;
	}	
	while ( $fila = mysqli_fetch_array( $PERMISO ) ) {

	 if($fila['IdFuncionalidad']=='1'){
				$GESTUSU=true;
		 if($fila['IdAccion']=='0'){
			    $ADD=true;	
			   }
		 if($fila['IdAccion']=='1'){
			    $DELETE=true;	
			   }
		 if($fila['IdAccion']=='2'){
			    $EDIT=true;	
			   }
		 if($fila['IdAccion']=='3'){
			    $SEARCH=true;	
			   }
		 if($fila['IdAccion']=='4'){
			    $SHOW=true;	
			   }
		 if($fila['IdAccion']=='6'){
			    $ASIGN=true;	
			   }
			   }
	 if($fila['IdFuncionalidad']=='2'){
				$GESTGRUP=true;
		 if($fila['IdAccion']=='0'){
			    $ADD=true;	
			   }
		 if($fila['IdAccion']=='1'){
			    $DELETE=true;	
			   }
		 if($fila['IdAccion']=='2'){
			    $EDIT=true;	
			   }
		 if($fila['IdAccion']=='3'){
			    $SEARCH=true;	
			   }
		 if($fila['IdAccion']=='4'){
			    $SHOW=true;	
			   }
		 if($fila['IdAccion']=='6'){
			    $ASIGN=true;	
			   }
			   }
	 if($fila['IdFuncionalidad']=='5'){
				$GESTPERM=true;
		 if($fila['IdAccion']=='0'){
			    $ADD=true;	
			   }
		 if($fila['IdAccion']=='1'){
			    $DELETE=true;	
			   }
		 if($fila['IdAccion']=='2'){
			    $EDIT=true;	
			   }
		 if($fila['IdAccion']=='3'){
			    $SEARCH=true;	
			   }
		 if($fila['IdAccion']=='4'){
			    $SHOW=true;	
			   }
		 if($fila['IdAccion']=='6'){
			    $ASIGN=true;	
			   }
			   }
	 if($fila['IdFuncionalidad']=='3'){
				$GESTFUNC=true;
		 if($fila['IdAccion']=='0'){
			    $ADD=true;	
			   }
		 if($fila['IdAccion']=='1'){
			    $DELETE=true;	
			   }
		 if($fila['IdAccion']=='2'){
			    $EDIT=true;	
			   }
		 if($fila['IdAccion']=='3'){
			    $SEARCH=true;	
			   }
		 if($fila['IdAccion']=='4'){
			    $SHOW=true;	
			   }
		 if($fila['IdAccion']=='6'){
			    $ASIGN=true;	
			   }
			   }
	 if($fila['IdFuncionalidad']=='4'){
				$GESTACC=true;
		 if($fila['IdAccion']=='0'){
			    $ADD=true;	
			   }
		 if($fila['IdAccion']=='1'){
			    $DELETE=true;	
			   }
		 if($fila['IdAccion']=='2'){
			    $EDIT=true;	
			   }
		 if($fila['IdAccion']=='3'){
			    $SEARCH=true;	
			   }
		 if($fila['IdAccion']=='4'){
			    $SHOW=true;	
			   }
		 if($fila['IdAccion']=='6'){
			    $ASIGN=true;	
			   }
			   }

			}
*/
?>
<nav>
	<ul class="menu">
<!-- Si hay un usuario logeado (Variable de sesion login con valor) ejecuta el código dento del if
que comprueba permisos para cada una de las acciones -->
<?php if (isset($_SESSION['login'])) { ?>
					<ul class ="menu">
	<?php if((permisosAcc($_SESSION['login'],1,5)==true)||(permisosAcc($_SESSION['login'],1,0)==true)||        (permisosAcc($_SESSION['login'],1,3)==true)){ ?>
				<li>
					<a class="primerNivel"><?php echo $strings['Gestion de usuarios']; ?></a>
						<ul class="submenu">
						<?php if(permisosAcc($_SESSION['login'],1,5)==true){ ?>
							<li>
								<a href="../Controllers/USUARIO_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],1,0)==true){ ?>
							<li>
								<a href="../Controllers/USUARIO_CONTROLLER.php?action=ADD" class="segundoNivel"><?php echo $strings['Añadir']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],1,3)==true){ ?>
							<li>
								<a href="../Controllers/USUARIO_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
							</li>
						<?php } ?>
						</ul>
				</li>

	<?php }
	if((permisosAcc($_SESSION['login'],2,5)==true)||(permisosAcc($_SESSION['login'],2,0)==true)||        (permisosAcc($_SESSION['login'],2,3)==true)){ ?>
				<li>
					<a class="primerNivel"><?php echo $strings['Gestion de grupo']; ?></a>
						<ul class="submenu">
						<?php if(permisosAcc($_SESSION['login'],2,5)==true){ ?>
							<li>
								<a href="../Controllers/GRUPO_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],2,0)==true){ ?>
							<li>
								<a href="../Controllers/GRUPO_CONTROLLER.php?action=ADD" class="segundoNivel"><?php echo $strings['Añadir']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],2,3)==true){ ?>
							<li>
								<a href="../Controllers/GRUPO_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
							</li>
						<?php } ?>
						</ul>
				</li>
	<?php }
	if((permisosAcc($_SESSION['login'],5,5)==true)|| (permisosAcc($_SESSION['login'],5,3)==true)){ ?>
				<li>
					<a class="primerNivel"><?php echo $strings['Gestión de permisos']; ?></a>
						<ul class="submenu">
						<?php if(permisosAcc($_SESSION['login'],5,5)==true){ ?>
							<li>
								<a href="../Controllers/PERMISO_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],5,3)==true){ ?>
							<li>
								<a href="../Controllers/PERMISO_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
							</li>
						<?php } ?>
						</ul>
				</li>
	<?php }
	if((permisosAcc($_SESSION['login'],3,5)==true)||(permisosAcc($_SESSION['login'],3,0)==true)||        (permisosAcc($_SESSION['login'],3,3)==true)){ ?>
				<li>
					<a class="primerNivel"><?php echo $strings['Gestion de funcionalidades']; ?></a>
						<ul class="submenu">
						<?php if(permisosAcc($_SESSION['login'],3,5)==true){ ?>
							<li>
								<a href="../Controllers/FUNCIONALIDAD_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],3,0)==true){ ?>
							<li>
								<a href="../Controllers/FUNCIONALIDAD_CONTROLLER.php?action=ADD" class="segundoNivel"><?php echo $strings['Añadir']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],3,3)==true){ ?>
							<li>
								<a href="../Controllers/FUNCIONALIDAD_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
							</li>
						<?php } ?>
						</ul>
				</li>
	<?php }
	if((permisosAcc($_SESSION['login'],4,5)==true)||(permisosAcc($_SESSION['login'],4,0)==true)||        (permisosAcc($_SESSION['login'],4,3)==true)){ ?>
				<li>
					<a class="primerNivel"><?php echo $strings['Gestion de acciones']; ?></a>
						<ul class="submenu">
						<?php if(permisosAcc($_SESSION['login'],4,5)==true){ ?>
							<li>
								<a href="../Controllers/ACCION_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],4,0)==true){ ?>
							<li>
								<a href="../Controllers/ACCION_CONTROLLER.php?action=ADD" class="segundoNivel"><?php echo $strings['Añadir']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],4,3)==true){ ?>
							<li>
								<a href="../Controllers/ACCION_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
							</li>
						<?php } ?>
						</ul>
				</li>
	<?php }
	if((permisosAcc($_SESSION['login'],11,5)==true)||(permisosAcc($_SESSION['login'],11,0)==true)||        (permisosAcc($_SESSION['login'],11,3)==true)){ ?>
				<li>
					<a class="primerNivel"><?php echo $strings['Gestion de trabajos']; ?></a>
						<ul class="submenu">
						<?php if(permisosAcc($_SESSION['login'],11,5)==true){ ?>
							<li>
								<a href="../Controllers/TRABAJO_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],11,0)==true){ ?>
							<li>
								<a href="../Controllers/TRABAJO_CONTROLLER.php?action=ADD" class="segundoNivel"><?php echo $strings['Añadir']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],11,3)==true){ ?>
							<li>
								<a href="../Controllers/TRABAJO_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
							</li>
						<?php } ?>
						</ul>
				</li>
	<?php }
	if((permisosAcc($_SESSION['login'],10,5)==true)||(permisosAcc($_SESSION['login'],10,0)==true)||        (permisosAcc($_SESSION['login'],10,3)==true)){ ?>
				<li>
					<a class="primerNivel"><?php echo $strings['Gestion de historias']; ?></a>
						<ul class="submenu">
						<?php if(permisosAcc($_SESSION['login'],10,5)==true){ ?>
							<li>
								<a href="../Controllers/HISTORIA_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],10,0)==true){ ?>
							<li>
								<a href="../Controllers/HISTORIA_CONTROLLER.php?action=ADD" class="segundoNivel"><?php echo $strings['Añadir']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],10,3)==true){ ?>
							<li>
								<a href="../Controllers/HISTORIA_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
							</li>
						<?php } ?>
						</ul>
				</li>

	<?php }
		 if((permisosAcc($_SESSION['login'],6,0)==true)||(permisosAcc($_SESSION['login'],6,3)==true) || (permisosAcc($_SESSION['login'],6,5)==true) ||(permisosAcc($_SESSION['login'],6,8)==true) ||(permisosAcc($_SESSION['login'],6,9)==true)){?>
				<li>
					<a class="primerNivel"><?php echo $strings['Gestión de QAs']; ?></a> 
						<ul class="submenu">
						<?php if(permisosAcc($_SESSION['login'],6,5)==true){ ?>
							<li>
								<a href="../Controllers/ASIGNAC_QA_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],6,0)==true){ ?>
							<li>
								<a href="../Controllers/ASIGNAC_QA_CONTROLLER.php?action=ADD" class="segundoNivel"><?php echo $strings['Añadir']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],6,3)==true){ ?>
							<li>
								<a href="../Controllers/ASIGNAC_QA_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
							</li>
						<?php } 
							if(permisosAcc($_SESSION['login'],6,8)==true){ ?>
							<li>
								<a href="../Controllers/ASIGNAC_QA_CONTROLLER.php?action=GENERAR" class="segundoNivel"><?php echo $strings['GENERACIÓN DE QAs']; ?></a>
							</li>
						<?php } 
							if(permisosAcc($_SESSION['login'],6,9)==true){ ?>
							<li>
								<a href="../Controllers/ASIGNAC_QA_CONTROLLER.php?action=HISTORIAS" class="segundoNivel"><?php echo $strings['GENERACIÓN DE HISTORIAS EVALUACIÓN']; ?></a>
							</li>
						<?php } ?>
						</ul>
				</li>
	<?php }
		 if(comprobarAdministrador($_SESSION['login']) || (permisosAcc($_SESSION['login'],8,0)==true)||(permisosAcc($_SESSION['login'],8,3)==true) || (permisosAcc($_SESSION['login'],8,10)==true)){?>
				<li>
					<a class="primerNivel"><?php echo $strings['Gestion de entregas']; ?></a> 
						<ul class="submenu">
						<?php if(comprobarAdministrador($_SESSION['login'])==true){ ?>
							<li>
								<a href="../Controllers/ENTREGA_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
							</li>
						<?php }else
		                       if((permisosAcc($_SESSION['login'],8,3)==true)){ ?>
							<li>
								<a href="../Controllers/TRABAJO_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
							</li>			 
						<?php }
							 if(permisosAcc($_SESSION['login'],8,0)==true){ ?>
							<li>
								<a href="../Controllers/ENTREGA_CONTROLLER.php?action=ADD" class="segundoNivel"><?php echo $strings['Añadir']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],8,3)==true){ ?>
							<li>
								<a href="../Controllers/ENTREGA_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
							</li>
						<?php } ?>
						</ul>
				</li>

	<?php }
	if((permisosAcc($_SESSION['login'],12,5)==true)||(permisosAcc($_SESSION['login'],12,0)==true)||        (permisosAcc($_SESSION['login'],12,3)==true)){ ?>
				<li>
					<a class="primerNivel"><?php echo $strings['Gestion de evaluaciones']; ?></a>
						<ul class="submenu">
						<?php if(permisosAcc($_SESSION['login'],12,5)==true){ ?>
							<li>
								<a href="../Controllers/EVALUACION_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],12,0)==true){ ?>
							<li>
								<a href="../Controllers/EVALUACION_CONTROLLER.php?action=ADD" class="segundoNivel"><?php echo $strings['Añadir']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],12,3)==true){ ?>
							<li>
								<a href="../Controllers/EVALUACION_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
							</li>
						<?php } ?>
						</ul>
				</li>
	<?php }
		 if((permisosAcc($_SESSION['login'],9,7)==true)||(permisosAcc($_SESSION['login'],13,7)==true)){?>
				<li>
					<a class="primerNivel"><?php echo $strings['Consulta de correciones']; ?></a> 
						<ul class="submenu">
						<?php if(permisosAcc($_SESSION['login'],9,7)==true){ ?>
							<li>
								<a href="../Controllers/CORRECION_QA_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Correción QAs']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],13,7)==true){ ?>
							<li>
								<a href="../Controllers/CORRECION_ENTREGA_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Correción entregas']; ?></a>
							</li>
                        <?php } ?>
						</ul>
				</li>
	<?php }
		 if((permisosAcc($_SESSION['login'],7,0)==true)||(permisosAcc($_SESSION['login'],7,3)==true) || (permisosAcc($_SESSION['login'],7,5)==true)){?>
				<li>
					<a class="primerNivel"><?php echo $strings['Gestion de notas']; ?></a> 
						<ul class="submenu">
						<?php if(permisosAcc($_SESSION['login'],7,5)==true){ ?>
							<li>
								<a href="../Controllers/NOTAS_CONTROLLER.php" class="segundoNivel"><?php echo $strings['Mostrar todos']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],7,0)==true){ ?>
							<li>
								<a href="../Controllers/NOTAS_CONTROLLER.php?action=ADD" class="segundoNivel"><?php echo $strings['Añadir']; ?></a>
							</li>
						<?php }
							 if(permisosAcc($_SESSION['login'],7,3)==true){ ?>
							<li>
								<a href="../Controllers/NOTAS_CONTROLLER.php?action=SEARCH" class="segundoNivel"><?php echo $strings['Buscador']; ?></a>
							</li>
						<?php } ?>


	<?php } ?>
			</ul>
<?php } ?>
	</ul>
</nav>