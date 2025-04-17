<?php
// Incluir archivo de conexión
include('conexion.php');

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Validar que las contraseñas coincidan
    if ($contrasena !== $confirmar_contrasena) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Validar que el correo no esté registrado previamente
    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$correo]);
    if ($stmt->rowCount() > 0) {
        echo "El correo electrónico ya está registrado.";
        exit;
    }

    // Encriptar la contraseña
    $contrasena_encriptada = password_hash($contrasena, PASSWORD_BCRYPT);

    // Insertar los datos en la base de datos
    try {
        $sql = "INSERT INTO usuarios (nombre_usuario, correo, contrasena) 
                VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$usuario, $correo, $contrasena_encriptada]);

        echo "Usuario registrado con éxito.";
        // Redirigir a la página de inicio de sesión (si lo deseas)
        header('Location: inicio.html');
        exit;
    } catch (PDOException $e) {
        echo "Error al registrar el usuario: " . $e->getMessage();
    }
}
?>
