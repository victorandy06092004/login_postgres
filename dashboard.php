<?php
session_start();

// Si no hay usuario en sesión, redirigir al login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}

$nombreUsuario = $_SESSION['usuario']; // nombre del usuario logueado

include 'conexion.php';

// Obtener lista de usuarios
$sql = "SELECT u.*, r.nombre AS rol_nombre 
        FROM usuarios u 
        INNER JOIN rol r ON u.id_rol = r.id_rol
        ORDER BY u.id ASC";
$stmt = $pdo->query($sql);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener roles para el formulario de nuevo usuario
$rolesStmt = $pdo->query("SELECT * FROM rol ORDER BY id_rol ASC");
$roles = $rolesStmt->fetchAll(PDO::FETCH_ASSOC);
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
    <h2 class="mb-4">👋 Bienvenido, <?= htmlspecialchars($nombreUsuario); ?></h2>

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
                        <th>Rol</th>
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
                            <td><?= htmlspecialchars($usuario['rol_nombre']) ?></td>
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
                                    data-id_rol="<?= $usuario['id_rol'] ?>"
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

<!-- Modal: Nuevo Usuario -->
<div class="modal fade" id="nuevoUsuarioModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="registrar_usuario.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Registrar Nuevo Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="gmail" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="contrasena" class="form-control"
                       required
                       pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$"
                       title="Debe tener al menos 8 caracteres, incluyendo mayúsculas, minúsculas y números">
            </div>
            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select" required>
                    <option value="true">Activo</option>
                    <option value="false">Inactivo</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="id_rol" class="form-select" required>
                    <?php foreach ($roles as $rol): ?>
                        <option value="<?= $rol['id_rol'] ?>"><?= htmlspecialchars($rol['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Aquí irían los modales de Editar y Eliminar, sin cambios -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.editarBtn').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('edit-id').value = this.dataset.id;
        document.getElementById('edit-nombre').value = this.dataset.nombre;
        document.getElementById('edit-gmail').value = this.dataset.gmail;
        document.getElementById('edit-contrasena').value = this.dataset.contrasena;
        document.getElementById('edit-estado').value = this.dataset.estado;
        document.getElementById('edit-rol').value = this.dataset.id_rol; // Asignar rol al editar
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
