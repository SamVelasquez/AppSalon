<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;
use Classes\Correo;

class LoginController {
    public static function login(Router $router) {
        $alertas =[];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);

            $alertas = $auth -> validarLogin();

            //validar cuenta y contraseña

            if(empty($alertas)){
                //formulario con datos

                //comprobar que exista el usuario
                $usuario = Usuario::where('correo' , $auth ->correo);

                if ($usuario){
                    //Verificar que el usuario este confirmado
                    //verificar contraseña
                    if( $usuario -> comprobarPasswordAndVerificado($auth -> password)) {//error del phpintelephense ignorar el codigo funciona
                        

                        //debuguear($usuario);
                        //variable de sesion
                       // session_start();
                        $_SESSION['id'] = $usuario -> id;
                        $_SESSION['nombre'] = $usuario-> nombre . " " . $usuario->apellido;
                        $_SESSION['correo'] = $usuario->correo;
                        $_SESSION['login'] = true;

                       
                        if($usuario->admin === "1"){
                            
                            $_SESSION['admin'] = $usuario->admin ?? null;

                            header('Location: /admin');

                        }else{
                            header('Location: /citas');
                            //debuguear($usuario-> admin);
                        }
                        
                    }
                    
                }else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }

                //debuguear($usuario);
            }else{
                //formulario con errores
               
            }
        }
        //obtener alertas
        $alertas = Usuario::getAlertas();
        //mostrar la vista
        $router->render('auth/login', [
            'alertas' => $alertas
          
        ]);
    }


    public static function logout() {

       $_SESSION=[];
       header('Location: /');
    }

    public static function recuperar(Router $router) {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth -> validarCorreo();

            if(empty($alertas)){

                $usuario = Usuario::where('correo', $auth -> correo);

                if($usuario && $usuario->confirmado ==="1"){

                    //generar un token de un solo uso
                    $usuario -> crearToken();
                    $usuario -> guardar(); 

                    //eniviar el email
                    $email = new Correo($usuario -> correo , $usuario-> nombre, $usuario->token);
                    $email -> enviarInstrucciones();

                    //alerta de exito
                    Usuario::setAlerta('exito' , 'Revisa tu email');

                }else{
                    Usuario::setAlerta('error' , 'El usuario no existe o no esta confirmado');
                 
                }
            }
        }


        //obtener alertas
        $alertas= Usuario::getAlertas();
        //$alertas = Usuario::getAlertas();
        $router->render('auth/recuperar', [
            'alertas' => $alertas
        ]);
    }

    public static function cambiarPassword(Router $router) {
        $alertas =[];
        $error = false;

        $token = s($_GET['token']);

        //buscar usuario por su token
        $usuario = Usuario::where('token' , $token);

        if(empty($usuario)){
            Usuario::setAlerta('error' , 'Token No Valido');
            $error = true;
        }

        //leer la nueva contraseña
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $password = new Usuario($_POST);

            $alertas = $password -> validarPassword();

            if(empty($alertas)){
                //eliminio la contraseña anterior
                $usuario -> password = null;

                //remplazo la contraseña anterior por la nueva
                $usuario -> password = $password -> password;
                
              
                $usuario ->  hashPassword();
                $usuario -> token = '';

                $resultado = $usuario -> guardar();

                if($resultado){
                    //redireccion al login
                    header('Location: /');
                }
            }
        }

        $alertas= Usuario::getAlertas();
        //mostrar la vista
        $router->render('auth/cambiar-password',[
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router) {

        $usuario = new Usuario($_POST);
        //alertas vacias
        $alertas=[];

        //cuando oprimen el boton enviar
        if($_SERVER ['REQUEST_METHOD'] == 'POST'){
           
            $usuario-> sincronizar($_POST);
            $alertas = $usuario -> validarNuevaCuenta();
            //debuguear($usuario);

            if(empty($alertas)){
                //verifica si el correo esta registrado

                $resultado = $usuario -> existeUsuario();

                if($resultado -> num_rows){
                    $alertas = Usuario::getAlertas();
                }else{

                    //hashear password
                    $usuario ->hashPassword();

                    //GENERAR TOKEN
                    $usuario -> crearToken();


                    //enviar email
                    $email = new Correo( $usuario -> correo , $usuario-> nombre , $usuario->token);

                    $email -> enviarConfirmacion();


                    //crear el usuario
                    $resultado = $usuario -> guardar();

                    if($resultado){
                       header ('Location: /mensaje');
                    }
                    //no esta registrado
                    //debuguear($email);
                }
            }
            
        }


       //mostrar la vista
       $router->render('auth/crear-cuenta',[
            'usuario' => $usuario,
            'alertas' => $alertas
       ]);

    }

    public static function confirmar(Router $router) { 
        $alertas = [];
       

        $token = s($_GET ['token']);

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            //token invalido
            Usuario::setAlerta('error' , 'Token no Valido');
        }else{
            //modifica token confirmado
    
            $usuario -> confirmado = "1";
            $usuario -> token = 0;
            $usuario -> guardar();

            Usuario::setAlerta('exito', 'Cuenta Comprobada correctamente');

          
        }
        //obtener alertas
        $alertas = Usuario::getAlertas();
     

        //mostrar la vista
        $router->render('auth/confirmar-cuenta',[
        'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router) {
   


        //mostrar la vista
        $router->render('auth/mensaje',[
            
        ]);
    }



}