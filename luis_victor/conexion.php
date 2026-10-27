<?php
// Datos de XAMPP por defecto
$conexion = new mysqli("localhost", "root", "", "luis_victor");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8mb4");
