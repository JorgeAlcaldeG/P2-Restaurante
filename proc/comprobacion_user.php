<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciando sesión</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
session_start(); // Inicia la sesión

if (!filter_has_var(INPUT_POST, 'enviar')) {
    header('Location: ./index.php');
    exit();
}
// Conexión a la base de datos (asegúrate de tener una conexión configurada en conexion.php)
include_once("./conexion.php");

$correo = isset($_POST['correo']) ? $_POST['correo'] : "";
$correo = trim($correo);
$contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : "";
$contrasena = trim($contrasena);
// $contrasenaIntroducida =hash("sha256", $contrasena);
$contrasenaIntroducida = password_hash($contrasena, PASSWORD_BCRYPT);
// echo $contrasenaIntroducida;
// die();


// Validación de campos
if (empty($correo)) {
    header("Location: ../index.php?correoVacio=true");
    exit();
}else{
    if(!filter_input(INPUT_POST, "correo", FILTER_VALIDATE_EMAIL)){
        header("Location: ../index.php?mailMal=true");
        exit();
    }
}

if (empty($contrasena)) {
    header("Location: ../index.php?contrasenaVacio=true");
    exit();
}


try {
    // Consulta SQL para verificar el correo
    $sql = "SELECT correo, contrasena, id_user, cargo FROM tbl_camareros WHERE correo = :correo LIMIT 1";
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare($sql);
    $stmt -> bindParam(':correo',$correo);
    $stmt -> execute();
    $res = $stmt -> fetchAll();
    foreach ($res as $usuario) {
        $contrasenaAlmacenada = $usuario["contrasena"];
        $correoAlmacenado = $usuario["correo"];
        $id_user = $usuario["id_user"];
    }
    if ($correo == $correoAlmacenado && password_verify($contrasena, $contrasenaAlmacenada)) {
        if($usuario["cargo"]==5){
            echo'<script>Swal.fire({
                title: "Este usuario ha sido deshabilitado",
                text: "Si crees que podría tratarse de un error contacte con un administración",
                icon: "error",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Cerrar"
              }).then((result) => {
                location.href="../index.php"
              })</script>';
        }else{
            $_SESSION['correo'] = $correo;
            $_SESSION['id_user'] = $id_user;
            $_SESSION['cargo'] = $usuario["cargo"];
            if($usuario["cargo"]==1){
                header("Location: ../home.php");
                exit();
            }
            if($usuario["cargo"]==2){
                header("Location: ../listaRecurso.php");
                exit();
            }
            header("Location: ../intermedio.php");
            exit();
        }
    } else {
        // Las credenciales no son válidas
        header("Location: ../index.php?loginError=true");
        exit();
    }
} catch (Exception $e) {
    echo "Error: ".$e->getMessage();
}
?>
    
</body>
</html>
