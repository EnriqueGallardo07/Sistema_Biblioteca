<?php
require_once 'conexion.php';

// Obtener los datos del formulario
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$isbn = $_POST['isbn'];
$categoria = $_POST['categoria'] ?? null; // Puede ir NULL si no se llena
$disponible = 1; // Por defecto todos se registran como disponibles

try {
    $sql = "INSERT INTO libros (titulo, autor, isbn, categoria, disponible) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titulo, $autor, $isbn, $categoria, $disponible]);

    // Puedes redirigir o mostrar un mensaje
    header("Location: ../pantallas/registro_libro.html?exito=1");
    exit();
} catch (PDOException $e) {
    echo "Error al registrar libro: " . $e->getMessage();
}
