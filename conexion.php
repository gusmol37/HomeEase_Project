<?php
$host = 'localhost';
$usuario = 'root';
$password = '';    
$base_datos = 'servicios_hogar';

$conn = new mysqli($host, $usuario, $password, $base_datos);

// Verifica la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>