<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php');
    exit();
}

include_once("./conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_mesa = substr(key($_POST), 5);

    if (!empty($id_mesa)) {
        ocuparMesa($id_mesa, $conn);
    } else {
        echo "Error: El ID de la mesa está vacío.";
    }
}

function ocuparMesa($id_mesa, $conn) {
    $sql_select_mesa = "SELECT mesa_ocupada, fecha_entrada FROM tbl_mesas WHERE id_mesa = ?";
    $stmt_select_mesa = mysqli_prepare($conn, $sql_select_mesa);
    mysqli_stmt_bind_param($stmt_select_mesa, "s", $id_mesa);
    mysqli_stmt_execute($stmt_select_mesa);
    $result = mysqli_stmt_get_result($stmt_select_mesa);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $mesa_ocupada = $row["mesa_ocupada"];

        if ($mesa_ocupada) {
            $id_usuario_actual = $_SESSION['id_user'];
            $fecha_entrada_actual = $row["fecha_entrada"];
            $fecha_salida_actual = date("Y-m-d H:i:s");

            $sql_desocupar_sillas = "UPDATE tbl_sillas SET silla_ocupada = FALSE WHERE id_mesa = ?";
            $stmt_desocupar_sillas = mysqli_prepare($conn, $sql_desocupar_sillas);
            mysqli_stmt_bind_param($stmt_desocupar_sillas, "s", $id_mesa);

            if (mysqli_stmt_execute($stmt_desocupar_sillas)) {
                echo "Sillas desocupadas correctamente.";
            } else {
                echo "Error al desocupar las sillas: " . mysqli_error($conn);
            }

            $sql_insert_registro = "INSERT INTO tbl_registros_mesas (id_mesa, id_user, fecha_hora_entrada, fecha_hora_salida) VALUES (?, ?, ?, ?)";
            $stmt_insert_registro = mysqli_prepare($conn, $sql_insert_registro);
            mysqli_stmt_bind_param($stmt_insert_registro, "ssss", $id_mesa, $id_usuario_actual, $fecha_entrada_actual, $fecha_salida_actual);

            if (mysqli_stmt_execute($stmt_insert_registro)) {
                echo "Registro de salida mesa insertado correctamente.";

                $sql_update_mesa = "UPDATE tbl_mesas SET mesa_ocupada = FALSE, fecha_entrada = NULL WHERE id_mesa = ?";
                $stmt_update_mesa = mysqli_prepare($conn, $sql_update_mesa);
                mysqli_stmt_bind_param($stmt_update_mesa, "s", $id_mesa);

                if (mysqli_stmt_execute($stmt_update_mesa)) {
                    echo "Mesa liberada correctamente.";
                    header('Location: ../home.php');
                    exit();
                } else {
                    echo "Error al actualizar la mesa: " . mysqli_error($conn);
                }
            } else {
                echo "Error al insertar el registro de salida: " . mysqli_error($conn);
            }
        } else {
            $sql_update_mesa = "UPDATE tbl_mesas SET mesa_ocupada = TRUE, fecha_entrada = CURRENT_TIMESTAMP WHERE id_mesa = ?";
            $stmt_update_mesa = mysqli_prepare($conn, $sql_update_mesa);
            mysqli_stmt_bind_param($stmt_update_mesa, "s", $id_mesa);

            if (mysqli_stmt_execute($stmt_update_mesa)) {
                $sql_ocupar_sillas = "UPDATE tbl_sillas SET silla_ocupada = TRUE WHERE id_mesa = ?";
                $stmt_ocupar_sillas = mysqli_prepare($conn, $sql_ocupar_sillas);
                mysqli_stmt_bind_param($stmt_ocupar_sillas, "s", $id_mesa);

                if (mysqli_stmt_execute($stmt_ocupar_sillas)) {
                    echo "Mesa ocupada y sillas ocupadas correctamente.";
                    header('Location: ../home.php');
                    exit();
                } else {
                    echo "Error al ocupar las sillas: " . mysqli_error($conn);
                }
            } else {
                echo "Error al ocupar la mesa: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Error al obtener el estado de la mesa: " . mysqli_error($conn);
    }

}
?>
