<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php'); // Redirige a la página de inicio de sesión
    exit();
}
include("./conexion.php");

// var_dump($_POST);
$nom = trim(mysqli_real_escape_string($conn, $_POST["nom"]));
$ape = trim(mysqli_real_escape_string($conn, $_POST["ape"]));
$email = trim(mysqli_real_escape_string($conn, $_POST["email"]));
$pwd=trim(mysqli_real_escape_string($conn, $_POST["pwd"]));
$error="";
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
    $pwd = password_hash(mysqli_real_escape_string($conn, $pwd), PASSWORD_BCRYPT);
}
echo $pwd;
if ($error!=""){
    $datosRecibidos = array(
        'nom' => $nom,
        'ape' =>$ape,
        'email' => $email,
    );
    $datosDevueltos=http_build_query($datosRecibidos);
    header("Location: ../addCamarero.php". $error. "&". $datosDevueltos);
    exit();
}else{
    try {
        $sqlChk="SELECT nombre FROM tbl_camareros WHERE correo = ?";
        $stmt1 = mysqli_prepare($conn, $sqlChk);
        mysqli_stmt_bind_param($stmt1, "s", $email);
        mysqli_stmt_execute($stmt1);
        $res = mysqli_stmt_get_result($stmt1);
        echo mysqli_num_rows($res);
        if(mysqli_num_rows($res)>=1){
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
            $stmt2= mysqli_stmt_init($conn);
            $sqlInsert=  "INSERT INTO tbl_camareros (`id_user`, `nombre`, `apellido`, `correo`, `contrasena`) VALUES (NULL, ?,?,?,?);";
            mysqli_stmt_prepare($stmt2,$sqlInsert);
            mysqli_stmt_bind_param($stmt2,"ssss",$nom,$ape,$email,$pwd);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_close($stmt1);
            mysqli_stmt_close($stmt2);
            echo "Usuario creadado correctamente";
            header('Location: '.'../listaCamareros.php');
        }
    }catch (Exception $e) {
        echo "Error: ".$e->getMessage();
    }


}


echo $error;
