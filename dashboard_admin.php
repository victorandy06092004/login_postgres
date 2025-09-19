<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'Admin') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Bienvenido Admin, <?php echo $_SESSION['usuario']; ?> 👑</h1>
    <a href="logout.php">Cerrar sesión</a>

    <h2>Gestión de Usuarios</h2>
    <!-- Aquí va tu tabla de usuarios con botones Editar, Eliminar y Agregar -->
    <?php include("tabla_usuarios.php"); ?>
</body>
</html>
