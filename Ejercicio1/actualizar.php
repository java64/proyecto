<?php
spl_autoload_register(function( $NombreClase ) {
    include_once($NombreClase . '.php');
});

include "./includes/cabecera.php";

print '<h1>Actualizar</h1>';
if (isset($_GET["id"])) {
    $reserva = CrudReserva::mostrarPorId($_GET['id']);
}
echo "Reserva a nombre de: " . $reserva->getApellidos() . " " . $reserva->getNombre();
?>  

<form action="manager.php" method="POST">
    <input type="hidden" name="apellidos" value="<?php echo $reserva->getApellidos() ?>">
    <input type="hidden" name="nombre" value="<?php echo $reserva->getNombre() ?>">
    <input type="time" name="hora" value="<?php echo $reserva->getHora() ?>">
    <input type="number" name="comensales" value="<?php echo $reserva->getComensales() ?>">
    <input type="date" name="fecha" value="<?php echo $reserva->getFecha() ?>">
    <input type="hidden" name="id" value="<?php echo $reserva->getId() ?>">
    <input type="submit" name="actualizar" value="Actualizar">
</form>

<?php
include "./includes/pie.php";
?>