<?php
    require 'vendor/autoload.php';

class Db
{
    private static $conexion=null;
    private function __construct()
    {
    }
 
    public static function conectar()
    {

            //Abrimos conexión a Mongo
            //Esto es un cambio No me gusta
            $conexion = new MongoDB\Client;
            //Seleccionamos base de datos
            self::$conexion = $conexion->daw;

            return self::$conexion;
    }
}
