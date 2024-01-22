<?php

// var_dump($_POST);
include("./conexion.php");
// $sqlMesa = "SELECT * FROM tbl_mesas WHERE id_mesa = :id LIMIT 1";
$sqlMesa = "SELECT tbl_mesas.id_mesa AS mesa, tbl_salas.ubicacion_sala AS sala, tbl_mesas.mesa_ocupada AS disponibilidad, COUNT(tbl_sillas.id_silla) AS numero_sillas FROM tbl_mesas INNER JOIN tbl_salas ON tbl_mesas.id_sala = tbl_salas.id_sala INNER JOIN tbl_sillas ON tbl_mesas.id_mesa = tbl_sillas.id_mesa WHERE tbl_mesas.id_mesa = :id AND tbl_sillas.deshabilitado = 0 GROUP BY tbl_mesas.id_mesa, tbl_salas.ubicacion_sala, tbl_mesas.mesa_ocupada LIMIT 1; ";
$stmt = $pdo -> prepare($sqlMesa);
$stmt -> bindParam(":id", $_POST['id']);
$stmt ->execute();
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($res);
?>