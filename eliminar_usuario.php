<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);

    try {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Volver al dashboard
        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger text-center'>❌ Error: " . $e->getMessage() . "</div>";
    }
} else {
    // Si entran sin enviar POST
    header("Location: dashboard.php");
    exit;
}
?>
