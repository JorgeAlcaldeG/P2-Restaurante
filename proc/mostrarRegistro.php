<?php

include("./conexion.php");
var_dump($_POST);
$sala = $_POST["sala"];
$emp = $_POST["emp"];
$sql = "SELECT tbl_registros_mesas.id_registro_mesas as id, tbl_mesas.id_mesa as mesa, tbl_camareros.nombre as camarero, tbl_registros_mesas.fecha_hora_entrada as entrada, tbl_registros_mesas.fecha_hora_salida as salida, TIMEDIFF(fecha_hora_salida, fecha_hora_entrada) AS diferencia, tbl_salas.id_sala as id_sala, tbl_salas.ubicacion_sala as sala FROM `tbl_registros_mesas` INNER JOIN tbl_mesas INNER JOIN tbl_camareros INNER JOIN tbl_salas ON tbl_mesas.id_mesa = tbl_registros_mesas.id_mesa and tbl_registros_mesas.id_user = tbl_camareros.id_user and tbl_salas.id_sala = tbl_mesas.id_sala ORDER BY id asc;";
$stmt = $pdo ->prepare($sql);
$stmt -> execute();
$res = $stmt -> fetchAll();
if($stmt->rowCount() != 0){
    echo"<table>
        <tr>
            <th>Registro</th>
            <th>Mesa</th>
            <th>Camarero</th>
            <th>Sala</th>
            <th>Entrada</th>
            <th>Salida</th>
            <th>Tiempo ocupado</th>
        </tr>";
        foreach ($res as $reg) {
            var_dump($reg);
            echo"<tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            </tr>";
        }
    echo"</table>";
}else{
    echo "No se han encontrado registros";
}
