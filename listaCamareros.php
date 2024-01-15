<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php'); // Redirige a la página de inicio de sesión
    exit();
}
include("./proc/conexion.php");
var_dump($_POST);
if(isset($_POST["nom"])){
    try {
        $nom = trim(mysqli_real_escape_string($conn, $_POST["nom"]));
        $paramNom = "%{$nom}%";
        $ape = trim(mysqli_real_escape_string($conn, $_POST["ape"]));
        $paramApe="%{$ape}%";
        $sqlBase = "SELECT * FROM `tbl_camareros` ";
        $primerFiltro = false;
        $segundoFiltro = false;
        if($_POST["nom"]=="" && $_POST["ape"]==""){
            $sqlUsr="SELECT * FROM `tbl_camareros`";
            if($_POST["orden"] == "asc"){
                $sqlBase .=" ORDER BY apellido ASC";
            }else{
                $sqlBase .=" ORDER BY apellido DESC";
            }
            echo $sqlBase;
            // die();
            $stmt1 = mysqli_prepare($conn, $sqlUsr);
        }else{
            if($_POST["nom"]!=""){
                $primerFiltro = true;
                $sqlBase .="WHERE nombre LIKE ?";
            }
            if($_POST["ape"] !=""){
                if($primerFiltro == false){
                    $sqlBase .=" WHERE apellido LIKE ?";
                }else{
                    $sqlBase .=" AND apellido LIKE ?";
                }
                $segundoFiltro = true;
            }
            if($_POST["orden"] == "asc"){
                $sqlBase .=" ORDER BY apellido asc";
            }else{
                $sqlBase .=" ORDER BY apellido desc";
            }
            // echo "</br>";
            // echo $sqlBase;
            // echo "</br>";
            // var_dump($_POST);
            // die();
            $stmt1 = mysqli_prepare($conn, $sqlBase);
            if($primerFiltro && $segundoFiltro){
                mysqli_stmt_bind_param($stmt1, "ss", $paramNom,$paramApe);
    
            }elseif($primerFiltro){
                mysqli_stmt_bind_param($stmt1, "s", $paramNom);
            }else{
                mysqli_stmt_bind_param($stmt1, "s",$paramApe);
            }
        }
        mysqli_stmt_execute($stmt1);
        $res = mysqli_stmt_get_result($stmt1);
    } catch (Exception $e) {
        echo "Ha ocurrido un error al hacer la consulta: ".$e->getMessage();
        die();
    }
    
}else{
    try {
        $sqlUsr="SELECT * FROM `tbl_camareros` ORDER BY apellido ASC";
        $stmt1 = mysqli_prepare($conn, $sqlUsr);
        mysqli_stmt_execute($stmt1);
        $res = mysqli_stmt_get_result($stmt1);
        $rows = mysqli_num_rows($res);
    } catch (Exception $e) {
        echo "Ha ocurrido un error al hacer la consulta: ".$e->getMessage();
        die();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <h1>Lista de camareros</h1>
    <a href="./addCamarero.php">Añadir camarero</a>
    <form action="listaCamareros.php" method="post">
        <label for="nom">Nombre</label>
        <input type="text" name="nom" id="nom" value="<?php if(isset($_POST["nom"])){echo $nom;} ?>">
        <label for="ape">Apellido</label>
        <input type="text" name="ape" id="ape" value="<?php if(isset($_POST["ape"])){echo $ape;}?>">
        <select name="orden" id="">
            <option value="asc">ASC</option>
            <option value="desc">DESC</option>
        </select>
        <input type="submit" value="filtro">
    </form>
    <form action="./listaCamareros.php" method="post">
        <input type="submit" value="Ver todos">
    </form>
    <table>
    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>correo</th>
        <th>contraseña</th>
    </tr>
    <?php 
        if(mysqli_num_rows($res)==0){
            echo "no se han encontrado usuarios con estos criterios";
        }else{
            foreach ($res as $camarero) {
                // var_dump($camarero);
                echo"<tr>
                        <th>". $camarero['nombre']."</th>
                        <th>". $camarero['apellido']."</th>
                        <th>".$camarero['correo']."</th>
                        <th>".$camarero['contrasena']."</th>
                    </tr>";
            }
        }
    ?>
    </table>
    <a href="./intermedio.php">Volver</a>
    <a href="./salas.php">Ver salas</a>
</body>
</html>