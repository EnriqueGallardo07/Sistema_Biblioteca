<?php
$host = 'localhost';
$dbname = 'biblioteca';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "¡Conexión exitosa a la base de datos! 🎉"; // Mensaje de éxito
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage()); // Mensaje de error
}
?>