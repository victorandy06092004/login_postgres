<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $gmail = $_POST['gmail'];
    $contrasena = $_POST['contrasena'];
    $estado = ($_POST['estado'] === 'true') ? true : false;
    $id_rol = $_POST['id_rol'];

    // Validar contraseña
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $contrasena)) {
        $_SESSION['error'] = "❌ La contraseña debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas y números.";
        header("Location: dashboard.php");
        exit;
    }

    try {
        $sql = "INSERT INTO usuarios (nombre, gmail, contrasena, estado, id_rol) 
                VALUES (:nombre, :gmail, :contrasena, :estado, :id_rol)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':gmail', $gmail);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_BOOL);
        $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
        $stmt->execute();

        // ✅ Mensaje de éxito
        $_SESSION['success'] = "Usuario registrado correctamente";

        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        // ❌ Mensaje de error
        $_SESSION['error'] = "Error al registrar usuario: " . $e->getMessage();
        header("Location: dashboard.php");
        exit;
    }
}
?>
