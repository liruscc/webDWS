<?php

echo '<div class="col-lg-8 col-md-8 col-sm-8">';
if (isset($_SESSION['tipo'])) {
    if ($_SESSION['tipo'] == 'empleado' || $_SESSION['tipo'] == 'superusuario') {
        //LLamamos al método estático que lista todos los $categorias

        $categorias = new categoriasctrl();
        $categorias->listar();
        //Si no hay ningún articulo lo mostramos en la tabla
        if ($categorias->getErrores()) {
            error($categorias->getErrores());
        }
        echo '<div class="d-flex justify-content-between">';
        echo '<div class="m-1">Categorías de la tienda</div>';
        botonAñadir("categoryForm.php?act=add", "Nueva");
        echo '</div>';
        if ($categorias->getData()) {
            $datos = $categorias->getData();
            echo "<table class='table'>";
            echo "<tr class='table-info'><td>Código categoria</td><td>Nombre</td><td>Activa</td></tr>";
            for ($i = 0; $i < count($categorias->getData()); $i++) {
                echo "<tr>";
                echo "<td>" . $datos[$i]->getCodigo() . "</td><td>" . $datos[$i]->getNombre() . "</td><td>" . $datos[$i]->getActivo() . "</td><td>"
                . $datos[$i]->getActivo() . "</td>";
                echo "<td>";
                if ($datos[$i]->getActivo()) {
                    botonDesactivar("categoryForm.php?cod=" . $datos[$i]->getCodigo() . "&act=deactivate");
                } else {
                    botonActivar("categoryForm.php?cod=" . $datos[$i]->getCodigo() . "&act=activate");
                }
                botonEditar("categoryForm.php?cod=" . $datos[$i]->getCodigo() . "&act=update");

                botonInfo("categoryForm.php?cod=" . $datos[$i]->getCodigo());
                echo "</tr>";
            }
            echo "</table>";
        }
        echo '</div>';
    } else {
        echo '<h5>Acceso denegado</h5>';
    }
} else {
    echo '<h5>Acceso denegado</h5>';
}
?>