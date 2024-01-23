<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Creado usuario</title>
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['id_user'])) {
        header('Location: ./index.php'); // Redirige a la página de inicio de sesión
        exit();
    }
    include("./conexion.php");

    $nom = $_POST["nom"];
    $ape = $_POST["ape"];
    $email = $_POST["email"];
    $pwd=$_POST["pwd"];
    $cargo=$_POST["cargo"];
    $error="";

    if($cargo >=6 || $cargo <=0){
        if($error==""){
            $error .="?cargoError=true";
        } else {
            $error .="&cargoError=true";        
        }
    }
    if(empty($nom)){
        if($error==""){
            $error .="?uservacio=true";
        } else {
            $error .="&uservacio=true";        
        }
    }
    if(empty($ape)){
        if($error==""){
            $error .="?apevacio=true";
        } else {
            $error .="&apevacio=true";        
        }
    }
    if(empty($email)){
        if($error==""){
            $error .="?emailvacio=true";
        } else {
            $error .="&emailvacio=true";        
        } 
    }else{
        if(!filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)){
            if($error==""){
                $error .="?emailform=true";
            } else {
                $error .="&emailform=true";        
            } 
        }
    }
    if(empty($pwd)){
        if($error==""){
            $error .="?pwdvacio=true";
        } else {
            $error .="&pwdvacio=true";        
        }
    }else{
        $pwd = password_hash($pwd, PASSWORD_BCRYPT);
    }
    if ($error!=""){
        $datosRecibidos = array(
            'nom' => $nom,
            'ape' =>$ape,
            'email' => $email,
            'cargo' => $cargo,
        );
        $datosDevueltos=http_build_query($datosRecibidos);
        header("Location: ../addCamarero.php". $error. "&". $datosDevueltos);
        exit();
    }else{
        try {
            $sqlChk="SELECT nombre FROM tbl_camareros WHERE correo = :correo";
            $stmt1 = $pdo -> prepare($sqlChk);
            $stmt1 -> bindParam(":correo",$email);
            $stmt1 -> execute();
            $res = $stmt1->fetchAll();
            if($stmt1->rowCount()>=1){
                echo"El usuario existe";
                $datosRecibidos = array(
                    'nom' => $nom,
                    'ape' =>$ape,
                    'email' => $email,
                );
                $datosDevueltos=http_build_query($datosRecibidos);
                header("Location: ../addCamarero.php?userExist=true&". $datosDevueltos);
                exit();
            }else{
                // $stmt2= mysqli_stmt_init($conn);
                $sqlInsert=  "INSERT INTO tbl_camareros (`id_user`, `nombre`, `apellido`, `correo`, `contrasena`,`cargo`) VALUES (NULL, :nom,:ape,:correo,:pwd,:cargo);";
                $stmt2=$pdo -> prepare($sqlInsert);
                $stmt2 -> bindParam(":nom",$nom);
                $stmt2 -> bindParam(":ape",$ape);
                $stmt2 -> bindParam(":correo",$email);
                $stmt2 -> bindParam(":cargo",$cargo);
                $stmt2 -> bindParam(":pwd",$pwd);
                // mysqli_stmt_bind_param($stmt2,"ssss",$nom,$ape,$email,$pwd);
                $stmt2 -> execute();
                // $stmt1->close();
                // $stmt2->close();
                echo'<script>Swal.fire({
                    icon: "success",
                    title: "Usuario creado correctamente",
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    location.href ="../listaRecurso.php";
                });</script>';
            }
        }catch (Exception $e) {
            echo "Error: ".$e->getMessage();
        }


    } ?>
    
</body>
</html>