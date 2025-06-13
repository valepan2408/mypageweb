<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $cita_id = $_POST['cita_id'];
        
        $sql = "UPDATE citas SET estado = 'Cancelada' WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cita_id]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Cita cancelada exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontró la cita']);
        }
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>