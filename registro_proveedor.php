<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encriptar la contraseña
    $especialidad = $_POST['especialidad'];

    $sql = "INSERT INTO usuarios (nombre, email, contraseña, tipo_usuario, especialidad) VALUES (?, ?, ?, 'proveedor', ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $nombre, $email, $password, $especialidad);

    if ($stmt->execute()) {
        echo "Registro exitoso. ¡Ahora puedes iniciar sesión!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
