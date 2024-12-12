<?php
// Incluir la conexión a la base de datos
include('conexion.php');

// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos del formulario
    $cliente_id = isset($_POST['cliente_id']) ? intval($_POST['cliente_id']) : null;
    $servicio_id = isset($_POST['servicio_id']) ? intval($_POST['servicio_id']) : null;
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : null;
    $detalles = isset($_POST['detalles']) ? $_POST['detalles'] : null;

    // Validar los campos obligatorios
    if ($cliente_id && $servicio_id && $fecha) {
        // Preparar la consulta SQL
        $sql = "INSERT INTO transacciones (id_usuario, id_servicio, estado, fecha_contratacion) 
                VALUES (?, ?, 'pendiente', ?)";

        // Preparar y ejecutar la consulta
        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param("iis", $cliente_id, $servicio_id, $fecha);

            if ($stmt->execute()) {
                echo "Contratación realizada con éxito.";
            } else {
                echo "Error al contratar el servicio: " . $stmt->error;
            }

            // Cerrar el statement
            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conexion->error;
        }
    } else {
        echo "Por favor, complete todos los campos obligatorios.";
    }
} else {
    echo "Solicitud no válida.";
}


?>