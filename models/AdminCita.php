<?php

namespace Model;

class AdminCita extends ActiveRecord{

    //lammada la tabla
    protected static $tabla = 'cita_servicio';
    //campos de la tabla
    protected static  $columnasDB = ['id','hora','cliente','correo','telefono','servicio', 'precio' ] ;

    public $id;
    public $hora;
    public $cliente;
    public $correo;
    public $telefono;
    public $servicio;
    public $precio;
   
    public function __construct()
    {
        $this -> id = $agrs['id'] ?? null;
        $this -> hora = $agrs['hora'] ?? '';
        $this -> cliente = $agrs['cliente'] ?? '';
        $this -> correo = $agrs['correo'] ?? '';
        $this -> telefono = $agrs['telefono'] ?? '';
        $this -> servicio = $agrs['servicio'] ?? '';
        $this -> precio = $agrs['precio'] ?? '';
    }

}