<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $gmail = $_POST['gmail'];
    $contrasena = $_POST['contrasena'];
    $estado = ($_POST['estado'] === 'true') ? true : false;

    // Validar contraseña (mínimo 8, una mayúscula, una minúscula, un número)
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $contrasena)) {
        die("<div class='alert alert-danger text-center mt-3'>
                ❌ La contraseña debe tener al menos 8 caracteres, 
                incluir mayúsculas, minúsculas y números.
             </div>
             <div class='text-center mt-3'><a href=\"dashboard.php\" class=\"btn btn-primary\">Volver</a></div>");
    }

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
