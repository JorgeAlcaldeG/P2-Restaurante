<?php
    session_start();
    include_once("./proc/conexion.php");
    // Comprobar si el usuario ha iniciado sesión
    if (!isset($_SESSION['id_user'])) {
        header('Location: ./index.php'); // Redirige a la página de inicio de sesión
        exit();
    }else{
        $id = $_SESSION['id_user'];
        // var_dump($_SESSION);
        $sqlMesa = "SELECT nombre, cargo FROM tbl_camareros WHERE id_user = :id";
        $stmt1 = $pdo -> prepare($sqlMesa);
        $stmt1 -> bindParam(":id", $id);
        $stmt1 ->execute();
        $res = $stmt1 ->fetchAll();
        foreach ($res as $nomRow) {
            $nom =$nomRow['nombre'];
            $_SESSION["cargo"] = $nomRow["cargo"];
        }
        if($_SESSION["cargo"] == 5 || $_SESSION["cargo"] == 2){
            header('Location: ./index.php');
            exit();
        }
    }

    $mesas = "SELECT id_mesa FROM tbl_mesas ORDER BY id_mesa ASC;";
    $stmtMesa = $pdo -> prepare($mesas);
    $stmtMesa -> execute();
    $mesaForm = $stmtMesa->fetchAll();
    $numMesas = $stmtMesa ->rowCount(); 
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Reservas</title>
</head>
<body>
    <h1 style="text-align: center;">Reservas</h1>
    <br>
    <a href="./home.php" class="logout">Mapa</a>
    <div class="container">
        <div class="row">
            <div class="col-6" id="reservasLista">
                <p id="textoReserva" style="text-align: center;">Hola</p>
                <table id='Tabla'>
                    <thead>
                        <tr id='Cabecera'>
                            <th>Mesa</th>
                            <th>Fecha inicio</th>
                            <th>Hora inicio</th>
                            <th>Hora final</th>
                        </tr>
                    </thead>
                    <tbody id="reservaDatos">

                    </tbody>
                </table>
            </div>
            <div class="col-6" id="formularioReservas">
                <h3 style="text-align: center;">Crear reserva</h3>
                <br>
                <div class="row">
                    <div class="col-6">
                        <p class="centrarTexto">Mesas</p>
                        <select class="centrarForm" name="mesas" id="mesas" onchange="mostrarReservas()">
                            <option value="0">Todos</option>
                            <?php
                                foreach ($mesaForm as $mesa) {
                                    echo'<option value="'.$mesa["id_mesa"].'">Mesa '.$mesa["id_mesa"].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <br>
                    <div class="col-6">
                        <p class="centrarTexto">Fecha</p>
                        <input class="centrarForm" type="date" name="date" id="date" onchange="mostrarReservas()">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <p class="centrarTexto">Inicio de la reserva</p>
                        <input class="centrarForm" type="time" name="time1" id="time1" onchange="mostrarReservas()">
                        </div>
                        <div class="col-6">
                            <p class="centrarTexto">Final de la reserva</p>
                            <input class="centrarForm" type="time" name="time2" id="time2" onchange="mostrarReservas()">
                    </div>
                </div>
                <input type="hidden" name="numMesas" id="numMesas" value="<?php echo $numMesas; ?>">
                <br>
                <button disabled id="btnReserva" class="centrarForm" onclick="crearReserva()">Crear reserva</button>
                <hr>
        </div>
    </div>
    <script src="./js/ajaxConn.js"></script>
    <script>
        window.onload = mostrarReservas();
    </script>
</body>
</html>