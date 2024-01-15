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
        $stmtU = $pdo -> prepare($numubi);
        $stmtU -> execute();
        $numubi = $stmtU -> fetchAll();
        if ($ubi >= 0 && $ubi <= $stmtU->rowCount()){
            if ($ubi === 0) {
                // Realizar la consulta SQL
                $sql = "SELECT tbl_registros_sillas.id_registro_silla as id, tbl_sillas.id_silla as silla, tbl_camareros.nombre as camarero, tbl_registros_sillas.fecha_hora_entrada as entrada, tbl_registros_sillas.fecha_hora_salida as salida, TIMEDIFF(fecha_hora_salida, fecha_hora_entrada) AS diferencia, tbl_salas.id_sala as id_sala, tbl_salas.ubicacion_sala as sala FROM `tbl_registros_sillas` INNER JOIN tbl_sillas INNER JOIN tbl_camareros INNER JOIN tbl_salas INNER JOIN tbl_mesas ON tbl_sillas.id_silla = tbl_registros_sillas.id_silla and tbl_registros_sillas.id_user = tbl_camareros.id_user and tbl_salas.id_sala = tbl_mesas.id_sala and tbl_sillas.id_mesa = tbl_mesas.id_mesa ORDER BY id asc;";
                $stmt = $pdo -> prepare($sql);
            }else {
                $sql = "SELECT tbl_registros_sillas.id_registro_silla as id, tbl_sillas.id_silla as silla, tbl_camareros.nombre as camarero, tbl_registros_sillas.fecha_hora_entrada as entrada, tbl_registros_sillas.fecha_hora_salida as salida, TIMEDIFF(fecha_hora_salida, fecha_hora_entrada) AS diferencia, tbl_salas.id_sala as id_sala, tbl_salas.ubicacion_sala as sala FROM `tbl_registros_sillas` INNER JOIN tbl_sillas INNER JOIN tbl_camareros INNER JOIN tbl_salas INNER JOIN tbl_mesas ON tbl_sillas.id_silla = tbl_registros_sillas.id_silla and tbl_registros_sillas.id_user = tbl_camareros.id_user and tbl_salas.id_sala = tbl_mesas.id_sala and tbl_sillas.id_mesa = tbl_mesas.id_mesa WHERE tbl_salas.id_sala = :id ORDER BY id asc;";
                $stmt = $pdo -> prepare($sql);
                $stmt -> bindParam(':id',$ubi);
            }
            $stmt -> execute();
            $resultado = $stmt -> fetchAll();
            if ($stmt->rowCount() > 0) {
                foreach ($resultado as $row) {
                        ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['silla']; ?></td>
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
}catch(Exception $e) {
    echo "Error: ".$e->getMessage();
}