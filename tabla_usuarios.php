<?php
include("conexion.php");

// Obtener lista de usuarios con su rol
$sql = "SELECT u.id, u.nombre, u.gmail, u.estado, r.nombre AS rol
        FROM usuarios u
        INNER JOIN rol r ON u.id_rol = r.id_rol
        ORDER BY u.id ASC";
$stmt = $conn->query($sql);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Estado</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= $usuario['id'] ?></td>
            <td><?= htmlspecialchars($usuario['nombre']) ?></td>
            <td><?= htmlspecialchars($usuario['gmail']) ?></td>
            <td><?= $usuario['estado'] ? 'Activo' : 'Inactivo' ?></td>
            <td><?= htmlspecialchars($usuario['rol']) ?></td>
            <td>
                <!-- Botón Editar -->
                <form action="editar_usuario.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                    <button type="submit">Editar</button>
                </form>

                <!-- Botón Eliminar -->
                <form action="eliminar_usuario.php" method="POST" style="display:inline;" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br>
<!-- Botón Agregar Usuario -->
<a href="nuevo_usuario.php"><button>+ Nuevo Usuario</button></a>
