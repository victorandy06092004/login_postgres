<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $gmail = $_POST['gmail'];
    $contrasena = $_POST['contrasena'];
    $estado = ($_POST['estado'] === 'true') ? true : false;

    try {
        $sql = "INSERT INTO usuarios (nombre, gmail, contrasena, estado) 
                VALUES (:nombre, :gmail, :contrasena, :estado)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':gmail', $gmail);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_BOOL);
        $stmt->execute();

        header("Location: dashboard.php");
        exit;
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger text-center'>❌ Error: " . $e->getMessage() . "</div>";
    }
}
?>
