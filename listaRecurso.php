<?php
session_start();
if (!isset($_SESSION['id_user'])|| $_SESSION["cargo"]==5) {
    header('Location: ./index.php'); // Redirige a la página de inicio de sesión
    exit();
}
include("./proc/conexion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Administración de recursos</title>
</head>
<body>
    <h1>Recursos</h1>
    <button id="btnOp" onclick="cambioTabla()">Mesas</button>
    <label for="nombre" id="lbl1">Nombre</label>
    <input type="text" name="nombre" id="input1" onkeyup="mostrarTabla()">
    <label for="ape" id="lbl2">Apellido</label>
    <input type="text" name="ape" id="input2" onkeyup="mostrarTabla()">
    <div id="tabla"></div>
    <script src="./js/ajaxConn.js"></script>
    <script>
        window.onload = mostrarTabla();
    </script>
    <br>
    <a href="./home.php" class="regBtn">Ir al panel de mesas</a>
    <a href="./proc/logout.php" class="logout">Cerrar sesión</a>
</body>
</html>