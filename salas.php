<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php'); // Redirige a la página de inicio de sesión
    exit();
}
include("./proc/conexion.php");
try {
    $sqlUsr="SELECT * FROM `tbl_salas`";
    $stmt1 = mysqli_prepare($conn, $sqlUsr);
    mysqli_stmt_execute($stmt1);
    $res = mysqli_stmt_get_result($stmt1);
    $rows = mysqli_num_rows($res);
} catch (Exception $e) {
    echo "Ha ocurrido un error al hacer la consulta: ".$e->getMessage();
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver salas</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<table>
    <tr>
        <th>ID sala</th>
        <th>Nombre de la sala</th>
        <th>Cambiar numero de sillas</th>
        <th>Ocupar</th>
        <th>Desocupar</th>
    </tr>
    <?php
    foreach ($res as $salas) {
        $id=$salas["id_sala"];
        // echo $id;
        echo"<tr>
                <th>". $salas['id_sala']."</th>
                <th>". $salas['ubicacion_sala']."</th>";
                echo'<th><a href="./cambioSilla.php?id='.$id.'">Ocupar</a></th>';
                echo'<th><a href="./ocupar.php?id='.$id.'">Ocupar</a></th>';
                echo'<th><a href="./desocupar.php?id='.$id.'">Desocupar</a></th>';
            echo"</tr>";
        // var_dump($salas);
    }
    ?>
<a href="./listaCamareros.php">Volver a la lista</a>
</body>
</html>