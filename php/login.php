<?php
// Mostrar errores (solo en desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Encabezados
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Iniciar sesión
session_start();

// Conexión a base de datos
require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario']); // Puede ser correo o nombre_usuario
    $contrasena = $_POST['contrasena'];

    try {
        // Buscar usuario por correo o nombre_usuario
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ? OR nombre_usuario = ?");
        $stmt->execute([$usuario, $usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($contrasena, $user['contrasena'])) {
            // Guardar datos en sesión
            $_SESSION['user_id'] = $user['id_usuario'];
            $_SESSION['user_name'] = $user['nombre_usuario'];
            $_SESSION['user_role'] = $user['rol'];

            // Redirigir según el rol
            if ($user['rol'] === 'admin') {
                header("Location: ../pantallas/indexAdmin.html");
            } else {
                header("Location: ../pantallas/index.html");
            }
            exit();
        } else {
            // Credenciales incorrectas
            header("Location: ../pantallas/inicio.html?error=credenciales");
            exit();
        }
    } catch (PDOException $e) {
        die("Error en la base de datos: " . $e->getMessage());
    }
} else {
    // Si se accede por GET, redirigir al login
    header("Location: ../pantallas/inicio.html");
    exit();
}
