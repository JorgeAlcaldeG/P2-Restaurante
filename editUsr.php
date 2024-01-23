<?php
session_start();
if (!isset($_SESSION['id_user']) ) {
    header('Location: ./index.php'); // Redirige a la página de inicio de sesión
    exit();
}
if(!isset($_GET["usr"])){
    header('Location: ./listaRecurso.php'); // Redirige a la página de inicio de sesión
    exit();
}
include("./proc/conexion.php");
$sql = "SELECT * FROM tbl_cargo";
$stmt = $pdo -> prepare($sql);
$stmt -> bindParam(":correo",$email);
$stmt -> execute();
$res = $stmt->fetchAll();

$sql = "SELECT * FROM tbl_camareros WHERE id_user = :usr";
$stmt = $pdo -> prepare($sql);
$stmt -> bindParam(":usr",$_GET["usr"]);
$stmt -> execute();
$resusr = $stmt->fetchAll();

foreach ($resusr as $usr) {
    $idUsr = $usr["id_user"];
    $nom = $usr["nombre"];
    $ape = $usr["apellido"];
    $correo = $usr["correo"];
    $cargo = $usr["cargo"];
    // var_dump($usr);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <title>Editar camarero</title>
</head>
<body>
    <div class="row formContainer" id="userForm">
        <h1 class="text-Center" style="margin-bottom:5%">Editando a <?php echo $nom; ?></h1>
        <?php 
            if(isset($_GET["mailExiste"])){
                echo "<p>El correo indicado ya está en uso</p>";
            }
            ?>
        <form  action="./proc/editUsr_proc.php" method="post" onsubmit="return validarForm()">
            <input type="hidden" name="usr" value="<?php echo $idUsr; ?>">
            <label for="cargo">Cargo</label>
            <select name="cargo" id="Cargo">
                <option value="0">Elegir cargo</option>
                <?php
                    foreach ($res as $opt) {
                        if($cargo == $opt["id_cargo"]){
                            echo'<option value="'.$opt["id_cargo"].'" selected>'.$opt["nom_cargo"].'</option>';
                        }else{
                            echo'<option value="'.$opt["id_cargo"].'">'.$opt["nom_cargo"].'</option>';
                        }
                    }
                    ?>
            </select>
            <div class="row">
                <div class="col-6">
                    <p id="errorCargo"><?php if(isset($_GET['cargoError'])){echo"Indica un cargo";}?></p>
                    <label for="nom">Nombre</label>
                    <input type="text" name="nom" id="nom" value="<?php echo $nom; ?>">
                    <p id="errorNom"><?php if(isset($_GET['uservacio'])){echo"El campo usuario es obligatorio";}?></p>
                    <label for="ape">Apellido</label>
                    <input type="text" name="ape" id="ape" value="<?php echo $ape; ?>">
                </div>
                <div class="col-6">
                    <p id="errorApe"><?php if(isset($_GET['apevacio'])){echo"El campo apellido es obligatorio";} ?></p>
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="<?php echo $correo; ?>">
                    <p id="errorEmail"><?php if(isset($_GET['emailvacio'])){echo"El campo email es obligatorio";} if(isset($_GET['emailform'])){echo"El formato del mail no es correcto";} ?></p>
                    <label for="pwd">Contraseña</label>
                    <input type="password" name="pwd" id="pwd">
                    <p id="errorPwd"><?php if(isset($_GET['pwdvacio'])){echo"El campo contraseña es obligatorio";} ?></p>
                </div>
            </div>
            <a class="regBtn" href="./listaRecurso.php">Volver</a>
            <input class="regBtn2" style="float:right" type="submit" value="Enviar">
            </form>
            <?php
                if(isset($_GET['userExist'])){echo"El email ingresado ya existe";}
            ?>
    </div>
    <!-- <script src="./js/valModCamarero.js"></script> -->
</body>
</html>