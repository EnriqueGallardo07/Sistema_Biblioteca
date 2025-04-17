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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual</title>
    <link rel="stylesheet" href="../css/index.css">
    <!-- Navbar -->
    <header class="navbar">
        <div class="logo">
            <img src="../IMG/logo.png" alt="PBU">
        </div>
        <nav class="nav-links">
            <a href="http://localhost/Biblioteca/pantallas/indexAdmin.html">Inicio</a>
            <a href="http://localhost/Biblioteca/pantallas/registro_libro.html">Registrar un libro</a>
            <a href="http://localhost/Biblioteca/pantallas/prestamo_libro.html">Prestar libros</a>
            <a href="http://localhost/Biblioteca/pantallas/reportes_prestamos.html">Reporte</a>
        </nav>
        <div class="user-cart">
            <a href="http://localhost/Biblioteca/pantallas/perfil.html" class="user-icon">👤</a>
        </div>
    </header>
    <meta charset="UTF-8">
    <title>Listado de Libros</title>
    <style>
        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ccc;
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
        .acciones a {
            margin: 0 5px;
            text-decoration: none;
            color: #0077cc;
        }
        h1 {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <h1>Listado de Libros Registrados</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>ISBN</th>
                <th>Categoría</th>
                <th>Disponible</th>
                <th>Registrado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($libros) > 0): ?>
            <?php foreach ($libros as $libro): ?>
                <tr>
                    <td><?= $libro['id_libro'] ?></td>
                    <td><?= htmlspecialchars($libro['titulo']) ?></td>
                    <td><?= htmlspecialchars($libro['autor']) ?></td>
                    <td><?= $libro['isbn'] ?></td>
                    <td><?= htmlspecialchars($libro['categoria'] ?? 'Sin categoría') ?></td>
                    <td><?= $libro['disponible'] ? 'Sí' : 'No' ?></td>
                    <td><?= $libro['fecha_registro'] ?></td>
                    <td class="acciones">
                        <a href="editar_libro.php?id=<?= $libro['id_libro'] ?>">Editar</a> |
                        <a href="eliminar_libro.php?id=<?= $libro['id_libro'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este libro?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No hay libros registrados.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
