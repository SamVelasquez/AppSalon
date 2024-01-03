<?php

namespace Controllers;

use MVC\Router;
use Model\Servicio;

class ServicioController{

    public static function index (Router $router){

        isAdmin();
        //mostrar resultados de la db

        $servicios = Servicio::all();


        //vista
        $router->render('servicios/index',[
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }

    public static function crear (Router $router){
        isAdmin();

        $servicio = new Servicio;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $servicio -> sincronizar($_POST); 
            $alertas = $servicio -> validar();

            if(empty($alertas)){
                $servicio-> guardar();

                //debuguear($servicio);
                header('Location: /servicios');
            }
        }

        //vista
        $router->render('servicios/crear',[
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);

    }

    public static function actualizar (Router $router){
        isAdmin();
      
        if(!is_numeric($_GET['id'])){

            header('Location: /error');

        }

        $alertas = [];
        $servicio = Servicio::find($_GET['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio -> sincronizar($_POST);

            $alertas  = $servicio -> validar();

            if(empty($alertas)){
                $servicio-> guardar();

            
                header('Location: /servicios');
            }
        }
        //vista
        $router->render('servicios/actualizar',[
            'nombre' => $_SESSION['nombre'],
            'alertas' => $alertas,
            'servicio' => $servicio,
        ]);
    }

    public static function eliminar (){
        isAdmin();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $id = $_POST['id'];
            $servicio = Servicio::find($id);
            
            $servicio-> eliminar();

            header('Location: /servicios');
        }
    }
}