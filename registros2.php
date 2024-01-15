<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Registros</title>
</head>
<body id="registro">
<a id="csv"><img id="csvIcon" src="./img/csvIcon.png" alt="GenerarCSV"></a>
    <br>
    <button id="cambio"></button>
<?php
    session_start();
    if (!isset($_SESSION['id_user'])) {
        header('Location: ./index.php'); // Redirige a la página de inicio de sesión
        exit();
    }
    include_once("./proc/conexion.php");
    ?>
    
    <select id="tabla">
    <option value="0" selected>Todas</option>
    <?php
    include_once("./proc/conexion.php");
    // Consulta SQL para verificar el correo
    $sql = "SELECT * FROM tbl_salas";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute();
    $res = $stmt -> fetchAll();
    if ($stmt->rowCount() > 0) {
        foreach ($res as $row) {
            echo "<option value=" . $row['id_sala'] . ">" . $row['ubicacion_sala'] . "</option>";
        }
    }
    ?>
    </select>
    <!-- MESAS -->
    <select id="tabla2">
    <option value="0" selected>Todas</option>
    <?php
    include_once("./proc/conexion.php");
    // Consulta SQL para verificar el correo
    $sql = "SELECT * FROM tbl_salas";
    $stmt = $stmt = $pdo -> prepare($sql);
    // mysqli_stmt_bind_param($stmt, "sss", $username, $username, $sesion);
    $stmt -> execute();
    $res = $stmt -> fetchAll();
    if ($stmt->rowCount() > 0) {
        foreach ($res as $row) {
            echo "<option value=" . $row['id_sala'] . ">" . $row['ubicacion_sala'] . "</option>";
        }
    }
    ?>
    </select>
    <div class="tabla">
    <table id="Tabla">
        <thead>
            <tr id="Cabecera">
                <th>Registro</th>
                <th id="recurso"></th>
                <th>Camarero</th>
                <th>Sala</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Tiempo Ocupado</th>
            </tr>
        </thead>
        <tbody id="tbody">

        </tbody>
    </table>
    </div>
    <script>
        tabla.addEventListener("change", mostrarTabla);
        tabla2.addEventListener("change", mostrarTablaM);
        function mostrarTabla() {
            var boton = document.getElementById("cambio");
            boton.innerText = "Mostrar mesas";
            boton.onclick = mostrarTablaM;

            var select = document.getElementById("tabla");
            select.style.visibility = "visible";
            select.style.width = "auto";

            var a = document.getElementById("csv");
            a.href = "./proc/historico_csv.php?sala=" + select.value;
            a.addEventListener("click",()=>{
            Swal.fire({
                // position: "top-end",
                icon: "info",
                title: "El registro se descargará en breve",
                showConfirmButton: false,
                timer: 1500
                });
            });
            var select2 = document.getElementById("tabla2");
            select2.style.visibility = "hidden";
            select2.style.width = "0";

            var recurso = document.getElementById("recurso");
            recurso.innerText = "Silla";

            var div = document.getElementById("tbody");
            div.innerHTML = ""; // Asignar una cadena vacía al innerHTML
            // Obtener los valores seleccionados o ingresados
            var contenido = tabla.value;

            // Realizar la solicitud AJAX
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Actualizar el contenido del div resultado con la respuesta de filtro.php
                    tbody.innerHTML = xhr.responseText;
                }
            };

            // Construir la URL con los parámetros
            var url = "./proc/historico.php";
            
            // Construir los datos a enviar por POST
            var params = "tabla=" + encodeURIComponent(contenido);

            // Realizar la solicitud POST
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(params);
        }


    function mostrarTablaM() {
        var boton = document.getElementById("cambio");
        boton.innerText = "Mostrar sillas";
        boton.onclick = mostrarTabla;

        var select = document.getElementById("tabla");
        select.style.visibility = "hidden";
        select.style.width = "0";

        var select2 = document.getElementById("tabla2");
        select2.style.visibility = "visible";
        select2.style.width = "auto";

        var a = document.getElementById("csv");
        a.href = "./proc/historicoM_csv.php?sala=" + select2.value;
        a.addEventListener("click",()=>{
            Swal.fire({
            // position: "top-end",
            icon: "info",
            title: "El registro se descargará en breve",
            showConfirmButton: false,
            timer: 1500
            });
        });

        var recurso = document.getElementById("recurso");
        recurso.innerText = "Mesa";

        var div = document.getElementById("tbody");
        div.innerHTML = ""; // Asignar una cadena vacía al innerHTML
        // Obtener los valores seleccionados o ingresados
        var contenido = tabla2.value;

        // Realizar la solicitud AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Actualizar el contenido del div resultado con la respuesta de filtro.php
                tbody.innerHTML = xhr.responseText;
            }
        };

        // Construir la URL con los parámetros
        var url = "./proc/historicoM.php";
        
        // Construir los datos a enviar por POST
        var params = "tabla=" + encodeURIComponent(contenido);

        // Realizar la solicitud POST
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(params);
    }
    window.addEventListener("load", mostrarTablaM);
    </script>
    <br>
    <a href="home.php" class="logout">Volver</a>
</body>
</html>