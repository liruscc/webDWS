<?php
require_once ('views/helpers.php');
$error = false;
$usuario = false;
$accion = false;
?>

<?php

if(isset($_GET['accion'])){
    $accion = $_GET['accion'];
}

echo '<div class="col-lg-8 col-md-8 col-sm-8 row">';
if ($_POST) {
    //validar cliente y error o actualizar (llamar al controlador)
    $errores = cliente::validarForm($_POST['dni'], $_POST['nombre'], $_POST['telefono'], $_POST['email'], $_POST['direccion'], $_POST['localidad'], $_POST['provincia']);
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
        if (cliente::updateClient($_POST['dni'], $_POST['nombre'], $_POST['direccion'], $_POST['localidad'], $_POST['provincia'], $_POST['telefono'], $_POST['email'], $_POST['activo'])) {
            mensaje('El cliente se actualizó correctamente.');
        } else {
            error('No se pudo actualizar el cliente.');
        }
    }
}

if (isset($_SESSION['tipo'])) {
    if ($_SESSION['tipo'] == 'navegante' || $_SESSION['tipo'] == 'registrado') {
        $edit = $_SESSION['id'];
        $usuario = cliente::getClient($edit);
    } elseif ($_SESSION['tipo'] == 'superusuario' || $_SESSION['tipo'] == 'empleado') {
        $edit = false;
        if (isset($_GET['id'])) {
            $edit = $_GET['id'];
            $usuario = cliente::getClient($edit);
        }
    }
    
    if($accion=='deactivate'){
        $usuario->setActivo('0');
        if(!$usuario->updateClient($usuario->getDni(), $usuario->getNombre(), $usuario->getDireccion(), $usuario->getLocalidad(), $usuario->getProvincia(), $usuario->getTelefono(), $usuario->getEmail(), $usuario->getActivo())){
            error('No se pudo desactivar el usuario.');
        }else{
            mensaje('El usuario ha sido desactivado.');
        }
    }
    
    if($accion=='activate'){
        $usuario->setActivo('1');
        if(!$usuario->updateClient($usuario->getDni(), $usuario->getNombre(), $usuario->getDireccion(), $usuario->getLocalidad(), $usuario->getProvincia(), $usuario->getTelefono(), $usuario->getEmail(), $usuario->getActivo())){
            error('No se pudo activar el usuario.');
        }else{
            mensaje('El usuario ha sido activado.');
        }
    }
    
    $action = 'index.php?menu=clientesForm&id=' . $edit;
    echo '<div class="col-lg-6 col-md-6 col-sm-6">';
    if ($usuario) {
        echo '<form id="producto" class="m-4" method="post" action="' . $action . '">';
        ?>
        <fieldset>
            <legend><em>Datos Usuario</em></legend>
            <div class="form-group">
                <label for="dni">Dni:</label><br/>
                <input class="form-control" type="text" id="dni" name="dni" size="10" maxlength="9" value ="<?php echo $usuario->getDni() ?>" readonly="readonly"/><br/>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre completo:</label><br/>	
                <input class="form-control" type="text" id="nombre" name="nombre" size="40" maxlength="40" value ="<?php echo $usuario->getNombre() ?>"/><br/>
            </div>
            <div class="form-group">
                <label for="nombre">Teléfono:</label><br/>	
                <input class="form-control" type="text" id="nombre" name="telefono" size="10" maxlength="9" value ="<?php echo $usuario->getTelefono() ?>"/><br/>
                <label for="nombre">Email:</label><br/>	
                <input class="form-control" type="text" id="email" name="email" size="20" maxlength="30" value ="<?php echo $usuario->getEmail() ?>"/><br/>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label><br/>
                <input class="form-control" type="direccion" id="direccion" name="direccion" size="100" maxlength="120" value ="<?php echo $usuario->getDireccion(); ?>"/><br/>
            </div>
            <div class="form-group">
                <label for="localidad">Localidad:</label><br/>
                <input class="form-control" type="text" id="localidad" name="localidad" size="30" maxlength="30" value="<?php echo $usuario->getLocalidad(); ?>"/><br/>
            </div>
            <div class="form-group">
                <label for="provincia">Provincia:</label><br/>
                <input class="form-control" type="text" id="provincia" name="provincia" size="30" maxlength="30" value="<?php echo $usuario->getProvincia(); ?>"/><br/>
            </div>
            <input class="form-control" type="hidden" id="activo" name="activo" value="<?php echo $usuario->getActivo(); ?>"/><br/>
        </fieldset>
        <br/>
        <input class="btn btn-success" type="submit" name="confirmar" value="Guardar"/>
        <input class="btn btn-danger" type="button" name="cancelar" value="Cancelar" onclick="location.href = 'index.php?menu=clientes<?php if($usuario->getTipo()=='empleado') echo '&empleados'?>'"/>
        </form>
        <?php
        echo '</form>';
        echo "</div>";
        
        if($_SESSION['tipo'] == 'superusuario' || $_SESSION['tipo'] == 'empleado'){
        echo '<div class="col-lg-6 col-md-6 col-sm-6 mt-5">';
        echo "<div>";
        if ($usuario->getActivo()) {
            echo "Desactivar cliente <a class='btn btn-danger mr-1 pt-0' href='index.php?menu=clientesForm&id=" . $usuario->getDni() . "&accion=deactivate'><img with='15px' src='img/delete.png'></a>";
        } else {
            echo "Activar cliente <a class='btn btn-success mr-1 pt-0' href='index.php?menu=clientesForm&id=" . $usuario->getDni() . "&accion=activate'><img with='15px' src='img/anadir.png'></a>";
        }
        echo "</div>";
        echo '</div>';
        }
        
    } else {
        echo "No se encontró el usuario";
    }
} else {
    echo "Acceso denegado";
}

echo '</div>';
?>