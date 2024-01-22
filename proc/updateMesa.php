<?php
$op = $_POST["op"];
include("./conexion.php");
try {
    $sqlMesa = "SELECT COUNT(tbl_sillas.id_silla) AS numero_sillas FROM tbl_mesas INNER JOIN tbl_salas ON tbl_mesas.id_sala = tbl_salas.id_sala INNER JOIN tbl_sillas ON tbl_mesas.id_mesa = tbl_sillas.id_mesa WHERE tbl_mesas.id_mesa = :id AND tbl_sillas.deshabilitado = 0 GROUP BY tbl_mesas.id_mesa, tbl_salas.ubicacion_sala, tbl_mesas.mesa_ocupada LIMIT 1; ";
    $stmt = $pdo -> prepare($sqlMesa);
    $stmt -> bindParam(":id", $_POST['id']);
    $stmt ->execute();
    $sillas = $stmt->fetchColumn();
} catch (Exception $e){
    echo "Error en la conexión con la base de datos: " . $e->getMessage();
    die();
}
    if($op =="1" && $sillas <=5){
        $sqlsilla = "SELECT `id_silla` FROM tbl_sillas WHERE id_mesa = :id AND deshabilitado = 1 LIMIT 1;  ";
        $stmt = $pdo -> prepare($sqlsilla);
        $stmt -> bindParam(":id", $_POST['id']);
        $stmt ->execute();
        $sillasDes = $stmt->fetchColumn();
        if($stmt->rowCount()==1){
            try {
                $sqlAddsilla = "UPDATE `tbl_sillas` SET `deshabilitado`='0' WHERE `id_mesa` = :id AND `deshabilitado` = 1; ";
                $stmt1 = $pdo -> prepare($sqlAddsilla);
                $stmt1 -> bindParam(":id", $_POST['id']);
                $stmt1 ->execute();
                echo $sillas = $sillas +1;
            } catch (Exception $e){
                echo "Error en la conexión con la base de datos: " . $e->getMessage();
                die();
            }
        }else{
            // INSERT
        }
    }else if($op =="-1" && $sillas >1){
        try {
            $sqlMesa = "UPDATE `tbl_sillas` SET `deshabilitado` = '1' WHERE `id_mesa` = 1 AND `deshabilitado` = 0 LIMIT 1;";
            $stmt = $pdo -> prepare($sqlMesa);
            $stmt -> bindParam(":id", $_POST['id']);
            $stmt ->execute();
            echo $sillas = $sillas -1; 
        } catch (Exception $e){
            echo "Error en la conexión con la base de datos: " . $e->getMessage();
            die();
        }
    }else{
        echo $sillas;
    }