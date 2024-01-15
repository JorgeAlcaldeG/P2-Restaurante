<?php


include_once("./proc/conexion.php");

$sql_select_ids_mesas = "SELECT id_mesa FROM tbl_mesas ORDER BY id_mesa ASC";
$result_ids_mesas = mysqli_query($conn, $sql_select_ids_mesas);

if (!$result_ids_mesas) {
    die("Error al obtener los IDs de las mesas: " . mysqli_error($conn));
}

$id_mesa_seleccionada = "";

$sql_base = "SELECT m.id_mesa, m.id_sala, s.ubicacion_sala, m.mesa_ocupada, m.numero_mesa, m.fecha_entrada
             FROM tbl_mesas m
             INNER JOIN tbl_salas s ON m.id_sala = s.id_sala";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['mostrar_ocupadas'])) {
        $sql_select_mesas = "$sql_base WHERE m.mesa_ocupada = 1";
    } elseif (isset($_POST['mostrar_no_ocupadas'])) {
        $sql_select_mesas = "$sql_base WHERE m.mesa_ocupada = 0";
    } elseif (isset($_POST['mostrar_todas'])) {
        $sql_select_mesas = $sql_base;
    } elseif (isset($_POST['filtrar_por_id'])) {
        $id_mesa_seleccionada = $_POST['id_mesa_seleccionada'];
        $sql_select_mesas = "$sql_base WHERE m.id_mesa = $id_mesa_seleccionada";
    } else {
        $sql_select_mesas = $sql_base;
    }
} else {
    $sql_select_mesas = $sql_base;
}

$result_mesas = mysqli_query($conn, $sql_select_mesas);

if (!$result_mesas) {
    die("Error al obtener las mesas: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Mesas</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h2>Mesas</h2>

<form action="#" method="post">
    <input type="submit" name="mostrar_todas" value="Mostrar Todas">
    <input type="submit" name="mostrar_ocupadas" value="Mostrar Ocupadas">
    <input type="submit" name="mostrar_no_ocupadas" value="Mostrar No Ocupadas">

    <label for="id_mesa_seleccionada">Filtrar por ID de Mesa:</label>
    <select name="id_mesa_seleccionada" id="id_mesa_seleccionada">
        <option value="">Seleccionar ID de Mesa</option>
        <?php
        while ($row_ids_mesas = mysqli_fetch_assoc($result_ids_mesas)) {
            $id_mesa = $row_ids_mesas['id_mesa'];
            echo "<option value='$id_mesa'>$id_mesa</option>";
        }
        ?>
    </select>

    <input type="submit" name="filtrar_por_id" value="Filtrar por ID">
</form>
<table>
    <tr>
        <th>ID Mesa</th>
        <th>ID Sala</th>
        <th>Ubicación Sala</th>
        <th>Mesa Ocupada</th>
        <th>Número de Mesa</th>
        <th>Fecha de Entrada</th>
    </tr>

    <?php
    while ($row = mysqli_fetch_assoc($result_mesas)) {
        echo "<tr>";
        echo "<td>{$row['id_mesa']}</td>";
        echo "<td>{$row['id_sala']}</td>";
        echo "<td>{$row['ubicacion_sala']}</td>";

        $estado_mesa = ($row['mesa_ocupada'] == 1) ? "Ocupada" : "Libre";
        echo "<td>$estado_mesa</td>";

        echo "<td>{$row['numero_mesa']}</td>";
        echo "<td>{$row['fecha_entrada']}</td>";
        echo "</tr>";
    }
    ?>

</table>
<a href="home.php" class="logout">Volver</a>
<a href="./registros.php" class="regBtn">Historico</a>
</body>
</html>
