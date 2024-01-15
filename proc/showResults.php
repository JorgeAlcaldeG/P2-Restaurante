<?php
    // var_dump($_POST);
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
        echo"<h1>Empleados</h1>
        <button><a href='./addCamarero.php'>Crear usuario</></button>";
        if($stmt->rowCount() !=0){
            echo"<table>
            <tr>
            <th>Correo</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Cargo</th>
            <th>Acciones</th>
            </tr>";
            foreach ($res as $emp) {
                echo"<tr>
                <td>".$emp["correo"]."</td>
                <td>".$emp["nombre"]."</td>
                <td>".$emp["apellido"]."</td>
                <td>".$emp["Nomcargo"]."</td>
                <td>Eliminar-Modificar</td>";
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
    echo"<table>
            <tr>
            <th>Sala</th>
            <th>Número de mesa</th>
            <th>Estado</th>
            <th>Acciones</th>
            </tr>";
    foreach ($res as $mesa) {
        // var_dump($mesa);
        echo"<tr>
            <td>".$mesa["nomUbi"]."</td>
            <td>".$mesa["numero_mesa"]."</td>";
            if($mesa["mesa_ocupada"] == 0){
                echo"<td>Libre</td>";
            }else{
                echo"<td>Ocupada</td>";
            }
            echo"<td>Modificar</td>";
    }
    echo"</table>";
    }
?>