<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php'); // Redirige a la página de inicio de sesión
    exit();
}
include("./proc/conexion.php");

?>