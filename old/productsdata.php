<?php
require_once ('plantilla/header.php');
require_once ('plantilla/nav.php');
?>

<div id="container" class="d-flex flex-row col-lg-12 col-md-12 col-sm-12 justify-content-center">
    <?php
    require_once ('plantilla/leftmenu.php');

    echo '<div class="col-lg-8 col-md-8 col-sm-8">';
    if (isset($_SESSION['tipo'])) {
        if ($_SESSION['tipo'] == 'empleado' || $_SESSION['tipo'] == 'superusuario') {
            //LLamamos al método estático que lista todos los clientes
            $pedidos = articulo::getArticulos();
            echo "<table class='table'>";
            echo "<tr class='table-info'><td>Código artículo</td><td>Descripción</td><td>Precio</td><td>En promoción</td></tr>";
            //Si no hay ningún cliente lo mostramos en la tabla
            if (!$pedidos) {
                echo "<td colspan='9'><b>No existen artículos para mostrar</b></td>";
                //Si existen clientes mostramos un cliente por fila
            } else {
                foreach ($pedidos as $key => $value) {
                    echo "<tr>";
                    echo "<td>" . $value->getCodigo() . "</td>";
                    echo "<td>" . $value->getDescripcion() . "</td>";
                    echo "<td>" . $value->getPrecio() . "</td>";
                    echo "<td>" . $value->getPromocion() . "</td>";
                    //Pintamos los enlaces para editar y borrar el cliente pasando como parámetro el dni
                    echo "<td><a class='btn btn-warning mr-1 pt-0' href='productForm.php?ref=" . $value->getCodigo() . "'><img with='15px' src='img/edit.png'></a>
					<a class='btn btn-danger mr-1 pt-0' href='productForm.php?ref=" . $value->getCodigo() . "'><img with='15px' src='img/delete.png'></a><a class='btn btn-info pt-0' href='productForm.php?ref=" . $value->getCodigo() . "'><img with='15px' src='img/info.png'></a></td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
        } else {
            echo '<h5>Acceso denegado</h5>';
        }
    } else {
        echo '<h5>Acceso denegado</h5>';
    }
    echo '</div>';
    require_once ('plantilla/rightmenu.php');
    ?>
</div>

<?php
require_once ('plantilla/footer.php');
?>