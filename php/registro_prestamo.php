<?php
// Incluir el archivo de conexión
include('conexion.php');

// Obtener los datos del formulario
$id_usuario = $_POST['id_usuario']; // ID del usuario
$id_libro = $_POST['id_libro']; // ID del libro
$fecha_prestamo = $_POST['fecha_prestamo']; // Fecha de préstamo (en formato YYYY-MM-DD)

// Calcular la fecha de devolución sumando 3 días hábiles
$fecha_devolucion = date('Y-m-d', strtotime($fecha_prestamo . ' + 3 weekdays'));

// Insertar el préstamo en la base de datos
try {
    $sql = "INSERT INTO prestamos (id_usuario, id_libro, fecha_prestamo, fecha_devolucion) 
            VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_usuario, $id_libro, $fecha_prestamo, $fecha_devolucion]);

    // Marcar el libro como no disponible
    $sql_update = "UPDATE libros SET disponible = 0 WHERE id_libro = ?";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([$id_libro]);

    echo "Préstamo registrado con éxito. Fecha de devolución: " . $fecha_devolucion;
} catch (PDOException $e) {
    echo "Error al registrar préstamo: " . $e->getMessage();
}
?>
