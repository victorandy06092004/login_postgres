<?php
session_start();

// Si no hay usuario en sesión, redirigir al login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}

$nombreUsuario = $_SESSION['usuario']; // se guarda en login.php

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
    <title>Panel de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <!-- Título con Bienvenida -->
    <h2 class="mb-4">👋 Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?></h2>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>👤 Lista de Usuarios</h3>
        <div>
            <!-- Botón nuevo usuario -->
            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#nuevoUsuarioModal">
                ➕ Nuevo Usuario
            </button>
            <a href="logout.php" class="btn btn-outline-dark">🚪 Cerrar Sesión</a>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
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
                            <td>
                                <!-- Botón editar -->
                                <button 
                                    class="btn btn-warning btn-sm text-white editarBtn"
                                    data-id="<?= $usuario['id'] ?>"
                                    data-nombre="<?= htmlspecialchars($usuario['nombre']) ?>"
                                    data-gmail="<?= htmlspecialchars($usuario['gmail']) ?>"
                                    data-contrasena="<?= htmlspecialchars($usuario['contrasena']) ?>"
                                    data-estado="<?= $usuario['estado'] ? 'true' : 'false' ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editarUsuarioModal"
                                >
                                    ✏️ Editar
                                </button>

                                <!-- Botón eliminar -->
                                <button 
                                    class="btn btn-danger btn-sm eliminarBtn"
                                    data-id="<?= $usuario['id'] ?>"
                                    data-nombre="<?= htmlspecialchars($usuario['nombre']) ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#eliminarUsuarioModal"
                                >
                                    🗑️ Eliminar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- aquí siguen tus modales y scripts JS -->



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.editarBtn').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('edit-id').value = this.dataset.id;
        document.getElementById('edit-nombre').value = this.dataset.nombre;
        document.getElementById('edit-gmail').value = this.dataset.gmail;
        document.getElementById('edit-contrasena').value = this.dataset.contrasena;
        document.getElementById('edit-estado').value = this.dataset.estado;
    });
});

document.querySelectorAll('.eliminarBtn').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('delete-id').value = this.dataset.id;
        document.getElementById('delete-nombre').textContent = this.dataset.nombre;
    });
});
</script>

</body>
</html>
