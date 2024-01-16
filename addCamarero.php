<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php'); // Redirige a la página de inicio de sesión
    exit();
}
include("./proc/conexion.php");
$sql = "SELECT * FROM tbl_cargo";
$stmt = $pdo -> prepare($sql);
$stmt -> bindParam(":correo",$email);
$stmt -> execute();
$res = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir camarero</title>
</head>
<body>
    <h1>Crear usuario</h1>
    <form action="./proc/camarero_proc.php" method="post" onsubmit="return validarForm()">
        <label for="cargo">Cargo</label>
        <select name="cargo" id="Cargo">
            <option value="0">Elegir cargo</option>
            <?php
                foreach ($res as $opt) {
                    if(isset($_GET["cargo"]) && $_GET["cargo"] == $opt["id_cargo"]){
                        echo'<option value="'.$opt["id_cargo"].'" selected>'.$opt["nom_cargo"].'</option>';
                    }else{
                        echo'<option value="'.$opt["id_cargo"].'">'.$opt["nom_cargo"].'</option>';
                    }
                }
            ?>
        </select>
        <p id="errorCargo"><?php if(isset($_GET['cargoError'])){echo"Indica un cargo";}?></p>
        <label for="nom">Nombre</label>
        <input type="text" name="nom" id="nom" value="<?php if(isset($_GET['nom'])){echo $_GET['nom'];} ?>">
        <p id="errorNom"><?php if(isset($_GET['uservacio'])){echo"El campo usuario es obligatorio";}?></p>
        <label for="ape">Apellido</label>
        <input type="text" name="ape" id="ape" value="<?php if(isset($_GET['ape'])){echo $_GET['ape'];} ?>">
        <p id="errorApe"><?php if(isset($_GET['apevacio'])){echo"El campo apellido es obligatorio";} ?></p>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>">
        <p id="errorEmail"><?php if(isset($_GET['emailvacio'])){echo"El campo email es obligatorio";} if(isset($_GET['emailform'])){echo"El formato del mail no es correcto";} ?></p>
        <label for="pwd">Contraseña</label>
        <input type="password" name="pwd" id="pwd">
        <p id="errorPwd"><?php if(isset($_GET['pwdvacio'])){echo"El campo contraseña es obligatorio";} ?></p>
        <input type="submit" value="Enviar">
    </form>
    <?php
        if(isset($_GET['userExist'])){echo"El email ingresado ya existe";}
    ?>
    <button><a href="./listaRecurso.php">Volver</a></button>
    <script src="./js/valAddCamarero.js"></script>
</body>
</html>