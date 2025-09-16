<?php
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
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>👤 Lista de Usuarios</h3>
        <div>
            <!-- Botón nuevo usuario -->
            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#nuevoUsuarioModal">
                ➕ Nuevo Usuario
            </button>
            <!-- Botón eliminar usuario -->
            <button class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#eliminarUsuarioModal">
                🗑️ Eliminar Usuario
            </button>
            <!-- Botón editar usuario -->
            <button class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal">
                ✏️ Editar Usuario
            </button>
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
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Eliminar Usuario -->
<div class="modal fade" id="eliminarUsuarioModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="eliminar_usuario.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title text-danger">Eliminar Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <p class="text-muted">Ingrese el <b>ID</b> del usuario a eliminar:</p>
            <div class="mb-3">
                <label class="form-label">ID de Usuario</label>
                <input type="number" name="id" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Eliminar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Editar Usuario -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="editar_usuario.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title text-warning">Editar Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <p class="text-muted">Ingrese el <b>ID</b> del usuario y los nuevos datos:</p>
            <div class="mb-3">
                <label class="form-label">ID de Usuario</label>
                <input type="number" name="id" class="form-control" required>
            </div>
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
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning text-white">Actualizar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
