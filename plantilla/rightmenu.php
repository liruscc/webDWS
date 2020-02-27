 <div class = "col-lg-2 col-md-2 col-sm-2">
<aside>
<?php
	if(!isset($_SESSION['id'])){
?>

	<form id="login" method="POST" action="autenticar.php">
		<div class="form-group">
			<label for="usuario">Login:</label><br/>
			<input type="text" name="usuario" id="usuario" size="8" maxlength="9"/><br/>
		</div>
		<div class="form-group">
			<label for="password">Contraseña:</label><br/>
			<input type="password" name="password" id="password" size="8" maxlength="10"/><br/>
		</div>	
		<input class="btn btn-primary" type="submit" name="Entrar" value="Entrar" />
	</form>
	<a href='register.php'>Registrarse</a>
<?php
	}else{
            $user = cliente::getClient($_SESSION['id']);
            $nombre = $user->getNombre();
?>
	<div class="d-flex flex-row no-wrap">
		<div class="text"><?php echo "Bienvenid@ ".$nombre;?></div>
		<div class="ml-3"><a class='btn btn-danger pt-0' href="autenticar.php?logout"><img with='15px' src='img/logout.png'></a></div>
	</div>

	<nav class="navbar fixed-left">
		<ul>
			<?php
				if($_SESSION['tipo']=='registrado' || $_SESSION['tipo']=='navegante'){
					echo '<li class="nav-item"><a class="nav-link" href="index.php?menu=clientesForm">Editar datos</a></li>';
					echo '<li class="nav-item"><a class="nav-link" href="index.php?menu=pedidos">Ver pedidos</a></li>';
				}
				if($_SESSION['tipo']=='superusuario'){
					echo '<li class="nav-item"><a class="nav-link" href="index.php?menu=clientes&empleados ">Gestionar empleados</a></li>';
				}
				if($_SESSION['tipo']=='empleado' || $_SESSION['tipo']=='superusuario'){
                                        echo '<li class="nav-item"><a class="nav-link" href="index.php?menu=clientes">Gestionar clientes</a></li>';
					echo '<li class="nav-item"><a class="nav-link" href="index.php?menu=pedidos">Gestionar pedidos</a></li>';
					echo '<li class="nav-item"><a class="nav-link" href="index.php?menu=articulos">Gestionar artículos</a></li>';
					echo '<li class="nav-item"><a class="nav-link" href="index.php?menu=categorias">Gestionar categorías</a></li>';
				}
			?>
		</ul>
	</nav>
	<?php	
	}
?>
</aside>
</div>