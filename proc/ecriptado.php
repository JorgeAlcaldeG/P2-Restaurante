<?php
    session_start(); // Iniciamos la sesión.

    // Si se ha enviado un valor para 'user', lo almacenamos en una variable de sesión llamada 'user'
    if (isset($_POST['nombre'])) 
    {
        $_SESSION['nombre'] = $_POST['nombre'];
    }

    // Si se ha enviado un valor para 'pass', lo almacenamos en una variable de sesión llamada 'pass'
    if (isset($_POST['pwd'])) 
    {
        $pass2 = $_POST['pass'];
        $pass = hash("sha256", $pass2);
        $_SESSION['pwd'] = $pass;
    }

    // Redirige al usuario a la página 'check.php'
    header("Location: check.php");
    exit();