<?php
$host = 'localhost';
$dbname = 'hospital';
$username = 'root'; // Cambia por tu usuario de MySQL
$password = ''; // Cambia por tu contraseña de MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>