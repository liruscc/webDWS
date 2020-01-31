<?php
require_once ('plantilla/header.php');
require_once ('plantilla/nav.php');
require_once('controllers/clientesctrl.php');
require_once('views/helpers.php');
?>

<div id="container" class="d-flex flex-row col-lg-12 col-md-12 col-sm-12 justify-content-center">
    <?php
    require_once ('plantilla/leftmenu.php');
    echo '<div class="col-lg-8 col-md-8 col-sm-8">';
    //LLamamos al método estático que lista todos los clientes
    $clientes = new clientctrl();
    $clientes->listarClientes();

    //Si no hay ningún cliente lo mostramos en la tabla
    if ($clientes->getErrores()) {
        error('No existen clientes para mostrar');
    }
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
            echo "</td>";
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