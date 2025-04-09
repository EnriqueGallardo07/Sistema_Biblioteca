<?php
$host = 'localhost'; // Servidor de base de datos
$dbname = 'biblioteca'; // Nombre de la base de datos
$username = 'root'; // Usuario de MySQL
$password = ''; // Contraseña (por defecto en XAMPP es vacía)

// Crear la conexión
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
