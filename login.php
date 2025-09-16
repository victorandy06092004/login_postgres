<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gmail = $_POST['gmail'];
    $contrasena = $_POST['contraseña'];

    $sql = "SELECT * FROM usuarios WHERE gmail = :gmail AND contrasena = :contrasena";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':gmail', $gmail);
    $stmt->bindParam(':contrasena', $contrasena);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario['estado']) {
            $_SESSION['usuario'] = $usuario['nombre'];
            header("Location: dashboard.php");
            exit;
        } else {
            echo "<div class='alert alert-warning text-center mt-3'>⚠️ Usuario inactivo. Contacte al administrador.</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center mt-3'>❌ Usuario o contraseña incorrectos</div>";
    }
}
?>
