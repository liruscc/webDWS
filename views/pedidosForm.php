<?php
require_once ('views/helpers.php');
require_once ('classes/lineapedido.php');
require_once ('classes/articulo.php');
$error = false;
$pedido = false;
$accion = false;
?>

<?php
echo '<div class="col-lg-8 col-md-8 col-sm-8">';


if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];
}

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
}

if (isset($_GET['id'])) {
    $cod_pedido = $_GET['id'];
}

if (isset($_POST['id'])) {
    $cod_pedido = $_POST['id'];
}

if (isset($_GET['linea'])) {
    $num_linea = $_GET['linea'];
}

if (isset($_POST['linea'])) {
    $num_linea = $_POST['linea'];
}

if(isset($_POST['cod_articulo']))$cod_articulo = $_POST['cod_articulo'];
if(isset($_POST['unidades']))$unidades = $_POST['unidades'];
switch ($accion) {
    case 'update':
        //validar cliente y error o actualizar (llamar al controlador)
        $errores = pedido::validarForm($_POST['dni'], $_POST['nombre'], $_POST['telefono'], $_POST['email'], $_POST['direccion'], $_POST['estado'], $_POST['tipo_pago'], $_POST['estado_pago'], $_POST['envio'], $_POST['activo']);
        //Por cada error devuelto lo imprimos en la parte superior de la página
        if ($errores) {
            echo "<div id='errores' class='alert alert-danger p-1'>";
            foreach ($errores as $key => $value) {
                if ($value) {
                    echo $value . "<br/>";
                }
            }
            echo "</div>";
        } else {
            if (pedido::updatePedido($_GET['id'], $_POST['dni'], $_POST['nombre'], $_POST['telefono'], $_POST['email'], $_POST['direccion'], $_POST['estado'], $_POST['tipo_pago'], $_POST['estado_pago'], $_POST['envio'], $_POST['activo'])) {
                mensaje('Los datos del pedido se actualizaron correctamente.');
            } else {
                error('No se pudo actualizar el pedido.');
            }
        }
        break;

    case 'add':
        $linea = lineapedido::getLineaPedido($cod_pedido, $num_linea);
        $errores = lineapedido::validarLinea($linea->getLinea(), $linea->getCodigoPedido(), $linea->getCodigoArticulo(), $linea->getUnidades() + 1, $linea->getActivo());
        //Por cada error devuelto lo imprimos en la parte superior de la página
        if ($errores) {
            echo "<div id='errores' class='alert alert-danger p-1'>";
            foreach ($errores as $key => $value) {
                if ($value) {
                    echo $value . "<br/>";
                }
            }
            echo "</div>";
        } else {
            if (lineapedido::updateLineaPedido($linea->getLinea(), $linea->getCodigoPedido(), $linea->getCodigoArticulo(), $linea->getUnidades() + 1, $linea->getActivo())) {
                mensaje('Se actualizó la línea correctamente.');
            } else {
                error('No se pudo actualizar la línea.');
            }
        }
        break;

    case 'sub':
        $linea = lineapedido::getLineaPedido($cod_pedido, $num_linea);
        $errores = lineapedido::validarLinea($linea->getLinea(), $linea->getCodigoPedido(), $linea->getCodigoArticulo(), $linea->getUnidades() - 1, $linea->getActivo());
        //Por cada error devuelto lo imprimos en la parte superior de la página
        if ($errores) {
            echo "<div id='errores' class='alert alert-danger p-1'>";
            foreach ($errores as $key => $value) {
                if ($value) {
                    echo $value . "<br/>";
                }
            }
            echo "</div>";
        } else {
            if (lineapedido::updateLineaPedido($linea->getLinea(), $linea->getCodigoPedido(), $linea->getCodigoArticulo(), $linea->getUnidades() - 1, $linea->getActivo())) {
                mensaje('Se actualizó la línea correctamente.');
            } else {
                error('No se pudo actualizar la línea.');
            }
        }

        break;
    case 'delete':
        $lineaBorrada = lineapedido::borrarLinea($cod_pedido, $num_linea);
        //Por cada error devuelto lo imprimos en la parte superior de la página
        if (!$lineaBorrada) {
            error('No se pudo eliminar la línea');
        } else {
            mensaje('Se eliminó la línea.');
        }
        break;

    case 'addArticulo':
        $num_linea = lineapedido::getLastLinea($cod_pedido);
        $activo = '1';
        $errores = lineapedido::validarLinea($num_linea, $cod_pedido, $cod_articulo, $unidades, $activo);
        if ($errores) {
            echo "<div id='errores' class='alert alert-danger p-1'>";
            foreach ($errores as $key => $value) {
                if ($value) {
                    echo $value . "<br/>";
                }
            }
            echo "</div>";
        } else {
            if (lineapedido::addLastLinea($cod_pedido, $cod_articulo, $unidades, '1')) {
                mensaje('Se añadió el artículo correctamente.');
            } else {
                error('No se pudo añadir el artículo.');
            }
        }
        break;
}


if (isset($_SESSION['tipo'])) {
    if ($_SESSION['tipo'] == 'navegante' || $_SESSION['tipo'] == 'registrado') {
        $edit = $_GET['id'];
        $pedido = pedido::getPedido($edit);
        if (!$pedido) {
            $pedido = false;
        } else {
            $pedido = pedido::getPedido($edit);
            if ($pedido->getDni() == $_SESSION['id']) {
                $pedido = pedido::getPedido($edit);
            } else {
                $pedido = false;
            }
        }
    } elseif ($_SESSION['tipo'] == 'superusuario' || $_SESSION['tipo'] == 'empleado') {
        $edit = false;
        if (isset($_GET['id'])) {
            $edit = $_GET['id'];
            $pedido = pedido::getPedido($edit);
        }
    }
    echo '<div class="col-lg-12 col-md-12 col-sm-12 row">';
    $action = 'index.php?menu=pedidosForm&id=' . $edit;
    if ($pedido) {
        echo '<div class="col-lg-6 col-md-6 col-sm-6">';
        echo '<form id="producto" class="m-4" method="post" action="' . $action . '">';
        ?>

        <fieldset>
            <legend><em>Datos Pedido</em></legend>
            <div class="form-group">
                <label for="fecha">Fecha pedido:</label><br/>
                <input class="form-control" type="text" id="dni" name="fecha" size="10" maxlength="9" value ="<?php echo $pedido->getFecha(); ?>" readonly="readonly"/>
            </div>
            <div class="form-group">
                <label for="dni">Dni:</label><br/>
                <input class="form-control" type="text" id="dni" name="dni" size="10" maxlength="9" value ="<?php echo $pedido->getDni(); ?>"/>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre completo:</label><br/>	
                <input class="form-control" type="text" id="nombre" name="nombre" size="40" maxlength="40" value ="<?php echo $pedido->getNombre(); ?>"/>
            </div>
            <div class="form-group">
                <label for="nombre">Teléfono:</label><br/>	
                <input class="form-control" type="text" id="nombre" name="telefono" size="10" maxlength="9" value ="<?php echo $pedido->getTelefono(); ?>"/>
                <label for="nombre">Email:</label><br/>	
                <input class="form-control" type="text" id="email" name="email" size="20" maxlength="30" value ="<?php echo $pedido->getEmail(); ?>"/>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label><br/>
                <input class="form-control" type="direccion" id="direccion" name="direccion" size="100" maxlength="120" value ="<?php echo $pedido->getDireccion(); ?>"/>
            </div>
            <div class="form-group">
                <label for="estado">Estado:</label><br/>
                <input class="form-control" type="text" id="estado" name="estado" size="30" maxlength="30" value="<?php echo $pedido->getEstado(); ?>"/>
            </div>
            <div class="form-group">
                <label for="tipo_pago">Tipo de pago:</label><br/>
                <input class="form-control" type="text" id="tipo_pago" name="tipo_pago" size="30" maxlength="30" value="<?php echo $pedido->getTipoPago(); ?>"/>
            </div>
            <div class="form-group">
                <label for="estado_pago">Estado del pago:</label><br/>
                <input class="form-control" type="text" id="estado_pago" name="estado_pago" size="30" maxlength="30" value="<?php echo $pedido->getEstadoPago(); ?>"/>
            </div>
            <div class="form-group">
                <label for="envio">Tipo de envío:</label><br/>
                <input class="form-control" type="text" id="envio" name="envio" size="30" maxlength="30" value="<?php echo $pedido->getEnvio(); ?>"/>
            </div>
            <div class="form-group">
                <label for="activo">Activo:</label><br/>
                <input class="form-control" type="text" id="activo" name="activo" size="30" maxlength="30" value="<?php echo $pedido->getActivo(); ?>"/>
            </div>
            <input type="hidden" class='form-control' name="accion" id="accion" value ="update"/>
        </fieldset>
        <br/>
        <input class="btn btn-success" type="submit" name="confirmar" value="Guardar"/>
        <input class="btn btn-danger" type="button" name="cancelar" value="Cancelar" onclick="location.href = 'index.php'"/>
        </form>
        <?php
        echo '</div>';
        echo '<div class="col-lg-6 col-md-6 col-sm-6">';
        $lineasPedido = lineapedido::getPedido($pedido->getCodigo());
        echo "<table class='table mt-5'>";
        echo "<tr class='table-info'><td>Artículo</td><td>Unidades</td><td class='w-50'></td></tr>";
        //Si no hay ningún cliente lo mostramos en la tabla
        if (!$lineasPedido) {
            echo "<td colspan='4'><b>No existen artículos asociados al pedido</b></td>";
            //Si existen clientes mostramos un cliente por fila
        } else {
            foreach ($lineasPedido as $key => $value) {
                $articulo = articulo::getArticulo($value->getCodigoArticulo());
                echo "<tr>";
                echo "<td>" . $articulo[0]->getDescripcion() . "</td>";
                echo "<td>" . $value->getUnidades() . "</td>";
                //Pintamos los enlaces para editar y borrar el cliente pasando como parámetro el dni
                echo "<td><a class='btn btn-success mr-1 pt-0' href='index.php?accion=add&menu=pedidosForm&id=" . $value->getCodigoPedido() . "&linea=" . $value->getLinea() . "'>+</a>";
                echo "<a class='btn btn-warning mr-1 pt-0' href='index.php?accion=sub&menu=pedidosForm&id=" . $value->getCodigoPedido() . "&linea=" . $value->getLinea() . "'>-</a>";
                echo "<a class='btn btn-danger mr-1 pt-0' href='index.php?accion=delete&menu=pedidosForm&id=" . $value->getCodigoPedido() . "&linea=" . $value->getLinea() . "'><img with='15px' src='img/delete.png'></a>";
                echo "</td>";
                echo "</tr>";
            }
        }
        echo "</table>";

        echo '<form id="linea" class="m-4 mt-5" method="post" action="' . $action . '">';
        ?>

        <fieldset>
            <legend><em>Añadir artículo</em></legend>
            <div class="form-group">
                <label for="fecha">Artículo:</label><br/>
                <input class="form-control" type="text" id="cod_articulo" name="cod_articulo" size="10" maxlength="9" value =""/>
            </div>
            <div class="form-group">
                <label for="dni">Unidades:</label><br/>
                <input class="form-control" type="text" id="unidades" name="unidades" size="10" maxlength="9" value =""/>
            </div>
        </fieldset>
        <input type="hidden" class='form-control' name="accion" id="accion" value ="addArticulo"/>
        <input class="btn btn-success" type="submit" name="add" value="Añadir"/>
        </form>


        <?php
        echo '</div>';
    } else {
        echo "No se encontró el pedido";
    }
} else {
    echo "Acceso denegado";
}
echo '</div>';
echo '</div>';
?>