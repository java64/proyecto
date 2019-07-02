<?php

require 'vendor/autoload.php';

class Db {

    private static $conexion = null;

    private function __construct() {
        
    }

    public static function conectar() {

        //Abrimos conexión a Mongo
        $conexion = new MongoDB\Client;
        //Seleccionamos base de datos
        self::$conexion = $conexion->peliculas;

        return self::$conexion;
    }

}

?>