<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="login-container">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Acceso al Sistema</h4>
                    <p class="mb-0">Inicie sesión con sus credenciales</p>
                </div>
                <div class="card-body">

                    <!-- Mostrar errores -->
                    <?php if (isset($_SESSION['error'])): ?>
                        <script>
                            Swal.fire({
                                icon: '<?= $_SESSION['error']['tipo']; ?>',
                                title: (<?= $_SESSION['error']['tipo'] === "'warning'" ? "'Atención'" : "'Oops...'" ?>),
                                text: '<?= $_SESSION['error']['mensaje']; ?>',
                                confirmButtonText: 'Intentar de nuevo'
                            });
                        </script>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <!-- Mostrar éxito (ejemplo: sesión cerrada correctamente) -->
                    <?php if (isset($_SESSION['success'])): ?>
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: '<?= $_SESSION['success']; ?>',
                                confirmButtonText: 'Aceptar'
                            });
                        </script>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <form action="procesar_login.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" name="gmail" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="contraseña" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <small>Empresita</small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
