<?php
require_once 'conexion.php';

// Obtener libros
try {
    $stmt = $pdo->query("SELECT * FROM libros ORDER BY fecha_registro DESC");
    $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener los libros: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Libros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fdfdfd;
        }
        h1 {
            text-align: center;
            margin-top: 30px;
            color: #d4006b;
        }
        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #ff66b2;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #fce6ef;
        }
    </style>
</head>
<body>

    <h1>Catálogo de Libros</h1>

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>ISBN</th>
                <th>Categoría</th>
                <th>Disponible</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($libros) > 0): ?>
            <?php foreach ($libros as $libro): ?>
                <tr>
                    <td><?= htmlspecialchars($libro['titulo']) ?></td>
                    <td><?= htmlspecialchars($libro['autor']) ?></td>
                    <td><?= $libro['isbn'] ?></td>
                    <td><?= htmlspecialchars($libro['categoria'] ?? 'Sin categoría') ?></td>
                    <td><?= $libro['disponible'] ? 'Sí' : 'No' ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No hay libros registrados.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
