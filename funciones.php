<?php
session_start();

function iniciarSesion($usuario, $clave) {
    // Usuario y clave de ejemplo
    $usuarioCorrecto = "admin";
    $claveCorrecta   = "1234";

    if ($usuario === $usuarioCorrecto && $clave === $claveCorrecta) {
        $_SESSION['usuario'] = $usuario;
        return true;
    }
    return false;
}

function protegerPagina() {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?error=1");
        exit();
    }
}
?>
