<?php
session_start();

include_once("./conexion.php");

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_user'])) {
    header('Location: ./singup.php'); // Redirige a la página de inicio de sesión
    exit();
}

function ocuparSilla($id_silla, $conn) {
    // Consultar el estado actual de la silla
    $sql_select_silla = "SELECT silla_ocupada, fecha_entrada FROM tbl_sillas WHERE id_silla = ?";
    $stmt_select_silla = mysqli_prepare($conn, $sql_select_silla);
    mysqli_stmt_bind_param($stmt_select_silla, "i", $id_silla);
    mysqli_stmt_execute($stmt_select_silla);
    mysqli_stmt_store_result($stmt_select_silla);

    if (mysqli_stmt_num_rows($stmt_select_silla) > 0) {
        mysqli_stmt_bind_result($stmt_select_silla, $silla_ocupada, $fecha_entrada);
        mysqli_stmt_fetch($stmt_select_silla);

        // Actualizar la tabla tbl_sillas
        if ($silla_ocupada) {
            // Obtener el ID de usuario actual
            $id_usuario_actual = $_SESSION['id_user'];

            // Obtener la fecha_hora_entrada actual de la silla
            $fecha_entrada_actual = $fecha_entrada;

            // Obtener la fecha y hora actual para fecha_hora_salida
            $fecha_salida_actual = date("Y-m-d H:i:s");

            // Utilizar sentencia preparada para la inserción
            $sql_insert_registro = "INSERT INTO tbl_registros_sillas (id_silla, id_user, fecha_hora_entrada, fecha_hora_salida) VALUES (?, ?, ?, ?)";
            $stmt_insert_registro = mysqli_prepare($conn, $sql_insert_registro);
            mysqli_stmt_bind_param($stmt_insert_registro, "iiss", $id_silla, $id_usuario_actual, $fecha_entrada_actual, $fecha_salida_actual);

            if (mysqli_stmt_execute($stmt_insert_registro)) {
                echo "Registro de salida insertado correctamente.";

                // Actualizar la tabla tbl_sillas
                $sql_update_silla = "UPDATE tbl_sillas SET silla_ocupada = FALSE, fecha_entrada = NULL WHERE id_silla = ?";
                $stmt_update = mysqli_prepare($conn, $sql_update_silla);
                mysqli_stmt_bind_param($stmt_update, "i", $id_silla);

                if (mysqli_stmt_execute($stmt_update)) {
                    echo "Silla liberada correctamente.";
                } else {
                    echo "Error al actualizar la silla: " . mysqli_stmt_error($stmt_update);
                }
            } else {
                echo "Error al insertar el registro de salida: " . mysqli_stmt_error($stmt_insert_registro);
            }
        } else {
            // Si la silla no está ocupada, ocuparla y establecer la fecha de entrada
            $sql_update_silla = "UPDATE tbl_sillas SET silla_ocupada = TRUE, fecha_entrada = CURRENT_TIMESTAMP WHERE id_silla = ?";
            $stmt_update = mysqli_prepare($conn, $sql_update_silla);
            mysqli_stmt_bind_param($stmt_update, "i", $id_silla);

            if (mysqli_stmt_execute($stmt_update)) {
                echo "Silla ocupada correctamente.";
            } else {
                echo "Error al ocupar la silla: " . mysqli_stmt_error($stmt_update);
            }
        }
    } else {
        echo "Error al obtener el estado de la silla.";
    }
    mysqli_stmt_close($stmt_select_silla);
    // mysqli_stmt_close($stmt_insert_registro);
    mysqli_stmt_close($stmt_update);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID de la silla desde el botón
    $id_silla = substr(key($_POST), 6); // Extraer el número de silla del nombre del botón

    // Llamar a la función ocuparSilla
    ocuparSilla($id_silla, $conn);
}
echo "</br>";
echo'<a href="../home.php">volver</a>';
?>
