<?php
session_start();

// Verificar que el usuario está logueado
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol'])) {
    header("Location: login.php");
    exit();
}

// Solo permitir acceso a Supervisores
if ($_SESSION['rol'] !== 'Supervisor') {
    header("Location: dashboard.php"); // Redirige al dashboard principal si no es supervisor
    exit();
}

$nombreUsuario = $_SESSION['usuario'];
$nombreRol = $_SESSION['rol']; // rol del usuario logueado

include 'conexion.php';

// Obtener lista de usuarios
$sql = "SELECT * FROM usuarios ORDER BY id ASC";
$stmt = $pdo->query($sql);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Supervisores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

<?php if (isset($_SESSION['rol_cambiado'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Rol actualizado',
            text: '<?= $_SESSION['rol_cambiado']; ?>',
            confirmButtonText: 'OK'
        });
    </script>
    <?php unset($_SESSION['rol_cambiado']); ?>
<?php endif; ?>

<div class="container mt-5">
    <!-- Saludo -->
    <h2 class="mb-4">👋 Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?> - <?= htmlspecialchars($nombreRol); ?></h2>

    <!-- Botón Cerrar Sesión -->
    <div class="mb-3 text-end">
        <a href="logout.php" class="btn btn-outline-dark">🚪 Cerrar Sesión</a>
    </div>

    <!-- Tabla de usuarios (sin botones) -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= $usuario['id'] ?></td>
                            <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                            <td><?= htmlspecialchars($usuario['gmail']) ?></td>
                            <td>
                                <?php if ($usuario['estado']): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactivo</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>
