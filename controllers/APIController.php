<?php

namespace Controllers;

use Model\Cita;
use Model\Servicio;
use Model\CitaServicio;


Class APIController{
    
    public static function index(){
        
        $servicios = Servicio::all();

       // debuguear($servicios);
        echo json_encode($servicios);
    
    }

    public static function guardar(){

        $cita = new Cita($_POST);

        $resultado = $cita -> guardar();
        $id = $resultado['id'];

        //almacena la cita y devuelve el id
        //separa los datos
        $idServicios = explode(",", $_POST['servicios'] );
        //arreglo asociativo
        foreach ($idServicios as $idServicio){
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
          
            $citaServicio  -> guardar();
            
            
        }  
        //retorna la respuesta */
        $respuesta = [
            'servicios' => $resultado
        ];

        echo json_encode($respuesta);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];

            $cita = Cita::find($id);

            $cita -> eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']); //redirecciono a la  pagina donde vino
        }
    }

}