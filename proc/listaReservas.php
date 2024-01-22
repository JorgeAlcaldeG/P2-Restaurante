<?php
// var_dump($_POST);
$sql = "SELECT * FROM tbl_reservas";
$filtro="";
if($_POST["mesa"] !=0){
    $mesa =$_POST["mesa"];
    $filtro .=" WHERE id_mesa = :mesa ";
}
if($_POST["date"]!=""){
    $fecha = $_POST["date"];
    if($filtro !=""){
        $filtro .=" AND reserva_fecha = :date ";
    }else{
        $filtro .=" WHERE reserva_fecha = :date ";
    }
}

if($_POST["time1"]!=""){
    $time1 = $_POST["time1"];

    if($filtro !=""){
        $filtro .=" AND reserva_hora_ini >= :time1 ";
    }else{
        $filtro .=" WHERE reserva_hora_ini >= :time1 ";
    }
}
if($_POST["time2"]!=""){
    $time2 = $_POST["time2"];

    if($filtro !=""){
        $filtro .=" AND reserva_hora_final <= :time2 ";
    }else{
        $filtro .=" WHERE reserva_hora_final <= :time2 ";
    }
}

if($filtro !=""){
    $sql .=$filtro;
}

session_start();
include_once("./conexion.php");
$stmt = $pdo -> prepare($sql);
if($_POST["mesa"] !=0){
    $stmt -> bindParam(":mesa", $mesa);
}
if($_POST["date"]!=""){
    $stmt -> bindParam(":date", $fecha);
}
if($_POST["time1"]!=""){
    $stmt -> bindParam(":time1", $time1);
}
if($_POST["time2"]!=""){
    $stmt -> bindParam(":time2", $time2);
}
// echo $sql;
// die();
$stmt ->execute();
if($stmt->rowCount() ==0){
    echo "no";
}else{
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($res);
    // var_dump($res);
}