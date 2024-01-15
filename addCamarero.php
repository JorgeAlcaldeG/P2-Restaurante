<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php'); // Redirige a la página de inicio de sesión
    exit();
}
// include("./proc/conexion.php");
// var_dump($_GET);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir camarero</title>
</head>
<body>
    <form action="./proc/camarero_proc.php" method="post" onsubmit="return validarForm()">
        <label for="nom">Nombre</label>
        <input type="text" name="nom" id="nom" value="<?php if(isset($_GET['nom'])){echo $_GET['nom'];} ?>">
        <p id="errorNom"></p>
        <label for="ape">Apellido</label>
        <input type="text" name="ape" id="ape" value="<?php if(isset($_GET['ape'])){echo $_GET['ape'];} ?>">
        <p id="errorApe"></p>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>">
        <p id="errorEmail"></p>
        <label for="pwd">Contraseña</label>
        <input type="password" name="pwd" id="pwd">
        <p id="errorPwd"></p>
        <input type="submit" value="Enviar">
    </form>
    <?php
        if(isset($_GET['uservacio'])){echo"<p>El campo usuario es obligatorio</p>";}
        if(isset($_GET['apevacio'])){echo"<p>El campo apellido es obligatorio</p>";}
        if(isset($_GET['emailvacio'])){echo"<p>El campo email es obligatorio</p>";}
        if(isset($_GET['emailform'])){echo"<p>El formato del mail no es correcto</p>";}
        if(isset($_GET['pwdvacio'])){echo"<p>El campo contraseña es obligatorio</p>";}    
        if(isset($_GET['userExist'])){echo"<p>El email ingresado ya existe</p>";}
    ?>
    <button><a href="./listaRecurso.php">Volver</a></button>
    <script src="./js/valAddCamarero.js"></script>
</body>
</html>