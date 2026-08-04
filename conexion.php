<?php
// ==========================================
// Archivo de conexión a la base de datos
// CRONÓMETRO - cronometro_db
// ==========================================

$servidor = "localhost";
$usuario  = "root";      // usuario por defecto de XAMPP
$password = "";          // por defecto XAMPP no tiene contraseña
$base_datos = "cronometro_db";

// Crear la conexión
$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

// Verificar si hubo error de conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Establecer el juego de caracteres para evitar problemas con tildes y ñ
$conexion->set_charset("utf8mb4");
?>
