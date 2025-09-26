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

        // 🔑 Si el usuario editado es el mismo que está logueado
        if ($_SESSION['id_usuario'] == $id) {
            // Consultar el rol actualizado
            $sqlRol = "SELECT r.nombre AS rol_nombre 
                       FROM usuarios u
                       INNER JOIN rol r ON u.id_rol = r.id_rol
                       WHERE u.id = :id";
            $stmtRol = $pdo->prepare($sqlRol);
            $stmtRol->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtRol->execute();
            $nuevoRol = $stmtRol->fetch(PDO::FETCH_ASSOC);

            $_SESSION['rol'] = $nuevoRol['rol_nombre'];

            // 🚀 Guardamos un mensaje especial para mostrar en el nuevo dashboard
            $_SESSION['rol_cambiado'] = "✅ Tu rol ha sido actualizado a {$nuevoRol['rol_nombre']}";

            // 🔀 Redirigir al dashboard correcto según el nuevo rol
            if ($nuevoRol['rol_nombre'] === 'Operario') {
                header("Location: dashboard_operario.php");
            } elseif ($nuevoRol['rol_nombre'] === 'Supervisor') {
                header("Location: dashboard_supervisor.php");
            } else {
                header("Location: dashboard.php"); // Admin
            }
            exit;
        }

        // 🚀 Si se editó a otro usuario, volver al dashboard del admin
        header("Location: dashboard.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "❌ Error: " . $e->getMessage();
        header("Location: dashboard.php");
        exit;
    }
}
?>
