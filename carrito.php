<?php
require_once ('plantilla/header.php');
require_once ('plantilla/nav.php');
?>

<div id = "container" class="d-flex flex-row col-lg-12 col-md-12 col-sm-12 justify-content-center">
    <?php
    require_once ('plantilla/leftmenu.php');
    ?>
    <div class ='col-lg-8 col-md-8 col-sm-8'>
        <?php
        mostrar_carrito();
        ?>	
    </div>

    <?php
    require_once ('plantilla/rightmenu.php');
    ?>
</div>

<?php
require_once ('plantilla/footer.php');

function mostrar_carrito() {

    //Si el carrito está vacío mostramos la frase carrito vacío
    if (isCarritoVacio() == true) {
        echo "<h4>El carrito está vacío</h4>";
        //Si el carrito no está vacío mostramos la tabla con los productos del carrito
    } else {
        $numUnidades = 0;
        echo "<table class='table'>";
        echo "<tr class='table-info'><td>Articulo</td><td>Cantidad</td><td>Precio unitario</td><td>Precio</td></tr>";

        //Recorro la cookie y pinto la tabla con el contenido actual
        foreach ($_COOKIE["carrito"] as $ref => $unidades) {
            $articulo = articulo::getArticulo($ref);
            echo "<tr>";
            echo "<td>" . $articulo[0]->getDescripcion() . "</td><td>" . $unidades . "</td><td>" . $articulo[0]->getPrecio() . "</td><td>" . $articulo[0]->getPrecio() * $unidades . "</td><td><a class='btn btn-success mr-1 pt-0' href='accionescarrito.php?act=up&ref=" . $articulo[0]->getCodigo() . "'>+<a><a class='btn btn-warning mr-1 pt-0' href='accionescarrito.php?act=down&ref=" . $articulo[0]->getCodigo() . "'>-<a><a class='btn btn-danger pt-0' a href='accionescarrito.php?act=delete&ref=" . $articulo[0]->getCodigo() . "'><img with='15px' src='img/delete.png'><a></td>";
            echo "</tr>";
            echo "<tr>";
            echo "</tr>";
            $numUnidades += $unidades;
        }
        echo "<tr><td colspan='3'>Numero total de unidades: </td><td>$numUnidades</td></tr>";
        echo "<tr><td colspan='3'>Importe total de unidades: </td> <td>" . articulo::calcularImporte() . "</td></tr>";
        echo "</table>";
        echo "<div class='row'>
			<div><a class='btn btn-warning m-2' href ='index.php'>Seguir comprando</a></div>
			<div><a class='btn btn-success m-2' href ='realizarcompra.php'>Realizar compra</a></div>
			</div>";
    }
}
?>