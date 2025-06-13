<?php
require_once 'conexion.php';

$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : '';

try {
    $sql = "SELECT c.id, p.nombre as paciente, c.fecha, c.hora, c.especialidad, c.estado 
            FROM citas c 
            JOIN pacientes p ON c.paciente_id = p.id 
            WHERE c.estado = 'Agendada'";
    
    $params = [];
    
    if (!empty($filtro)) {
        $sql .= " AND (p.nombre LIKE ? OR c.especialidad LIKE ?)";
        $params[] = "%$filtro%";
        $params[] = "%$filtro%";
    }
    
    $sql .= " ORDER BY c.fecha, c.hora";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($citas);
} catch(Exception $e) {
    echo json_encode([]);
}
?>