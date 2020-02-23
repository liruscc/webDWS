<?php
require_once('classes/pedido.php');
require_once('classes/lineapedido.php');
require_once ('plantilla/header.php');
require_once ('plantilla/nav.php');

$altapedido = false;
$altalineas = false;
$error = false;

//Control sesión
if (isset($_SESSION) && isset($_SESSION['tipo'])) {
    $tipoUsuario = $_SESSION['tipo'];
    if ($tipoUsuario == 'registrado') {
        //header('Location: pago.php');
    } elseif ($tipoUsuario == 'empleado') {
        $error = 'Haga login con un usuario cliente finalizar su pedido.';
    } elseif ($tipoUsuario == 'superusuario') {
        $error = 'Haga login con un usuario cliente finalizar su pedido.';
    } elseif ($tipoUsuario == 'navegante') {
        //header('Location: completardatos.php');
    }
} else {
    $error = 'Haga login con su usuario para finalizar su pedido.';
}

if ($_POST){
    //validar datos
    $altapedido = pedido::altaPedido($_POST['dni'],$_POST['nombre'],$_POST['telefono'],$_POST['email'],$_POST['direccion'],$_POST['pago'],$_POST['envio'] );
    
    if ($altapedido) {
    $i = 1;
    foreach ($_COOKIE["carrito"] as $ref => $unidades) {
        $altalineas = lineapedido::altaLinea($i, $altapedido, $ref, $unidades, '1');
        $i++;
    }
}

if ($altapedido && $altalineas) {
    foreach ($_COOKIE["carrito"] as $ref => $unidades) {// la recorro y borro las cookies
        setcookie("carrito[$ref]", "0", time() - 1);
    }
}

    //Redirigimos a la tienda
    //header("Location: index.php");
}

?>

<div id="container" class="d-flex flex-row col-lg-12 col-md-12 col-sm-12 justify-content-center">
<?php
require_once ('plantilla/leftmenu.php');
echo '<div class="col-lg-8 col-md-8 col-sm-8">';
echo '<div class="col-lg-6 col-md-6 col-sm-6">';
echo '<form id="producto" class="m-4" method="post" action="realizarcompra.php">';
if (!$_SESSION) {
    ?>		      
        <fieldset>
            <legend><em>Datos envío</em></legend>
            <div class="form-group">
                <label for="dni">Dni:</label><br/>
                <input type="text" id="dni" name="dni" size="10" maxlength="9"/><br/>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre completo:</label><br/>	
                <input type="text" id="nombre" name="nombre" size="40" maxlength="40"/><br/>
            </div>
            <div class="form-group">
                <label for="nombre">Teléfono:</label><br/>	
                <input type="text" id="nombre" name="telefono" size="10" maxlength="9"/><br/>
                <label for="nombre">Email:</label><br/>	
                <input type="text" id="email" name="email" size="20" maxlength="30"/><br/>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label><br/>
                <input type="direccion" id="direccion" name="direccion" size="100" maxlength="120"/><br/>
            </div>
        </fieldset>
    <?php
} elseif (isset($_SESSION)) {
    $usuario = cliente::getClient($_SESSION['id']);
    ?>
    <fieldset>
        <legend><em>Datos envío</em></legend>
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
            <input class="form-control" type="direccion" id="direccion" name="direccion" size="100" maxlength="120" value ="<?php echo $usuario->getDireccion().", ".$usuario->getProvincia().", ".$usuario->getLocalidad();?>"/><br/>
        </div>
    </fieldset>
    <?php
} else {
    echo "Error inesperado";
}
?>
<fieldset>
    <legend class><em>Datos de Pago</em></legend>
    <div class="form-group">
        <label for="pago">Tipo de pago:</label>
        <select name="pago">
            <option value="tarjeta">Tarjeta de crédito</option> 
            <option value="transferencia">Transferencia</option>
        </select>
    </div>
    <div class="form-group">	
        <label for="numero">Número IBAN/Tarjeta:</label>
        <input type="text" class='form-control' name="numero" id="descripcion" size="20"/><br/>
    </div>
    <div class="form-group">	
        <label for="envio">Tipo de envío:</label>
        <select name="envio">
            <option value="urgente">Urgente 24h</option> 
            <option value="normal">Normal</option>
            <option value="recogida">Recogida en tienda</option>
        </select>
    </div>
</fieldset>
<br/>
<input class="btn btn-success" type="submit" name="confirmar" value="Guardar"/>
<input class="btn btn-danger" type="button" name="cancelar" value="Cancelar" onclick="location.href = 'carrito.php'"/>
</form>          

<?php
echo '</div>';
echo '</div>';
require_once ('plantilla/rightmenu.php');
?>
</div>

<?php
require_once ('plantilla/footer.php');
?>