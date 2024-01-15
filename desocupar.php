<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php'); // Redirige a la página de inicio de sesión
    exit();
}
include("./proc/conexion.php");
try {
    $sqlOcupar="UPDATE `tbl_mesas` SET mesa_ocupada = 0 WHERE id_sala = ?";
    $stmt1 = mysqli_prepare($conn, $sqlOcupar);
    mysqli_stmt_bind_param($stmt1, "i", $_GET['id']);
    mysqli_stmt_execute($stmt1);
    $res = mysqli_stmt_get_result($stmt1);
    echo "Se han desocupado todas las mesas de la sala";
    echo"<a href='./salas.php'>Volver</a>";
} catch (Exception $e) {
    echo "Ha ocurrido un error al hacer la consulta: ".$e->getMessage();
    die();
}
?>