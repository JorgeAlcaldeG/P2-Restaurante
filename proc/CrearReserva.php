
<?php
// var_dump($_POST);
$error="";
if($_POST["mesa"]<=$_POST["numMesas"] && $_POST["mesa"]>0){
    $mesa = $_POST["mesa"];
}else{
    $error .="Mesa incorrecta \n";
}
if(strtotime($_POST["date"])){
    $date=$_POST["date"];
}else{
    $error .="Formato de la fecha incorrecta </br>";
}
if(preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $_POST["time1"])){
    $time1 = $_POST["time1"];
}else{
    $error .="Formato de la hora inicial incorrecto </br>";
}
if(preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $_POST["time2"])){
    $time2 = $_POST["time2"];
}else{
    $error .="Formato de la hora final incorrecto";
}
if($error ==""){
    include_once("./conexion.php");
    $chkRes = "SELECT id_reserva FROM tbl_reservas  WHERE id_mesa = :mesa AND reserva_fecha = :date AND reserva_hora_ini >= :time1 AND reserva_hora_final <= :time2";
    $stmt = $pdo -> prepare($chkRes);
    $stmt -> bindParam(":mesa", $mesa);
    $stmt -> bindParam(":date", $date);
    $stmt -> bindParam(":time1", $time1);
    $stmt -> bindParam(":time2", $time2);
    $stmt -> execute();
    if($stmt ->rowCount()!=0){
        $error = "La mesa ya está ocupada en esa franja horaria";
        echo $error;
    }else{
        try {
            $sqlRes = "INSERT INTO tbl_reservas (id_reserva, id_mesa, reserva_fecha, reserva_hora_ini, reserva_hora_final) VALUES(NULL, :mesa, :date,:time1, :time2)";
            $stmt = $pdo -> prepare($sqlRes);
            $stmt -> bindParam(":mesa", $mesa);
            $stmt -> bindParam(":date", $date);
            $stmt -> bindParam(":time1", $time1);
            $stmt -> bindParam(":time2", $time2);
            $stmt -> execute();
            echo "ok";
        } catch (Exception $e){
            echo "Error en la conexión con la base de datos: " . $e->getMessage();
            die();
        }
        
    }
}else{
    echo $error;
}