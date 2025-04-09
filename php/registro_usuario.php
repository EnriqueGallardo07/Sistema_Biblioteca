<?php
// Incluir el archivo de conexión
include('conexion.php');

// Obtener los datos del formulario
$nombre_usuario = $_POST['nombre_usuario'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$contrasena = $_POST['contrasena']; // La contraseña será encriptada
$rol = $_POST['rol'] ?? 'usuario'; // Por defecto el rol es 'usuario'

// Encriptar la contraseña
$contrasena_encriptada = password_hash($contrasena, PASSWORD_BCRYPT);

try {
    // Insertar los datos del usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre_usuario, correo, telefono, contrasena, rol) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre_usuario, $correo, $telefono, $contrasena_encriptada, $rol]);

    echo "Usuario registrado con éxito.";
} catch (PDOException $e) {
    echo "Error al registrar usuario: " . $e->getMessage();
}
?>