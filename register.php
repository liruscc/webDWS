<?php
require_once ('plantilla/header.php');
require_once ('plantilla/nav.php');
require_once ('views/helpers.php' )
?>

<div id = "container" class="d-flex flex-row col-lg-12 col-md-12 col-sm-12 justify-content-center">
    <?php
    require_once ('plantilla/leftmenu.php');
    ?>
    <div class="col-lg-8 col-md-8 col-sm-8">
        <div id = "errores">
            <?php
            if ($_POST) {
                $errores = cliente::validarAltaCorta($_POST['dni'], $_POST['nombre'], $_POST['password']);
                //Por cada error devuelto lo imprimos en la parte superior de la página
                if ($errores) {
                    echo "<div id='errores' class='alert alert-danger p-1'>";
                    foreach ($errores as $key => $value) {
                        if($value){
                            echo $value . "<br/>";
                        }
                    }
                    echo "</div>";
                } else {
                    if (cliente::altaCorta($_POST['dni'], $_POST['nombre'], $_POST['password'])) {
                        mensaje('Se ha realizado el alta correctamente. Haga login para iniciar sesión.');
                    }
                }
            }
            ?>
        </div>
        <form id="registrar" class="m-4" method="POST" action="register.php">
            <fieldset title="Registrate">
                <legend><em>Regístrate</em></legend>
                <div class="form-group">
                    <label for="dni">Dni:</label><br/>
                    <input type="text" id="dni" name="dni" size="10" maxlength="9"/><br/>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre completo:</label><br/>	
                    <input type="text" id="nombre" name="nombre" size="20" maxlength="40"/><br/>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label><br/>
                    <input type="password" id="password" name="password" size="20" maxlength="10"/><br/>
                </div>
            </fieldset>
            <input class="btn btn-primary" type="submit" name="alta" value="Alta" />
        </form>
    </div>
    <?php
    require_once ('plantilla/rightmenu.php');
    ?>
</div>

<?php
require_once ('plantilla/footer.php');
?>