<?php

namespace Model;

#[\AllowDynamicProperties]

class Usuario extends ActiveRecord{
    //base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre' , 'apellido' , 'correo' , 'telefono',
    'password', 'admin' , 'confirmado', 'token' ];

    public $id;
    public $nombre;
    public $apellido;
    public $correo;
    public $telefono;
    public $password;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this-> id =$args['id'] ?? NULL;
        $this-> nombre =$args['nombre'] ?? '';
        $this-> apellido =$args['apellido'] ?? '';
        $this-> correo =$args['correo'] ?? '';
        $this-> telefono =$args['telefono'] ?? '';
        $this-> password =$args['password'] ?? '';
        $this-> admin =$args['admin'] ?? 0;
        $this-> confirmado = $args['confirmado'] ?? 0;
        $this-> token =$args['token'] ?? '';
    }

    //mensaje de validacion para la creacion de una cuenta

    public function validarNuevaCuenta() {
        if(!$this -> nombre){
            self::$alertas['error'][] = 'El nombre  es Obligatorio';
        }
        if(!$this -> apellido){
            self::$alertas['error'][] = 'El apellido es Obligatorio';
        }
        if(!$this -> telefono){
            self::$alertas['error'][] = 'El Telefono  es Obligatorio';
        }
        if(!$this -> correo){
            self::$alertas['error'][] = 'El Correo es Obligatorio';
        }
        if(!$this -> password){
            self::$alertas['error'][] = 'Favor ingresar contraseña';
        }

        //longitud
        if (strlen($this -> password) < 6){
            self::$alertas['error'][] = 'La contraseña debe tener almenos 6 caracteres';
        }
        return self::$alertas;
    }

    //validar usuario
    public function existeUsuario(){
        $query = "SELECT * FROM " . self::$tabla  . " WHERE correo ='".$this -> correo  . "' LIMIT 1";

        $resultado = self::$db -> query($query);
        
        //leo los datos en memoria
        if($resultado -> num_rows) {

            self::$alertas['error'][] = 'EL usuario ya esta registrado';

            return $resultado;
        }
    }
    //validar correo
    public function validarCorreo(){

        if(!$this -> correo){
            self::$alertas['error'][] = 'Debes ingresar un correo';
        }
        return self::$alertas;
    }

    //hashear password

    public function hashPassword(){
        $this -> password = password_hash($this -> password, PASSWORD_BCRYPT);
    }

    public function crearToken(){
        $this -> token = uniqid();
    }

    public function validarLogin(){
        if(!$this -> correo ){
            self::$alertas['error'][] = 'El correo es obligatorio';
        }
        if(!$this -> password ){
            self::$alertas['error'][] = 'La contraseña es obligatorio';
        }

        return self::$alertas;
    }
    //comprobar contraseña
    public function comprobarPasswordAndVerificado($password) {
        $resultado = password_verify($password, $this->password);
        
        if(!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = "Password incorrecto o tu cuenta no ha sido confirmada";
        } else {
            return true;
        }
    }
    
    public function validarPassword(){
        if(!$this -> password){
            self::$alertas['error'][] = 'Contraseña es Obligatoria';
        }
        if(strlen($this -> password) < 6 )  {
            self::$alertas['error'][] = 'Debe contener almenos 6 caracteres';
        }

        return self::$alertas;
    }

}