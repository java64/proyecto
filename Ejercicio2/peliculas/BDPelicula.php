<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php

        class BDPelicula {

            //metodos de basede datos
            public static function mostrar() {
                $dbh = Db::conectar();
                $listaPeliculas = array();

                try {
                    $stml = $dbh->prepare('SELECT * FROM pelicula');
                    $stml->execute();
                    $peliculas = $stml->fetchAll(PDO::FETCH_OBJ);

                    foreach ($peliculas as $pelicula) {
                        $peliculaObj = new Pelicula($pelicula->id, $pelicula->titulo, $pelicula->genero, $pelicula->director, $pelicula->year, $pelicula->sinopsis, $pelicula->cartel);
                        $listaPeliculas[] = $peliculaObj;
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                $dbh = null;
                return $listaPeliculas;
            }
            public static function mostrarPorId($unId) {
                $dbh = Db::conectar();

                try {
                    $stml = $dbh->prepare('SELECT * FROM pelicula WHERE id=:id');
                    $stml->bindValue(":id", $unId);
                    $stml->execute();
                    $pelicula = $stml->fetch();
                    $miPelicula = new Pelicula($pelicula['id'], $pelicula['titulo'], $pelicula['genero'], $pelicula['director'], $pelicula['year'], $pelicula['sinopsis'], $pelicula['cartel']);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                $dbh = null;
                return $miPelicula;
            }

            public static function eliminar($idPelicula) {
                $dbh = Db::conectar();

                try {
                    $stml = $dbh->prepare('DELETE FROM pelicula WHERE id=:id');
                    $stml->bindValue(':id', $idPelicula);
                    $stml->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                $dbh = null;
            }
            
            //insertar una pelicula
            public static function insertar($unaPelicula) {
                $dbh = Db::conectar();
                try {
                    $stmt = $dbh->prepare("INSERT INTO pelicula (titulo, genero, director, year, sinopsis, cartel) "
                            . "VALUES (:titulo, :genero, :director, :year, :sinopsis, :cartel)");
                    // Bind
                    $nombre = "Charles";
                    $ciudad = "Valladolid";
                    $stmt->bindValue(':titulo', $unaPelicula->getTitulo());
                    $stmt->bindValue(':genero', $unaPelicula->getGenero());
                    $stmt->bindValue(':director', $unaPelicula->getDirector());
                    $stmt->bindValue(':year', $unaPelicula->getYear());
                    $stmt->bindValue(':sinopsis', $unaPelicula->getSinopsis());
                    $stmt->bindValue(':cartel', $unaPelicula->getCartel());
                    // Excecute
                    $stmt->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
            
            //Se modifica una pelicuña pasandole un objeto pelicula con los valores a modificar
            public static function modificar($unaPelicula) {
                $dbh = Db::conectar();

                try {
                    $stml = $dbh->prepare('UPDATE pelicula SET titulo=:titulo, genero=:genero, director=:director, year=:year, sinopsis=:sinopsis, cartel=:cartel WHERE id=:id');
                    $stml->bindValue(':id', $unaPelicula->getId());
                    $stml->bindValue(':titulo', $unaPelicula->getTitulo());
                    $stml->bindValue(':genero', $unaPelicula->getGenero());
                    $stml->bindValue(':director', $unaPelicula->getDirector());
                    $stml->bindValue(':year', $unaPelicula->getYear());
                    $stml->bindValue(':sinopsis', $unaPelicula->getSinopsis());
                    $stml->bindValue(':cartel', $unaPelicula->getCartel());
                    $stml->execute();
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                $dbh = null;
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
    </body>
</html>
