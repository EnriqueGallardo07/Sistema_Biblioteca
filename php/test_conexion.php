<?php
require_once 'conexion.php'; // Incluye tu archivo de conexión

// Si llegamos aquí sin errores, la conexión PDO funciona
echo "✅ ¡Conexión exitosa a la base de datos!<br>";

// Opcional: Listar tablas para confirmar acceso a la BD
try {
    $tablas = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tablas en la base de datos: " . implode(", ", $tablas);
} catch (PDOException $e) {
    echo "<br>Error al listar tablas: " . $e->getMessage();
}
?>