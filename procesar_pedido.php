<?php
// ==========================================
// Procesa el formulario de pedido y lo guarda
// en la tabla "pedidos" de cronometro_db
// ==========================================

require_once "conexion.php";

// Solo procesar si la petición es POST (envío del formulario)
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recoger y limpiar los datos enviados desde el formulario
    $modelo       = $conexion->real_escape_string($_POST['modelo']);
    $nombre       = $conexion->real_escape_string($_POST['nombre']);
    $email        = $conexion->real_escape_string($_POST['email']);
    $telefono     = $conexion->real_escape_string($_POST['telefono']);
    $direccion    = $conexion->real_escape_string($_POST['direccion']);
    $ciudad       = $conexion->real_escape_string($_POST['ciudad']);
    $departamento = $conexion->real_escape_string($_POST['departamento']);
    $codigo_postal = $conexion->real_escape_string($_POST['codigo_postal']);

    // Validación básica de campos obligatorios
    if (empty($modelo) || empty($nombre) || empty($email) || empty($telefono)
        || empty($direccion) || empty($ciudad) || empty($departamento) || empty($codigo_postal)) {

        echo "<script>alert('Por favor completa todos los campos.'); window.history.back();</script>";
        exit;
    }

    // Validar formato de correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Correo electrónico no válido.'); window.history.back();</script>";
        exit;
    }

    // Preparar la consulta usando sentencias preparadas (más seguro contra inyección SQL)
    $sql = "INSERT INTO pedidos (modelo, nombre, email, telefono, direccion, ciudad, departamento, codigo_postal)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        die("Error al preparar la consulta: " . $conexion->error);
    }

    // Vincular los parámetros ("s" = string, hay 8 campos tipo texto)
    $stmt->bind_param(
        "ssssssss",
        $modelo,
        $nombre,
        $email,
        $telefono,
        $direccion,
        $ciudad,
        $departamento,
        $codigo_postal
    );

    // Ejecutar la inserción
    if ($stmt->execute()) {
        // Redirigir a una página de confirmación (puedes crear pedido_confirmado.html)
        echo "<script>alert('¡Pedido confirmado con éxito! Gracias por tu compra.'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Ocurrió un error al guardar el pedido. Intenta de nuevo.'); window.history.back();</script>";
    }

    $stmt->close();
    $conexion->close();

} else {
    // Si alguien intenta acceder al archivo directamente sin enviar el formulario
    header("Location: index.html");
    exit;
}
?>
