<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Modificando usuario</title>
</head>
<body> 
    <?php
    session_start();
    if (!isset($_SESSION['id_user'])) {
        header('Location: ./index.php'); // Redirige a la página de inicio de sesión
        exit();
    }
    include("./conexion.php");

    // var_dump($_POST);
    $usr = $_POST["usr"];
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
    if(!empty($pwd)){
        $pwd = password_hash($pwd, PASSWORD_BCRYPT);
    }
    if ($error!=""){
        $datosRecibidos = array(
            'usr' => $usr,
            'nom' => $nom,
            'ape' =>$ape,
            'email' => $email,
            'cargo' => $cargo,
        );
        $datosDevueltos=http_build_query($datosRecibidos);
        header("Location: ../editUsr.php". $error. "&". $datosDevueltos);
        exit();
    }else{
        try {
            $sqlNomNuevo = "SELECT correo FROM tbl_camareros WHERE id_user = :id LIMIT 1";
            $query = $pdo ->prepare($sqlNomNuevo);
            $query -> bindParam(":id", $usr);
            $query -> execute();
            $mailOriginal = $query->fetchColumn();
            $sql = "UPDATE `tbl_camareros` SET `nombre`= :nom ,apellido = :ape ,";

            if($mailOriginal != $email){
                // Comprobar si el mail nuevo está disponible
                $sqlNomNuevo = "SELECT correo FROM tbl_camareros WHERE correo = :mail LIMIT 1";
                $query = $pdo ->prepare($sqlNomNuevo);
                $query -> bindParam(":mail", $email);
                $query -> execute();
                if($query->rowCount()==1){
                    $error = "?mailExiste=true";
                    $datosRecibidos = array(
                        'usr' => $usr,
                        'nom' => $nom,
                        'ape' =>$ape,
                        'email' => $email,
                        'cargo' => $cargo,
                    );
                    $datosDevueltos=http_build_query($datosRecibidos);
                    header("Location: ../editUsr.php". $error. "&". $datosDevueltos);
                    exit();
                }else{
                    $sql .='correo= :mail,';
                }

            }
            if($pwd !=""){
                $sql .='contrasena= :pwd,';
                
            }
            $sql .= "`cargo` = :cargo WHERE `tbl_camareros`.`id_user` =:id";
            // echo $sql;
            $update =$pdo->prepare($sql);
            $update -> bindParam(":nom",$nom);
            $update -> bindParam(":ape",$ape);
            $update -> bindParam(":cargo",$cargo);
            $update -> bindParam(":id",$usr);

            if($mailOriginal != $email){
                $update -> bindParam(":mail",$email);

            }
            if($pwd !=""){
                $update -> bindParam(":pwd",$pwd);
            }
            $update -> execute();?>
            <script>Swal.fire({
                icon: "success",
                title: "Usuario modificado correctamente",
                showConfirmButton: false,
                timer: 1500
              }).then((result) => {
                location.href ="../listaRecurso.php";
              });</script>'
            <?php
        }catch (Exception $e) {
            echo "Error: ".$e->getMessage();
        }
    } ?>