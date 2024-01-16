<?php

try {
    $usr =$_POST["usr"];
    // echo $usr;
    require_once('conexion.php');
    $query = $pdo ->prepare("DELETE FROM tbl_camareros WHERE `tbl_camareros`.`id_user` = :id");
    $query -> bindParam(":id", $usr);
    $query -> execute();
    echo "ok";
} catch (Exception $e){
    echo "Error en la conexión con la base de datos: " . $e->getMessage();
    die();
}
