<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);

    try {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // ✅ Mensaje de éxito
        $_SESSION['success'] = "Usuario eliminado correctamente";

        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        // ❌ Mensaje de error
        $_SESSION['error'] = "Error al eliminar usuario: " . $e->getMessage();
        header("Location: dashboard.php");
        exit;
    }
} else {
    header("Location: dashboard.php");
    exit;
}
?>
