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
            $_SESSION['id_usuario'] = $usuario['id'];
            $_SESSION['usuario'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol_nombre'];

            if ($usuario['rol_nombre'] === 'Operario') {
                header("Location: dashboard_operario.php");
            } elseif ($usuario['rol_nombre'] === 'Supervisor') {
                header("Location: dashboard_supervisor.php");
            } else {
                header("Location: dashboard.php"); // Admin
            }
            exit;
        } else {
            // ⚠️ Usuario inactivo
            $_SESSION['error'] = [
                'tipo' => 'warning',
                'mensaje' => '⚠️ Usuario inactivo. Contacte al administrador.'
            ];
            header("Location: login.php");
            exit;
        }
    } else {
        // ❌ Usuario/contraseña incorrectos
        $_SESSION['error'] = [
            'tipo' => 'error',
            'mensaje' => '❌ Usuario o contraseña incorrectos'
        ];
        header("Location: login.php");
        exit;
    }
}
?>
