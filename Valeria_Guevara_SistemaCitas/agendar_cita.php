<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $paciente_id = $_POST['paciente_id'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $especialidad = $_POST['especialidad'];
        
        //verfificar la fecha
        if ($fecha < date('Y-m-d')) {
            throw new Exception('No se pueden agendar citas en fechas pasadas');
        }
        
        // Verificar si ya existe una cita para el mismo paciente en la misma fecha y hora
        $sql_check = "SELECT COUNT(*) FROM citas WHERE paciente_id = ? AND fecha = ? AND hora = ? AND estado = 'Agendada'";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->execute([$paciente_id, $fecha, $hora]);
        
        if ($stmt_check->fetchColumn() > 0) {
            throw new Exception('Ya existe una cita agendada para este paciente en la misma fecha y hora');
        }
        
        $sql = "INSERT INTO citas (paciente_id, fecha, hora, especialidad) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$paciente_id, $fecha, $hora, $especialidad]);
        
        echo json_encode(['success' => true, 'message' => 'Cita agendada exitosamente']);
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>