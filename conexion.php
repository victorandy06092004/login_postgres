<?php
$host = "localhost";
$dbname = "Prueba";   // nombre de tu BD
$user = "postgres";   // usuario de PostgreSQL
$pass = "after dark"; // tu contraseña

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}
?>
