<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $gmail = $_POST['gmail'];
    $contrasena = $_POST['contrasena'];
    $estado = ($_POST['estado'] === "true") ? true : false;
    $id_rol = intval($_POST['id_rol']); // nuevo: rol

    try {
        $sql = "UPDATE usuarios 
                SET nombre = :nombre, gmail = :gmail, contrasena = :contrasena, estado = :estado, id_rol = :id_rol 
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':gmail', $gmail);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_BOOL);
        $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // ✅ Guardar mensaje de éxito en sesión
        $_SESSION['success'] = "Usuario actualizado correctamente";

        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "❌ Error: " . $e->getMessage();
        header("Location: dashboard.php");
        exit;
    }
}
?>
