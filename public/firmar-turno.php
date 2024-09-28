<?php
include('../src/conexion.php');
session_start();
error_reporting(0);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $turno_id = $_POST['turno_id'];
    $usuario_firma = $_POST['usuario_firma'];

    // Realiza la actualización de la firma en la base de datos
    $query = "UPDATE Registro SET Recibe = '$usuario_firma' WHERE id = '$turno_id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        // Redirige de vuelta a la página de visualización de los registros
        header('Location: index.php');
    } else {
        echo "Error al firmar el turno.";
    }
}
?>
