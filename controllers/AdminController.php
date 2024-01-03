<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {

    public static function index(Router $router){

        //proteger ruta

        isAdmin();

        //si en la url no tiene nada , agarra la fecha del servidor
        $fecha = $_GET['fecha'] ??  date('Y-m-d');

        //separamos
        $fechas = explode('-', $fecha);
        //valida los campos de la fecha
        if( !checkdate($fechas[1], $fechas[2], $fechas[0])){
            header('Location: /404');
        }

        //CONSULTAR DB

        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.correo, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN cita_servicio ";
        $consulta .= " ON cita_servicio.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=cita_servicio.servicioId ";
        $consulta .= " WHERE fecha =  '$fecha' ";

       
       $citas = AdminCita::SQL($consulta);



        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}