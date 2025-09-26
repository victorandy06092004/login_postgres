<?php
session_start();

// Cerrar sesión
session_unset();
session_destroy();

// ✅ Guardamos mensaje de éxito
session_start();
$_SESSION['success'] = "Sesión cerrada correctamente";

// Redirigir al login
header("Location: login.php");
exit;
?>
