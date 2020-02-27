<?php

//Añadimos la librería funciones.php
require_once("classes/funciones.php");

//Creamos la clase cliente con los mismos parámetros en el la tabla de la bbdd
class cliente {

    private $dni;
    private $nombre;
    private $direccion;
    private $localidad;
    private $provincia;
    private $telefono;
    private $email;
    private $password;
    private $tipo;
    private $activo;

    //Constructor para la clase cliente. 
    //Este constructor permite que cuando PDO hace el fetch a la clase cree los objetos sin argumentos,
    //Y que además podamos instancias un objeto cliente de forma manual.
    function __construct($dni = null, $nombre = null, $direccion = null, $localidad = null, $provincia = null, $telefono = null, $email = null, $password = null, $tipo = null, $activo = null) {
        if ($dni !== null) {
            $this->dni = $dni;
        }

        if ($nombre !== null) {
            $this->nombre = $nombre;
        }

        if ($direccion !== null) {
            $this->direccion = $direccion;
        }

        if ($localidad !== null) {
            $this->localidad = $localidad;
        }

        if ($provincia !== null) {
            $this->provincia = $provincia;
        }

        if ($telefono !== null) {
            $this->telefono = $telefono;
        }

        if ($email !== null) {
            $this->email = $email;
        }

        if ($password !== null) {
            $this->password = $password;
        }

        if ($tipo !== null) {
            $this->tipo = $tipo;
        }

        if ($activo !== null) {
            $this->activo = $activo;
        }
    }

    //getters
    public function getDni() {
        return $this->dni;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getLocalidad() {
        return $this->localidad;
    }

    public function getProvincia() {
        return $this->provincia;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getActivo() {
        return $this->activo;
    }

    //setters
    public function setDni($dni) {
        $this->dni = $dni;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setLocalidad($localidad) {
        $this->localidad = $localidad;
    }

    public function setProvincia($provincia) {
        $this->provincia = $provincia;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }

    //Imprimir cliente
 //   public function __toString() {
 //       return "<td>" . $this->getDni() . "</td><td>" . $this->getNombre() . "</td><td>" . $this->getDireccion() . "</td><td>"
 //               . $this->getLocalidad() . "</td><td>" . $this->getProvincia() . "</td><td>" . $this->getTelefono() . "</td><td class='breaktext'>" . $this->getEmail();
 //   }

    //Método para validar que un objeto cliente cumple los requisitos.
    public function validarClient($type = "nuevo") {
        //Expresión regular para validar el DNI.
        $dniRegex = '/\d{8}[a-zA-Z]$/';
        //Expresión regular para validar el teléfono.
        $telRegex = '/\d{9}/';
        //Creamos un array para guardar el resultado de las validaciones.
        $validaciones = Array();

        //Validamos si el formato del dni es correcto.
        if (!preg_match($dniRegex, $this->dni)) {
            //Si no es agregamos el mensaje de error al array asociativo. Se hace igual en el reto de validaciones.
            $validaciones['dni'] = "El formato del dni no es correcto.";
        } else {
            //Validamos si ya existe el cliente
            if (self::getClient($this->dni) && $type == 'nuevo') {
                $validaciones['dni'] = "El dni ya está registrado.";
            }
        }

        //Validamos que el nombre se introduce
        if (empty(trim($this->nombre))) {
            $validaciones['nombre'] = "El nombre es obligatorio";
        }

        //Validamos si el formato del teléfono es correcto.
        if (!preg_match($telRegex, $this->telefono)) {
            $validaciones['telefono'] = "El formato del teléfono no es correcto, debe tener 9 dígitos.";
        }

        //Validamos si el formato del email es correcto.
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $validaciones['email'] = "El formato del email no es válido.";
        }

        //Devolvemos un array con los errores resultantes de las validaciones.
        return $validaciones;
    }

    public static function validarDni($dni) {
        //Expresión regular para validar el DNI.
        $dniRegex = '/\d{8}[a-zA-Z]$/';
        //Expresión regular para validar el teléfono.
        $telRegex = '/\d{9}/';
        //Creamos un array para guardar el resultado de las validaciones.
        $resultado = false;

        //Validamos si el formato del dni es correcto.
        if (!preg_match($dniRegex, $dni)) {
            //Si no es agregamos el mensaje de error al array asociativo. Se hace igual en el reto de validaciones.
            $resultado = "El formato del dni no es correcto.";
        } elseif (self::getClient($dni)) {
            $resultado = "El dni ya está registrado.";
        } else {
            $resultado = false;
        }
        return $resultado;
    }

    public static function validarNombre($nombre) {
        $len = 40;
        if (empty(trim($nombre) || strlen($nombre)>$len)) {
            $resultado = "El nombre es obligatorio y la longitud máxima es de ".$len." carácteres.";
        } else {
            $resultado = false;
        }
        return $resultado;
    }
    
    
    public static function validarDireccion($direccion) {
        $len = 120;
        if (empty(trim($direccion) || strlen($direccion)>$len)) {
            $resultado = "La dirección es obligatoria y la longitud máxima es de ".$len." carácteres.";
        } else {
            $resultado = false;
        }
        return $resultado;
    }
    
    public static function validarLocalidad($localidad) {
        $len = 30;
        if (empty(trim($localidad) || strlen($localidad)>$len)) {
            $resultado = "La localidad es obligatoria y la longitud máxima es de ".$len." carácteres.";
        } else {
            $resultado = false;
        }
        return $resultado;
    }
    
    public static function validarProvincia($provincia) {
        $len=40;
        if (empty(trim($provincia) || strlen($provincia)>$len)) {
            $resultado = "La provincia es obligatoria y la longitud máxima es de ".$len." carácteres.";
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
    
    public static function validarPassword($password) {
        if (empty(trim($password))) {
            $resultado = "La contraseña es obligatoria.";
        } elseif (strlen(trim($password)) < 8) {
            $resultado = "La contraseña debe tener al menos 8 dígitos.";
        } else {
            $resultado = false;
        }
        return $resultado;
    }

    public static function verificarPassword($dni, $password) {
        $cliente = self::getClient($dni);
        $validaciones = Array();
        if (password_verify($password, $cliente->getPassword())) {
            return $cliente;
        } else {
            return false;
        }
    }

    public function validarAltaCorta($dni, $nombre, $password) {
        $validaciones = Array();
        $validaciones['dni'] = self::validarDni($dni);
        $validaciones['nombre'] = self::validarNombre($nombre);
        $validaciones['password'] = self::validarPassword($password);

        if (!$validaciones['dni'] && !$validaciones['nombre'] && !$validaciones['password']) {
            return false;
        } else {
            return $validaciones;
        }
    }
    
    public function validarForm($dni, $nombre, $telefono, $email, $direccion, $localidad, $provincia) {
        $validaciones = Array();
        $validaciones['nombre'] = self::validarNombre($nombre);
        $validaciones['email'] = self::validarEmail($email);
        $validaciones['direccion'] = self::validarDireccion($direccion);
        $validaciones['localidad'] = self::validarLocalidad($localidad);
        $validaciones['provincia'] = self::validarProvincia($provincia);

        if (!$validaciones['nombre'] && !$validaciones['email']&& !$validaciones['direccion']&& !$validaciones['localidad']&& !$validaciones['provincia']) {
            return false;
        } else {
            return $validaciones;
        }
    }

    public function validarLogin($dni, $password) {
        $validaciones = Array();
        $validaciones['dni'] = self::getClient($dni);
        $validaciones['password'] = self::validarPassword($password);

        if ($validaciones['dni'] && !$validaciones['password']) {
            return false;
        } else {
            return $validaciones;
        }
    }

    //Método estático para añadir un nuevo cliente a la bbdd
    public static function altaCorta($dni, $nombre, $password) {
        $tipo = 'navegante';
        //Encripta antes de insertar
        $password = password_hash($password, PASSWORD_DEFAULT);
        $bbdd = connectBBDD();
        $query = 'INSERT INTO clientes (dni,nombre,password,tipo) VALUES (:dni,:nombre,:password,:tipo)';
        $parametros = array(':dni' => $dni, ':nombre' => $nombre, ':password' => $password, ':tipo' => $tipo);
        $cliente = executeUpdate($bbdd, $query, $parametros);
        //Validamos que devuelve el resultado correcto
        return $cliente == 1 ? true : false;
    }

    //Método estático para añadir un nuevo cliente a la bbdd
    public function addClient() {
        $bbdd = connectBBDD();
        $query = 'INSERT INTO clientes VALUES (:dni,:nombre,:direccion,:localidad,:provincia,:telefono,:email)';
        $parametros = array(':dni' => $this->dni, ':nombre' => $this->nombre, ':direccion' => $this->direccion,
            ':localidad' => $this->localidad, ':provincia' => $this->provincia, ':telefono' => $this->telefono, ':email' => $this->email);
        $cliente = executeUpdate($bbdd, $query, $parametros);

        //Validamos que devuelve el resultado correcto
        return $cliente == 1 ? true : false;
    }

    //Método estático para borrar un cliente de la bbdd por su dni
    public static function deleteClient($dni) {
        $bbdd = connectBBDD();
        $query = "DELETE FROM clientes WHERE dni=:dni";
        $parametros = array(':dni' => $dni);
        $cliente = executeUpdate($bbdd, $query, $parametros);

        //Validamos que devuelve el resultado correcto
        return $cliente == 1 ? true : false;
    }

    //Método estático para editar un cliente con los valores de un formulario
    public static function updateClient($dni, $nombre, $direccion, $localidad, $provincia, $telefono, $email) {
        $bbdd = connectBBDD();
        $query = "UPDATE clientes SET nombre=:nombre,direccion=:direccion,localidad=:localidad,provincia=:provincia,telefono=:telefono,email=:email WHERE dni=:dni";
        $parametros = array(':nombre' => $nombre, ':direccion' => $direccion, ':localidad' => $localidad, ':provincia' => $provincia, ':telefono' => $telefono, ':email' => $email, ':dni' => $dni);
        $cliente = executeUpdate($bbdd, $query, $parametros);
        //Validamos que devuelve el resultado correcto
        return $cliente == 1 ? true : false;
    }

    //Método estático para recuperar un cliente de la bbdd
    public static function getClient($dni) {
        $bbdd = connectBBDD();
        $query = "SELECT * FROM clientes WHERE dni = :dni";
        $parametros = array(':dni' => $dni);
        $cliente = executeQuery($bbdd, 'cliente', $query, $parametros);
        return (count($cliente) > 0) ? $cliente[0] : false;
    }

    //Método estático para recuperar todos cliente de la bbdd
    public static function getClientes() {
        $bbdd = connectBBDD();
        $query = 'SELECT * FROM clientes WHERE tipo = :navegante OR tipo= :registrado';
        $parametros = array(':navegante' => 'navegante',':registrado' => 'registrado');
        $clientes = executeQuery($bbdd, 'cliente', $query, $parametros);
        return (count($clientes) > 0) ? $clientes : false;
    }

    //Método estático para recuperar todos cliente de la bbdd
    public static function getEmpleados() {
        $bbdd = connectBBDD();
        $query = 'SELECT * FROM clientes WHERE tipo = :empleado';
        $parametros = array(':empleado' => 'empleado');
        $clientes = executeQuery($bbdd, 'cliente', $query, $parametros);

        return (count($clientes) > 0) ? $clientes : false;
    }

}

?>