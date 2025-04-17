<?php
require_once 'conexion.php';

$nombre_usuario = "admin";
$correo = "admin@gmail.com";
$contrasena = password_hash("admin", PASSWORD_DEFAULT); // Encriptar la contraseña
$rol = "admin";

try {
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre_usuario, correo, contrasena, rol) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre_usuario, $correo, $contrasena, $rol]);
    echo "Usuario admin creado con éxito.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
    