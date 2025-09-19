<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Operario') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Operario</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Bienvenido Operario, <?php echo $_SESSION['usuario']; ?> 🛠️</h1>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
