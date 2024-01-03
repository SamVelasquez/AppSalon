<?php

namespace Model;

class Servicio extends ActiveRecord{
    //base datps

    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id' , 'nombre' , 'precio'];
    
    //variables con el mismo nombre de la base de datos 
    public $id;
    public $nombre;
    public $precio;

    //constructor

    public function __construct($args = [])
    {
        $this -> id  = $args ['id'] ?? null ;
        $this -> nombre  = $args ['nombre'] ?? '' ;
        $this -> precio  = $args ['precio'] ?? 0 ;
    }
    public function validar (){

        if (!$this -> nombre){
            self::$alertas['error'][] = 'el nombre del servicio esta vacio';
        }
        if (!$this -> precio){
            self::$alertas['error'][] = 'Debe ingresar el precio del servicio';
        }
        if (!is_numeric($this -> precio)){
            self::$alertas['error'][] = 'El precio no es valido';
        }

        return self::$alertas;
    }
}