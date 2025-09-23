<?php
session_start();

// Verificar que el usuario está logueado
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol'])) {
    header("Location: login.html");
    exit();
}

// Solo permitimos que ingresen operarios
if ($_SESSION['rol'] !== 'Operario') {
    header("Location: dashboard.php"); // Redirige al dashboard principal si no es operario
    exit();
}

$nombreUsuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido Operario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 text-center">
    <!-- Título con saludo -->
    <h1 class="display-4 mb-4">👋 Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?></h1>

    <!-- Botón Cerrar Sesión -->
    <a href="logout.php" class="btn btn-danger btn-lg">🚪 Cerrar Sesión</a>
</div>

</body>
</html>
