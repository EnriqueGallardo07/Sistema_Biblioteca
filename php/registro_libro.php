<?php
// Incluir el archivo de conexión
include('conexion.php');

// Obtener los datos del formulario
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$isbn = $_POST['isbn'];
$categoria = $_POST['categoria'];

// Insertar los datos del libro en la base de datos
try {
    $sql = "INSERT INTO libros (titulo, autor, isbn, categoria) 
            VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titulo, $autor, $isbn, $categoria]);

    echo "Libro registrado con éxito.";
} catch (PDOException $e) {
    echo "Error al registrar libro: " . $e->getMessage();
}
?>
