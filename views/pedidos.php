<?php

echo '<div class="col-lg-8 col-md-8 col-sm-8">';
if (isset($_SESSION['tipo'])) {
    if ($_SESSION['tipo'] == 'empleado' || $_SESSION['tipo'] == 'superusuario') {
        //LLamamos al método estático que lista todos los $categorias

        $pedidos = new pedidosctrl();
        $pedidos->listar();
        //Si no hay ningún articulo lo mostramos en la tabla
        if ($pedidos->getErrores()) {
            error($pedidos->getErrores());
        }
        echo '<div class="d-flex justify-content-between">';
        echo '<div class="m-1">Categorías de la tienda</div>';
        botonAnadir("categoryForm.php?act=add", "Nueva");
        echo '</div>';
        if ($pedidos->getData()) {
            $datos = $pedidos->getData();
            echo "<table class='table'>";
            echo "<tr class='table-info'><td>Código pedido</td><td>Cliente</td><td>Estado</td></tr>";
            for ($i = 0; $i < count($pedidos->getData()); $i++) {
                echo "<tr>";
                echo "<td>" . $datos[$i]->getCodigo() . "</td><td>" . $datos[$i]->getDni() . "</td><td>" . $datos[$i]->getEstado() . "</td><td>"
                . $datos[$i]->getActivo() . "</td>";
                echo "<td>";
                if ($datos[$i]->getActivo()) {
                    botonDesactivar("orderForm.php?cod=" . $datos[$i]->getCodigo() . "&act=deactivate");
                } else {
                    botonActivar("orderForm.php?cod=" . $datos[$i]->getCodigo() . "&act=activate");
                }
                botonEditar("orderForm.php?cod=" . $datos[$i]->getCodigo() . "&act=update");

                botonInfo("orderForm.php?cod=" . $datos[$i]->getCodigo());
                echo "</tr>";
            }
            echo "</table>";
        }
    } else {
        echo '<h5>Acceso denegado</h5>';
    }
} else {
    echo '<h5>Acceso denegado</h5>';
}
echo '</div>';
?>