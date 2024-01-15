<?php
session_start();
if (!isset($_SESSION['id_user'])) {
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
    <title>Administración de recursos</title>
</head>
<body>
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
    
</body>
</html>