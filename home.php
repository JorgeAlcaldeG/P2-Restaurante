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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Home</title>
</head>
<body id="login">
    <h2 id="userTitulo">Hola <?php echo $nom; ?> <span class="csvBtn"><a href="./registros.php" class="regBtn">Historico</a></span></h2>
    <div class="InfoContainer">
        <h1 id="infoTitulo">Pasa el ratón por la mesa para saber su información</h1>
        <!-- Disponibilidad -->
        <p id="disp"></p>
        <!-- Sala -->
        <p id="info" class="text-Center"></p>
        <!-- sillas disponibles -->
        <p id="sillasDisp" class="text-Center"></p>

    </div>
    <div id="reservasContainer">
        <!-- <img class="imgSize mesaOcupada" id ="Mesa1" src="./img/mesaIcon/mesa.png" alt="" srcset=""> -->
        <form method="post" action="./proc/ocupar_mesa.php">
        <!-- Botones de mesa -->
            <!-- <label for="mesa_1"></label> -->
            <div id="1" onmouseover='Informacion(this)' onmouseleave='Ocultar(this)' class="mesaContainer mesa1">
                <button type="submit" name="mesa_1" value="Mesa 1" class="mesa-btn"><img class="mesaIcon" src="./img/mesaIcon/mesa.png" alt="" srcset=""></button>
                <p style="display: none;">info</p>
            </div>
            <div id="2" onmouseover='Informacion(this)' onmouseleave='Ocultar(this)'class="mesaContainer mesa2">
                <button type="submit" name="mesa_2" value="Mesa 2" class="mesa-btn"><img class="mesaIcon" src="./img/mesaIcon/mesa.png" alt="" srcset=""></button>
                <p style="display: none;">info</p>
            </div>
            <div id="3" onmouseover='Informacion(this)' onmouseleave='Ocultar(this)'class="mesaContainer mesa3">
                <button type="submit" name="mesa_3" value="Mesa 3" class="mesa-btn"><img class="mesaIcon" src="./img/mesaIcon/mesa.png" alt="" srcset=""></button>
                <p style="display: none;">info</p>
            </div>
            <div id="4" onmouseover='Informacion(this)' onmouseleave='Ocultar(this)'class="mesaContainer mesa4">      
                <button type="submit" name="mesa_4" value="Mesa 4" class="mesa-btn"><img class="mesaIcon" src="./img/mesaIcon/mesa.png" alt="" srcset=""></button>
                <p style="display: none;">info</p>
            </div>
            <div id="5" onmouseover='Informacion(this)' onmouseleave='Ocultar(this)'class="mesaContainer mesa5">              
                <button type="submit" name="mesa_5" value="Mesa 5" class="mesa-btn"><img class="mesaIcon" src="./img/mesaIcon/mesa.png" alt="" srcset=""></button>
                <p style="display: none;">info</p>
            </div>
            <div id="6" onmouseover='Informacion(this)' onmouseleave='Ocultar(this)'class="mesaContainer mesa6">              
                <button type="submit" name="mesa_6" value="Mesa 6" class="mesa-btn"><img class="mesaIcon" src="./img/mesaIcon/mesa.png" alt="" srcset=""></button>
                <p style="display: none;">info</p>
            </div>
            <div id="7" onmouseover='Informacion(this)' onmouseleave='Ocultar(this)'class="mesaContainer mesa7">              
                <button type="submit" name="mesa_7" value="Mesa 7" class="mesa-btn"><img class="mesaIcon" src="./img/mesaIcon/mesa.png" alt="" srcset=""></button>
                <p style="display: none;">info</p>
            </div>
            <div id="8" onmouseover='Informacion(this)' onmouseleave='Ocultar(this)'class="mesaContainer mesa8">              
                <button type="submit" name="mesa_8" value="Mesa 8" class="mesa-btn"><img class="mesaIcon" src="./img/mesaIcon/mesa.png" alt="" srcset=""></button>
                <p style="display: none;">info</p>
            </div>
            <div id="9" onmouseover='Informacion(this)' onmouseleave='Ocultar(this)'class="mesaContainer mesa9">              
                <button type="submit" name="mesa_9" value="Mesa 9" class="mesa-btn"><img class="mesaIcon" src="./img/mesaIcon/mesa.png" alt="" srcset=""></button>
                <p style="display: none;">info</p>
            </div>
            <div id="10" onmouseover='Informacion(this)' onmouseleave='Ocultar(this)'class="mesaContainer mesa10">              
                <button type="submit" name="mesa_10" value="Mesa 10" class="mesa-btn"><img class="mesaIcon" src="./img/mesaIcon/mesa.png" alt="" srcset=""></button>
                <p style="display: none;">info</p>
            </div>
            <!-- Repite esto para cada mesa -->
        </form>
        <?php 
            $sqlMesa = "SELECT tbl_mesas.id_mesa AS mesa, tbl_salas.ubicacion_sala AS sala, tbl_mesas.mesa_ocupada AS disponibilidad, COUNT(tbl_sillas.id_silla) AS numero_sillas FROM tbl_mesas INNER JOIN tbl_salas ON tbl_mesas.id_sala = tbl_salas.id_sala INNER JOIN tbl_sillas ON tbl_mesas.id_mesa = tbl_sillas.id_mesa WHERE tbl_sillas.deshabilitado = 0 GROUP BY tbl_mesas.id_mesa, tbl_salas.ubicacion_sala, tbl_mesas.mesa_ocupada; ";
            $stmt1 = $pdo->prepare($sqlMesa);
            $stmt1 -> execute();
            $res = $stmt1 ->fetchAll();
            echo "</br>";
            foreach ($res as $mesa) {
                $id = $mesa["mesa"];
                $info ="\"".$mesa['sala']."-".$mesa["numero_sillas"]."-".$mesa["disponibilidad"]."\"";
                echo"<script>
                if($info.slice(-1)==1){
                    document.getElementById($id).children[0].children[0].classList.add('mesaOcupada');
                }else{
                    document.getElementById($id).children[0].children[0].classList.remove('mesaOcupada')
                }
                document.getElementById($id).children[0].children[0].src = './img/mesaIcon/mesa'+$info.slice(-3,-2)+'.png';
                document.getElementById($id).children[1].innerText=$info;
                </script>";
            }
        ?>
    </div>
    <?php
        if ($_SESSION["cargo"] == 3) {
            echo'<a href="./listaRecurso.php" class="regBtn2">Administrar</a>';
        }
    ?>
    <a href="./proc/logout.php" class="logout">Reservas</a>
    <a href="./proc/logout.php" class="logout" style="float:right;">Cerrar sesión</a>
    <script src="./js/getInfo.js"></script>

</body>
</html>