<?php
require_once ('views/helpers.php');
$error = false;

if ($_POST){
 //validar cliente y error o actualizar (llamar al controlador)
}

?>

<?php
echo '<div class="col-lg-8 col-md-8 col-sm-8">';
echo '<div class="col-lg-6 col-md-6 col-sm-6">';
echo '<form id="producto" class="m-4" method="post" action="clientesForm.php">';

if (isset($_SESSION)) {
   // if($_SESSION['tipo']='navegante' || $_SESSION['tipo']='registrado'){
        $usuario = cliente::getClient($_SESSION['id']);
   // }elseif($_SESSION['tipo']='superusuario' || $_SESSION['tipo']='empleado'){
   //     $id = false;
   //     if(isset($_GET['id'])){
   //         $id = $_GET['id'];
   //         $usuario = cliente::getClient($id);
   //     }
   // }
    
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
            <input class="form-control" type="direccion" id="direccion" name="direccion" size="100" maxlength="120" value ="<?php echo $usuario->getDireccion();?>"/><br/>
        </div>
        <div class="form-group">
            <label for="localidad">Localidad:</label><br/>
            <input class="form-control" type="text" id="localidad" name="localidad" size="30" maxlength="30" value="<?php echo $usuario->getLocalidad();?>"/><br/>
        </div>
        <div class="form-group">
            <label for="provincia">Provincia:</label><br/>
            <input class="form-control" type="text" id="provincia" name="provincia" size="30" maxlength="30" value="<?php echo $usuario->getProvincia();?>"/><br/>
        </div>
    </fieldset>
    <br/>
    <input class="btn btn-success" type="submit" name="confirmar" value="Guardar"/>
    <input class="btn btn-danger" type="button" name="cancelar" value="Cancelar" onclick="location.href = 'index.php'"/>
    </form>
    <?php
} else {
    echo "Acceso denegado";
}
echo '</form>';          
echo '</div>';
echo '</div>';
?>