<?php
// Incluir la conexión a la base de datos
include('conexion.php');

// Inicializamos la variable para mostrar los resultados
$mensaje = "";

// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = isset($_POST['usuario_id']) ? intval($_POST['usuario_id']) : null;

    if ($usuario_id) {
        // Consulta para obtener el historial de transacciones del usuario
        $sql = "SELECT t.id, s.nombre AS servicio, t.estado, t.fecha_contratacion, t.fecha_pago 
                FROM transacciones t
                JOIN servicios s ON t.id_servicio = s.id
                WHERE t.id_usuario = ?";
        
        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param("i", $usuario_id);

            if ($stmt->execute()) {
                $resultado = $stmt->get_result();
                if ($resultado->num_rows > 0) {
                    $mensaje = "<h2>Historial de Transacciones</h2>";
                    $mensaje .= "<table class='table table-bordered mt-4'>";
                    $mensaje .= "<thead><tr><th>ID Transacción</th><th>Servicio</th><th>Estado</th><th>Fecha de Contratación</th><th>Fecha de Pago</th></tr></thead>";
                    $mensaje .= "<tbody>";

                    while ($transaccion = $resultado->fetch_assoc()) {
                        $mensaje .= "<tr>
                                        <td>" . $transaccion['id'] . "</td>
                                        <td>" . $transaccion['servicio'] . "</td>
                                        <td>" . $transaccion['estado'] . "</td>
                                        <td>" . $transaccion['fecha_contratacion'] . "</td>
                                        <td>" . ($transaccion['fecha_pago'] ? $transaccion['fecha_pago'] : 'Pendiente') . "</td>
                                      </tr>";
                    }
                    $mensaje .= "</tbody></table>";
                } else {
                    $mensaje = "No se encontraron transacciones para el usuario con ID: " . $usuario_id;
                }
            } else {
                $mensaje = "Error al ejecutar la consulta: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $mensaje = "Error al preparar la consulta: " . $conexion->error;
        }
    } else {
        $mensaje = "Por favor, ingresa un ID de Usuario válido.";
    }
} else {
    $mensaje = "Solicitud no válida.";
}

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Historial de Transacciones</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Historial de Transacciones</h2>
        <div class="mt-4">
            <?php echo $mensaje; ?>
        </div>
    </div>
</body>
</html>
