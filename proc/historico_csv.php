<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php'); // Redirige a la página de inicio de sesión
    exit();
}
include 'conexion.php';
// Realizar la consulta SQL
$sala = $_GET["sala"];
$emp = $_GET["emp"];
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
if(isset($_GET["date1"])){
    $date1 = $_GET["date1"];
}
if(isset($_GET["date2"])){
    $date2 = $_GET["date2"];
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
    $stmt-> execute();
    $resultado = $stmt -> fetchAll();
// Verificar si hay resultados
if ($stmt->rowCount() > 0) {
    // Definir el nombre del archivo CSV
    $nombreArchivo = 'export_registros_mesas.csv';

    // Crear un puntero al archivo temporal
    $archivo = fopen($nombreArchivo, 'w');

    // Escribir la fila de encabezado en el archivo CSV
    $encabezados = array('id', 'mesa', 'camarero', 'entrada', 'salida', 'diferencia', 'ubicacion');
    fputcsv($archivo, $encabezados);

    // Recorrer los resultados y escribir cada fila en el archivo CSV
    foreach ($resultado as $fila) {
        fputcsv($archivo, $fila);
    }

    // Cerrar el puntero al archivo
    fclose($archivo);

    // Configurar las cabeceras para descargar el archivo
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
    header('Pragma: no-cache');
    readfile($nombreArchivo);

    // Eliminar el archivo temporal
    unlink($nombreArchivo);

} else {
    echo 'No hay datos para exportar.';
}

// // Cerrar la conexión a la base de datos
// mysqli_close($pdo);
?>