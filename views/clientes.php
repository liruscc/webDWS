<?php

echo '<div class="col-lg-8 col-md-8 col-sm-8">';
if (isset($_SESSION['tipo'])) {
    if ($_SESSION['tipo'] == 'empleado' || $_SESSION['tipo'] == 'superusuario') {

        //LLamamos al método estático que lista todos los clientes
        $clientes = new clientesctrl();
        $clientes->listar();

        //Si no hay ningún cliente lo mostramos en la tabla
        if ($clientes->getErrores()) {
            error($clientes->getErrores());
        }

        pageTitle($clientes->getNombre());
        if ($clientes->getData()) {
            $datos = $clientes->getData();
            echo "<table class='table'>";
            echo "<tr class='table-info'><td>Dni</td><td>Nombre</td><td>Dirección</td><td>Localidad</td><td>Provincia</td><td>Teléfono</td><td>Email</td></tr>";
            for ($i = 0; $i < count($clientes->getData()); $i++) {
                echo "<tr>";
                echo "<td>" . $datos[$i]->getDni() . "</td><td>" . $datos[$i]->getNombre() . "</td><td>" . $datos[$i]->getDireccion() . "</td><td>"
                . $datos[$i]->getLocalidad() . "</td><td>" . $datos[$i]->getProvincia() . "</td><td>" . $datos[$i]->getTelefono() . "</td><td class='breaktext'>" . $datos[$i]->getEmail();
                //Pintamos los enlaces para editar y borrar el cliente pasando como parámetro el dni
                echo "<td>";
                echo botonEditar("editarcliente.php?dni=" . $datos[$i]->getDni());
                echo botonDesactivar("borrarcliente.php?dni=" . $datos[$i]->getDni());
                echo botonInfo("borrarcliente.php?dni=" . $datos[$i]->getDni());
                echo "</td>";
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
?>