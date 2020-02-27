<?php

echo '<div class="col-lg-8 col-md-8 col-sm-8">';
if (isset($_SESSION['tipo'])) {
    if ($_SESSION['tipo'] == 'empleado' || $_SESSION['tipo'] == 'superusuario') {
        //LLamamos al método estático que lista todos los articulos

        $articulos = new articulosctrl();
        $articulos->listar();
        //Si no hay ningún articulo lo mostramos en la tabla
        if ($articulos->getErrores()) {
            error($articulos->getErrores());
        }

        echo '<div class="d-flex justify-content-between">';
        echo '<div class="m-1">' . $articulos->getNombre() . ' de la tienda</div>';
        botonAnadir('articulosForm.php?accion=add', " Nuevo");
        echo '</div>';
        if ($articulos->getData()) {
            $datos = $articulos->getData();
            echo "<table class='table'>";
            echo "<tr class='table-info'><td>Código artículo</td><td>Descripción</td><td>Precio</td><td>En promoción</td></tr>";
            for ($i = 0; $i < count($articulos->getData()); $i++) {
                echo "<tr>";
                echo "<td>" . $datos[$i]->getCodigo() . "</td><td>" . $datos[$i]->getDescripcion() . "</td><td>" . $datos[$i]->getPrecio() . "</td><td>"
                . $datos[$i]->getPromocion() . "</td>";
                echo "<td>";
                botonEditar("articulosForm.php?accion=update&ref=" . $datos[$i]->getCodigo());
                botonDesactivar("articulosForm.php?accion=delete&ref=" . $datos[$i]->getCodigo());
                botonInfo("articulosForm.php?accion=update&ref=" . $datos[$i]->getCodigo());
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