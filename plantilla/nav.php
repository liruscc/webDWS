<?php

	$numUnidades = 0;
	$impTotal = 0;
	//Si el carrito está vacío mostramos la frase carrito vacío
	if (isCarritoVacio() == true){
		$numUnidades = 'Carrito vacío';
	//Si el carrito no está vacío mostramos la tabla con los productos del carrito
	}else{
    	//Recorro la cookie y pinto la tabla con el contenido actual
    	foreach ($_COOKIE["carrito"] as $ref=>$unidades){
            $numUnidades+=$unidades;
    	}

    	$impTotal = articulo::calcularImporte();
	}

	function isCarritoVacio(){
		$vacio = true;
		//Comprobamos si ya hay cookie de pedido
		if(isset ($_COOKIE["carrito"])){
			$vacio = false;
		}
		else{
			$vacio = true;
		}
		return $vacio;
	}
?>
<nav>
	<ul class="navbar navbar-expand-lg navbar-light bg-light justify-content-center ml-0">
		<li class="nav-item col-lg-2 col-md-2 text-center">
			<a class="nav-link" href="index.php">Inicio</a>
		</li>
		<li class="nav-item col-lg-2 col-md-2 text-center">
			<a class="nav-link" href="">¿Quienes somos?</a>
		</li>
		<li class="nav-item col-lg-2 col-md-2 text-center">
			<a class="nav-link" href="">Contacto</a>
		</li>
		<li class="nav-item col-lg-2 col-md-2 text-center">
			<a class="nav-link" href="">Envío</a>
		</li>
		<li class="nav-item col-lg-4 col-md-4">
			<a href="carrito.php">
			<div class="d-flex flex-row justify-content-center">
				<div class="p-2">
					<img src="img/cart.png" height="30px">
				</div>
				<div class="p-2">
					Articulos: <?php echo $numUnidades;?>
				</div>
				<div class="p-2">
					Total: <?php echo $impTotal;?>
				</div>
			</div>
			</a>
		</li>
	</ul>
</nav>