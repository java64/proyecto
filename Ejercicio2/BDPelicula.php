<?php

spl_autoload_register(function( $NombreClase ) {
    include_once($NombreClase . '.php');
});

class BDPelicula {

    //metodos de base de datos
    public static function mostrar() {
        $bd = Db::conectar();

        //Dentro de la base de datos seleccionamos una colección (tabla)
        $coleccion = $bd->pelicula;
        //Buscamos todas las peliculas
        $cursor = $coleccion->find();
        $listaPeliculas = [];

        foreach ($cursor as $documento) {
            $miPelicula = new Pelicula($documento["_id"], $documento["titulo"], $documento["genero"], $documento["director"], $documento["year"], $documento["sinopsis"], $documento["cartel"]);
            $listaPeliculas[] = $miPelicula;
        }

        $bd = null;
        return $listaPeliculas;
    }

    public static function mostrarPorId($unId) {
        $bd = Db::conectar();
        //Dentro de la base de datos seleccionamos una colección (tabla)
        $coleccion = $bd->pelicula;
        //Buscamos todas las peliculas
        $cursor = $coleccion->find(['_id' => new \MongoDB\BSON\ObjectId($unId)]);
        $listaPeliculas = [];

        foreach ($cursor as $documento) {
            $miPelicula = new Pelicula($documento["_id"], $documento["titulo"], $documento["genero"], $documento["director"], $documento["year"], $documento["sinopsis"], $documento["cartel"]);
            $listaPeliculas[] = $miPelicula;
        }

        $bd = null;
        return $listaPeliculas[0];
    }

    //Eliminar una pelicula
    public static function eliminar($idPelicula) {
        $bd = Db::conectar();
        //Dentro de la base de datos seleccionamos una colección (tabla)
        $coleccion = $bd->pelicula;
        //Buscamos todas las peliculas
        $coleccion->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($idPelicula)]);
        $dbh = null;
    }

    //insertar una pelicula
    public static function insertar($unaPelicula) {
        $bd = Db::conectar();
        //Dentro de la base de datos seleccionamos una colección (tabla)
        $coleccion = $bd->pelicula;

        $documento = array(
            "titulo" => $unaPelicula->getTitulo(),
            "genero" => $unaPelicula->getGenero(),
            "director" => $unaPelicula->getDirector(),
            "year" => $unaPelicula->getYear(),
            "sinopsis" => $unaPelicula->getSinopsis(),
            "cartel" => $unaPelicula->getCartel()
        );

        $coleccion->insertOne($documento);
        $dbh = null;
    }

    //Se modifica una pelicula pasandole un objeto pelicula con los valores a modificar
    public static function modificar($unaPelicula) {
        $bd = Db::conectar();
        //Dentro de la base de datos seleccionamos una colección (tabla)
        $coleccion = $bd->pelicula;
        //Buscamos todas las peliculas
        $coleccion->updateOne(
        ['_id' => new \MongoDB\BSON\ObjectId($unaPelicula->getId())],
        ['$set' => ["titulo" => $unaPelicula->getTitulo(),
        "genero" => $unaPelicula->getGenero(),
        "director" => $unaPelicula->getDirector(),
        "year" => $unaPelicula->getYear(),
        "sinopsis" => $unaPelicula->getSinopsis(),
        "cartel" => $unaPelicula->getCartel()]]);
    }

    //Muestra las criticas de una pelicula por el id_pelicula
    public static function mostrarCriticas($unId) {
        $dbh = Db::conectar();

        try {
            $stml = $dbh->prepare('SELECT * FROM critica WHERE id_pelicula=:id');
            $stml->bindValue(":id", $unId);
            $stml->execute();
            $misCriticas = array();
            $criticas = $stml->fetchAll(PDO::FETCH_OBJ);
            foreach ($criticas as $critica) {
                $miCritica = new Critica(0, $critica->id_pelicula, $critica->autor, $critica->texto, $critica->nota);
                $misCriticas[] = $miCritica;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $dbh = null;
        return $misCriticas;
    }

}
?>