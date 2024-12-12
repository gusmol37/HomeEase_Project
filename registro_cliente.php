<?php
// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Comprobar si los datos han sido enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO usuarios (nombre, correo, contraseña, tipo) 
            VALUES ('$nombre', '$correo', '$contraseña', '$cliente')";

    // Ejecutar la consulta
    if (mysqli_query($conn, $sql)) {
        echo "Registro exitoso. ¡Bienvenido!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Cerrar la conexión
    mysqli_close($conn);
}
?>
