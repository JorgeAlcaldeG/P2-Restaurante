<?php

include("./conexion.php");
$sala = $_POST["sala"];
$emp = $_POST["emp"];
$params = false;
$sql="";
$sql = "SELECT tbl_registros_mesas.id_registro_mesas as id, tbl_mesas.id_mesa as mesa, tbl_camareros.nombre as camarero, tbl_registros_mesas.fecha_hora_entrada as entrada, tbl_registros_mesas.fecha_hora_salida as salida, TIMEDIFF(fecha_hora_salida, fecha_hora_entrada) AS diferencia, tbl_salas.id_sala as id_sala, tbl_salas.ubicacion_sala as sala FROM `tbl_registros_mesas` INNER JOIN tbl_mesas INNER JOIN tbl_camareros INNER JOIN tbl_salas ON tbl_mesas.id_mesa = tbl_registros_mesas.id_mesa and tbl_registros_mesas.id_user = tbl_camareros.id_user and tbl_salas.id_sala = tbl_mesas.id_sala";
if($sala !=0){
    $params = true;
    $sql .= " WHERE tbl_salas.id_sala =:id_sala";
}
if($emp !=0){
    if($params == false){
        $params = true;
        $sql .= " WHERE tbl_camareros.id_user = :id_usr";
    }else{
        $sql .=" AND tbl_camareros.id_user = :id_usr";
    }
}
if(isset($_POST["date1"])){
    $date1 = $_POST["date1"];
}
if(isset($_POST["date2"])){
    $date2 = $_POST["date2"];
}
if(isset($date1) && isset($date2)){
    if(!$params){
        $params = true;
        $sql .= " WHERE fecha_hora_entrada >= :date1 AND fecha_hora_entrada <= :date2";
    }else{
        $sql .= " AND fecha_hora_entrada >= :date1 AND fecha_hora_entrada <= :date2";
    }
}else{
    if(isset($date1) && !isset($date2)){
        if(!$params){
            $params = true;
            $sql .= " WHERE fecha_hora_entrada >= :date1";
        }else{
            $sql .= " AND fecha_hora_entrada >= :date1";
        }
    }
    if(!isset($date1) && isset($date2)){
        if(!$params){
            $params = true;
            $sql .= " WHERE fecha_hora_entrada <= :date2";
        }else{
            $sql .= " AND fecha_hora_entrada <= :date2";
        }
    }
}
$sql.= " ORDER BY id asc";
$stmt = $pdo ->prepare($sql);
if($sala !=0){
    $stmt -> bindParam(":id_sala",$sala);
}
if($emp !=0){
    $stmt -> bindParam(":id_usr",$emp);
}
if(isset($date1)){$stmt -> bindParam(":date1",$date1);}
if(isset($date2)){$stmt -> bindParam(":date2",$date2);}
$stmt -> execute();
$res = $stmt -> fetchAll();
if($stmt->rowCount() != 0){
    echo"<table id='Tabla'>
        <tr id='Cabecera'>
            <th>Registro</th>
            <th>Mesa</th>
            <th>Camarero</th>
            <th>Sala</th>
            <th>Entrada</th>
            <th>Salida</th>
            <th>Tiempo ocupado</th>
        </tr>";
        foreach ($res as $reg) {
            // var_dump($reg);
            echo"<tr>
            <td>".$reg["id"]."</td>
            <td>".$reg["mesa"]."</td>
            <td>".$reg["camarero"]."</td>
            <td>".$reg["sala"]."</td>
            <td>".$reg["entrada"]."</td>
            <td>".$reg["salida"]."</td>
            <td>".$reg["diferencia"]."</td>
            </tr>";
        }
    echo"</table>";
}else{
    echo "No se han encontrado registros";
}
