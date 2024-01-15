<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php'); // Redirige a la página de inicio de sesión
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina intermedia</title>
</head>
<body>
    <h1>Elige una opción</h1>
    <a href="./home.php">Ir a Home</a>
    <a href="./listaRecurso.php">Lista de empleados</a>
</body>
</html>