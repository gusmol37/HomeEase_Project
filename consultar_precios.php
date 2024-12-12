<?php
// Incluir la conexión a la base de datos
include('conexion.php');

// Inicializamos la variable para mostrar los resultados
$mensaje = "";

// Verificar si se recibió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servicio_id = isset($_POST['servicio_id']) ? intval($_POST['servicio_id']) : null;

    if ($servicio_id) {
        // Consulta para obtener el precio del servicio seleccionado
        $sql = "SELECT nombre, precio FROM servicios WHERE id = ?";
        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param("i", $servicio_id);

            if ($stmt->execute()) {
                $resultado = $stmt->get_result();
                if ($resultado->num_rows > 0) {
                    $servicio = $resultado->fetch_assoc();
                    $mensaje = "<h2>Precio del Servicio</h2>";
                    $mensaje .= "<p><strong>Servicio:</strong> " . htmlspecialchars($servicio['nombre']) . "</p>";
                    $mensaje .= "<p><strong>Precio:</strong> $" . number_format($servicio['precio'], 2) . "</p>";
                } else {
                    $mensaje = "No se encontró información para el servicio seleccionado.";
                }
            } else {
                $mensaje = "Error al ejecutar la consulta: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $mensaje = "Error al preparar la consulta: " . $conexion->error;
        }
    } else {
        $mensaje = "Por favor, selecciona un servicio.";
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
    <title>Consultar Precios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Consultar Precios</h2>
        <form action="consultar_precios.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="servicio_id" class="form-label">Selecciona un Servicio</label>
                <select class="form-select" name="servicio_id" id="servicio_id" required>
                    <option value="" selected disabled>Seleccione un servicio</option>
                    <option value="1">Limpieza</option>
                    <option value="2">Mantenimiento</option>
                    <!-- Se pueden agregar más opciones directamente desde la base de datos si se requiere -->
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Consultar</button>
        </form>

        <div class="mt-4">
            <?php echo $mensaje; ?>
        </div>
    </div>
</body>
</html>
