<?php
require_once 'conexion.php';

// Función para convertir DD/MM/YYYY → YYYY-MM-DD
function convertirFecha($fecha) {
    $partes = explode('/', $fecha);
    if (count($partes) !== 3) {
        return null; // o lanza un error si prefieres
    }
    return $partes[2] . '-' . $partes[1] . '-' . $partes[0];
}



// Validar que las fechas vengan correctamente
if (!isset($_POST['fecha_prestamo']) || empty($_POST['fecha_prestamo']) ||
    !isset($_POST['fecha_devolucion']) || empty($_POST['fecha_devolucion'])) {
    die("⚠️ Error: Las fechas no fueron enviadas correctamente.");
}

// Obtener datos del formulario
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$isbn = $_POST['isbn'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$fecha_prestamo = convertirFecha($_POST['fecha_prestamo']);
$fecha_devolucion = convertirFecha($_POST['fecha_devolucion']);



// Buscar ID del libro por ISBN
$stmtLibro = $pdo->prepare("SELECT id_libro FROM libros WHERE isbn = ? AND disponible = 1");
$stmtLibro->execute([$isbn]);
$id_libro = $stmtLibro->fetchColumn();

if (!$id_libro) {
    die("El libro no está disponible o no existe.");
}

// Buscar o registrar usuario por correo
$stmtUsuario = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE correo = ?");
$stmtUsuario->execute([$correo]);
$id_usuario = $stmtUsuario->fetchColumn();

if (!$id_usuario) {
    $stmtInsert = $pdo->prepare("INSERT INTO usuarios (nombre_usuario, correo, telefono, rol) VALUES (?, ?, ?, 'usuario')");
    $stmtInsert->execute([$nombre, $correo, $telefono]);
    $id_usuario = $pdo->lastInsertId();
}

// Convertir fecha de devolución (enviada desde el JS)
$fecha_devolucion = convertirFecha($_POST['fecha_devolucion']);


try {
    // Insertar préstamo
    $sql = "INSERT INTO prestamos (id_usuario, id_libro, fecha_prestamo, fecha_devolucion)
            VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_usuario, $id_libro, $fecha_prestamo, $fecha_devolucion]);

    // Marcar el libro como no disponible
    $stmt_update = $pdo->prepare("UPDATE libros SET disponible = 0 WHERE id_libro = ?");
    $stmt_update->execute([$id_libro]);

    echo "📚 Préstamo registrado con éxito. Fecha de devolución: " . date('d/m/Y', strtotime($fecha_devolucion));
} catch (PDOException $e) {
    echo "Error al registrar el préstamo: " . $e->getMessage();
}
?>
