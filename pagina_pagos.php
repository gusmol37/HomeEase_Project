<?php
// Incluir la conexión a la base de datos
include('conexion.php');

// Inicializar variables
$mensaje = "";
$transacciones = [];

// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = isset($_POST['usuario_id']) ? intval($_POST['usuario_id']) : null;

    if ($usuario_id) {
        // Consulta para obtener las transacciones pendientes de pago del usuario
        $sql = "SELECT t.id, s.nombre AS servicio, t.estado, t.fecha_contratacion, t.fecha_pago 
                FROM transacciones t
                JOIN servicios s ON t.id_servicio = s.id
                WHERE t.id_usuario = ? AND t.estado = 'pendiente'";

        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param("i", $usuario_id);

            if ($stmt->execute()) {
                $resultado = $stmt->get_result();
                if ($resultado->num_rows > 0) {
                    while ($transaccion = $resultado->fetch_assoc()) {
                        $transacciones[] = $transaccion;
                    }
                } else {
                    $mensaje = "No tienes transacciones pendientes de pago.";
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
    <title>Página de Pagos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Transacciones Pendientes de Pago</h2>
        <div class="mt-4">
            <?php
            if ($mensaje) {
                echo "<p>$mensaje</p>";
            } else {
                if (count($transacciones) > 0) {
                    echo "<table class='table table-bordered'>";
                    echo "<thead><tr><th>ID Transacción</th><th>Servicio</th><th>Estado</th><th>Fecha de Contratación</th><th>Fecha de Pago</th><th>Acción</th></tr></thead>";
                    echo "<tbody>";
                    foreach ($transacciones as $transaccion) {
                        echo "<tr>
                                <td>{$transaccion['id']}</td>
                                <td>{$transaccion['servicio']}</td>
                                <td>{$transaccion['estado']}</td>
                                <td>{$transaccion['fecha_contratacion']}</td>
                                <td>" . ($transaccion['fecha_pago'] ? $transaccion['fecha_pago'] : 'Pendiente') . "</td>
                                <td><a href='procesar_pago.php?id={$transaccion['id']}' class='btn btn-success'>Pagar</a></td>
                              </tr>";
                    }
                    echo "</tbody></table>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
