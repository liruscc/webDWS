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
    $categorias = categoria::getCategorias(false);
    echo '<div class="d-flex justify-content-between">';
    echo '<div class="m-1">Categorías de la tienda</div>';
    echo '<div class="m-1"><a class="btn btn-success mr-1 pt-0" href="categoryForm.php?act=add"><img with="15px" src="img/anadir.png"> Nueva</a></div>';
    echo '</div>';
    echo "<table class='table'>";
    echo "<tr class='table-info'><td>Código categoria</td><td>Nombre</td><td>Activa</td></tr>";
    //Si no hay ningún cliente lo mostramos en la tabla
    if (!$categorias) {
        echo "<td colspan='3'><b>No existen pedidos para mostrar</b></td>";
        //Si existen clientes mostramos un cliente por fila
    } else {
        foreach ($categorias as $key => $value) {
            echo "<tr>";
            echo "<td>" . $value->getCodigo() . "</td>";
            echo "<td>" . $value->getNombre() . "</td>";
            echo "<td>" . $value->getActivo() . "</td>";
            //Añadir Encender y apagar categorías 
            //Pintamos los enlaces para editar y borrar el cliente pasando como parámetro el dni
            echo "<td><a class='btn btn-warning mr-1 pt-0' href='categoryForm.php?cod=" . $value->getCodigo() . "&act=update'><img with='15px' src='img/edit.png'></a>";
            if($value->getActivo()){
                echo "<a class='btn btn-danger mr-1 pt-0' href='categoryForm.php?cod=" . $value->getCodigo() . "&act=deactivate'><img with='15px' src='img/delete.png'></a>";
            }else{
                echo "<a class='btn btn-success mr-1 pt-0' href='categoryForm.php?cod=" . $value->getCodigo() . "&act=activate'><img with='15px' src='img/anadir.png'></a>";
            }
            echo "<a class='btn btn-info pt-0' href='categoryForm.php?cod=" . $value->getCodigo() . "'><img with='15px' src='img/info.png'></a></td>";
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