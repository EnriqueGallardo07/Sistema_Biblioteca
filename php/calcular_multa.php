<?php
// Incluir el archivo de conexión
include('conexion.php');

// Obtener los datos del préstamo
$id_prestamo = $_POST['id_prestamo'];

// Obtener la fecha de devolución real y la fecha de devolución original
try {
    // Obtener la fecha de devolución real y la original
    $sql = "SELECT fecha_devolucion, fecha_devolucion_real FROM prestamos WHERE id_prestamo = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_prestamo]);
    $prestamo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si el libro no ha sido devuelto, no calcular multa
    if (!$prestamo['fecha_devolucion_real']) {
        echo "El libro aún no ha sido devuelto.";
        exit;
    }

    // Calcular los días de retraso
    $fecha_devolucion_real = new DateTime($prestamo['fecha_devolucion_real']);
    $fecha_devolucion = new DateTime($prestamo['fecha_devolucion']);
    $dias_retraso = $fecha_devolucion->diff($fecha_devolucion_real)->days;

    // Si no hay retraso, no hay multa
    if ($dias_retraso <= 0) {
        echo "El libro fue devuelto a tiempo.";
        exit;
    }

    // Calcular la multa (por ejemplo, $5 por día de retraso)
    $multa = $dias_retraso * 5;

    // Registrar la multa
    $sql_multa = "INSERT INTO multas (id_prestamo, monto, descripcion) 
                  VALUES (?, ?, ?)";
    $stmt_multa = $pdo->prepare($sql_multa);
    $stmt_multa->execute([$id_prestamo, $multa, "Retraso de $dias_retraso días"]);

    // Actualizar la multa en el préstamo
    $sql_update = "UPDATE prestamos SET multa = ? WHERE id_prestamo = ?";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([$multa, $id_prestamo]);

    echo "Multa calculada: $multa USD.";
} catch (PDOException $e) {
    echo "Error al calcular multa: " . $e->getMessage();
}
?>
