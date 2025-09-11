<?php
include 'conexion.php';  // 👈 Esto trae $pdo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gmail = $_POST['gmail'];
    $contrasena = $_POST['contraseña'];

    $sql = "SELECT * FROM usuarios WHERE gmail = :gmail AND contrasena = :contrasena";
    $stmt = $pdo->prepare($sql);   // ✅ ahora $pdo existe
    $stmt->bindParam(':gmail', $gmail);
    $stmt->bindParam(':contrasena', $contrasena);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "✅ Bienvenido, " . $usuario['nombre'];
    } else {
        echo "❌ Usuario o contraseña incorrectos";
    }
}
?>
