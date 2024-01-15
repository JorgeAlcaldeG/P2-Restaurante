<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Registros</title>
</head>
<body>
    <?php
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header('Location: ./index.php'); // Redirige a la página de inicio de sesión
            exit();
        }
        include_once("./proc/conexion.php");
    ?>
    <select id="sala" onchange="mostrarRegistro()">
    <option value="0" selected>Todas</option>
    <?php
    include_once("./proc/conexion.php");
    // Consulta SQL para verificar el correo
    $sql = "SELECT * FROM tbl_salas";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute();
    $res = $stmt -> fetchAll();
    if ($stmt->rowCount() > 0) {
        foreach ($res as $row) {
            echo "<option value=" . $row['id_sala'] . ">" . $row['ubicacion_sala'] . "</option>";
        }
    }?>;
    </select>
    <select id="emp" onchange="mostrarRegistro()">
    <option value="0" selected>Todos</option>
    <?php 
    $sql = "SELECT * FROM tbl_camareros";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute();
    $res = $stmt -> fetchAll();
    foreach ($res as $row) {
        echo "<option value=" . $row['id_user'] . ">" . $row['nombre'] . "</option>";
    }
    ?>
    </select>
    <div class="tabla" id="tabla"></div>
    <script src="./js/ajaxConn.js"></script>
    <script>
        window.onload = mostrarRegistro();
    </script>
</body>
</html>