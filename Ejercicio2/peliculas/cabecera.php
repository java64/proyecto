<?php 
$conexion = mysqli_connect("localhost", "root", "", "agenda");
 if ($conexion) {
     mysqli_set_charset($conexion, "utf8");
}else{
    echo 'Error de la conexion';
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Agenda de contactos</title>
        <link rel="stylesheet" href="includes/css/Estilos.css"/>
        <style>
            
        </style>
    </head>
    <body>
        
        
