<?php
require_once ('plantilla/header.php');
require_once ('plantilla/nav.php');
?>

<div id="container" class="d-flex flex-row col-lg-12 col-md-12 col-sm-12 justify-content-center">
    <?php
    require_once ('plantilla/leftmenu.php');
    echo '<div class="col-lg-8 col-md-8 col-sm-8">';
    //LLamamos al método estático que lista todos los clientes
    $pedidos = pedido::getPedidos();
    echo "<table class='table'>";
    echo "<tr class='table-info'><td>Código pedido</td><td>Cliente</td><td>Estado</td></tr>";
    //Si no hay ningún cliente lo mostramos en la tabla
    if (!$pedidos) {
        echo "<td colspan='9'><b>No existen pedidos para mostrar</b></td>";
        //Si existen clientes mostramos un cliente por fila
    } else {
        foreach ($pedidos as $key => $value) {
            echo "<tr>";
            echo "<td>" . $value->getCodigo() . "</td>";
            echo "<td>" . $value->getDni() . "</td>";
            echo "<td>" . $value->getEstado() . "</td>";
            //Pintamos los enlaces para editar y borrar el cliente pasando como parámetro el dni
            echo "<td><a class='btn btn-warning mr-1 pt-0' href='editarpedido.php?dni=" . $value->getCodigo() . "'><img with='15px' src='img/edit.png'></a>
					<a class='btn btn-danger mr-1 pt-0' href='borrarpedido.php?dni=" . $value->getCodigo() . "'><img with='15px' src='img/delete.png'></a><a class='btn btn-info pt-0' href='verpedido.php?dni=" . $value->getCodigo() . "'><img with='15px' src='img/info.png'></a></td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    echo '</div>';

    require_once ('plantilla/rightmenu.php');
    ?>
</div>

<?php
require_once ('plantilla/footer.php');
?>