<?php
header("Access-Control-Allow-Origin: *"); // Solo para desarrollo
require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar campos obligatorios
    if (empty($_POST['nombre_usuario']) || empty($_POST['correo']) || empty($_POST['contrasena'])) {
        die("Error: Faltan campos obligatorios (nombre, correo o contraseña)");
    }

    // Procesar datos
    $nombre = trim($_POST['nombre_usuario']);
    $correo = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);
    $telefono = $_POST['telefono'] ?? null; // Opcional
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);

    if (!$correo) {
        die("Error: Correo no válido");
    }

    // Insertar en BD
    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre_usuario, correo, telefono, contrasena) 
                              VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $correo, $telefono, $contrasena]);
        
        echo "¡Usuario registrado! Redirigiendo...";
        // Opcional: Redirigir después de 2 segundos
        header("Refresh: 2; url=http://localhost/Biblioteca/pantallas/inicio.html");
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            die("Error: El correo ya está registrado");
        } else {
            die("Error al registrar: " . $e->getMessage());
        }
    }
} else {
    die("Error: Método no permitido");
}
?>