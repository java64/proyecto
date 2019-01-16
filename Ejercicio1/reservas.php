<?php
spl_autoload_register(function( $NombreClase ) {
    include_once($NombreClase . '.php');
});

include "includes/cabecera.php";

//Sacamos la fecha del día o la que diga el formulario
if (!isset($_POST['fecha'])) {
    $date = new DateTime();
    //echo $date->format('d/m/Y');
    $fecha = $date->format('d/m/Y');
} else {
    $date = new DateTime($_POST['fecha']);
    //echo $date->format('d/m/Y');
    $fecha = $date->format('d/m/Y');
}
?>

<header class="cabecera">
    <h1>RESERVAS</h1><h3>Día:&nbsp;<?php echo $fecha; ?></h3><h3>&nbsp;</h3>
</header>

<section>
    <form action="reservas.php" method="post">
        <input type="date" name="fecha" value="<?php echo $fecha; ?>">
        <input type="submit" name="Fecha" value="Buscar Fecha">
    </form>
    <form action="reservas.php" method="post">
        <input type="text" name="apellido" >
        <input type="submit" value="Buscar Apellido">
    </form>
</section>
<section>
    <table>
        <tr>
            <th>Apellidos</th>
            <th>Nombre</th>
            <th>Hora</th>
            <th>Comensales</th>
            <th>Editar</th>
            <th>Cancelar</th>
        </tr>

        <?php
        if (isset($_POST['Fecha'])) {
            $listaReservasFecha = CrudReserva::mostrar($fecha);
            foreach ($listaReservasFecha as $reserva) {
                ?>
                <tr>
                    <td><?php echo $reserva->getApellidos() ?></td>
                    <td><?php echo $reserva->getNombre() ?></td>
                    <td><?php echo $reserva->getHora() ?></td>
                    <td><?php echo $reserva->getComensales() ?></td>
                    <td><a href="manager.php?id=<?php echo $reserva->getId() ?>&accion=a">Edit</a> </td>
                    <td><a href="manager.php?id=<?php echo $reserva->getId() ?>&accion=e">x</a>   </td>
                </tr>
                <?php
            }
        }
        ?>
        <?php
        if (isset($_POST['apellido'])) {
            $listaReservasApellido = CrudReserva::mostrarPorApellido($_POST['apellido']);
            foreach ($listaReservasApellido as $reserva) {
                ?>
                <tr>
                    <td><?php echo $reserva->getApellidos() ?></td>
                    <td><?php echo $reserva->getNombre() ?></td>
                    <td><?php echo $reserva->getHora() ?></td>
                    <td><?php echo $reserva->getComensales() ?></td>
                    <td><a href="manager.php?id=<?php echo $reserva->getId() ?>&accion=a">Edit</a> </td>
                    <td><a href="manager.php?id=<?php echo $reserva->getId() ?>&accion=e">x</a>   </td>
                </tr>
                <?php
            }
        }
        ?>

    </table>


</section>
<?php
include "includes/pie.php";
?>