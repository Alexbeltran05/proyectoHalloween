<?php
require 'funciones.php';

$usuario = $_POST['usuario'] ?? '';
$clave   = $_POST['clave'] ?? '';

if (iniciarSesion($usuario, $clave)) {
    header("Location: Inicio.php");
    exit();
} else {
    header("Location: index.php?error=1");
    exit();
}
?>