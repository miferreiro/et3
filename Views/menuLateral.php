<!--Creado el 8 de noviembre del 2017 por de3t7q/-->
<!--Contiene la vista del menu lateral-->
    <script type="text/javascript" src="../Views/js/desplegarMenu.js"></script> 
	<link href="https://fonts.googleapis.com/css?family=Raleway:200,400,600" rel="stylesheet" type="text/css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript">
	</script>
	<link href="../Views/css/estiloFinal.css" rel="stylesheet" type="text/css">

		<div class="menujq">
			<ul>
				<!--Diferentes opciones de la lista y sus links-->


				<li>
					<div>
						<a href="#cabecera"><?php echo $strings['Inicio']; ?></a>
					</div>
				</li>


				<li>
					<a href="javascript:void();"><?php echo $strings['usuarios']; ?></a>

					<ul>
						<li>
							<a href="../Controllers/usuarios_Controller.php?action=ADD"><?php echo $strings['Insertar Usuario']; ?></a>
						</li>


						<li>
							<a href="../Controllers/usuarios_Controller.php?action=SEARCH"><?php echo $strings['Buscar Usuario']; ?></a>
						</li>

					</ul>
				</li>


				<li>
					<a href="../Controllers/usuarios_Controller.php"><?php echo $strings['Mostrar todos']; ?></a>
				</li>



				<li>
					<a href="#footer"><?php echo $strings['Footer']; ?></a>
				</li>
			</ul>
		</div>
                