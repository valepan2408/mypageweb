<?php
require_once 'conexion.php';

try {
    $sql = "SELECT id, nombre FROM pacientes ORDER BY nombre";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($pacientes);
} catch(Exception $e) {
    echo json_encode([]);
}
?>