<?php
// Inicia el script
echo "Inicio del script.";

// Asegúrate de incluir el archivo de conexión correctamente
include('conexion.php');
echo "Conexión incluida correctamente.";

// Prueba con una consulta simple para verificar que todo está funcionando
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "Datos recibidos del formulario.";
} else {
    echo "No se recibió un método POST.";
}
?>
