<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php'); // Redirige a la página de inicio de sesión
    exit();
}
try {
    include 'conexion.php';
    if (isset($_POST['tabla'])) {
        $ubi = intval($_POST['tabla']);
        $numubi = "SELECT * FROM tbl_salas;";
        $stmtU = mysqli_prepare($conn, $numubi);
        mysqli_stmt_execute($stmtU);
        $numubi = mysqli_stmt_get_result($stmtU);
        if ($ubi >= 0 && $ubi <= mysqli_num_rows($numubi)){
            if ($ubi === 0) {
                // Realizar la consulta SQL
                $sql = "SELECT tbl_registros_mesas.id_registro_mesas as id, tbl_mesas.id_mesa as mesa, tbl_camareros.nombre as camarero, tbl_registros_mesas.fecha_hora_entrada as entrada, tbl_registros_mesas.fecha_hora_salida as salida, TIMEDIFF(fecha_hora_salida, fecha_hora_entrada) AS diferencia, tbl_salas.id_sala as id_sala, tbl_salas.ubicacion_sala as sala FROM `tbl_registros_mesas` INNER JOIN tbl_mesas INNER JOIN tbl_camareros INNER JOIN tbl_salas ON tbl_mesas.id_mesa = tbl_registros_mesas.id_mesa and tbl_registros_mesas.id_user = tbl_camareros.id_user and tbl_salas.id_sala = tbl_mesas.id_sala ORDER BY id asc;";
                $stmt = mysqli_prepare($conn, $sql);
            }else {
                $sql = "SELECT tbl_registros_mesas.id_registro_mesas as id, tbl_mesas.id_mesa as mesa, tbl_camareros.nombre as camarero, tbl_registros_mesas.fecha_hora_entrada as entrada, tbl_registros_mesas.fecha_hora_salida as salida, TIMEDIFF(fecha_hora_salida, fecha_hora_entrada) AS diferencia, tbl_salas.id_sala as id_sala, tbl_salas.ubicacion_sala as sala FROM `tbl_registros_mesas` INNER JOIN tbl_mesas INNER JOIN tbl_camareros INNER JOIN tbl_salas ON tbl_mesas.id_mesa = tbl_registros_mesas.id_mesa and tbl_registros_mesas.id_user = tbl_camareros.id_user and tbl_salas.id_sala = tbl_mesas.id_sala WHERE tbl_salas.id_sala = ? ORDER BY id asc;";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $ubi);
            }
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($resultado) > 0) {
                while ($row = mysqli_fetch_assoc($resultado)) { 
                    ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['mesa']; ?></td>
                    <td><?php echo $row['camarero']; ?></td>
                    <td><?php echo $row['sala']; ?></td>
                    <td><?php echo $row['entrada']; ?></td>
                    <td><?php echo $row['salida']; ?></td>
                    <td><?php echo $row['diferencia']; ?></td>
                </tr>
                <?php
                }
            }else{
                echo "No hay datos registrados";
            }
        }else {
            echo "Ubicacion inexistente";
        }
    }else {
        echo "Seleccione una opcion del menú desplegable por favor";
    }
}catch(PDOException $e) {
    echo $e->getMessage();
}