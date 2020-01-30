<?php
require_once ('plantilla/header.php');
require_once ('plantilla/nav.php');
require_once('classes/cliente.php');
?>

<div id="container" class="d-flex flex-row col-lg-12 col-md-12 col-sm-12 justify-content-center">
    <?php
    require_once ('plantilla/leftmenu.php');
    echo '<div class="col-lg-8 col-md-8 col-sm-8">';
    //LLamamos al método estático que lista todos los clientes
    $clientes = cliente::getClientes();
    echo "<table class='table'>";
    echo "<tr class='table-info'><td>Dni</td><td>Nombre</td><td>Dirección</td><td>Localidad</td><td>Provincia</td><td>Teléfono</td><td>Email</td></tr>";
    //Si no hay ningún cliente lo mostramos en la tabla
    if (!$clientes) {
        echo "<td colspan='7'><b>No existen clientes para mostrar</b></td>";
        //Si existen clientes mostramos un cliente por fila
    } else {
        foreach ($clientes as $key => $value) {
            echo "<tr>";
            echo $value;
            //Pintamos los enlaces para editar y borrar el cliente pasando como parámetro el dni
            echo "<td><a class='btn btn-warning mr-1' href='editarcliente.php?dni=" . $value->getDni() . "'><img with='15px' src='img/edit.png'></a>
					<a class='btn btn-danger' href='borrarcliente.php?dni=" . $value->getDni() . "'><img with='15px' src='img/delete.png'></a></td>";
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