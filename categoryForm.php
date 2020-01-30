<?php
require_once ('plantilla/header.php');
require_once ('plantilla/nav.php');
?>

<div id="container" class="d-flex flex-row col-lg-12 col-md-12 col-sm-12 justify-content-center">

    <?php
    require_once ('plantilla/leftmenu.php');
    $accion = "none";
    $errores = true;

    echo '<div class="col-lg-8 col-md-8 col-sm-8 row">';
    if (isset($_SESSION['tipo'])) {
        if ($_SESSION['tipo'] == 'empleado' || $_SESSION['tipo'] == 'superusuario') {

            if (isset($_GET["act"])) {
                $accion = $_GET["act"];
            }

            if ($_POST) {
                if (isset($_POST["act"])) {
                    $accion = $_POST["act"];
                }

                if (isset($_POST["cod"])) {
                    $referencia = $_POST["cod"];
                }
            }
  
            switch ($accion) {
                case 'add':
                    if ($_POST) {
                        $categoria = new categoria($_POST['nombre'], $_POST['activo']);
                        $errores = $categoria->validarNuevaCategoria();
                        if ($errores) {
                            echo "<div id='errores' class='alert alert-danger p-1 w-100'>";
                            foreach ($errores as $key => $value) {
                                echo $value . "<br/>";
                            }
                            echo "</div>";
                        } else {
                            $nuevaCategoria = $categoria->addCategoria();
                            if(!$nuevaCategoria){
                                echo "<div id='errores' class='alert alert-danger p-1 w-100'>";
                                echo "Se ha producido un error al crear la categoría.";
                                echo "</div>";
                            }else{
                                $categoria = categoria::getCategoria($nuevaCategoria);
                                echo "<div id='errores' class='alert alert-success p-1 w-100'>";
                                echo "Se ha creado la categoría.";
                                echo "</div>";
                            }
                        }
                    } else {
                        $categoria = new categoria();
                    }
                    break;
                case 'update':
                    if ($_POST) {
                        $categoria = new categoria($_POST['nombre'], $_POST['activo'],$_POST['codigo']);
                        $errores = $categoria->validarNuevaCategoria();
                        if ($errores) {
                            echo "<div id='errores' class='alert alert-danger p-1 w-100'>";
                            foreach ($errores as $key => $value) {
                                echo $value . "<br/>";
                            }
                            echo "</div>";
                        } else {
                            $categoriaActualizada = $categoria->updateCategoria();
                            if(!$categoriaActualizada){
                                $categoria = categoria::getCategoria($categoria->getCodigo());
                                echo "<div id='errores' class='alert alert-success p-1 w-100'>";
                                echo "Se producido un error al actualizar la categoría.";
                                echo "</div>";
                            }else{
                                echo "<div id='errores' class='alert alert-success p-1 w-100'>";
                                echo "Se ha actualizado la categoría.";
                                echo "</div>";
                            }
                        }
                    } else {
                        $categoria = categoria::getCategoria($_GET['cod'], false);
                        $categoria = $categoria;
                    }
                    break;
                case 'activate':
                    $categoria = categoria::getCategoria($_GET['cod'], false);
                    $categoria->cambiarEstado("1");
                    $categoria = categoria::getCategoria($_GET['cod'], false);
                    break;
                case 'deactivate':
                    $categoria = categoria::getCategoria($_GET['cod'], false);
                    $categoria->cambiarEstado("0");
                    $categoria = categoria::getCategoria($_GET['cod'], false);
                    break;
                default:
                    echo "<div id='errores' class='alert alert-danger p-1 w-100'>";
                    echo "Se produjo un error al realizar la acción.";
                    echo "</div>";
                    break;
            }
            ?>

            <div class="col-lg-8 col-md-8 col-sm-8 row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light py-1">
                        <li class="breadcrumb-item"><a href="categoriesdata.php">Categorías</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Editar categoría</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5">
                <form id="producto" class='m-4' method="post" action="categoryForm.php">	
                    <div class="form-group">	
                        <label for="codigo">Código:</label>
                        <input type="text" class='form-control' name="codigo" id="codigo" value="<?php echo $categoria->getCodigo(); ?>" size="40" readonly="readonly"/><br/>
                    </div>
                    <div class="form-group">	
                        <label for="nombre">Nombre:</label>
                        <input type="text" class='form-control' name="nombre" id="descripcion" value="<?php echo $categoria->getNombre(); ?>" size="40"/><br/>
                    </div>

                    <?php
                    echo '<div clas"row">';
                    echo "<div>";
                    if ($categoria->getActivo()) {
                        echo "Desactivar categoría <a class='btn btn-danger mr-1 pt-0' href='categoryForm.php?cod=" . $categoria->getCodigo() . "&act=deactivate'><img with='15px' src='img/delete.png'></a>";
                    } else {
                        echo "Activar categoría <a class='btn btn-success mr-1 pt-0' href='categoryForm.php?cod=" . $categoria->getCodigo() . "&act=activate'><img with='15px' src='img/anadir.png'></a>";
                    }
                    echo "</div>";
                    echo "</div>";
                    ?>
                    <input type="hidden" class='form-control' name="activo" id="activo" value="<?php echo $categoria->getActivo(); ?>"/><br/>
                    <input type="hidden" class='form-control' name="cod" id="cod" value ="<?php echo $categoria->getCodigo(); ?>"/><br/>
                    <input type="hidden" class='form-control' name="act" id="act" value ="<?php echo $accion ?>"/><br/>

                    <br/>
                    <input class="btn btn-success" type="submit" name="guardar" value="Guardar"/>
                    <input class="btn btn-danger" type="button" name="cancelar" value="Cancelar" onclick="location.href = 'categoriesdata.php'"/>
                </form>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7">
                <?php
                $subcategorias = subcategoria::getSubcategorias($categoria);
                echo "<table class='table mt-5'>";
                echo "<tr class='table-info'><td>Código</td><td>Nombre</td><td>Activo</td><td class='w-50'></td></tr>";
                //Si no hay ningún cliente lo mostramos en la tabla
                if (!$subcategorias) {
                    echo "<td colspan='4'><b>No existen subcategorías asociadas a la categoría</b></td>";
                    //Si existen clientes mostramos un cliente por fila
                } else {
                    foreach ($subcategorias as $key => $value) {
                        echo "<tr>";
                        echo "<td>" . $value->getCodigo() . "</td>";
                        echo "<td>" . $value->getNombre() . "</td>";
                        echo "<td>" . $value->getActivo() . "</td>";
                        //Pintamos los enlaces para editar y borrar el cliente pasando como parámetro el dni
                        echo "<td><a class='btn btn-warning mr-1 pt-0' href='sucategoryForm.php?cod=" . $value->getCodigo() . "'><img with='15px' src='img/edit.png'></a>";
                        if ($value->getActivo()) {
                            echo "<a class='btn btn-danger mr-1 pt-0' href='subcategoryForm.php?cod=" . $value->getCodigo() . "&act=deactivate'><img with='15px' src='img/delete.png'></a>";
                        } else {
                            echo "<a class='btn btn-success mr-1 pt-0' href='subcategoryForm.php?cod=" . $value->getCodigo() . "&act=activate'><img with='15px' src='img/anadir.png'></a>";
                        }
                        echo "<a class='btn btn-info pt-0' href='subcategoryForm.php?cod=" . $value->getCodigo() . "'><img with='15px' src='img/info.png'></a></td>";
                        echo "</tr>";
                    }
                }
                echo "</table>";
                ?>
            </div>
            <?php
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

