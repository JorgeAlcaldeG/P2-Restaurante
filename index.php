<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body id="login">
    <div id="form-container">
        <h1>Bienvenido</h1><br>
        <form action="./proc/comprobacion_user.php" method="post" onsubmit="return submitFrom()">
            <!-- Email -->
            <?php if (isset($_GET['correoVacio'])) {echo "<div class='error-message'>Email vacío. Has de introducir un email válido.</div>"; } ?>
            <?php if (isset($_GET['mailMal'])) {echo "<div class='error-message'>Email incorrecto. Has de introducir un email con un formato válido.</div>"; } ?>
            <label for="correo" class="labelInput">Email</label>
            <br>
            <input type="text" class="loginInput" name="correo" id="correo"placeholder="Inserta tu email aqui" value="<?php if(isset($_GET["correo"])) {echo $_GET["correo"];} ?>">
            <br>
            <span id="email_error" class="error" style="font-weight: bolder;"></span>
            <br>
            <!-- Contraseña -->
            <?php if (isset($_GET['contrasenaVacio'])) {echo "<div class='error-message'>Contraseña vacía. Has de introducir una contraseña válida.</div>"; } ?>
            <label for="contrasena">Contraseña</label>
            <br>
            <input type="password" placeholder="Contraseña" class="loginInput" name="contrasena" id="contrasena" value="<?php if(isset($_GET["contrasena"])) {echo $_GET["contrasena"];} ?>">
            <br>
            <span id="pass_error" class="error" style="font-weight: bolder;"></span>

            <br/><br>

            <input type="submit" name="enviar" id="loginBtn" value="Enviar" style="width: 100%;">
            <?php if (isset($_GET['loginError'])) 
            {echo "<div class='error-message'>
                <script>
                    Swal.fire({
                    icon: 'error',
                    title: 'Login incorrecto',
                    text: 'Revisa tus credenciales e intentalo de nuevo!',
                  })</script>
                </div>"; 
            
            } ?>
    </div>
    <script src="./js/validacion_login.js"></script>
</body>
</html>
