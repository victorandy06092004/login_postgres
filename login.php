<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gmail = $_POST['gmail'];
    $contrasena = $_POST['contraseña'];

    $sql = "SELECT u.*, r.nombre AS rol_nombre 
            FROM usuarios u 
            INNER JOIN rol r ON u.id_rol = r.id_rol
            WHERE u.gmail = :gmail AND u.contrasena = :contrasena";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':gmail', $gmail);
    $stmt->bindParam(':contrasena', $contrasena);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario['estado']) {
            $_SESSION['usuario'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol_nombre']; // Guardamos el rol

            // Redirigir según rol
            if ($usuario['rol_nombre'] === 'Operario') {
                header("Location: dashboard_operario.php");
            } else {
                header("Location: dashboard.php"); // Admin y Supervisor usan el dashboard completo
            }
            exit;
        } else {
            echo "<div class='alert alert-warning text-center mt-3'>⚠️ Usuario inactivo. Contacte al administrador.</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center mt-3'>❌ Usuario o contraseña incorrectos</div>";
    }
}
?>
