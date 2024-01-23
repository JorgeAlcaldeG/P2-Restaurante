<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php'); // Redirige a la página de inicio de sesión
    exit();
}
include("./funciones/actuCargo.php");
actuCargo();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <title>Pagina intermedia</title>
</head>
<body id="bg">
    <div class="row"id="interContainer" style="margin-top:10%">
        <h1 class="centrarTexto">Elige una opción</h1>
        <p class="centrarTexto"><strong>Bienvenido al panel del administrador.</strong></p>
        <div class="col-6 homebtn" onclick="window.location.href = './home.php'">
            <h2 class="centrarTexto">Home</h2>
            <p class="desAdmin">Comprueba y gestiona el estado de las mesas mediante una interfaz gráfica, crea reservas y comprueba el historial de ocupaciones</p>
            <p class="centrarTexto" style="font-style:italic;">*Solo para el admin y camareros*</p>
        </div>
        <div class="col-6 adminbtn" onclick="window.location.href = './listaRecurso.php'">
            <h2 class="centrarTexto">Administrar</h2>
            <p class="desAdmin">Administra tanto los empleados y sus datos como el estado de las mesas</p>
            <p class="centrarTexto" style="font-style:italic;">*Solo para administradores y mantenimiento (con funciones limitadas)*</p>
        </div>
    </div>
</body>
</html>