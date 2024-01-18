<?php
function actuCargo(){
    include_once("./proc/conexion.php");
    $id = $_SESSION['id_user'];
    $sqlMesa = "SELECT cargo FROM tbl_camareros WHERE id_user = :id";
    $stmt1 = $pdo -> prepare($sqlMesa);
    $stmt1 -> bindParam(":id", $id);
    $stmt1 ->execute();
    $res = $stmt1 ->fetchAll();
    foreach ($res as $nomRow) {
        $_SESSION["cargo"] = $nomRow["cargo"];
    }
    if($_SESSION["cargo"] != 3){
        header('Location: ./index.php');
        exit();
    }
}