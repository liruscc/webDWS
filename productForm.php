<?php
require_once ('plantilla/header.php');
require_once ('plantilla/nav.php');
?>

<div id="container" class="d-flex flex-row col-lg-12 col-md-12 col-sm-12 justify-content-center">

    <?php
    require_once ('plantilla/leftmenu.php');

    echo '<div class="col-lg-8 col-md-8 col-sm-8 row">';
    if (isset($_SESSION['tipo'])) {
        if ($_SESSION['tipo'] == 'empleado' || $_SESSION['tipo'] == 'superusuario') {

            if ($_POST) {
                if (isset($_POST["act"])) {
                    $accion = $_POST["act"];
                }
                if (isset($_POST["ref"])) {
                    $referencia = $_POST["ref"];
                }
                if ($accion === "update") {
                    $articulo = new articulo($_POST['codigo'], $_POST['descripcion'], $_POST['precio'], $_POST['promocion'], $_POST['activo']);
                    $errores = $articulo->validarArticulo();
                    if ($errores) {
                        echo "<div id='errores' class='alert alert-danger p-1 w-100'>";
                        foreach ($errores as $key => $value) {
                            echo $value . "<br/>";
                        }
                        echo "</div>";
                    }
                }

                if ($accion === "img") {
                    $errores = articulo::validarImagen($_FILES['imagen']['type'], $_FILES['imagen']['size']);
                    if ($errores) {
                        echo "<div id='errores' class='alert alert-danger p-1 w-100'>";
                        echo $errores;
                        echo "</div>";
                    }
                }

                switch ($accion) {
                    case 'img':
                        //$errores = false;
                        if (!isset($_POST['imagen'])) {
                            $nombre_archivo = $_FILES['imagen']['name'];
                            //$tipo_archivo = $_FILES['imagen']['type'];
                            //$tamano_archivo = $_FILES['imagen']['size'];
                            $archivo = $_FILES['imagen']['tmp_name'];
                        } else {
                            $nombre_archivo = "";
                        }

                        if (!$errores) {
                            $file = $_FILES['imagen']['name'];
                            $res = explode(".", $nombre_archivo);
                            $extension = $res[count($res) - 1];
                            $nombre = $referencia . "." . $extension;
                            $dirtemp = "img/articulos/" . $nombre;

                            if (is_uploaded_file($archivo)) {
                                move_uploaded_file($archivo, $dirtemp);
                                header("Location: productForm.php?ref=" . $referencia);
                            } else {
                                $errores += "Ocurrió un error al subir el fichero. No pudo guardarse.";
                            }
                        }

                        break;

                    case 'update':
                        if (!$errores) {
                            $articulo = new articulo($_POST['codigo'], $_POST['descripcion'], $_POST['precio'], $_POST['promocion'], $_POST['activo']);
                            $errores = $articulo->updateArticulo();
                        }
                        break;
                }
            }

            if (isset($_GET['ref'])) {
                $articulos = articulo::getArticulo($_GET['ref']);
                $articulo = $articulos[0];
            }
            ?>		
            <div class="col-lg-6 col-md-6 col-sm-6">
                <form id="producto" class='m-4' method="post" action="productForm.php?ref=<?php echo $articulo->getCodigo(); ?>">
                    <div class="form-group">
                        <label for="codigo">Código producto:</label>
                        <input type="text" class='form-control' name="codigo" id="codigo" size="8" readonly="readonly" value="<?php echo $articulo->getCodigo(); ?>"/><br/>
                    </div>
                    <div class="form-group">	
                        <label for="descripcion	">Descripción:</label>
                        <input type="text" class='form-control' name="descripcion" id="descripcion" value="<?php echo $articulo->getDescripcion(); ?>" size="40"/><br/>
                    </div>
                    <div class="form-group">	
                        <label for="precio">Precio:</label>
                        <input type="text" class='form-control' name="precio" id="precio" value="<?php echo $articulo->getPrecio(); ?>" size="8"/><br/>
                    </div>
                    <div class="form-group">
                        <label for="promocion">Promoción:</label>
                        <input type="text" class='form-control' name="promocion" id="promocion" value="<?php echo $articulo->getPromocion(); ?>" size="6"/><br/>
                    </div>
                    <div class="form-group">		
                        <label for="activo">Activo:</label>
                        <input type="text" class='form-control' name="activo" id="activo" value="<?php echo $articulo->getActivo(); ?>" size="20" maxlength="6"/><br/>
                    </div>
                    <input type="hidden" class='form-control' name="ref" id="ref" value ="<?php echo $articulo->getCodigo(); ?>"/><br/>
                    <input type="hidden" class='form-control' name="act" id="act" value ="update"/><br/>
                    <br/>
                    <input class="btn btn-success" type="submit" name="guardar" value="Guardar"/>
                    <input class="btn btn-danger" type="button" name="cancelar" value="Cancelar" onclick="location.href = 'index.php'"/>
                </form>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <form id="imagen" class='m-4' method="post" action="productForm.php?ref=<?php echo $articulo->getCodigo(); ?>" enctype="multipart/form-data"> 
                    <div>
                        <img class='mt-5' src="img/articulos/<?php echo $articulo->getCodigo(); ?>.png">
                    </div>
                    <div class="form-group">		
                        <label for="imagen">Modificar imagen:</label>
                        <input type="file" class='form-control' name="imagen" id="imagen"/><br/>
                        <input type="submit" class='btn btn-success' value ="Modificar"/><br/>
                        <input type="hidden" class='form-control' name="ref" id="ref" value ="<?php echo $articulo->getCodigo(); ?>"/><br/>
                        <input type="hidden" class='form-control' name="act" id="act" value ="img"/><br/>
                    </div>	
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