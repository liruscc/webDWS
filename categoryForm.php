<?php
require_once ('views/helpers.php');
require_once ('plantilla/header.php');
require_once ('plantilla/nav.php');
$referencia = false;
?>

<div id="container" class="d-flex flex-row col-lg-12 col-md-12 col-sm-12 justify-content-center">

    <?php
    require_once ('plantilla/leftmenu.php');
    $accion = "none";
    $errores = true;

    echo '<div class="col-lg-8 col-md-8 col-sm-8 row">';
    if (isset($_SESSION['tipo'])) {
        if ($_SESSION['tipo'] == 'empleado' || $_SESSION['tipo'] == 'superusuario') {

            if (isset($_GET["accion"])) {
                $accion = $_GET["accion"];
                if ($accion == 'add') {
                    $name = 'Añadir';
                } elseif ($accion == 'update' || $accion == 'activate' || $accion == 'deactivate' || $accion == 'associate' || $accion == 'deactivatesub' || $accion == 'activatesub') {
                    $name = 'Actualizar';
                } else {
                    $name = 'Editar';
                }
            }

            if (isset($_GET["cod"])) {
                $referencia = $_GET["cod"];
            }

            if (isset($_POST["cod"])) {
                $referencia = $_POST["cod"];
            }


            if (isset($_POST["accion"])) {
                $accion = $_POST["accion"];
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
                            if (!$nuevaCategoria) {
                                echo "<div id='errores' class='alert alert-danger p-1 w-100'>";
                                echo "Se ha producido un error al crear la categoría.";
                                echo "</div>";
                            } else {
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
                        $categoria = new categoria($_POST['nombre'], $_POST['activo'], $_POST['codigo']);
                        $errores = $categoria->validarNuevaCategoria();
                        if ($errores) {
                            echo "<div id='errores' class='alert alert-danger p-1 w-100'>";
                            foreach ($errores as $key => $value) {
                                echo $value . "<br/>";
                            }
                            echo "</div>";
                        } else {
                            $categoriaActualizada = $categoria->updateCategoria();
                            if (!$categoriaActualizada) {
                                $categoria = categoria::getCategoria($categoria->getCodigo());
                                echo "<div id='errores' class='alert alert-success p-1 w-100'>";
                                echo "Se producido un error al actualizar la categoría.";
                                echo "</div>";
                            } else {
                                echo "<div id='errores' class='alert alert-success p-1 w-100'>";
                                echo "Se ha actualizado la categoría.";
                                echo "</div>";
                            }
                        }
                    } else {
                        $categoria = categoria::getCategoria($_GET['cod'], false);
                    }
                    break;
                case 'activate':
                    $categoria = categoria::getCategoria($_GET['cod'], false);
                    if ($categoria->cambiarEstado("1")) {
                        $categoria = categoria::getCategoria($_GET['cod'], false);
                        mensaje('La categoría se activó correctamente.');
                    } else {
                        error('Se produjo un error al activar la categoría.');
                    }
                    break;
                case 'deactivate':
                    $categoria = categoria::getCategoria($_GET['cod'], false);
                    if ($categoria->cambiarEstado("0")) {
                        $categoria = categoria::getCategoria($_GET['cod'], false);
                        mensaje('La categoria se desactivó correctamente.');
                    } else {
                        error('Se produjo un error al desactivar la categoría.');
                    }

                    break;

                case 'associate':
                    $categoria = categoria::getCategoria($_GET['cod'], false);
                    if (subcategoria::getSubCategoria(isset($_POST['subid']))) {
                        $subcategoria = subcategoria::getSubCategoria($_POST['subid']);
                        $subcategoria->setFamilia($referencia);
                        $subcategoria->setActivo('1');

                        if ($subcategoria->addSubCategoria()) {
                            mensaje('La subcategoria se ascoció correctamente.');
                        } else {
                            error('Se produjo un error al asociar la subcategoría.');
                        }
                    }
                    break;
                 
                case 'activatesub':
                    $categoria = categoria::getCategoria($_GET['cod'], false);
                    $subcategoria = subcategoria::getSubcategoria($_GET['subcod'], false);
                    if ($subcategoria->cambiarEstado("1")) {
                        $subcategoria = subcategoria::getSubCategoria($_GET['subcod'], false);
                        mensaje('La subcategoría se activó correctamente.');
                    } else {
                        error('Se produjo un error al activar la subcategoría.');
                    }
                    break;
                case 'deactivatesub':
                    $categoria = categoria::getCategoria($_GET['cod'], false);
                    $subcategoria = subcategoria::getSubCategoria($_GET['subcod'], false);
                    if ($subcategoria->cambiarEstado("0")) {
                        $subcategoria = subcategoria::getSubCategoria($_GET['subcod'], false);
                        mensaje('La subcategoria se desactivó correctamente.');
                    } else {
                        error('Se produjo un error al desactivar la subcategoría.');
                    }
                    break;
                    
                default:
                    echo "<div id='errores' class='alert alert-danger p-1 w-100'>";
                    echo "Se produjo un error al realizar la acción.";
                    echo "</div>";
                    break;
            }
            print_r($categoria);
            ?>

            <div class="col-lg-8 col-md-8 col-sm-8 row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light py-1">
                        <li class="breadcrumb-item"><a href="categoriesdata.php">Categorías</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $name . ' categoría' ?></li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5">
                <form id="producto" class='m-4' method="post" action="categoryForm.php?accion=<?php echo $accion ?>&cod=<?php echo $referencia; ?>"/>
                    <?php if ($accion == 'update') { ?>
                        <div class="form-group">	
                            <label for="codigo">Código:</label>
                            <input type="text" class='form-control' name="codigo" id="codigo" value="<?php echo $categoria->getCodigo(); ?>" size="40" readonly="readonly"/><br/>
                        </div>
                    <?php } ?>
                    <div class="form-group">	
                        <label for="nombre">Nombre:</label>
                        <input type="text" class='form-control' name="nombre" id="descripcion" value="<?php echo $categoria->getNombre(); ?>" size="40"/><br/>
                    </div>

                    <?php
                    echo '<div clas"row">';
                    echo "<div>";
                    if ($categoria->getActivo()) {
                        echo "Desactivar categoría <a class='btn btn-danger mr-1 pt-0' href='categoryForm.php?cod=" . $categoria->getCodigo() . "&accion=deactivate'><img with='15px' src='img/delete.png'></a>";
                    } else {
                        echo "Activar categoría <a class='btn btn-success mr-1 pt-0' href='categoryForm.php?cod=" . $categoria->getCodigo() . "&accion=activate'><img with='15px' src='img/anadir.png'></a>";
                    }
                    echo "</div>";
                    echo "</div>";
                    ?>
                    <input type="hidden" class='form-control' name="activo" id="activo" value="<?php echo $categoria->getActivo(); ?>"/><br/>
                    <input type="hidden" class='form-control' name="cod" id="cod" value ="<?php echo $categoria->getCodigo(); ?>"/><br/>
                    <input type="hidden" class='form-control' name="accion" id="accion" value ="<?php echo $accion ?>"/><br/>

                    <br/>
                    <input class="btn btn-success" type="submit" name="guardar" value="Guardar"/>
                    <input class="btn btn-danger" type="button" name="cancelar" value="Cancelar" onclick="location.href = 'index.php?menu=categorias'"/>
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
                        echo "<td><a class='btn btn-warning mr-1 pt-0' href='subcategoryForm.php?cod=".$referencia."&subcod=" . $value->getCodigo() . "'><img with='15px' src='img/edit.png'></a>";
                        if ($value->getActivo()) {
                            echo "<a class='btn btn-danger mr-1 pt-0' href='categoryForm.php?cod=".$referencia."&subcod=" . $value->getCodigo() . "&accion=deactivatesub'><img with='15px' src='img/delete.png'></a>";
                        } else {
                            echo "<a class='btn btn-success mr-1 pt-0' href='categoryForm.php?cod=".$referencia."&subcod=" . $value->getCodigo() . "&accion=activatesub'><img with='15px' src='img/anadir.png'></a>";
                        }
                        echo "<a class='btn btn-info pt-0' href='subcategoryForm.php?cod=".$referencia."&subcod=" . $value->getCodigo() . "'><img with='15px' src='img/info.png'></a></td>";
                        echo "</tr>";
                    }
                }
                echo "</table>";

                echo '<form id="linea" class="m-4 mt-5" method="post" action="categoryForm.php?accion=associate&cod=' . $referencia . '">';
                ?>

                <fieldset>
                    <legend><em>Asociar subcategoría</em></legend>
                    <div class="form-group">
                        <?php
                        $subcategorias = subcategoria::getAll();
                        echo '<select name="subid">';
                        foreach ($subcategorias as $sub) {
                            echo '<option value="' . $sub->getCodigo() . '">' . $sub->getNombre() . '</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>
                </fieldset>
                <input type="hidden" class='form-control' name="accion" id="accion" value ="associate"/>
                <input class="btn btn-success" type="submit" name="associate" value="Asociar subcategoría"/>
                </form>

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

