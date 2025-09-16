<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit;
}
include 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h3 class="text-center mb-4">Bienvenido, <?php echo $_SESSION['usuario']; ?> 👋</h3>
            
            <!-- Formulario para registrar usuarios -->
            <h5>Registrar nuevo usuario</h5>
            <form action="registrar_usuario.php" method="POST" class="mb-4">
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
                    <select name="estado" class="form-select">
                        <option value="true">Activo</option>
                        <option value="false">Inactivo</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Registrar</button>
            </form>

            <!-- Tabla de usuarios -->
            <h5>Lista de usuarios</h5>
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM usuarios ORDER BY id ASC";
                    $stmt = $pdo->query($sql);
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['nombre']}</td>
                                <td>{$row['gmail']}</td>
                                <td>" . ($row['estado'] ? 'Activo ✅' : 'Inactivo ❌') . "</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="text-center mt-3">
                <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
            </div>
        </div>
    </div>
</body>
</html>
