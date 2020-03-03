<?php
$subcat = false;
$cat = false;
$error = false;
$numArticulos = '8';
$pag = '0';

if (isset($_GET["cat"])) {
    $cat = $_GET["cat"];
}
if (isset($_GET["subcat"])) {
    $subcat = $_GET["subcat"];
}
if (isset($_GET["pag"])) {
    $pag = $_GET["pag"];
}

if (isset($_GET["error"])) {
    $error = $_GET["error"];
}

if (!$_POST) {
    $consulta = articulo::imprimirArticulosPaginados($cat, $subcat, $numArticulos, $pag);
    $articulos = $consulta[0];
}

if ($_POST) {
    $consulta = articulo::buscarArticulos($_POST['cadena']);
    $articulos = $consulta[0];
}
?>

<div class = "col-lg-8 col-md-8 col-sm-8">
    <?php
    if ($error) {
        echo "<div id='errores' class='alert alert-danger p-1'>";
        echo $error;
        echo "</div>";
    }
    ?>	
    <form class="form-inline md-form form-sm mt-1 mb-2" method="post" action="<?php echo 'index.php' ?>">
        <input class="form-control form-control-sm mr-3 w-50" name ="cadena" type="text" placeholder="Search" aria-label="Search"/>
        <input class='btn btn-outline-primary px-2 py-1' type="submit" value="Buscar"/>
    </form>

    <div class = "resultado">
        <?php if ($articulos) echo 'Total articulos: ' . $consulta[1]; ?>
    </div>
    <div class = "d-flex flex-row flex-wrap justify-content-center">
        <?php
        if (!$articulos) {
            echo 'No hay articulos para mostrar';
        } else {
            foreach ($articulos as $key => $value) {
                echo '<div class="p-2 producto">
					<div>
						<div class="descripcion">' . $value->getDescripcion() . '</div>
					</div>	
					<div class="imgwrapper">
						<img src="img/articulos/' . $value->getCodigo() . '.png">
					</div>
					<div class="infowrapper">
						<div class="price">' . $value->getPrecio() . '</div>
					</div>
					<div class="botonwrapper text-center row justify-content-center">';
                if (isset($_SESSION['tipo'])) {
                    if ($_SESSION['tipo'] == 'navegante' || $_SESSION['tipo'] == 'registrado') {
                        echo '<div><a class="btn btn-success" href="compra.php?ref=' . $value->getCodigo() . '&pre=' . $value->getPrecio() . '&cat=' . $cat . '&subcat=' . $subcat . '">Comprar</a></div>';
                    }
                    if ($_SESSION['tipo'] == 'superusuario' || $_SESSION['tipo'] == 'empleado') {
                        echo '<a class="btn btn-warning pt-0" href="articulosForm.php?accion=update&ref=' . $value->getCodigo() . '"><img width="15px" src="img/edit.png"></a>';
                        echo '<a class="btn btn-danger pt-0" href="productactions.php?ref=' . $value->getCodigo() . '&act=delete"><img width="15px" src="img/delete.png"></a></td>';
                    }
                } else {
                    echo '<div><a class="btn btn-success" href="compra.php?ref=' . $value->getCodigo() . '&pre=' . $value->getPrecio() . '&cat=' . $cat . '&subcat=' . $subcat . '">Comprar</a></div>';
                }
                echo '</div>
				</div>';
            }
        }
        ?>
    </div>

    <?php
    if (!$_POST) {
        if ($articulos && $consulta[1] > $numArticulos) {
            $numPaginas = ceil($consulta[1] / $numArticulos);
            $paginaAnterior = ($pag - 1 < 0) ? $pag : $pag - 1;
            $paginaSiguiente = ($pag + 1 <= $numPaginas - 1) ? $pag + 1 : $pag;
            echo '<nav>';
            echo '<ul class="pagination justify-content-center">';
            echo '<li class="page-item"><a class="page-link" ref="index.php?cat=' . $cat . '&subcat=' . $subcat . '&pag=' . $paginaAnterior . '""><</a></li>';
            for ($i = 0; $i < $numPaginas; $i++) {
                echo '<li class="page-item"><a class="page-link" href="index.php?cat=' . $cat . '&subcat=' . $subcat . '&pag=' . $i . '"">' . ($i + 1) . '</a></li>';
            }
            echo '<li class="page-item"><a class="page-link" href="index.php?cat=' . $cat . '&subcat=' . $subcat . '&pag=' . $paginaSiguiente . '"">></a></li>';
            echo '</ul>';
            echo '</nav>';
        }
    }
    ?>
</div>