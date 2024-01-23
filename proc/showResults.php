<?php
    // var_dump($_POST);
    session_start();
    $cargo = $_SESSION["cargo"];
    include("./conexion.php");
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    if($_POST["tipo"] =="Mesas"){
        $sql="";
        if($_POST["name"] !=""){
            $input1 = $_POST["name"]."%";
            $sql = "SELECT c.*, ca.nom_cargo AS 'Nomcargo' FROM tbl_camareros `c` INNER JOIN tbl_cargo `ca` ON c.cargo = ca.id_cargo WHERE nombre LIKE :nom";
        }
        if($_POST["ape"]!=""){
            $input2 = $_POST["ape"]."%";
            if($sql==""){
                $sql = "SELECT c.*, ca.nom_cargo AS 'Nomcargo' FROM tbl_camareros `c` INNER JOIN tbl_cargo `ca` ON c.cargo = ca.id_cargo WHERE apellido LIKE :ape";
            }else{
                $sql .=" AND apellido LIKE :ape";
            }
        }
        if($sql ==""){
            $sql ="SELECT c.*, ca.nom_cargo AS 'Nomcargo' FROM tbl_camareros `c` INNER JOIN tbl_cargo `ca` ON c.cargo = ca.id_cargo";
        }
        $stmt = $pdo -> prepare($sql);
        if($_POST["name"] !=""){
            $stmt -> bindParam(":nom",$input1);
        }
        if($_POST["ape"]!=""){
            $stmt -> bindParam(":ape",$input2);
        }
        $stmt -> execute();
        $res = $stmt -> fetchAll();
        echo"<h1 style='float:left'>Empleados</h1>";
        if($cargo != 2){
            echo"<a style='margin-top:3%' href='./addCamarero.php' id='btnUsr'><img src='./img/addUser.png' alt=''></a>";
        }
        if($stmt->rowCount() !=0){
            echo"<table id='Tabla'>
            <tr id='Cabecera'>
            <th>Correo</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Cargo</th>
            ";
            if($cargo != 2){
                echo"<th>Acciones</th>";
            }
            echo"</tr>";
            foreach ($res as $emp) {
                echo"<tr>
                <td>".$emp["correo"]."</td>
                <td>".$emp["nombre"]."</td>
                <td>".$emp["apellido"]."</td>
                <td>".$emp["Nomcargo"]."</td>";
                if($cargo != 2){
                    echo"<td><button onclick='removeUsr(".$emp["id_user"].")' class='logout btnS'>Eliminar</button><button class='regBtn2 btnS '><a href='./editusr.php?usr=".$emp["id_user"]."'>Modificar</a></button></td>";
                }
            }
            echo"</table>";
        }else{
            echo "No hay resultados";
        }
    }else{
    $sql ="SELECT m.*, s.ubicacion_sala AS `nomUbi` FROM tbl_mesas `m` INNER JOIN tbl_salas `s` ON m.id_sala =s.id_sala";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute();
    $res = $stmt -> fetchAll();
    echo "<h1>Mesas</h1>";
    echo"<table id='Tabla'>
            <tr id='Cabecera'>
            <th>Número de mesa</th>
            <th>Sala</th>
            <th>Estado</th>
            <th>Acciones</th>
            </tr>";
    foreach ($res as $mesa) {
        // var_dump($mesa);
        echo"<tr>
            <td>".$mesa["numero_mesa"]."</td>
            <td>".$mesa["nomUbi"]."</td>";
            if($mesa["mesa_ocupada"] == 0){
                echo"<td>Libre</td>";
            }else{
                echo"<td>Ocupada</td>";
            }
            $id_mesa = $mesa["numero_mesa"];
            echo"<td><button class='regBtn2 btnS' onclick='modMesa($id_mesa)'><a>Modificar</a></button></td>";
    }
    echo"</table>";
    echo"<div class='modMesa' id='modMesa'>
        <input type='hidden' id='mesaId' value=''>
        <a style='float:right; margin-right: 2%; color:black' onclick='cerrarMesa()'><strong>X</strong></a>
        <h1 class='text-Center'>Modificar mesa<h2>
        <p id='mod_nomMesa' class='mesaModForm'>Mesa numero </p>
        <p id='mod_estado'class='mesaModForm'>Estado: </p>
        </br>
        <p class='mesaModForm'>Numero de sillas</p>
        <div id='modContainer'>
            <button onclick='modMesaProc(1)'>+</button>
            <p class='mesaModForm' id='mod_num'></p>
            <button onclick='modMesaProc(-1)'>-</button>
        </div>
        <img src='' id='mod_img'>
    </div>";
    }
?>