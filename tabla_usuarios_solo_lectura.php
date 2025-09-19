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
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
