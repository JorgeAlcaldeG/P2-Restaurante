<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_mesa = substr(key($_POST), 5);

    if (!empty($id_mesa)) {
        ocuparMesa($id_mesa);
    } else {
        echo "Error: El ID de la mesa está vacío.";
    }
}

function ocuparMesa($id_mesa) {
    include_once("./conexion.php");
    $sql_select_mesa = "SELECT mesa_ocupada, fecha_entrada FROM tbl_mesas WHERE id_mesa = :id limit 1";
    $stmt_select_mesa = $pdo->prepare($sql_select_mesa);
    // $stmt_select_mesa = mysqli_prepare($conn, $sql_select_mesa);
    $stmt_select_mesa -> bindParam(":id", $id_mesa); 
    // mysqli_stmt_bind_param($stmt_select_mesa, "s", $id_mesa);
    $stmt_select_mesa -> execute();
    // mysqli_stmt_execute($stmt_select_mesa);
    $result = $stmt_select_mesa ->fetchAll();
    // $result = mysqli_stmt_get_result($stmt_select_mesa);
    foreach ($result as $row) {
        if ($result && $stmt_select_mesa-> rowCount() > 0) {
            $mesa_ocupada = $row["mesa_ocupada"];
            if ($mesa_ocupada) {
                try {
                    $pdo->beginTransaction();
                    $id_usuario_actual = $_SESSION['id_user'];
                    $fecha_entrada_actual = $row["fecha_entrada"];
                    $fecha_salida_actual = date("Y-m-d H:i:s");
        
                    $sql_desocupar_sillas = "UPDATE tbl_sillas SET silla_ocupada = FALSE WHERE id_mesa = :id";
                    $stmt_desocupar_sillas = $pdo -> prepare($sql_desocupar_sillas);
                    // $stmt_desocupar_sillas = mysqli_prepare($conn, $sql_desocupar_sillas);
                    $stmt_desocupar_sillas -> bindParam(":id", $id_mesa);
                    // mysqli_stmt_bind_param($stmt_desocupar_sillas, "s", $id_mesa);
    
                    if ($stmt_desocupar_sillas->execute()) {
                        echo "Sillas desocupadas correctamente.";
                    } else {
                        echo "Error al desocupar las sillas: " . mysqli_error($conn);
                    }
                    $sql_insert_registro = "INSERT INTO tbl_registros_mesas (id_mesa, id_user, fecha_hora_entrada, fecha_hora_salida) VALUES (:id_mesa, :usr, :fecha1, :fecha2)";
                    $stmt_insert_registro = $pdo->prepare($sql_insert_registro);
                    // $stmt_insert_registro = mysqli_prepare($conn, $sql_insert_registro);
                    $stmt_insert_registro -> bindParam(":id_mesa",$id_mesa);
                    $stmt_insert_registro -> bindParam(":usr",$id_usuario_actual);
                    $stmt_insert_registro -> bindParam(":fecha1",$fecha_entrada_actual);
                    $stmt_insert_registro -> bindParam(":fecha2",$fecha_salida_actual);
                    // mysqli_stmt_bind_param($stmt_insert_registro, "ssss", $id_mesa, $id_usuario_actual, $fecha_entrada_actual, $fecha_salida_actual);
                    $stmt_insert_registro->execute();
                    echo "Registro de salida mesa insertado correctamente.";
                    $sql_update_mesa = "UPDATE tbl_mesas SET mesa_ocupada = FALSE, fecha_entrada = NULL WHERE id_mesa = :id";
                    $stmt_update_mesa = $pdo->prepare($sql_update_mesa);
                    $stmt_update_mesa->bindParam(":id",$id_mesa);
                    $stmt_update_mesa->execute();
                    $pdo->commit();
                    echo "Mesa liberada correctamente.";
                    header('Location: ../home.php');
                    exit();
                } catch (Exception $e){
                    $pdo->rollback();
                    echo "Error en la conexión con la base de datos: " . $e->getMessage();
                    die();
                }                
            } else {
                try {
                    $pdo->beginTransaction();
                    $sql_update_mesa = "UPDATE tbl_mesas SET mesa_ocupada = TRUE, fecha_entrada = CURRENT_TIMESTAMP WHERE id_mesa = :id";
                    $stmt_update_mesa = $pdo->prepare($sql_update_mesa);
                    // $stmt_update_mesa = mysqli_prepare($conn, $sql_update_mesa);
                    $stmt_update_mesa->bindParam(":id", $id_mesa);
                    // mysqli_stmt_bind_param($stmt_update_mesa, "s", $id_mesa);
                    // die();
                    $stmt_update_mesa->execute();
                    $sql_ocupar_sillas = "UPDATE tbl_sillas SET silla_ocupada = TRUE WHERE id_mesa = :id";
                    $stmt_ocupar_sillas = $pdo->prepare($sql_ocupar_sillas);
                    // $stmt_ocupar_sillas = mysqli_prepare($conn, $sql_ocupar_sillas);
                    $stmt_ocupar_sillas ->bindParam(":id", $id_mesa);
                    // mysqli_stmt_bind_param($stmt_ocupar_sillas, "s", $id_mesa);
                    $stmt_ocupar_sillas->execute();
                    $pdo->commit();
                    echo "Mesa ocupada y sillas ocupadas correctamente.";
                    header('Location: ../home.php');
                    exit();
                } catch (Exception $e){
                    $pdo->rollback();
                    echo "Error en la conexión con la base de datos: " . $e->getMessage();
                    die();
                }    
            }
        } else {
            echo "Error al obtener el estado de la mesa: " . mysqli_error($conn);
        }
    }

}
?>
