<?php

namespace Controllers;
use MVC\Router;

class CitasController{
    /*********************AREA PRIVADA****************************** */
    public static function citas(Router $router){
        $alertas = [];

        //session_start();

        isAuth();
        //debuguear($_SESSION);
        //mostrar la vista
        $router->render('citas/index',[
            'alertas' => $alertas,
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
    }

    /******************FIN AREA PRIVADA****************************** */
}