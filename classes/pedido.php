<?php

//Añadimos la librería funciones.php
require_once("funciones.php");
require_once("classes/cliente.php");

//Creamos la clase categoria con los mismos parámetros en el la tabla pedidos de la bbdd
class pedido {

    private $cod_pedido;
    private $dni_cliente;
    private $nombre;
    private $telefono;
    private $email;
    private $direccion;
    private $estado;
    private $tipo_pago;
    private $estado_pago;
    private $envio;
    private $activo;
    private $fecha_pedido;

    //Constructor para la clase pedido. 
    //Este constructor permite que cuando PDO hace el fetch a la clase cree los objetos sin argumentos,
    //Y que además podamos instancias un objeto cliente de forma manual.
    function __construct($cod_pedido = null, $dni_cliente = null, $nombre = null, $telefono = null, $email = null, $direccion = null, $estado = null, $tipo_pago = null, $estado_pago = null, $envio = null, $activo = null, $fecha_pedido = null) {
        if ($cod_pedido !== null) {
            $this->cod_pedido = $cod_pedido;
        }

        if ($dni_cliente !== null) {
            $this->dni_cliente = $dni_cliente;
        }
        
        if ($nombre !== null) {
            $this->nombre = $nombre;
        }
        
        if ($telefono !== null) {
            $this->telefono = $telefono;
        }
        
        if ($email !== null) {
            $this->email = $email;
        }
        
        if ($direccion !== null) {
            $this->direccion = $direccion;
        }

        if ($estado !== null) {
            $this->estado = $estado;
        }
        
        if ($tipo_pago !== null) {
            $this->tipo_pago = $tipo_pago;
        }
        
        if ($estado_pago !== null) {
            $this->estado_pago = $estado_pago;
        }

        if ($envio !== null) {
            $this->envio = $envio;
        }
        
        if ($activo !== null) {
            $this->activo = $activo;
        }

        if ($fecha_pedido !== null) {
            $this->fecha_pedido = $fecha_pedido;
        }
    }

    //getters
    public function getCodigo() {
        return $this->cod_pedido;
    }

    public function getDni() {
        return $this->dni_cliente;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function getTelefono() {
        return $this->telefono;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getDireccion() {
        return $this->direccion;
    }

    public function getEstado() {
        return $this->estado;
    }
    
    public function getTipoPago() {
        return $this->tipo_pago;
    }
    
    public function getEstadoPago() {
        return $this->estado_pago;
    }

    public function getEnvio() {
        return $this->envio;
    }
    
    public function getActivo() {
        return $this->activo;
    }

    public function getFecha() {
        return $this->fecha_pedido;
    }

    //Setters
    public function setCodigo($codPedido) {
        $this->cod_pedido = $cod_pedido;
    }

    public function setDni($dni) {
        $this->dni_cliente = $dni_cliente;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setDescripcion($activo) {
        $this->activo = $activo;
    }
    
    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setTipoPago($tipo_pago) {
        $this->tipo_pago = $tipo_pago;
    }
    
    public function setEstadoPago($estado_pago) {
        $this->tipo_pago = $estado_pago;
    }
    
    public function setEnvio($envio) {
        $this->tipo_pago = $envio;
    }
    
    //Imprimir categoría
    public function __toString() {
        return $this->getCodigo();
    }
    
    //Método estático para recuperar un pedido por id de la bbdd 
    public static function getPedido($id) {
        $bbdd = connectBBDD();
        $query = 'SELECT * FROM pedidos WHERE cod_pedido=:cod_pedido';
        $parametros = array('cod_pedido'=>$id);
        $pedidos = executeQuery($bbdd, 'pedido', $query, $parametros);
        if (count($pedidos) > 0) {
            return $pedidos[0];
        } else {
            return false;
        }
    }

    //Método estático para recuperar todos los pedidos de la bbdd 
    public static function getPedidos() {
        $bbdd = connectBBDD();
        $query = 'SELECT * FROM pedidos';
        $pedidos = executeQuery($bbdd, 'pedido', $query);
        if (count($pedidos) > 0) {
            return $pedidos;
        } else {
            return false;
        }
    }
    
    //Método estático para recuperar todos productos de un usuario 
     public static function getPedidosUsuario($dni) {
        $bbdd = connectBBDD();
        $query = 'SELECT * FROM pedidos WHERE dni_cliente=:dni';
        $parametros = array (':dni'=>$dni);
        $pedido = executeQuery($bbdd, 'pedido', $query,$parametros);
        return (count($pedido) > 0) ? $pedido : false;
    }

    public static function altaPedido($dniCliente, $nombre, $telefono, $email, $direccion, $tipo_pago, $envio) {
        $bbdd = connectBBDD();
        $estado = 'pagado';
        $estado_pago = 'confirmado';
        $activo= '1';
        $query = 'INSERT INTO pedidos (dni_cliente,nombre,telefono,email,direccion,estado,tipo_pago,estado_pago,envio,activo, fecha_pedido) VALUES (:dni_cliente,:nombre,:telefono,:email,:direccion,:estado,:tipo_pago,:estado_pago,:envio,:activo,NOW())';
        $parametros = array(':dni_cliente' => $dniCliente, ':nombre'=>$nombre, ':telefono'=>$telefono, ':email'=>$email, ':direccion'=>$direccion, ':estado' => $estado,
            ':tipo_pago'=>$tipo_pago, ':estado_pago'=>$estado_pago,':envio'=>$envio, ':activo' => $activo);
        $cliente = executeUpdate($bbdd, $query, $parametros);
        $idpedido = $bbdd->lastInsertId();
        //Validamos que devuelve el resultado correcto
        if ($cliente == 1) {
            return $idpedido;
        } else {
            return false;
        }
    }
    
    public static function updatePedido($cod_pedido, $dni_cliente, $nombre, $telefono, $email, $direccion, $estado, $tipo_pago, $estado_pago, $envio, $activo) {
        $bbdd = connectBBDD();
        $query = "UPDATE pedidos SET dni_cliente=:dni_cliente,nombre=:nombre,telefono=:telefono,email=:email,direccion=:direccion,estado=:estado,tipo_pago=:tipo_pago,estado_pago=:estado_pago,envio=:envio,activo=:activo WHERE cod_pedido=:cod_pedido";
        $parametros = array(':cod_pedido' =>$cod_pedido, ':dni_cliente' =>$dni_cliente, ':nombre' =>$nombre, ':telefono' =>$telefono, ':email'=> $email,':direccion'=>$direccion,':estado'=>$estado,':tipo_pago'=>$tipo_pago,':estado_pago'=>$estado_pago,':envio'=>$envio,':activo'=>$activo);
        $articulo = executeUpdate($bbdd, $query, $parametros);
        //Validamos que devuelve el resultado correcto
        return $articulo == 1 ? true : false;
    }
    
    public static function validarDni($dni) {
        //Expresión regular para validar el DNI.
        $dniRegex = '/\d{8}[a-zA-Z]$/';
        //Validamos si el formato del dni es correcto.
        if (!preg_match($dniRegex, $dni)) {
            //Si no es agregamos el mensaje de error al array asociativo. Se hace igual en el reto de validaciones.
            $resultado = "El formato del dni no es correcto.";
        } else {
            $resultado = false;
        }
        return $resultado;
    }
    
    public static function validarTelefono($telefono) {
        $telRegex = '/\d{9}/';
        if (!preg_match($telRegex, $telefono)) {
            $resultado = "El teléfono debe tener 9 dígitos.";
        } else {
            $resultado = false;
        }
        return $resultado;
    }
    
    public static function validarEmail($email) {
        $len = 30;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $resultado = "El email no es correcto. La longitud máxima es de ".$len." carácteres..";
        } else {
            $resultado = false;
        }
        return $resultado;
    }
    
     public static function validarNombre($nombre) {
        $len = 30;
        if (empty(trim($nombre) || strlen($nombre)>$len)) {
            $resultado = "El nombre es obligatorio y la longitud máxima es de ".$len." carácteres.";
        } else {
            $resultado = false;
        }
        return $resultado;
    }
    
    public static function validarDireccion($direccion) {
        $len = 180;
        if (empty(trim($direccion) || strlen($direccion)>$len)) {
            $resultado = "La dirección es obligatoria y la longitud máxima es de ".$len." carácteres.";
        } else {
            $resultado = false;
        }
        return $resultado;
    }
    
    
    public static function validarEstado($estado) {
        if ( empty(trim($estado)) || ($estado != 'pagado' && $estado != 'en preparación' && $estado != 'enviado' && $estado != 'entregado'  && $estado != 'cancelado')) {
            $resultado = "El estado es obligatorio. ['pagado','en preparación','enviado','entregado','cancelado']";
        } else {
            $resultado = false;
        }
        return $resultado;
    }
    
    public static function validarTipoPago($tipo_pago) {
        if ( empty(trim($tipo_pago)) || ($tipo_pago != 'tarjeta' && $tipo_pago != 'transferencia')) {
            $resultado = "El tipo de pago es obligatorio. ['tarjeta','transferencia']";
        } else {
            $resultado = false;
        }
        return $resultado;
    }
    
    public static function validarEstadoPago($estado_pago) {
        if ( empty(trim($estado_pago)) || ($estado_pago != 'pendiente' && $estado_pago != 'confirmado')) {
            $resultado = "El estado del pago es obligatorio. ['pendiente','confirmado']";
        } else {
            $resultado = false;
        }
        return $resultado;
    }
    
    public static function validarEnvio($envio) {
        if ( empty(trim($envio)) || ($envio != 'urgente' && $envio != 'normal' && $envio != 'recogida')) {
            $resultado = "El tipo de envío es obligatorio. ['urgente','normal','recogida']";
        } else {
            $resultado = false;
        }
        return $resultado;
    }

     public static function validarActivo($activo) {
        $actRegex = '/[0-1]$/';
        if (!preg_match($actRegex, $activo)) {
            $resultado = "El campo Activo admite valor '0' o '1'.";
        } else {
            $resultado = false;
        }
        return $resultado;
    }
    
    public function validarForm($dni_cliente, $nombre, $telefono, $email, $direccion, $estado, $tipo_pago,$estado_pago,$envio,$activo) {
        $validaciones = Array();
        $validaciones['dni_cliente'] = self::validarDni($dni_cliente);;
        $validaciones['nombre'] = self::validarNombre($nombre);
        $validaciones['telefono'] = self::validarTelefono($telefono);
        $validaciones['email'] = self::validarEmail($email);
        $validaciones['direccion'] = self::validarDireccion($direccion);
        $validaciones['estado'] = self::validarEstado($estado);
        $validaciones['tipo_pago'] = self::validarTipoPago($tipo_pago);
        $validaciones['estado_pago'] = self::validarEstadoPago($estado_pago);
        $validaciones['envio'] = self::validarEnvio($envio);
         $validaciones['activo'] = self::validarActivo($activo);
       
        if (!$validaciones['dni_cliente'] && !$validaciones['nombre'] && !$validaciones['telefono'] && !$validaciones['email']&& !$validaciones['direccion']&& 
                !$validaciones['estado'] && !$validaciones['tipo_pago'] && !$validaciones['estado_pago'] && !$validaciones['envio'] && !$validaciones['activo'] ) {
            return false;
        } else {
            return $validaciones;
        }
    }
}

?>